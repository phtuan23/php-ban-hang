<?php 
    header("Content-type: application/json; charset=utf-8");
    require '../../config/connect.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $account = mysqli_fetch_object(mysqli_query($conn, "select*from account where id = $id"));
    }
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
        if($password != $account->password){
            $errors['password'] = "Mật khẩu hiện tại không đúng";
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
            $sql = "UPDATE account set name = '$name', email = '$email', phone = '$phone', address = '$address', gender = '$gender' WHERE id = $id" ;
            if(mysqli_query($conn,$sql)){
                echo json_encode([
                    'status' => true,
                    'url' => 'list-account.php'
                ]);
            }
        }
    }
?>