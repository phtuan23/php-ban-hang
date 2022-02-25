<?php
header("Content-type: application/json; charset=utf-8");
require '../../config/connect.php';
$errors = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $category = mysqli_fetch_object(mysqli_query($conn, "select*from category where id = $id"));
}
if (isset($_POST['name'])) {
    $name = $_POST['name'];

    $status = isset($_POST['status']) ? ($_POST['status']) : 0;

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
    } else {
        $id = $_GET['id'];
        $sql = "UPDATE category set name = '$name' , status = '$status' WHERE id = $id";
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