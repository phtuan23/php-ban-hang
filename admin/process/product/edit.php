<?php 
header("Content-type: application/json; charset=utf-8");
require '../../config/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = mysqli_fetch_object(mysqli_query($conn, "select*from product where id = $id"));
}
$errors = [];
if (isset($_POST['name'])) {
    $image = $product->image;
    $name = $_POST['name'];
    if ($name == '') {
        $errors['name'] = "Vui lòng nhập tên sản phẩm";
    }
    $price = $_POST['price'];
    if ($price == '') {
        $errors['price'] = "Vui lòng nhập giá sản phẩm";
    }
    $sale = $_POST['sale_price'];
    $category = $_POST['category_id'];
    if ($category == '') {
        $errors['category'] = "Vui lòng chọn danh mục sản phẩm";
    }
    $description = $_POST['description'] ? $_POST['description'] : "New";
    $status = $_POST['status'];
    if ($_FILES['image']['name'] != '') {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../assets/images/' . $image);
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
        $sql = "update product set name='$name', price='$price', sale_price='$sale', category_id='$category', status='$status', description='$description',image = '$image' where id = $id";
        if (mysqli_query($conn, $sql)) {
            echo json_encode([
                'status' => true,
                'url' => 'list-product.php'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Cập nhật thất bại. Vui lòng thử lại',
                'icon' => 'error'
            ]);
        }
    }
}
?>