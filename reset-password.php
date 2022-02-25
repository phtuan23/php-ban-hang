<?php include 'header.php';
$errors = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if(isset($_POST['nw_pass'])){
        $password = $_POST['nw_pass'];
        $re_password = $_POST['re_password'];
        if ($password == '') {
            $errors['nw_pass'] = 'Password is not empty';
        }
        if ($re_password == '') {
            $errors['re_password'] = 'ReEnter Password is not empty';
        }
        if ($password != $re_password) {
            $errors['check'] = 'Passwords do not match';
        }

        if (!$errors) {
            $sql = "UPDATE account SET password = '$password' WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                header('location: login.php');
            } else {
                $errors['reset'] = 'Please check again.';
            }
        }
    }
    
}else{
    header('location: forgot-password.php');
}

?>
<br>
<hr>
<div class="container">
    <div class="row">
        <div class="col-md-6 m-auto">
            <?php if ($errors) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $err) { ?>
                        <li><?=$err;?></li>
                    <?php } ?>
                </div>
            <?php } ?>
            <form action="#" method="post">
                <div class="row mb-1">
                    <div class="col-md-6">
                        <label>New Password</label>
                    </div>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="nw_pass" style="height:35px !important">
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6">
                        <label>Re Password</label>
                    </div>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="re_password" style="height:35px !important">
                    </div>
                </div>
                <button class="btn btn-sm btn-success"><i class="icon-save mr-2"></i>Save</button>
            </form>
        </div>
    </div>
</div>
<br>
<hr>
<?php include 'footer.php'; ?>