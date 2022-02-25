<?php include 'header.php';?>
<?php
$getCategory = mysqli_query($conn, "SELECT * FROM category");
$products = mysqli_query($conn, "SELECT * FROM product");
// paginate
$totals = mysqli_num_rows($products);
$limit = 8;
$pages = ceil($totals / $limit);
$current_page = (isset($_GET['pages'])) ? $_GET['pages'] : 1;
$start = ($current_page - 1) * $limit;
$products = mysqli_query($conn, "SELECT * FROM product ORDER BY sale_price DESC LIMIT $start,$limit");

if (isset($_GET['category-id'])) {
    $id = $_GET['category-id'];
    $products = mysqli_query($conn, "SELECT * FROM product WHERE category_id = $id");
    $totals = mysqli_num_rows($products);
    $limit = 8;
    $pages = ceil($totals / $limit);
    $current_page = (isset($_GET['pages'])) ? $_GET['pages'] : 1;
    $start = ($current_page - 1) * $limit;
    $products = mysqli_query($conn, "SELECT * FROM product WHERE category_id = $id LIMIT $start,$limit");
}

// Searching
if (isset($_GET['search_string'])) {
    $search_string = $_GET['search_string'];
    $products = mysqli_query($conn, "SELECT * FROM product WHERE name LIKE '%$search_string%'");
    $totals = mysqli_num_rows($products);
    $limit = 8;
    $pages = ceil($totals / $limit);
    $current_page = (isset($_GET['pages'])) ? $_GET['pages'] : 1;
    $start = ($current_page - 1) * $limit;
    $products = mysqli_query($conn, "SELECT * FROM product WHERE name LIKE '%$search_string%' LIMIT $start,$limit");
}
?>
<style>
    .list-group-item.active {
        background-color: #82ae46;
        border-color: #82ae46;
    }
    .form-control {
        height: 40px !important;
    }

    ol , ul {
        padding: 0;
    }

    .img-fluid{
        height: 180px !important;
    }
</style>
<div class="hero-wrap hero-bread" style="background-image: url('src/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ</a></span> <span>Sản phẩm</span></p>
                <h1 class="mb-0 bread">Sản phẩm</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section" id="main-content">
    <div class="container" >
        <div class="row justify-content-center mb-2">
            <div class="col-md-8">
                <ul class="product-category">
                    <li><a href="shop.php" class="<?= (!isset($_GET['category-id'])) ? 'active' : ''?> category">Tất cả</a></li>
                    <?php while ($cate = mysqli_fetch_assoc($getCategory)) { ?>
                        <li><a class="<?= ($_GET['category-id'] == $cate['id']) ? 'active' : '';?> category" href="shop.php?category-id=<?=$cate['id'];?>"><?=$cate['name'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-4">
                <form id="search" class="form-group">
                    <div class="input-group">
                        <?php if(isset($_GET['search_string'])) { ?>
                            <input type="text" name="search_string" value="<?=$_GET['search_string'];?>" class="form-control search" placeholder="Tìm kiếm..." >
                        <?php }else{ ?>
                            <input type="text" name="search_string" class="form-control search" placeholder="Tìm kiếm...">
                        <?php } ?>
                        <div class="input-group-prepend">
                            <button class="input-group-text" style="padding: 0 20px;"><i class="icon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="row pt-3">
            <div class="col-md-12">
                <div class="row" id="product">
                    <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                        <div class="col-md-3" height="200px">
                            <div class="product">
                                <a href="detail.php?id=<?= $product['id'] ?>" class="img-prod"><img class="img-fluid" src="admin/assets/images/<?= $product['image'] ?>" width="100%" style="max-height:300px">
                                    <div class="overlay"></div>
                                </a>
                                <div class="text py-3 pb-4 px-3 text-center">
                                    <h3><a href="#"><?= $product['name'] ?></a></h3>
                                    <div class="d-flex">
                                        <div class="pricing">
                                            <?php if ($product['sale_price'] > 0) { ?>
                                                <p class="price">Giá khuyến mãi : <?= number_format($product['sale_price']); ?> vnđ</p>
                                            <?php } else { ?>
                                                <p>Giá : <span><?= number_format($product['price']); ?> vnđ</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="bottom-area d-flex px-3">
                                        <div class="m-auto d-flex">
                                            <a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                                <span><i class="ion-ios-menu"></i></span>
                                            </a>
                                            <a href="cart-process.php?id=<?= $product['id'] ?>" class="buy-now d-flex justify-content-center align-items-center mx-1 add_to_cart">
                                                <span><i class="ion-ios-cart"></i></span>
                                            </a>
                                            <a href="#" class="heart d-flex justify-content-center align-items-center ">
                                                <span><i class="ion-ios-heart"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <?php if(isset($_GET['category-id'])) { ?>
                        <ul>
                            <li><a href="#">&lt;</a></li>
                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                <li class="<?= ($i == $current_page) ? 'active' : ''; ?> paginate" ><a href="shop.php?category-id=<?=$_GET['category-id']?>&pages=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php } ?>
                            <li><a href="#">&gt;</a></li>
                        </ul>
                    <?php }else if(isset($_GET['search_string'])) { ?>
                        <ul>
                            <li><a href="#">&lt;</a></li>
                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                <li class="<?= ($i == $current_page) ? 'active' : ''; ?> paginate" ><a href="shop.php?search_string=<?=$_GET['search_string']?>&pages=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php } ?>
                            <li><a href="#">&gt;</a></li>
                        </ul>
                    <?php }else{ ?>
                        <ul>
                            <li><a href="#">&lt;</a></li>
                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                <li class="<?= ($i == $current_page) ? 'active' : ''; ?> paginate"><a href="shop.php?pages=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php } ?>
                            <li><a href="#">&gt;</a></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
    $(document).ready(function(){
        $(document).on('click','.add_to_cart',function(e){
            e.preventDefault();
            var href = $(this).attr("href");
            $.ajax({
                url : href,
                type : "GET",
                success : function(res){
                    console.log(res);
                    if(res.status==true){
                        Swal.fire({
                            html: res.message,
                            icon: res.icon
                        });
                        $(".cta-colored").load(location.href + " .cta-colored>*");
                    }
                }
            });
        });

        $(document).on('click','.category',function(e){
            e.preventDefault();
            var href = $(this).attr('href');
            $.ajax({
                url : href,
                type : 'GET',
                success : function(res){
                    $("#main-content").load(href + " #main-content>*");
                }
            });
        });

        $(document).on('submit','#search',function(e){
            e.preventDefault();
            var search = $(".search").val();
            $.ajax({
                url : window.location.href + "?search_string=" + search,
                type : "GET",
                success : function(res){
                    $("#main-content").load(window.location.href + "?search_string=" + search + " #main-content>*");
                }
            });
        });

        $(document).on("click",'.paginate a',function(e){
            e.preventDefault();
            var href = $(this).attr("href");
            $.ajax({
                url : href,
                type : "GET",
                success : function(res){
                    $("#main-content").load(href + " #main-content>*");
                    $("html, body").animate({scrollTop: 500}, 800);
                }
            });
        });
    });
</script>
