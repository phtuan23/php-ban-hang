<?php 
header("Content-type: application/json; charset=utf-8");
require '../../config/connect.php';
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM product WHERE id =  $id");
    echo json_encode([
        'status' => true
    ]);
}
?>