<?php include 'layout/header.php'; ?>
<?php include 'layout/navbar.php'; ?>
<?php
$sql = 'SELECT * FROM account';
$query = mysqli_query($conn, $sql);
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Quản lý tài khoản</h5>
                        <p class="m-b-0">Danh sách tài khoản</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Danh sách tài khoản</a>
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
                            <h5>Danh sách tài khoản</h5>
                            <div class="p-15 ">
                                <form class="form-material">
                                    <div class="form-group form-primary">
                                        <input type="text" name="" class="form-control">
                                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Tìm kiếm</label>
                                    </div>
                                </form>
                                <a href="add-account.php" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>Thêm mới tài khoản</a>
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
                            <div class="table-responsive">
                                <table class="table text-center" id="table-data">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ảnh</th>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Giới tính</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($acc = mysqli_fetch_assoc($query)) { ?>
                                            <tr>
                                                <td><?= $acc['id']; ?></td>
                                                <td>
                                                    <img src="assets/images/<?= $acc['avatar']; ?>" width="80">
                                                </td>
                                                <td><?= $acc['name']; ?></td>
                                                <td><?= $acc['email']; ?></td>
                                                <td><?= $acc['phone']; ?></td>
                                                <td><?= ($acc['gender'] == 0) ? 'Nam' : 'Nữ'; ?></td>
                                                <th>
                                                    <a href="edit-account.php?id=<?= $acc['id']; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i></a>
                                                    <?php if($_SESSION['admin']['id'] != $acc['id']){ ?>
                                                    <a href="process/account/delete.php?delete=<?= $acc['id']; ?>" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a>
                                                    <?php } ?>
                                                </th>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
            $(document).on('click','.btn-delete',function(e){
                e.preventDefault();
                var href = $(this).attr('href');
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
                            url: href,
                            type: "GET",
                            success: function(res) {
                                console.log(res);
                                if (res.status == false) {
                                    Swal.fire({
                                        html: res.message,
                                        icon: res.icon
                                    });
                                }
                                if (res.status == true) {
                                    Swal.fire({
                                        html: "Xóa thành công",
                                        icon: "success"
                                    });
                                    $("#table-data").load("list-account.php" + " #table-data>*");
                                }
                            }
                        });
                    }
                });
            });
        })
    </script>