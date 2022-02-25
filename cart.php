<?php include 'header.php';
if (isset($_SESSION['cart'])) {
    $items = $_SESSION['cart'];
}
?>

<div class="hero-wrap hero-bread" style="background-image: url('src/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Cart</span></p>
                <h1 class="mb-0 bread">My Cart</h1>
            </div>
        </div>
    </div>
</div>

<div id="main-content">
    <?php if (isset($items) && $items != []) { ?>
        <section class="ftco-section ftco-cart">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="cart-list" id="data-cart">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr class="text-center">
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($items)) { ?>
                                        <?php $total = 0; ?>
                                        <?php foreach ($items as $item) {
                                            $total_amout = number_format($item['price'] * $item['quantity']);
                                        ?>
                                            <tr class="text-center">
                                                <td class="product-remove" width="80"><a class="btn-remove" href="cart-process.php?id=<?= $item['id']; ?>&action=delete"><span class="ion-ios-close "></span></a></td>

                                                <td class="image-prod" style="width:100px">
                                                    <img src="admin/assets/images/<?= $item['image']; ?>" width="80">
                                                </td>

                                                <td class="product-name" style="width:200px">
                                                    <h3><?= $item['name'] ?></h3>
                                                </td>

                                                <td class="price" width="100"><?= number_format($item['price']) ?>đ</td>

                                                <td class="quantity">
                                                    <div class="input-group mb-3">
                                                        <form class="form-inline form-cart" action="cart-process.php" id="form-cart-<?=$item['id'];?>">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                                <input type="hidden" name="action" value="update">
                                                                <button class="btn pl-3 pr-3 decrease">-</button>
                                                                <input type="text" name="quantity" class="form-control w-50" value="<?= $item['quantity'] ?>">
                                                                <button class="btn pl-3 pr-3 ascending">+</button>
                                                                <button class="btn btn-primary btn-update" id="<?= $item['id'] ?>">update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="total"><?= number_format($item['price'] * $item['quantity']) ?>đ</td>
                                            </tr>

                                        <?php $total += $item['price'] * $item['quantity'];
                                        } ?>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>


                <div class="row justify-content-end">
                    <div class="col-lg-4 mt-5" id="cart-total">
                        <div class="cart-total mb-3">
                            <h3>Cart Totals</h3>
                            <p class="d-flex">
                                <span>Subtotal</span>
                                <?php if (isset($_SESSION['cart'])) : ?>
                                    <span><?= number_format($total); ?>đ</span>
                                <?php else :  ?>
                                    <span>0đ</span>
                                <?php endif; ?>
                            </p>
                            <p class="d-flex">
                                <span>Ship</span>
                                <?php if (isset($_SESSION['cart'])) { ?>
                                    <span><?= number_format(30000); ?>đ</span>
                                <?php } else { ?>
                                    <span>0đ</span>
                                <?php } ?>
                            </p>
                            <hr>
                            <p class="d-flex total-price">
                                <span>Total</span>
                                <?php if (isset($_SESSION['cart'])) { ?>
                                    <span><?= number_format($total + 30000) ?>đ</span>
                                <?php } else {  ?>
                                    <span>0đ</span>
                                <?php } ?>
                            </p>
                        </div>
                        <p><a href="checkout.php" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
                    </div>
                </div>
            </div>
        </section>
    <?php } else { ?>
        <div class="jumbotron jumbotron-fluid mt-4" style="background: none">
            <div class="container">
                <h3 class=" text-center">Your Cart is empty</h3>
                <p class="lead text-center"><a href="index.php">Back to Home page</a></p>
            </div>
        </div>
    <?php } ?>
</div>


<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        $(document).on('click','.btn-remove',function(e){
            e.preventDefault();
            var href = $(this).attr("href");
            $.ajax({
                url : href,
                type : "GET",
                success : function(res){
                    if(res.status==true){
                        $("#main-content").load(location.href + " #main-content>*");
                        $(".cta-colored").load(location.href + " .cta-colored>*");
                    }
                }
            });
        });

        $(document).on("click", ".btn-update",function(e){
            e.preventDefault();
            var id = $(this).attr("id");
            var data = $("#form-cart-" + id).serialize();
            var url = "cart-process.php" + "?" + data;
            $.ajax({
                url : url,
                type : "GET",
                success : function(res){
                    if(res.status==false){
                        Swal.fire({
                            html: res.message,
                            icon: res.icon
                        });
                        $("#form-cart-" + id).find("input[name='quantity']").val(1);
                    }else{
                        $("#main-content").load(location.href + " #main-content>*");
                    }
                }
            });
        });

        $(document).on("click", ".decrease",function(e){
            e.preventDefault();
            var quantity = $(this).closest("form").find("input[name='quantity']").val();
            $(this).closest("form").find("input[name='quantity']").val(quantity-1);
            var data = $(this).closest("form").serialize();
            var url = "cart-process.php" + "?" + data;
            $.ajax({
                url : url,
                type : "GET",
                success : function(res){
                    if(res.status==false){
                        Swal.fire({
                            html: res.message,
                            icon: res.icon
                        });
                    }else{
                        $("#main-content").load(location.href + " #main-content>*");
                    }
                }
            });
        });

        $(document).on("click", ".ascending",function(e){
            e.preventDefault();
            var quantity = parseInt($(this).closest("form").find("input[name='quantity']").val());
            $(this).closest("form").find("input[name='quantity']").val(quantity+1);
            var data = $(this).closest("form").serialize();
            var url = "cart-process.php" + "?" + data;
            $.ajax({
                url : url,
                type : "GET",
                success : function(res){
                    if(res.status==false){
                        Swal.fire({
                            html: res.message,
                            icon: res.icon
                        });
                    }else{
                        $("#main-content").load(location.href + " #main-content>*");
                    }
                }
            });
        });
    });
</script>