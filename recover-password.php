<?php
require_once ('./include/Db.php');
$msg = '';
if (isset($_GET['msg']))
    $msg = $_GET['msg'];
$type = 'info';
if (isset($_GET['type']))
    $type = $_GET['type'];
//$selector = '';
//$validator = '';
//if (isset($_GET['selector'])) {
//    $selector = $_GET['selector'];
//}
//if (isset($_GET['validator'])) {
//    $selector = $_GET['validator'];
//}
$db = new Db();
if (isset($_POST['resetPwdBtn'])) {
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['password'];
    $url = "https://africanviewbycalyo.com/recover-password?selector=" . $selector . "&validator=" . $validator;
    $rePass = $_POST['rePwd'];
    if (empty(trim($password)) || empty(trim($rePass))) {
        header("location: " . $url . "msg=Your Password is Empty &type=danger");
        exit(1);
    } elseif (strlen($password) < 8) {
        header("location: " . $url . "&msg=Your Password is to short. Use at least 8 characters for your password!&type=danger");
        exit(1);
    } elseif ($password !== $rePass) {
        header("location: " . $url . "msg=Please Confirm Your Password!&type=danger");
        exit(1);
    }
    $currentDate = date("U");
    $sql = "SELECT * FROM password_reset WHERE resetSelector='$selector' AND resetExpires>='$currentDate'";
    $result = mysqli_query($db->conn, $sql);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    if ($count == 0) {
        header("location: " . $url . "msg=You need to Re-submit your Request. Invalide Token!&type=error");
        exit(1);
    } else {
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row['resetToken']);
        if ($tokenCheck !== true) {
            header("location: " . $url . "msg=You need to Re-submit your Request Reset Token!&type=danger");
            exit(1);
        } elseif ($tokenCheck === true) {
            $userEmail = $row['email'];
            $query = "SELECT * FROM user WHERE email='$userEmail'";
            $user = mysqli_query($db->conn, $query);
            $userRow = mysqli_fetch_array($user);
            if (mysqli_num_rows($user) == 0) {
                header("location: " . $url . "msg=There was an error Please try again this!&type=danger");
                exit(1);
            } else {
                $newPassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 13));
                $updateSql = "UPDATE user SET password= '$newPassword' WHERE `email`='$userEmail'";
                if (mysqli_query($db->conn, $updateSql)) {
                    $deleteQuery = "DELETE FROM password_reset WHERE email='$userEmail'";
                    mysqli_query($db->conn, $deleteQuery);
                    header("location: login?msg=Your password have been Changed Successfully! You can Login Now & type=success");
                    exit(1);
                } else {
                    header("location: " . $url . "msg=There was an error Please try again!&type=danger");
                    exit(1);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Recover Password | Serve Global</title>
        <link rel="shorcut icon" href="dist/img/favicon.ico"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="index"><b><span class="fa fa-globe text-fuchsia"></span> Serve </b>Global</a>
            </div>
            <!-- /.login-logo -->
           
                <div class="login-box-body">
                    <?php
                    if ($msg != '') {
                        ?>
                        <div class="alert alert-<?php echo trim($type); ?>" role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span>
                                <span class='sr-only'>Close</span></button> <?php echo $msg; ?>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    $selector = $_GET['selector'];
                    $validator = $_GET['validator'];
                    if (empty(trim($validator)) || empty(trim($selector))) {
                        ?>
                        <div class="alert alert-danger">
                            <strong>Danger!</strong> Could not validate your Request.
                        </div>
                        <?php
                    } else {
                        if (ctype_xdigit($validator) === true && ctype_xdigit($selector) === true) {
                            ?>

                            <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                                <div class="form-group has-feedback">
                                    <input type="password" class="form-control" placeholder="Enter new Password" name="password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="rePwd">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block" name="resetPwdBtn">Change password</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-danger">
                                <strong>Danger!</strong> Your Token is Not Valid.
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <p class="mt-3 mb-1">
                        <a href="login">Login</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            
        </div>
        <!-- /.login-box -->

       <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>

    </body>
</html>
