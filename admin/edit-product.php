<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>
<?php
$getCate = mysqli_query($conn, 'select*from category');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = mysqli_fetch_object(mysqli_query($conn, "select*from product where id = $id"));
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
                        <p class="m-b-0">Chỉnh sửa sản phẩm</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Chỉnh sửa sản phẩm</a>
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
                        <div class="card">
                            <form class="form-material" method="POST" enctype="multipart/form-data" id="form_data">
                                <div class="card-header">
                                    <h5>Chỉnh sửa Sản Phẩm</h5>
                                    <a href="list-product.php" class="btn btn-sm btn-info float-right">Hủy</a>
                                    <button class="btn btn-sm btn-success float-right mr-2">Lưu sản phẩm</button>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="form-group form-default form-static-label">
                                                <label class="float-label font-weight-bold text-dark">Ảnh sản phẩm</label>
                                                <input type="file" hidden name="image" id="file_upload">
                                                <img src="assets/images/<?= $product->image; ?>" id="image" width="100%" style="cursor: pointer;" class="mt-5 mb-3">
                                                <?php if (isset($errors['image'])) { ?>
                                                    <small class="text-danger"><?= $errors['image']; ?></small>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-default form-static-label pt-1">
                                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" autocomplete="off" value="<?= $product->name; ?>">
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
                                                                <option value="<?= $cat['id']; ?>" <?= $product->category_id == $cat['id'] ? 'selected' : '' ?>><?= $cat['name']; ?></option>
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
                                                        <input type="text" name="price" class="form-control" placeholder="Nhập giá sản phẩm" autocomplete="off" value="<?= $product->price; ?>">
                                                        <label class="float-label font-weight-bold text-dark">Giá sản phẩm</label>
                                                        <?php if (isset($errors['price'])) { ?>
                                                            <small class="text-danger"><?= $errors['price']; ?></small>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-default form-static-label pt-1">
                                                        <input type="text" name="sale_price" class="form-control" placeholder="Nhập giá khuyến mãi" autocomplete="off" value="<?= $product->sale_price; ?>">
                                                        <label class="float-label font-weight-bold text-dark">Giá khuyến mãi</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-default form-static-label pt-1">
                                                        <select class="form-control" name="status" id="status" style="color:gray">
                                                            <option>Chọn trạng thái</option>
                                                            <option value="1" <?= $product->status == 1 ? 'selected' : ''; ?>>Còn hàng</option>
                                                            <option value="0" <?= $product->status == 0 ? 'selected' : ''; ?>>Hết hàng</option>
                                                        </select>
                                                        <?php if (isset($errors['status'])) { ?>
                                                            <small class="text-danger"><?= $errors['status']; ?></small>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <textarea id="description" name="description" class="mt-2"><?= $product->description; ?></textarea>
                                            <button class="btn btn-sm btn-success mt-2 btn-save">Lưu sản phẩm</button>
                                            <a href="list-product.php" class="btn btn-sm btn-info mt-2">Hủy</a>
                                        </div>

                                    </div>
                                </div>
                        </div>
                        </form>
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
            $('#description').summernote({
                height: 116
            });

            $("#image").click(function() {
                $("#file_upload").click();
            })

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
                var file = $("#file_upload")[0].files[0];
                var formData = new FormData($("#form_data")[0]);
                var id = <?= $product->id; ?>;
                $.ajax({
                    url: "process/product/edit.php?id=" + id,
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
                        } else {
                            window.location = res.url
                        }
                    }
                });
            });
        });
    </script>