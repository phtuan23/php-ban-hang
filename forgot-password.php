<?php
include 'header.php';
include 'mailer/PHPMailerAutoload.php';

$errors = [];

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if ($email == '') {
        $errors['email'] = 'Email is not empty!';
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errors['email'] = 'Invalid email address';
    }
    if (!$errors) {
        $sql = "SELECT*FROM account WHERE email =  '$email' ";
        $user = mysqli_fetch_object(mysqli_query($conn, $sql));
        if (!$user) {
            $errors['user'] = 'Email does not exist';
        }
        if ($user) {
            $id = $user->id;
            $emailTo = $user->email;
            $url = "http://localhost:88/btl/reset-password.php?id=$id";

            $mail = new PHPMailer;
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'tuantuan230298@gmail.com';                 // SMTP username
            $mail->Password = 'rhnnkaldrtulnilw';                           // SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;                                     // TCP port to connect to

            $mail->setFrom('tuantuan230298@gmail.com', 'Food And Drink');
            $mail->addAddress($emailTo);
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = $url;
        }
    }
}

?>



<hr>
<br>
<div class="container">
    <?php if (!isset($user)) { ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 m-auto">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="icon-lock"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <?php if (isset($errors)) { ?>
                                <?php foreach ($errors as $err) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <li><?= $err; ?></li>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <div class="panel-body">
                                <form class="form" method="POST">
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>

                                                <input placeholder="email address" class="form-control" type="text" name="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input class="btn btn-lg btn-primary btn-block" value="Send" type="submit">
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="jumbotron jumbotron-fluid" style="background-color: inherit;">
            <div class="container text-center">
                <h1 class="display-4">Message has been sent</h1>
                <p class="lead">Message has been sent to your email. Please check your email.</p>
            </div>
        </div>
    <?php } ?>
</div>
<br>
<hr>


<?php include 'footer.php'; ?>