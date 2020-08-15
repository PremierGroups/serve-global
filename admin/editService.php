<?php
include_once "../models/User.php";
include_once '../models/Service.php';
ob_start();
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
    header('location:../public/login');
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    header('location:../public/login?msg=You have not a permission to access this page!');
    exit(1);
}
$msg = '';
if (isset($_REQUEST['msg'])) {
    $msg = $_REQUEST['msg'];
}
$id = 0;
$name = '';
$description = '';
$path = '';
if (isset($_REQUEST['service-id'])) {
    $id = $_REQUEST['service-id'];
    $serviceObj = new Service();
    $getItem = $serviceObj->getServiceById($id);
    $row = mysqli_fetch_array($getItem);

    $name = $row['name'];
    $description = $row['description'];
    $country=$row['country'];
    $serviceId = $row['id'];
    if (empty($row['id'])) {
        header("location:services?msg=Please select service to edit.Service not found!");
        exit(1);
    }
  
} else {
    $msg = 'Please select service to edit';
    header("location:services?msg=Please select service to edit!");
    exit(1);
}
if (isset($_POST['updateServiceBtn'])) {

    $msg = "Service has been updated.";
    $name = $_POST['name'];
    $description = $_POST['description'];
    $country='Ethiopia';
    $service = new Service();
    if ($service->updateService($id, $name, $description, $coverImage=null, $country)) {
        $msg = "Service is Updated Successfully!";
    } else {
        $msg = "Failed to update service.Try again!";
    }
    header("location:services?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Service</title>
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
    <body class="hold-transition skin-blue fixed sidebar-mini">
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
                            <!-- Add sales modal    -->
                            <div class="modal fade" id="viewItemImage" tabindex="-1" role="dialog" aria-labelledby="viewItemImageLAbel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="viewItemImageLAbel">View Cover Image</h4>
                                        </div>
                                        <div class="modal-body" >
                                            <div id="modalImage"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--End of add sales modal -->
                            <?php
                            if ($msg != '') {
                                echo "<div class='alert alert-info' role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
                            }
                            ?>
                            <form class="form-horizontal form-group" enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="post" id="editServiceForm">
                            <div class="panel panel-default"> 
                                <div class="panel-body"><h4>Edit Service</h4>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" id="name"  value="<?php echo "$name"; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control textarea" id="description" name="description"
                                                  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $description; ?>
                                        </textarea>
                                    </div>

                                </div>
                                </div>
                            </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" name="updateServiceBtn">Update</button>
                                        <a href="services" class="btn btn-warning">Cancel</a>
                                    </div>
                                </div>
                            </form>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
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
                    Pace.restart();
                });
                $('.select2').select2();
               
                $('#serviceNav').addClass('active');
                $('.textarea').wysihtml5();
               
                $('#editServiceForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        name: {
                            message: 'service Name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'service Name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 200,
                                    message: 'service name must be more than 2 and less than 200 characters long'
                                }

                            }
                        }
                    }
                });
            });
        </script>

    </body>
</html>
