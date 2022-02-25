<?php 
header("Content-type: application/json; charset=utf-8");
require '../../config/connect.php';
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    if (mysqli_query($conn, "DELETE FROM category where id = '$id'")) {
        echo json_encode([
            'status' => true
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Không thể xóa danh mục hiện tại',
            'icon' => 'warning'
        ]);
    };
}
?>