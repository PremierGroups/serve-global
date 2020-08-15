<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../include/User.php';

$msg = '';
$type = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
$username = $_SESSION['username'];
$userObj = new User();
$userId = $userObj->getUserIdByUsername($username);
if (!isset($_SESSION['username'])) {
    header('location:../login.php');
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    session_destroy();
    unset($_SESSION["username"]);
    unset($_SESSION["role"]);
    header('location:../login?msg=You have not a permission to access this page!');
    die(0);
}
if (isset($_POST['cPassword']) && isset($_POST['nPassword'])) {

    $msg = '';
    $cPassword = trim($_POST['cPassword']);
    $nPassword = trim($_POST['nPassword']);
    $rePass = trim($_POST['confirmPassword']);
    $username = $_SESSION['username'];
    if (strlen($nPassword) >= 8) {
        if ($nPassword === $rePass) {
            $checkExist = $userObj->checkPassword($username, $cPassword);
            if ($checkExist == 1) {
                if ($userObj->changeUserPassword($username, $cPassword, $nPassword)) {
                    unset($_SESSION["username"]);
                    unset($_SESSION["role"]);
                    header("location: ../login?msg=Your password has been successfully Updated. Please Login again!.&type=success");
                    exit(1);
                } else {
                    $msg = "Your Password does not Changed!. Please try again";
                    header("location: changePassword?msg=$msg&type=error");
                    exit(1);
                }
            } else {
                $msg = "User does not found with this password. Please try again.";
                header("location: changePassword?msg=$msg&type=error");
                exit(1);
            }
        } else {
            $msg = "Please Confirm Your Password!";
            header("location: changePassword?msg=$msg&type=error");
            exit(1);
        }
    } else {
        $msg = "Your Password is to short. Please Use at least 8 characters";
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
        <title>Serve Global | Change Password</title>
        <link rel="shorcut icon" href="dist/img/favicon.ico"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../dist/images/favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../plugins/pace/pace.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/bootstrapValidator.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href="index"><b>Serve Global</b></a>
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
                            <button type="submit" class="btn btn-primary btn-flat"><span class="fa fa-save"></span> Update</button>
                            <a href="index" class="text-center"><span class="fa fa-dashboard"></span> Back to Dashboard</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 3 -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>

        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>
        <script src="../plugins/pace/pace.min.js"></script>
        <script src="../dist/js/bootstrapValidator.min.js"></script>
        <script>
            $(document).ready(function () {
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart();
                });
                 $('#changePassFormId').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        cPassword: {
                            message: 'Your Current Password is required',
                            validators: {
                                notEmpty: {
                                    message: 'Current Password is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 8,
                                    max: 132,
                                    message: 'Current Password must be more than 8 and less than 132 characters long'
                                }
                            }
                        },
                        nPassword: {
                            validators: {
                                notEmpty: {
                                    message: 'New Password is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 8,
                                    max: 132,
                                    message: 'The new Password must be more than 8 and less than 132 characters long'
                                },
                                 different: {
                                    field: 'cPassword',
                                    message: 'The new Password can\'t be the same as your current password'
                                }

                            }
                        },
                        confirmPassword: {
                            validators: {
                                notEmpty: {
                                    message: 'This field is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 8,
                                    max: 132,
                                    message: 'This field must be more than 8 and less than 132 characters long'
                                },
                                 identical: {
                                    field: 'nPassword',
                                    message: 'Please confirm your password'
                                }

                            }
                        }
                    }
                });
            });
        </script>
    </body>
</html>
