<?php 
    header("Content-type: application/json; charset=utf-8");
    require '../../config/connect.php';
    $errors = [];
    if(isset($_POST['name'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $confirm_password = $_POST['cf_password'];
        if($name == ''){
            $errors['name'] = "Vui lòng nhập tên";
        }
        if($email == ''){
            $errors['email'] = "Vui lòng nhập email";
        }
        if($password == ''){
            $errors['password'] = "Vui lòng nhập mật khẩu";
        }
        if($confirm_password == ''){
            $errors['cf_password'] = "Vui lòng xác nhận mật khẩu";
        }
        if($password != $confirm_password){
            $errors['cf_password'] = "Mật khẩu không trùng nhau";
        }
        if ($errors) {
            $html = "<ul class='list-group'>";
            foreach ($errors as $err) {
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            echo json_encode([
                'status' => false,
                'message' => $html,
                'icon' => 'error'
            ]);
        }else{
            $sql = "INSERT INTO account set name = '$name', email = '$email', password = '$password', phone = '$phone', address = '$address', gender = '$gender' " ;
            if(mysqli_query($conn,$sql)){
                echo json_encode([
                    'status' => true,
                    'url' => 'list-account.php'
                ]);
            }else {
                echo json_encode([
                    'status' => false,
                    'message' => "Tên danh mục đã tồn tại",
                    'icon' => 'error'
                ]);
            }
        }
    }
?>