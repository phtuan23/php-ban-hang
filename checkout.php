
<?php
include 'header.php';

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

$price = 0;

$cart = $_SESSION['cart'];

foreach ($cart as $item) {
    $price += $item['price'] * $item['quantity'];
}

$subtotal = ($_SESSION['cart']) ? $price : 0;

$ship = (count($_SESSION['cart']) > 0) ? 30000 : 0;

$user = $_SESSION['user'];

$errors = [];
if (isset($_POST['create_order'])) {
    $customer_id = $user->id;
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if ($name == '') {
        $errors['name'] = 'Name is not empty';
    }
    if ($phone == '') {
        $errors['phone'] = 'Phone is not empty';
    }
    if ($email == '') {
        $errors['email'] = 'Email is not empty';
    }
    if ($address == '') {
        $errors['address'] = 'Address is not empty';
    }
    if (!$errors) {
        $today = date("d/m/Y");
        $sql = "INSERT INTO orders SET customer_id = $customer_id , name = '$name' , email = '$email' , phone = '$phone' , address = '$address'";
        if (mysqli_query($conn, $sql)) {
            $order_query = mysqli_query($conn, "SELECT id FROM orders WHERE customer_id = $customer_id ORDER BY id DESC LIMIT 1 ");
            // get id of orders;
            $id_order = mysqli_fetch_object($order_query);
            // 
            $num = 0;
            $total_price = 0;
            $table = "";
            $table =  "<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 50%;'>";
            $table .= " <tr style='text-align:center;'>
                                <th style='border: 1px solid #ddd;padding: 8px;text-align: center;background-color: #4CAF50;color: white;'>ID</th>
                                <th style='border: 1px solid #ddd;padding: 8px;text-align: center;background-color: #4CAF50;color: white;'>Name</th>
                                <th style='border: 1px solid #ddd;padding: 8px;text-align: center;background-color: #4CAF50;color: white;'>Price</th>
                                <th style='border: 1px solid #ddd;padding: 8px;text-align: center;background-color: #4CAF50;color: white;'>Quantity</th>
                                <th style='border: 1px solid #ddd;padding: 8px;text-align: center;background-color: #4CAF50;color: white;'>Total</th>
                            </tr>";

            //  HTML PDF
            $html_pdf = "<div id='bill'>";
            $html_pdf .= "<h1>Food And Drink</h1>
                          <h3>Orders Detail</h3>
                          <div class='invoice-box'>
                            <table>
                                <tbody>
                                    <tr class='top'>
                                        <td colspan='2'>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td class='title'>
                                                            VEGEFOODS
                                                        </td>
                    
                                                        <td>
                                                            Invoice #:".$id_order->id."<br>
                                                            Created: ".$today."
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class='information'>
                                        <td colspan='2'>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Vegefoods<br>
                                                            238 Hoang Quoc Viet<br>
                                                            098989898
                                                        </td>

                                                        <td>
                                                            $name<br>
                                                            $phone<br>
                                                            $email<br>
                                                            $address
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr class='heading'>
                                        <td>Item</td>

                                        <td>Price</td>
                                    </tr>
                        ";

            foreach ($_SESSION['cart'] as $key => $item) {
                $id = $id_order->id;
                $num++;
                $price = $item['price'];
                $id_product = $key;
                $quantity = $item['quantity'];
                $name = $item['name'];
                mysqli_query($conn, "INSERT INTO order_detail SET order_id = $id, product_id = $id_product, quantity = $quantity,price = $price");
                $total_price += $quantity * $price;
                $table .=   " <tr style='text-align:center;'>
                                    <td style='border: 1px solid #ddd;padding: 8px;'>$num</td>
                                    <td style='border: 1px solid #ddd;padding: 8px;'>$name</td>
                                    <td style='border: 1px solid #ddd;padding: 8px;'>".number_format($price)."</td>
                                    <td style='border: 1px solid #ddd;padding: 8px;'>$quantity</td>
                                    <td style='border: 1px solid #ddd;padding: 8px;'>".number_format($price*$quantity)."</td>
                                </tr>";
                $html_pdf .= "<tr class='item'>
                                <td>$name x $quantity</td>
                                <td>".number_format($price*$quantity)."</td>
                            </tr>";
            }
            $table .= "<tr><td>Subtotal : " . number_format($total_price)."</td></tr>";
            $table .= "<tr><td>Ship : " . number_format($ship)."</td></tr>";
            $table .= "<tr><td>Total : " . number_format($total_price+$ship)."</td></tr>";
            $table .= "</table>";

            // HTML PDF
            $html_pdf .= "  <tr class='item last'>
                                <td>Ship</td>
                                <td>".number_format($ship)."</td>
                            </tr>
                            <tr class='total'>
                                <td></td>
                                <td>Total: ".number_format($total_price+$ship)."</td>
                            </tr>";
            $html_pdf .= "</tbody></table></div></div>";

            require_once __DIR__ . '/vendor/autoload.php';

            $mpdf = new \Mpdf\Mpdf(['utf-8', 'A4-L']);

            $mpdf->setAutoTopMargin = 'stretch';
            $mpdf->setAutoBottomMargin = 'stretch';

            $file_name = 'src/pdf/mypdf.pdf';

            $style = file_get_contents('src/css/pdf.css');

            $mpdf->WriteHTML($style,1);
            $mpdf->WriteHTML($html_pdf);

            $mpdf->Output($file_name,'F');
            // PHPMailer
            include 'mailer/PHPMailerAutoload.php';

            $mail = new PHPMailer;
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'tuantuan230298@gmail.com';                 // SMTP username
            $mail->Password = 'rhnnkaldrtulnilw';                           // SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;                                     // TCP port to connect to

            $mail->setFrom('tuantuan230298@gmail.com', 'Food And Drink');
            $mail->addAddress('tuantuan230298@gmail.com');     // Add a recipient

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Information your orders';
            $mail->Body    = $table;
            $mail->addAttachment($file_name);
            // $mail->AltBody = 'Infomation your orders here.';
            if ($mail->send()) {
                header('location: index.php');
                unset($_SESSION['cart']);
            } else {
                echo $mail->ErrorInfo;
            }
        }
    }
}


?>
<div class="hero-wrap hero-bread" style="background-image: url('src/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Checkout</span></p>
                <h1 class="mb-0 bread">Checkout</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 ftco-animate">
                <form class="billing-form" method="post">
                    <h3 class="mb-4 billing-heading">Order Details</h3>
                    <?php if ($errors) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($errors as $err) { ?>
                                <li><?php echo $err; ?></li>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">Full Name (*)</label>
                                <input type="text" name="name" class="form-control" placeholder="Your name" value="<?=$user->name?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone (*)</label>
                                <input type="text" name="phone" class="form-control" placeholder="Your phone" value="<?=$user->phone?>">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="streetaddress">Email (*)</label>
                                <input type="text" name="email" class="form-control" placeholder="Your email address" value="<?=$user->email?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailaddress">Address (*)</label>
                                <input type="text" name="address" class="form-control" placeholder="House number and street name" value="<?=$user->address?>">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary py-3 px-4" name="create_order">Place an order</button>
                </form><!-- END -->
            </div>
            <div class="col-xl-5">
                <div class="row mt-5 pt-3">
                    <div class="col-md-12 d-flex mb-5">
                        <div class="cart-detail cart-total p-3 p-md-4">
                            <h3 class="billing-heading mb-4">Cart Total</h3>
                            <p class="d-flex">
                                <span>Subtotal</span>
                                <span><?= number_format($subtotal); ?>đ</span>
                            </p>
                            <p class="d-flex">
                                <span>Ship</span>
                                <span><?= number_format($ship); ?>đ</span>
                            </p>
                            <hr>
                            <p class="d-flex total-price">
                                <span>Total</span>
                                <span><?= number_format($subtotal + $ship) ?>đ</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div> <!-- .col-md-8 -->
        </div>
    </div>
</section> <!-- .section -->

<?php include 'footer.php'; ?>



</table>