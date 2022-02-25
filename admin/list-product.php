<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>
<?php
$query = mysqli_query($conn, "SELECT * FROM product order by id desc");
$total = mysqli_num_rows($query); // tính tổng số bản ghi
$limit = 4; // số bản ghi trên 1 trang.
$total_page = ceil($total / $limit); // tỉnh tổng số trang.
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // lấy ra trang hiện tại
$start = ($current_page - 1) * $limit; // bản ghi bắt đầu ở trang hiện tại
$query = mysqli_query($conn, "SELECT * FROM product order by id desc LIMIT $start,$limit");

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = mysqli_query($conn, "SELECT * FROM product WHERE name LIKE '%$search%'");
    $total = mysqli_num_rows($query); // tính tổng số bản ghi
    $limit = 4; // số bản ghi trên 1 trang.
    $total_page = ceil($total / $limit); // tỉnh tổng số trang.
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // lấy ra trang hiện tại
    $start = ($current_page - 1) * $limit; // bản ghi bắt đầu ở trang hiện tại
    $query = mysqli_query($conn, "SELECT * FROM product WHERE name LIKE '%$search%' LIMIT $start,$limit");
}
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Quản lý sản phẩm</h5>
                        <p class="m-b-0">Danh sách sản phẩm</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Danh sách sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <!-- Basic table card start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Danh sách sản phẩm</h5>
                            <div class="p-15 ">
                                <form class="form-material">
                                    <div class="form-group form-primary">
                                        <input type="text" name="search" id="search" class="form-control" width="300px">
                                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Tìm kiếm</label>
                                    </div>
                                </form>
                                <a href="add-product.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>Thêm mới sản phẩm</a>
                            </div>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                    <li><i class="fa fa-trash close-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive" id="table_data">
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Ảnh</th>
                                            <th>Giá</th>
                                            <th>Giá khuyến mãi</th>
                                            <th>Danh mục</th>
                                            <th>Trạng thái</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($query as $prd) {; ?>
                                            <?php
                                            $id_cate = $prd['category_id'];
                                            $category = mysqli_query($conn, "SELECT * FROM category WHERE id = $id_cate");
                                            while ($cate = mysqli_fetch_assoc($category)) {
                                                $cate_name = $cate['name'];
                                            }
                                            ?>
                                            <tr class="text-center">
                                                <td><?= $prd['id']; ?></td>
                                                <td><?= $prd['name']; ?></td>
                                                <td>
                                                    <img src="assets/images/<?= $prd['image']; ?>" width="60">
                                                </td>
                                                <td><?= number_format($prd['price']); ?></td>
                                                <td><?= number_format($prd['sale_price']); ?></td>
                                                <td><?= $cate_name; ?></td>
                                                <td>
                                                    <?php if ($prd['status'] == 1) { ?>
                                                        <span class="badge badge-success">Còn hàng</span>
                                                    <?php } ?>
                                                    <?php if ($prd['status'] == 0) { ?>
                                                        <span class="badge badge-warning">Hết hàng</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-right">
                                                    <a href="edit-product.php?id=<?= $prd['id']; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i>Sửa</a>
                                                    <a href="process/product/delete.php?del=<?= $prd['id']; ?>" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i>Xóa</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <hr>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php if(isset($_GET['search'])){ ?>
                                            <li class="page-item <?= ($current_page == 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="list-product.php?search=<?=$_GET['search']?>&page=<?= $current_page - 1 ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                            <li class="page-item <?= ($current_page == $i) ? 'active' : '' ?>"><a class="page-link" href="list-product.php?search=<?=$_GET['search']?>&page=<?= $i ?>"><?= $i ?></a></li>
                                            <?php } ?>
                                            <li class="page-item <?= ($current_page == $total_page) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="list-product.php?search=<?=$_GET['search']?>&page=<?= $current_page + 1 ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        <?php }else{ ?>
                                        <li class="page-item <?= ($current_page == 1) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="list-product.php?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                                            <li class="page-item <?= ($current_page == $i) ? 'active' : '' ?>"><a class="page-link" href="list-product.php?page=<?= $i ?>"><?= $i ?></a></li>
                                        <?php } ?>
                                        <li class="page-item <?= ($current_page == $total_page) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="list-product.php?page=<?= $current_page + 1 ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
        <!-- Main-body end -->
    </div>

    <?php include 'layout/footer.php'; ?>
    <script>
        $(document).ready(function() {
            _delete();
            paginate();
            function _delete() {
                $(document).on('click', '.btn-delete', function(e) {
                    e.preventDefault();
                    var url = $(this).attr("href");
                    var response;
                    Swal.fire({
                        title: 'Bạn có chắc muốn xóa?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Đồng ý'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: "GET",
                                success: function(res) {
                                    if (res.status == false) {
                                        Swal.fire({
                                            html: res.message,
                                            icon: res.icon
                                        });
                                    }
                                    if (res.status == true) {
                                        Swal.fire({
                                            html: "Xóa sản phẩm thành công",
                                            icon: "success"
                                        });
                                        $("#table_data").load("list-product.php" + " #table_data>*");
                                    }
                                }
                            });
                        }
                    })
                })
            }

            function paginate() {
                $(document).on('click', 'a.page-link', function(e) {
                    e.preventDefault();
                    var href = $(this).attr("href");
                    // alert(href);
                    $.ajax({
                        url: href,
                        type: "GET",
                        success: function() {
                            $("#table_data").load(href + " #table_data>*");
                            $("html, body").animate({scrollTop: 250}, 500);
                        }
                    });
                });
            }
        });
    </script>