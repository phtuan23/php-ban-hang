<?php include 'header.php'; ?>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        background: rgb(219, 226, 226);
    }

    .row {
        background: inherit;
        border-radius: 30px;
        box-shadow: 12px 12px 22px gray;
    }

    img {
        width: 100%;
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px;
    }

    .btn1 {
        border: none;
        outline: none;
        height: 50px;
        width: 100%;
        background-color: #82ae46;
        color: white;
        border-radius: 4px;
        font-weight: bold;
    }

    .btn1:hover {
        background: white;
        border: 1ps solid red;
        color: #82ae46;
    }

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

if (isset($_POST['email'])) {

    $email = $_POST['email'];

    $password = $_POST['password'];

    if ($email == '') {
        $errors['email'] = 'Email không được để trống';
    }
    if ($password == '') {
        $errors['password'] = 'Mật khẩu không được để trống';
    }

    if (!$errors) {
        $sql = "SELECT*FROM account WHERE email = '$email' AND password = '$password'";
        $query = mysqli_query($conn,$sql);
        $user = mysqli_fetch_object($query);
        if($user){
            $_SESSION['user'] = $user;
            header('location: index.php');
        }else{
            $errors['login_false'] = 'Tài khoản hoặc mật khẩu không đúng!';
        }
    }
}
?>
<section class="form my-4 mx-5">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-5 mr-auto">
                <img src="src/images/image_1.jpg" width="100%" height="550">
            </div>
            <div class="col-lg-7 px-5 pt-5">
                <h1 class="font-weight-bold py-3" style="color:#82ae46">VEGEFOODS</h1>
                <h3>Sign In Your Account</h3>
                <div class="container">
                    <?php if ($errors) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($errors as $err) { ?>
                                <li><?= $err ?></li>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <form method="post">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="padding:0 17.5px"><i class="icon-envelope"></i> </span>
                        </div>
                        <input class="form-control" name="email" placeholder="Email address" type="email">
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="icon-lock"></i> </span>
                        </div>
                        <input class="form-control" name="password" placeholder="Password" type="password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Login </button>
                    </div>
                    <a href="forgot-password.php">Forgot password?</a>
                    <p class="text-center">Do not have an account <a href="register.php">Register</a> </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php' ?>