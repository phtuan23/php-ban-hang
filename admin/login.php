<?php
session_start();
include 'config/connect.php';
$errors = [];
if(isset($_POST['name'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    if($name==''){
        $errors['name'] = "Vui lòng nhập tên đăng nhập.";
    }
    if($password==''){
        $errors['password'] = "Vui lòng nhập mật khẩu.";
    }
    if($errors){
        $html = "<ul class='list-group'>";
        foreach($errors as $err){
            $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
        }
        echo json_encode([
            'status' => false,
            'message' => $html,
            'icon' => 'error'
        ]);
        die;
    }else{
        $sql = "SELECT*FROM admin WHERE name = '$name' AND password = '$password' ";
        $result = mysqli_query($conn,$sql);
        $user = mysqli_fetch_assoc($result);
        if(isset($user)){
            $_SESSION["admin"] = $user;
            echo json_encode([
                'url' => "index.php"
            ]);
            die;
        }else{
            echo json_encode([
                'status' => false,
                'message' => "Tài khoản hoặc mật khẩu không đúng.",
                'icon' => 'error'
            ]);
            die;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />
    <!-- Favicon icon -->

    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
    <style>
        /* sign in FORM */
        #logreg-forms {
            width: 412px;
            margin: 10vh auto;
            background-color: #f3f3f3;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
        }

        #logreg-forms form {
            width: 100%;
            max-width: 410px;
            padding: 15px;
            margin: auto;
        }

        #logreg-forms .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        #logreg-forms .form-control:focus {
            z-index: 2;
        }

        #logreg-forms .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        #logreg-forms .form-signin input[type="password"] {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        #logreg-forms .social-login {
            width: 390px;
            margin: 0 auto;
            margin-bottom: 14px;
        }

        #logreg-forms .social-btn {
            font-weight: 100;
            color: white;
            width: 190px;
            font-size: 0.9rem;
        }

        #logreg-forms a {
            display: block;
            padding-top: 10px;
            color: lightseagreen;
        }

        #logreg-form .lines {
            width: 200px;
            border: 1px solid red;
        }


        #logreg-forms button[type="submit"] {
            margin-top: 10px;
        }

        #logreg-forms .facebook-btn {
            background-color: #3C589C;
        }

        #logreg-forms .google-btn {
            background-color: #DF4B3B;
        }

        #logreg-forms .form-reset,
        #logreg-forms .form-signup {
            display: none;
        }

        #logreg-forms .form-signup .social-btn {
            width: 210px;
        }

        #logreg-forms .form-signup input {
            margin-bottom: 2px;
        }

        .form-signup .social-login {
            width: 210px !important;
            margin: 0 auto;
        }

        /* Mobile */

        @media screen and (max-width:500px) {
            #logreg-forms {
                width: 300px;
            }

            #logreg-forms .social-login {
                width: 200px;
                margin: 0 auto;
                margin-bottom: 10px;
            }

            #logreg-forms .social-btn {
                font-size: 1.3rem;
                font-weight: 100;
                color: white;
                width: 200px;
                height: 56px;

            }

            #logreg-forms .social-btn:nth-child(1) {
                margin-bottom: 5px;
            }

            #logreg-forms .social-btn span {
                display: none;
            }

            #logreg-forms .facebook-btn:after {
                content: 'Facebook';
            }

            #logreg-forms .google-btn:after {
                content: 'Google+';
            }

        }
    </style>
</head>

<body>
    <div id="logreg-forms">
        <form class="form-signin" method="POST" id="form_login">
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">đăng nhập để tiếp tục</h1>
            <div class="social-login">
                <button class="btn facebook-btn social-btn" type="button"><span><i class="fa fa-facebook"></i> Đăng nhập với Facebook</span> </button>
                <button class="btn google-btn social-btn" type="button"><span><i class="fa fa-google-plus"></i> Đăng nhập với Google+</span> </button>
            </div>
            <p style="text-align:center"> OR </p>
            <input type="text" name="name"  class="form-control mb-3" placeholder="Tài khoản" >
            <input type="password" name="password"  class="form-control mb-3" placeholder="Mật khẩu">

            <button class="btn btn-success btn-block btn-login"><i class="fa fa-sign-in"></i> Đăng nhập</button>
            <a href="#" class="mt-1 text-center">Quên mật khẩu?</a>
        </form>
    </div>


    <script type="text/javascript" src="assets/js/jquery/jquery.min.js "></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
    <!-- waves js -->
    <script src="assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="assets/js/common-pages.js"></script>
    <script>
        function toggleResetPswd(e) {
            e.preventDefault();
            $('#logreg-forms .form-signin').toggle() // display:block or none
            $('#logreg-forms .form-reset').toggle() // display:block or none
        }

        function toggleSignUp(e) {
            e.preventDefault();
            $('#logreg-forms .form-signin').toggle(); // display:block or none
            $('#logreg-forms .form-signup').toggle(); // display:block or none
        }

        $(() => {
            // Login Register Form
            $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
            $('#logreg-forms #cancel_reset').click(toggleResetPswd);
            $('#logreg-forms #btn-signup').click(toggleSignUp);
            $('#logreg-forms #cancel_signup').click(toggleSignUp);
        })
    </script>
    <script>
        $(document).ready(function(){
            $(".btn-login").click(function(e){
                e.preventDefault();
                var url = window.location.href;
                var data = $("#form_login").serialize();
                var response;
                $.ajax({
                    url : url,
                    data : data,
                    type : "POST",
                    success : function (res){
                        response = JSON.parse(res);
                        if(response.status == false){
                            Swal.fire({
                                html: response.message,
                                icon: response.icon
                            });
                        }else{
                            window.location.href = response.url
                        }
                        
                    }
                });
            });
        });
    </script>
</body>

</html>