<?php include 'header.php'; ?>
<style>
    .divider-text {
        position: relative;
        text-align: center;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .divider-text span {
        padding: 7px;
        font-size: 12px;
        position: relative;
        z-index: 2;
    }

    .divider-text:after {
        content: "";
        position: absolute;
        width: 100%;
        border-bottom: 1px solid #ddd;
        top: 55%;
        left: 0;
        z-index: 1;
    }

    .btn-facebook {
        background-color: #405D9D;
        color: #fff;
    }

    .btn-twitter {
        background-color: #42AEEC;
        color: #fff;
    }

    .input-group-text {
        padding: 0 20px;
    }
</style>

<?php
$errors = [];
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rp_password = $_POST['rp_password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    if ($name == '') {
        $errors['name'] = 'Tên không được để trống!';
    }
    if ($email == '') {
        $errors['email'] = 'Địa chỉ email không được để trống!';
    }
    if ($password == '') {
        $errors['password'] = 'Mật khẩu không được để trống!';
    }
    if (strlen($password) < 6 or strlen($password) > 30) {
        $errors['password'] = 'Mật khẩu từ 6 đến 30 ký tự!';
    }
    if ($password != $rp_password) {
        $errors['rp_password'] = 'Mật khẩu không trùng nhau. Vui lòng nhập lại!';
    }
    if ($phone == '') {
        $errors['phone'] = 'Số điện thoại không được để trống!';
    }

    if (!$errors) {
        $sql = "INSERT INTO account SET name = '$name' , email = '$email' , password = '$password' , phone = '$phone', address = '$address' , gender = '$gender'";
        if (mysqli_query($conn, $sql)) {
            header("location: login.php");
        } else {
            $errors['register'] = 'Đăng ký tài khoản thất bại. vui lòng thử lại!';
        }
    }
}
?>
<div class="card bg-light">
    <article class="card-body mx-auto" style="max-width: 500px;">
        <h4 class="card-title mt-3 text-center">Create Account</h4>
        <p class="text-center">Get started with your free account</p>
        <!-- errors -->
        <div class="container">
            <?php if ($errors) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $err) { ?>
                        <li><?= $err ?></li>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <!-- end errors -->
        <form method="post">
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="icon-user"></i> </span>
                </div>
                <input class="form-control" name="name" placeholder="Full name" type="text">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:0 17.5px"><i class="icon-envelope"></i> </span>
                </div>
                <input class="form-control" name="email" placeholder="Email address" type="email">
            </div> <!-- form-group// -->
            <!-- form-group// -->
            <!-- form-group end.// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="icon-lock"></i> </span>
                </div>
                <input class="form-control" name="password" placeholder="Create password" type="password">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="icon-lock"></i> </span>
                </div>
                <input class="form-control" name="rp_password" placeholder="Repeat password" type="password">
            </div>
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="icon-phone"></i> </span>
                </div>
                <input class="form-control" name="phone" placeholder="Phone" type="text">
            </div>
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="icon-map"></i></span>
                </div>
                <input class="form-control" name="address" placeholder="Address" type="text">
            </div>
            <div class="form-group input-group">
                <label for="gender"></label>
                <select class="form-control" name="gender" id="gender">
                    <option>Chọn giới tính</option>
                    <option value="0">Male</option>
                    <option value="1">Famale</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> Create Account </button>
            </div> <!-- form-group// -->
            <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>
        </form>
    </article>
</div> <!-- card.// -->


<?php include 'footer.php' ?>