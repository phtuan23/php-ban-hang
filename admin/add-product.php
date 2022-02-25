<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>
<?php
$getCate = mysqli_query($conn, 'select*from category');
?>

<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Quản lý sản phẩm</h5>
                        <p class="m-b-0">Thêm mới sản phẩm</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Thêm mới sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="card">
                            <form class="form-material" method="POST" enctype="multipart/form-data" id="form_add">
                                <div class="card-header">
                                    <h5>Thêm mới Sản Phẩm</h5>
                                    <a href="list-product.php" class="btn btn-sm btn-info float-right">Hủy</a>
                                    <button class="btn btn-sm btn-success float-right mr-2 btn-save">Lưu sản phẩm</button>

                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="form-group form-default form-static-label">
                                                <label class="float-label font-weight-bold text-dark">Ảnh sản phẩm</label>
                                                <input type="file" hidden name="image" id="file_upload">
                                                <img src="http://cdn.onlinewebfonts.com/svg/download_212908.png" id="image" width="100%" style="cursor: pointer;" class="mt-5 mb-3">
                                                <?php if (isset($errors['image'])) { ?>
                                                    <small class="text-danger"><?= $errors['image']; ?></small>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-default form-static-label pt-1">
                                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" autocomplete="off">
                                                        <label class="float-label font-weight-bold text-dark">Tên sản phẩm</label>
                                                        <?php if (isset($errors['name'])) { ?>
                                                            <small class="text-danger"><?= $errors['name']; ?></small>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-default form-static-label pt-1">
                                                        <select class="form-control" name="category_id" id="category_id" style="color:gray">
                                                            <option value="">Chọn danh mục</option>
                                                            <?php foreach ($getCate as $cat) { ?>
                                                                <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (isset($errors['category'])) { ?>
                                                            <small class="text-danger"><?= $errors['category']; ?></small>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group form-default form-static-label pt-1">
                                                        <input type="text" name="price" class="form-control" placeholder="Nhập giá sản phẩm" autocomplete="off">
                                                        <label class="float-label font-weight-bold text-dark">Giá sản phẩm</label>
                                                        <?php if (isset($errors['price'])) { ?>
                                                            <small class="text-danger"><?= $errors['price']; ?></small>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-default form-static-label pt-1">
                                                        <input type="text" name="sale_price" class="form-control" placeholder="Nhập giá khuyến mãi" autocomplete="off">
                                                        <label class="float-label font-weight-bold text-dark">Giá khuyến mãi</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-default form-static-label pt-1">
                                                        <select class="form-control" name="status" id="status" style="color:gray">
                                                            <option value="">Chọn trạng thái</option>
                                                            <option value="1">Còn hàng</option>
                                                            <option value="0">Hết hàng</option>
                                                        </select>
                                                        <?php if (isset($errors['status'])) { ?>
                                                            <small class="text-danger"><?= $errors['status']; ?></small>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <textarea id="summernote" name="description" class="mt-2"></textarea>
                                            <button class="btn btn-sm btn-success mt-2 btn-save">Lưu sản phẩm</button>
                                            <a href="list-product.php" class="btn btn-sm btn-info mt-2">Hủy</a>
                                        </div>

                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'layout/footer.php'; ?>


    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 116
            });

            $("#image").click(function() {
                $("#file_upload").click();
            });

            $("#file_upload").change(function() {
                var file = $(this)[0].files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#image").attr("src", e.target.result);
                }
                reader.readAsDataURL(file);
            });

            $(".btn-save").click(function(e) {
                e.preventDefault();
                var formData = new FormData($("#form_add")[0]);
                $.ajax({
                    url: "process/product/add.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        console.log(res);
                        if (res.status == false) {
                            Swal.fire({
                                html: res.message,
                                icon: res.icon
                            });
                        } 
                        if(res.status == true) {
                            window.location = res.url
                        }
                    }
                });
            });
        });
    </script>