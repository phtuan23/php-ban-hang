<?php
    include 'connect/connect.php'; 
    $errors = [];
    if (isset($_POST['cr_pass'])) {
        $id = $_POST['id'];
        $customer = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM account WHERE id = $id"));
        $cr_pass = $_POST['cr_pass'];
        $nw_pass = $_POST['nw_pass'];
        $re_password = $_POST['re_password'];

        if($cr_pass!=$customer->password){
            $errors['cr_pass'] = 'Mật khẩu hiện tại không đúng';
        }
        if($cr_pass==''){
            $errors['cr_pass'] = "Vui lòng nhập mật khẩu hiện tại";
        }
        if($nw_pass==''){
            $errors['nw_pass'] = "Vui lòng nhập mật khẩu mới";
        }
        if($re_password==''){
            $errors['re_password'] = "Vui lòng xác nhận lại mật khẩu";
        }
        if ($nw_pass != $re_password) {
            $errors['check_pass'] = 'Mật khẩu không trùng nhau!';
        }
        if($errors){
            $html = "<ul class='list-group'>";
            foreach ($errors as $err) {
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            echo json_encode([
                'status' => false,
                'message' => $html,
                'icon' => 'error'
            ]);
            die;
        }else{
            $sql = "UPDATE account SET password = '$nw_pass' WHERE id = $customer->id";
            mysqli_query($conn, $sql);
            echo json_encode([
                'status' => true
            ]);
            die;
        }
    }
    
?>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="src/css/profile.css">
<?php
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
$id = $_SESSION['user']->id;
$sql = "SELECT*FROM account WHERE id = $id";
$query = mysqli_query($conn, $sql);
$user = mysqli_fetch_object($query);
if (!empty($_FILES)) {
    move_uploaded_file($_FILES['avatar']['tmp_name'], 'admin/assets/images/'.$_FILES['avatar']['name']);
    $avatar = $_FILES['avatar']['name'];
    $sql = "UPDATE account SET avatar = '$avatar' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("location: profile.php");
    }
}
$errors = [];
if (isset($_POST['name'])) {
    $id = $_SESSION['user']->id;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    $sql = "UPDATE account SET name = '$name', email = '$email', address = '$address', phone = '$phone', gender = '$gender' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("location: profile.php");
    }
}

?>
<div class="container emp-profile">
    <form method="post" enctype="multipart/form-data" id="form-avatar">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <?php if ($_FILES) { ?>
                        <img src="<?= $avatar; ?>" />
                    <?php } else { ?>
                        <img src="admin/assets/images/<?= $user->avatar ?>" style="cursor: pointer;" id="image"/>
                    <?php } ?>
                    <input type="file" name="avatar" id="avatar" hidden/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h5>
                        <?= $user->name; ?>
                    </h5>
                    <p class="proile-rating " style="padding-bottom: 60px;">Thành viên : <span>Gold</span></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Thông tin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile-update" role="tab" aria-controls="profile-update" aria-selected="false">Cập nhật</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="password-tab" data-toggle="tab" href="#password-update" role="tab" aria-controls="profile-update" aria-selected="false">Đổi mật khẩu</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="profile-work">
                <a class="active">Trang cá nhân</a><br />
                <a href="log-out.php"><i class="icon-sign-out mr-1"></i>Đăng xuất</a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="tab-content profile-tab" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tên</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user->name ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Email</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user->email ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Số điện thoại</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user->phone ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Địa chỉ</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user->address ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Giới tính</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= ($user->gender) == 0 ? 'Nam' : 'Nữ'; ?></p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile-update" role="tabpanel" aria-labelledby="profile-tab">
                    <form method="post" id="form-info">
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label>Tên</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" style="height:35px !important" value="<?=$user->name;?>">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" style="height:35px !important" value="<?=$user->email;?>">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label>Số điện thoại</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone" style="height:35px !important" value="<?=$user->phone;?>">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label>Địa chỉ</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="address" style="height:35px !important" value="<?=$user->address;?>">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label>Giới tính</label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" name="gender" value="0" <?=$user->gender==0?'checked':'';?>>
                                <label for="Male" class="mr-3">Nam</label>
                                <input type="radio" name="gender" value="1" <?=$user->gender==1?'checked':'';?>>
                                <label for="FaMale">Nữ</label>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-success btn-update-info"><i class="icon-save mr-2"></i>Lưu</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="password-update" role="tabpanel" aria-labelledby="password-tab">
                    <form method="post" id="form-password">
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label>Mật khẩu hiện tại</label>
                            </div>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="cr_pass" style="height:35px !important">
                                 <input type="hidden" class="form-control" name="id" value="<?=$user->id;?>">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label>Mật khẩu mới</label>
                            </div>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="nw_pass" style="height:35px !important">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label>Nhập lại mật khẩu mới</label>
                            </div>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="re_password" style="height:35px !important">
                            </div>
                        </div>
                        <button class="btn btn-sm btn-success btn-change-password"><i class="icon-save mr-2"></i>Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>
<script>
    $(document).ready(function() {
        $(document).on('click','#image',function(){
           $("#avatar").click(); 
        });

        $("#avatar").change(function(){
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function(e){
                $("#image").attr("src", e.target.result);
            }
            reader.readAsDataURL(file);
            var formData = new FormData($("#form-avatar")[0]);
            $.ajax({
                url : window.location.href,
                type : "POST",
                data : formData,
                processData: false,
                contentType: false,
                success : function(res){
                    $("#image").load(location.href + " #image>*");
                }
            })
        });

        $(".btn-change-password").click(function(e){
            e.preventDefault();
            var data = $("#form-password").serialize();
            $.ajax({
                url : window.location.href,
                type : "POST",
                data : data,
                success : function(res){
                    var _res = JSON.parse(res)
                    if(_res.status==false){
                        Swal.fire({
                            html: _res.message,
                            icon: _res.icon
                        });
                    }if(_res.status==true){
                        Swal.fire({
                            html: "Đổi mật khẩu thành công",
                            icon: "success"
                        });
                        $(".emp-profile").load(location.href + " .emp-profile>*");
                    }
                }
            })
        });
    });
</script>