<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../models/User.php';
if (!isset($_SESSION['username'])) {
    header('location:../public/login');
    exit(1);
}
$msg = "";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$user = new User();
$userId = $user->getUserIdByUsername($_SESSION['username']);
$profile = $user->getUser($userId);
$row = mysqli_fetch_array($profile);
$fname = $row['fname'];
$lname = $row['lname'];
$fullname = $fname . " " . $lname;
$phone = $row['phoneNo'];
$email = $row['email'];
$userImage=$row["userImage"];
if (isset($_POST['updateUser'])) {
    $fname = strip_tags($_POST['fname']);
    $lname = strip_tags($_POST['lname']);
    $tel = strip_tags($_POST['tel']);
    $email = strip_tags($_POST['email']);
    $msg = "Profile has been updated.";
    $coverImage="avatar.png";
    $user->updateUser($userId, $fname, $lname, $tel, $email,$coverImage);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>

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

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php
    include '../layout/admin/navigation.php';
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff !important;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h2>User Profile</h2>
            <?php
            if ($msg != '') {
                echo "<div class='alert alert-info' role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
            }
            ?>
           
        </section>
        <!-- Main content -->
        <section class="content container-fluid">
            <div class="col-sm-12 col-md-10">
                <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" id="profileForm">
                    <div class="form-group">
                        <input type="hidden" name="username" value="<?php echo "$_SESSION[username]"; ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="fname" class="col-sm-2 control-label">First Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo "$fname"; ?>" required=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lname" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="lname" name="lname" value="<?php echo "$lname"; ?>" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phoneNo" class="col-sm-2 control-label">Phone No</label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control" id="phoneNo" value="<?php echo "$phone"; ?>" name="tel" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo "$email"; ?>">
                        </div>
                    </div>
                    <br/>
                  
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" class="btn btn-primary" name="updateUser">Update</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </div>
                </form>
                <div class="pull-right">Click <a href="changePassword.php" class="text-center"><b> here </b></a> to Change Password</div>

            </div>
            <div class="col-sm-12 col-md-2">
                <img src="../images/avatar.png" class="img-responsive img-rounded" width="270" height="250">
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php
    include '../layout/admin/footer.php';
    ?>
    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

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
            Pace.restart()
        });
        $('#dashboardNav').addClass('active');
    });

    $('#profileForm').bootstrapValidator({
        message: 'This value is not valid',
        fields: {

            fname: {
                message: 'First name is not valid',
                validators: {
                    notEmpty: {
                        message: 'First name is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 2,
                        max: 100,
                        message: 'First name must be more than 2 and less than 100 characters long'
                    }

                }
            },
            lname: {
                message: 'Last name is not valid',
                validators: {
                    notEmpty: {
                        message: 'Last name is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 2,
                        max: 100,
                        message: 'Last name must be more than 2 and less than 100 characters long'
                    }

                }
            },
            tel: {
                message: 'Phone number is not valid',
                validators: {
                    notEmpty: {
                        message: 'Phone number is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 9,
                        max: 10,
                        message: 'Phone number must be more than 9 and less than 10 characters long'
                    },
                    digits: {
                        message: 'Phone number value can contain only digits'
                    }

                }
            }, 
            email: {
                message: 'Email address is not valid',
                validators: {
                    notEmpty: {
                        message: 'Email address is required and can\'t be empty'
                    },
                    stringLength: {
                    min: 5,
                    max: 50,
                    message: 'Email address must be more than 5 and less than 50 characters long'
                    },
                    regexp: {
                        regexp: /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/,
                        message: 'Email address is not in the right format'
                    }

                }
            }
        }
    });

</script>
</body>
</html>
