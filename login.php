<?php
require_once './f-config.php';
require_once 'gl-config.php';
include('include/Db.php');
$gloginUrl = $gClient->createAuthUrl();
$fbRedirectUrl = "http://localhost:81/serveGlobalNew/f-login";
$permissions = ['email', 'user_link', 'user_gender', 'user_birthday']; // optional
$fbLoginUrl = $helper->getLoginUrl($fbRedirectUrl, $permissions);
//echo $fbLoginUrl;
//exit();
$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}if (isset($_GET['type'])) {
    $type = $_GET['type'];
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $username = strip_tags($username);
    $password = strip_tags($password);
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $db = new Db();
    $username = mysqli_real_escape_string($db->conn, $username);
    $password = mysqli_real_escape_string($db->conn, $password);
    $sql = "SELECT username,password,role,enabled, email, profile_image, fname, mname FROM user WHERE username='$username'";
    $queryResult = mysqli_query($db->conn, $sql);
    $count = mysqli_num_rows($queryResult);
    $row = mysqli_fetch_row($queryResult);
    if ($count == 1) {
        if (password_verify($password, $row[1])) {

            if ($row[3] != 0) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row[2];
                $_SESSION['email'] = $row[4];
                $_SESSION['picture'] = $row[5];
                $_SESSION['name'] = $row[6] . " " . $row[7];
                $_SESSION['fname'] = $row[6];
                if ($_SESSION['role'] == 'admin') {
                    header('location:admin/');
                    exit(1);
                } else if ($_SESSION['role'] == 'volunteer') {
                    header('location:index');
                    exit(1);
                } else {
                    session_destroy();
                    unset($_SESSION["username"]);
                    unset($_SESSION["role"]);
                    unset($_SESSION['email']);
                    unset($_SESSION['picture']);
                    unset($_SESSION['name']);
                    unset($_SESSION['fname']);
                    header("location: login?msg=UnKnown User&type=danger");
                    exit(1);
                }
            } else {
                session_destroy();
                unset($_SESSION["username"]);
                unset($_SESSION["role"]);
                unset($_SESSION['email']);
                unset($_SESSION['picture']);
                unset($_SESSION['name']);
                 unset($_SESSION['fname']);
                header("location: login?msg=You are Blocked! Please contact the admin&type=danger");
                exit(1);
            }
        } else {
            header('location:login?msg=Incorrect Username or Password&type=danger');
            exit(1);
        }
    } else {
        header('location:login?msg=Incorrect Username or Password&type=danger');
        exit(1);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Log in</title>
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
                <a href="index"><b>Serve <span class="fa fa-globe text-fuchsia"></span>  Global</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php
                if ($msg != '') {
                    ?>
                    <div class="alert alert-<?php echo $type; ?>" role='alert'> 
                        <button type='button' class='close' data-dismiss='alert'>
                            <span aria-hidden='true'>&times;</span>
                            <span class='sr-only'>Close</span>
                        </button><?php echo $msg; ?>
                    </div>
                    <?php
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox"> Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" name="login">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="<?php echo $fbLoginUrl; ?>" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                        Facebook</a>
                    <a href="<?php echo $gloginUrl; ?> " class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google"></i> Sign in using
                        Google</a>
                </div>
                <!-- /.social-auth-links -->

                <a href="forgot-password">I forgot my password</a>
                <a href="register" class="text-center pull-right">Sign up here</a>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' /* optional */
                });
            });
        </script>
    </body>
</html>
