<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>
<?php
$sql = "SELECT*FROM category order by id desc";
$cats = mysqli_query($conn, $sql);
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    if ($search == '') {
        $sql = "SELECT*FROM category order by id desc";
        $cats = mysqli_query($conn, $sql);
    }
    $sql = "SELECT * FROM category WHERE name LIKE '%$search%'";
    $cats = mysqli_query($conn, $sql);
}

?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Quản lý danh mục</h5>
                        <p class="m-b-0">Danh sách danh mục</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Danh sách danh mục</a>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="fa fa-list mr-2"></i>Danh sách danh mục</h4>
                                    <div>
                                        <form class="form-material">
                                            <div class="form-group form-primary">
                                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm" autocomplete="off">
                                            </div>
                                        </form>
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
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th class="font-weight-bold">#</th>
                                                    <th class="font-weight-bold">Tên danh mục</th>
                                                    <th class="font-weight-bold">Trạng thái</th>
                                                    <th class="font-weight-bold">Tổng sản phẩm</th>
                                                    <th class="font-weight-bold"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($cats as $cat) {;
                                                    $category_id = $cat['id']; ?>
                                                    <?php
                                                    $products = mysqli_query($conn, "select*from product where category_id = $category_id");
                                                    ?>
                                                    <tr>
                                                        <td><?= $cat['id']; ?></td>
                                                        <td><?= $cat['name']; ?></td>
                                                        <td>
                                                            <?php if ($cat['status'] == 1) { ?>
                                                                <span class="badge badge-success">Hiển thị</span>
                                                            <?php } ?>
                                                            <?php if ($cat['status'] == 0) { ?>
                                                                <span class="badge badge-warning">Ẩn</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $products->num_rows; ?></td>
                                                        <td class="text-right" width="180px">
                                                            <a href="edit-category.php?id=<?= $cat['id']; ?>" class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                                            <a href="process/category/delete.php?del=<?= $cat['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i>Xóa</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        $(document).on('click', '.btn-delete', function(e) {
            var url = $(this).attr("href");
            e.preventDefault();
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
                                    html: "Xóa danh mục thành công",
                                    icon: "success"
                                });
                                $("#table_data").load("category.php" + " #table_data>*");
                            }
                        }
                    });
                }
            })
        });
    </script>