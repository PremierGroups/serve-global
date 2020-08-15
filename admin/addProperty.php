<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../models/User.php";
include "../models/Property.php";
if (!isset($_SESSION['username'])) {
    header('location:../public/login');
    die(1);
}
if ($_SESSION['role'] != "admin") {
    session_destroy();
    unset($_SESSION["username"]);
    unset($_SESSION["role"]);
    header('location:../public/login?msg=You have not a permission to access this page!');
    die(1);
}
$msg = '';
if (isset($_REQUEST['msg'])) {
    $msg = $_REQUEST['msg'];
}

if (isset($_POST['addPropertyBtn'])) {
    $imageNames = '';
    $image = array_keys($_FILES['coverImage']);
    for ($i=0; $i < count($_FILES['coverImage']['name']) ; $i++) { 
    
        //File Upload
        $target_dir = "../images/property/";
        $target_file = date('dmYHis') . '_' . basename($_FILES['coverImage']['name'][$i]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if file already exists
        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists.";
            $uploadOk = 0;
        }
    // Check file size
        if ($_FILES["coverImage"]["size"] > 12288800) {
            $msg = "Sorry, your file is too large, make sure your file is not more than 12MB.";
            $uploadOk = 0;
        }
    // Allow certain file formats
        if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "PNG" && $fileType != "JPG" && $fileType != "JPEG" && $fileType != "gif" && $fileType != "GIF") {
            $msg = "Sorry, Only Image file is allowed.";
            $uploadOk = 0;
        }
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg .= " Property is not added.";

    // if everything is ok, try to upload file
        }

        if(count($_FILES['coverImage']['name']) == ($i+1)){
            $imageNames =$imageNames.$target_file;
        }
        else{
            $imageNames =$imageNames.$target_file.',';
        }

        if(!(move_uploaded_file($_FILES["coverImage"]["tmp_name"][$i], $target_dir . $target_file))){
            $msg = "Sorry, Only Image file is allowed.Image is required.Property is not added.";
            header("location:properties?msg=$msg");
            exit(1);
        };
    }
    $title = $_POST['title'];
    $description = $_POST['description'];
    $phoneOne = $_POST['phoneOne'];
    $phoneTwo = $_POST['phoneTwo'];
    $newProperty = new Property();
    $msg=$newProperty->addProperty($title,$description,$imageNames, $phoneOne,$phoneTwo);
    header("location:properties?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Add Property For Sale Or Rental</title>
    <!-- Tell the browser to be responsive to screen width -->
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
        <link rel="stylesheet" href="../skins/css/skin-blue.min.css">
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
        <!-- Main content -->
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <?php
                    if ($msg != '') {
                        echo "<div class='alert alert-info' role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
                    }
                    ?>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#addPropertyTab" class="fa fa-plus-circle text-primary" data-toggle="tab"> <strong class="text-primary"> Add Property</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="addPropertyTab">
                                <form class="form-horizontal" action="<?php $_PHP_SELF ?>" role="form" method="post" id="addPropertyForm" enctype="multipart/form-data">
                                    <div class="panel panel-default"> 
                                        <div class="panel-body"><h4>Add Property</h4>
                                            <div class="form-group">
                                                <label for="title" class="col-sm-2 control-label">title</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="title" class="form-control" id="title" autofocus=""
                                                            placeholder="Enter the Property Title here...">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control textarea" id="description" name="description"
                                                                placeholder="Add Property Description here..."
                                                                style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                    </textarea>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="phoneNu" class="col-sm-2 control-label">Phone Number #1</label>
                                                <div class="col-sm-8">
                                                    <input type="tel" name="phoneOne"  class="form-control" id="phoneOne" placeholder="Enter Phone Number Here..." >
                                                </div>
                                            </div>
                                    
                                            <div class="form-group">
                                                <label for="phoneNu" class="col-sm-2 control-label">Phone Number #2</label>
                                                <div class="col-sm-8">
                                                    <input type="tel" name="phoneTwo"  class="form-control" id="phoneTwo" placeholder="Enter Phone Number Here..." >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputImage" class="col-sm-2 control-label">Images(maximum 3 images,in order of preference)</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="coverImage[]" class="form-control" id="inputImage" multiple
                                                            >
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" name="addPropertyBtn">Submit</button>
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
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
    $("#artMsg").fadeOut(5000);
    $(document).ready(function () {
        $('#propertyNav').addClass('active');
        $('#addPropertyNav').addClass('active');
        $(document).ajaxStart(function () {
            Pace.restart();
        });
        $('.select2').select2();
        $('.textarea').wysihtml5();
        $('#addPropertyForm').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                title: {
                    message: 'Title is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Title is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 2,
                            max: 200,
                            message: 'Title must be more than 2 and less than 200 characters long'
                        }

                    }
                },
                description: {
                    message: 'Description is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Description is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 2,
                            message: 'Description must be more than 2'
                        }

                    }
                },
                phoneOne: {
                    message: 'Phone number is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Phone number is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 9,
                            max: 15,
                            message: 'Mobile number must be more than 9 and less than 15 characters long'
                        },
                        digits: {
                            message: 'Phone number value can contain only digits'
                        }

                    }
                }
            }
        });
    });
</script>
</body>
</html>
