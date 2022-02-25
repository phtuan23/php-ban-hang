<?php 
    header("Content-type: application/json; charset=utf-8");
    session_start();
    include 'admin/config/connect.php';

    $id = !empty($_GET['id']) ? $_GET['id'] : 0;
    $quantity = !empty($_GET['quantity']) ? $_GET['quantity'] : 1;
    if($quantity < 0){
        $quantity = 1;
    }
    $action = !empty($_GET['action']) ? $_GET['action'] : 'add';
    $query = mysqli_query($conn,"SELECT*FROM product WHERE id = '$id'");
    $product = mysqli_fetch_object($query);

    if($product && $action =='add'){
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        }else{
            $cart = [
                'id' => $id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => (($product->sale_price) > 0) ? $product->sale_price : $product->price,
                'quantity' => $quantity
            ];
            $_SESSION['cart'][$id] = $cart;
        }
        echo json_encode([
            'status' => true,
            'icon' => 'success',
            'message' => 'Đã thêm vào giỏ hàng'
        ]);
    }

    if($product && $action =='update'){
        if(isset($_SESSION['cart'][$id])){
            if(is_numeric($quantity)){
                $_SESSION['cart'][$id]['quantity'] = $quantity;
                echo json_encode([
                    'status' => true
                ]);
            }else{
                echo json_encode([
                    'status' => false,
                    'message' => 'Số lượng không hợp lệ. Vui lòng nhập lại',
                    'icon' => 'warning'
                ]);
            }
        }
    }

    if($product && $action =='delete'){
        if(isset($_SESSION['cart'][$id])){
            unset($_SESSION['cart'][$id]);
            echo json_encode([
                'status' => true
            ]);
        }
    }
?>