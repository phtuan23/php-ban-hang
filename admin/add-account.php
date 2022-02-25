<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Quản lý tài khoản</h5>
                        <p class="m-b-0">Thêm mới tài khoản</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Thêm mới tài khoản</a>
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
                                    <h5>Thêm mới tài khoản</h5>
                                </div>
                                <div class="card-block">
                                    <form class="form-material" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">Tên khách hàng</label>
                                                    <input type="text" name="name" class="form-control" placeholder="Nhập tên khách hàng">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">Địa chỉ email</label>
                                                    <input type="text" name="email" class="form-control" placeholder="Địa chỉ email (exa@gmail.com)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Giới tính</label>
                                                    <select class="form-control" name="gender">
                                                        <option value="">Chọn giới tính</option>
                                                        <option value="0">Nam</option>
                                                        <option value="1">Nữ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="">Address</label>
                                                    <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">Mật khẩu</label>
                                                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">Xác nhận mật khẩu</label>
                                                    <input type="password" name="cf_password" class="form-control" placeholder="Xác nhận mật khẩu">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <button class="btn btn-success btn-sm btn-save"><i class="fa fa-save"></i>Lưu</button>
                                        <a href="list-account.php" class="btn btn-primary btn-sm">Quay lại</a>
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
    $(document).ready(function(){
        $(".btn-save").click(function(e){
            e.preventDefault();
            var data = $(".form-material").serialize();
            $.ajax({
                url : "process/account/add.php",
                type : "POST",
                data : data,
                success : function(res){
                    console.log(res);
                    if (res.status == false) {
                        Swal.fire({
                            html: res.message,
                            icon: res.icon
                        });
                    } else {
                        window.location.href = res.url
                    }
                }
            })
        })
    })
</script>