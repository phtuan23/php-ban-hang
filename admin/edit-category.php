
<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>
<?php

$errors = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $category = mysqli_fetch_object(mysqli_query($conn, "select*from category where id = $id"));
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
                        <p class="m-b-0">Chỉnh sửa danh mục</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Chỉnh sửa danh mục</a>
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
                        <div class="col-md-6 m-auto">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Chỉnh sửa Danh mục</h5>
                                </div>
                                <div class="card-block">
                                    <form class="form-material" method="POST" id="form-edit">
                                        <div class="form-group">
                                            <h6>Tên danh mục</h6>
                                            <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục" value="<?= $category->name; ?>">
                                        </div>
                                        <div class="form-group">
                                            <h6>Trạng thái</h6>
                                            <div class="form-check">
                                                <input type="checkbox" name="status" class="form-check-input" id="exampleCheck1" value="1" <?= ($category->status == 1 ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="exampleCheck1">Public</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-success btn-sm btn-add"><i class="fa fa-save"></i>Lưu</button>
                                        <a href="category.php" class="btn btn-primary btn-sm">Quay lại</a>
                                    </form>
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
        $(document).ready(function() {
            $(".btn-add").click(function(e) {
                e.preventDefault();
                var data = $("#form-edit").serialize();
                var response;
                var id = <?= $category->id ?>;
                $.ajax({
                    url: "process/category/edit.php?id=" + id,
                    data: data,
                    type: "POST",
                    success: function(res) {
                        if (res.status == false) {
                            Swal.fire({
                                html: res.message,
                                icon: res.icon
                            });
                        } else {
                            window.location.href = res.url
                        }
                    }
                });
            })
        })
    </script>