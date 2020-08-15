<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../models/User.php';

$msg = '';
$type = '';
if(isset($_GET['msg'])){
    $msg=$_GET['msg'];
}if(isset($_GET['type'])){
    $type=$_GET['type'];
}
$username = $_SESSION['username'];
$userObj = new User();
$userId = $userObj->getUserIdByUsername($username);
if (!isset($_SESSION['username'])) {
    header('location:../public/login.php');
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    session_destroy();
    unset($_SESSION["username"]);
    unset($_SESSION["role"]);
    header('location:../public/login?msg=You have not a permission to access this page!');
    die(0);
}
if (isset($_POST['cPassword']) && isset($_POST['nPassword'])) {
    
    $msg='';
    $cPassword = trim($_POST['cPassword']);
    $nPassword = trim($_POST['nPassword']);
    $rePass= trim($_POST['confirmPassword']);
    $username = $_SESSION['username'];
    if(strlen($nPassword)>=8){
       if($nPassword===$rePass){
           if($userObj->changeUserPassword($username, $cPassword, $nPassword)){
                unset($_SESSION["username"]);
                unset($_SESSION["role"]);
                header("location: ../public/login?msg=Your password has been successfully Updated. Please Login again!.&type=success");
                exit(1);
            }else{
                $msg="Your Password does not Changed!. Please try again";
                header("location: changePassword?msg=$msg&type=error");
                exit(1);
            }
       } else{
        $msg="Please Confirm Your Password!";
        header("location: changePassword?msg=$msg&type=error");
        exit(1);
       }
    }else{
        $msg="Your Password is to short. Please Use at least 8 characters";
        header("location: changePassword?msg=$msg&type=error");
        exit(1);
    }
    
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Consultancy | Change Password</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="../dist/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../css/ionicons.min.css">
    <link rel="stylesheet" href="../css/bootstrapValidator.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../css/AdminLTE.min.css">
    <link rel="stylesheet" href="../css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="../css/pace.min.css">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../css/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="../css/select2.min.css">
        <link rel="stylesheet" href="../css/skins/css/skin-blue.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index"><b>Consultancy </b>Services</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Change Your Password</p>
     <?php
        if ($msg != '') {
            if ($type == 'error') {
                echo "<div class='alert alert-danger' role='alert'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
            } else {
                echo "<div class='alert alert-success' role='alert'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
            }
        }
        ?>
    <form action="?" method="post" id="changePassFormId">
      <div class="form-group has-feedback">
          <input type="password" name="cPassword" class="form-control" id="currentInput" placeholder="Current Password" autofocus="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
     
      <div class="form-group has-feedback">
          <input type="password" name="nPassword" class="form-control" placeholder="New Password" id="newInput">
        <span class="glyphicon glyphicon-edit form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="confirmInput" class="form-control" name="confirmPassword" placeholder="Retype password">
        <span class="glyphicon glyphicon-edit form-control-feedback"></span>
      </div>
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-12">
            <input type="submit" class="btn btn-primary btn-flat" value="Update">
             <a href="../admin/index" class="text-center"><span class="fa fa-dashboard"></span> Back to Dashboard</a>
        </div>
        <!-- /.col -->
      </div>
    </form>

 
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
<!-- jQuery 3 -->
<script src="../js/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrapValidator.min.js"></script>
<!-- DataTables -->
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../js/fastclick.js"></script>
<script src="../js/pace.min.js"></script>

<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
<script src="../js/select2.full.min.js"></script>
<script src="../js/bootstrap3-wysihtml5.all.min.js"></script>
<script>
    $(document).ready(function () {
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function () {
            Pace.restart();
        });
      
    });

    $('#changePassFormId').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
             cPassword: {
                message: 'Old Password is not valid',
                validators: {
                    notEmpty: {
                        message: 'Old Password is required and can\'t be empty'
                    }

                }
            },
            nPassword: {
                validators: {
                    notEmpty: {
                        message: 'Password is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 8,
                        max: 30,
                        message: 'password must be more than 8 and less than 30 characters long'
                    }
                  
                }
            },
            confirmPassword: {
                message: 'Confirm password is not valid',
                validators: {
                    notEmpty: {
                        message: 'Confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'nPassword',
                        message: 'The new password and its confirm are not the same'
                    }

                }
            },
        }
    });
</script>
</body>
</html>
