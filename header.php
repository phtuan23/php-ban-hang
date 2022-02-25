<?php session_start(); 
ob_start();
include 'connect/connect.php'; 
if(isset($_SESSION['cart'])){
    $number = count($_SESSION['cart']);
}
?>
        
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vegefoods</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="src/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="src/css/animate.css">

    <link rel="stylesheet" href="src/css/owl.carousel.min.css">
    <link rel="stylesheet" href="src/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="src/css/magnific-popup.css">

    <link rel="stylesheet" href="src/css/aos.css">

    <link rel="stylesheet" href="src/css/ionicons.min.css">

    <link rel="stylesheet" href="src/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="src/css/jquery.timepicker.css">


    <link rel="stylesheet" href="src/css/flaticon.css">
    <link rel="stylesheet" href="src/css/icomoon.css">
    <link rel="stylesheet" href="src/css/style.css">
</head>

<body class="goto-here">
    <div class="py-1 bg-primary">
        <div class="container">
            <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
                <div class="col-lg-12 d-block">
                    <div class="row d-flex">
                        <div class="col-md pr-4 d-flex topper align-items-center">
                            <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                            <span class="text">+ 1235 2355 98</span>
                        </div>
                        <div class="col-md pr-4 d-flex topper align-items-center">
                            <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                            <span class="text">youremail@email.com</span>
                        </div>
                        <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
                            <span class="text">3-5 Business days delivery &amp; Free Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">Vegefoods</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.php" class="nav-link">Trang chủ</a></li>
                    <li class="nav-item">
                    <li class="nav-item"><a href="shop.php" class="nav-link">Cửa hàng</a></li>
                    </li>
                    <li class="nav-item"><a href="about.php" class="nav-link">Về chúng tôi</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Liên Hệ</a></li>
                    <li class="nav-item cta cta-colored"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart"></span><?=(isset($_SESSION['cart']))? $number : 0?></a></li>
                    <?php if(isset($_SESSION['user'])) { ?>
                        <li class="nav-item"><a href="profile.php" class="nav-link"><?=$_SESSION['user']->name;?></span></a></li>
                        <li class="nav-item"><a href="log-out.php" class="nav-link">Đăng xuất</span></a></li>
                    <?php }else{ ?>
                        <li class="nav-item"><a href="login.php" class="nav-link"><span class="icon-user"></span></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    