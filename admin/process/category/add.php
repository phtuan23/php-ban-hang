<?php
header("Content-type: application/json; charset=utf-8");
require '../../config/connect.php';

$errors = [];
if (isset($_POST['name'])) {
    $name = $_POST['name'];

    if (isset($_POST['status'])) {
        $status = $_POST['status'];
    } else {
        $status = 0;
    }

    if ($name == '') {
        $errors['name'] = 'Tên danh mục không để trống !';
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
    }
    if (!$errors) {
        $sql = "INSERT INTO category set name = '$name' , status = '$status'";
        if (mysqli_query($conn, $sql)) {
            echo json_encode([
                'url' => 'category.php'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => "Tên danh mục đã tồn tại",
                'icon' => 'error'
            ]);
        }
    }
}
?>