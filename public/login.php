<?php
ob_start();
session_start();
session_regenerate_id();
include('../db/Db.php');
$msg = '';
if (isset($_REQUEST['msg']))
    $msg = $_REQUEST['msg'];
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $username=strip_tags($username);
    $password=strip_tags($password);
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $db = new Db();
    $username=mysqli_real_escape_string($db->conn,$username);
    $password=mysqli_real_escape_string($db->conn,$password);
    $sql = "SELECT username,password,role,enabled FROM user WHERE username='$username'";
    $queryResult = mysqli_query($db->conn, $sql);
    $count = mysqli_num_rows($queryResult);
    $row = mysqli_fetch_row($queryResult);
    if ($count == 1) {
        if(password_verify($password, $row[1])){
            
        if ($row[3] != 0) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row[2];
            if ($_SESSION['role'] == 'admin') {
                header('location:../admin/index');
                exit(1);
            } else {
                session_destroy();
                unset($_SESSION["username"]);
                unset($_SESSION["role"]);
                header("location: login?msg=UnKnown User");
                exit(1);
            }
        } 
        else {
            session_destroy();
            unset($_SESSION["username"]);
            unset($_SESSION["role"]);
            header("location: login?msg=You are Blocked! Please contact the admin");
            exit(1);
        }
    }else{
        header('location:login?msg=Incorrect Username or Password');
        exit(1);
    }
    } else {
        header('location:login?msg=Incorrect Username or Password');
        exit(1);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome | Log in</title>
        <link rel="shorcut icon" href="dist/img/logo.ico"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="dist/images/favicon.ico" type="image/x-icon"/>
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrapValidator.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="../css/square/blue.css">

    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
            <h2>PREMIER GROUP</h2>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                
                <h3 class="login-box-msg"><span class="glyphicon glyphicon-lock"></span> Sign in to start your session</h3>
                <?php
                if ($msg != '') {
                    echo "<div class='alert alert-danger' role='alert'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
                }
                ?>
                <form action="login.php" method="post" id="loginForm" role="form">
                    <div class="form-group has-feedback">
                        <input type="text" name="username" class="form-control" placeholder="Username" autofocus="">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control"  placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" name='login' class="btn btn-primary btn-block btn-flat form-control">LogIn</button>
                    </div><!-- /.col -->

                </form>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

        <!-- jQuery 3 -->
        <script src="../js/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../js/bootstrap.min.js"></script>

    </body>
</html>
