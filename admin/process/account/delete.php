<?php 
header("Content-type: application/json; charset=utf-8");
require '../../config/connect.php';
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM account WHERE id = $id");
    echo json_encode([
        'status' => true
    ]);
}
?>