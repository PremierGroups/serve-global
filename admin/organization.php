<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../models/Company.php';
if (!isset($_SESSION['username'])) {
    header('location:../public/login');
    exit(1);
}
$msg = "";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$company = new Company();
$companyData = $company->getOrganization();
$row = mysqli_fetch_array($companyData);
$address = $row['address'];
$email = $row['email'];
$phone = $row['phone'];
$facebook = $row['facebook'];
$instagram = $row['instagram'];
$telegram=$row["telegram"];
if (isset($_POST['updateCompany'])) {
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    $telegram=$_POST["telegram"];
    $msg = "Company Profile has been updated.";
    $company->updateOrganization($address, $email, $phone, $facebook, $instagram,$telegram);
    header("location:organization?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Company Profile</title>

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
            <h2>Company Profile</h2>
            <?php
            if ($msg != '') {
                echo "<div class='alert alert-info' role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
            }
            ?>
           
        </section>
        <!-- Main content -->
        <section class="content container-fluid">
            <div class="col-sm-12 col-md-10">
                <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" id="updateCompanyForm">
                    
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo "$address"; ?>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo "$email"; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control" id="phone" value="<?php echo "$phone"; ?>" name="phone"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facebook" class="col-sm-2 control-label">Facebook Link</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo "$facebook"; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="instagram" class="col-sm-2 control-label">Instagram Link</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="instagram" id="instagram" value="<?php echo "$instagram"; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telegram" class="col-sm-2 control-label">Telegram Link</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="telegram" id="telegram" value="<?php echo "$telegram"; ?>">
                        </div>
                    </div>
                    <br/>
                  
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-10">
                            <button type="submit" class="btn btn-primary" name="updateCompany">Update</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </div>
                </form>
               
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

<!-- REQUIRED JS SCRIPTS -->

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
        $('#organizationNav').addClass('active');
    });

    $('#updateCompanyForm').bootstrapValidator({
        message: 'This value is not valid',
        fields: {

            address: {
                message: 'Address is not valid',
                validators: {
                    notEmpty: {
                        message: 'Address is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 2,
                        max: 200,
                        message: 'Address must be more than 2 and less than 200 characters long'
                    }

                }
            },
            phone: {
                message: 'Phone Number is not valid',
                validators: {
                    notEmpty: {
                        message: 'Phone Number is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 2,
                        max: 100,
                        message: 'Phone Number must be more than 2 and less than 100 characters long'
                    }

                }
            },
            email: {
                message: 'Email is not valid',
                validators: {
                    notEmpty: {
                        message: 'Email Address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }

                }
            },
             facebook: {
                message: 'Facebook Address is not valid',
                validators: {
                    notEmpty: {
                        message: 'Facebook Address is required and can\'t be empty'
                    }

                }
            },
            instagram: {
                message: 'Instagram Address is not valid',
                validators: {
                    notEmpty: {
                        message: 'Instagram Address is required and can\'t be empty'
                    }

                }
            },
            telegram: {
                message: 'Telegram Address is not valid',
                validators: {
                    notEmpty: {
                        message: 'Telegram Address is required and can\'t be empty'
                    }
                }
            },

            
        }
    });

</script>
</body>
</html>
