<?php
include_once '../models/Client.php';
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
$clientId = 0;
$email = '';
$website = '';
$phone = '';
$location = '';
$about = '';
$path = '';
if (isset($_REQUEST['client-id'])) {
    $id = $_REQUEST['client-id'];
    $client = new Client();
    $getItem = $client->getClientById($id);
    $row = mysqli_fetch_array($getItem);
    $name = $row['name'];
    $email = $row['email'];
    $website = $row['website'];
    $location = $row['location'];
    $phone = $row['phone'];
    $about = $row['about'];
    if (empty($row['id'])) {
        header("location:clients?msg=Please select the Client to edit!");
        exit(1);
    }
    $path = $row['logo'];
} else {
    $msg = 'Please Select Client first';
}
if (isset($_POST['updateClientBtn'])) {
    //File Upload
    $target_dir = "../images/client/";
    $target_file = date('dmYHis') . '_' . basename($_FILES["coverImage"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if file already exists
    if (file_exists($target_file)) {
        $msg = "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["coverImage"]["size"] > 2048000) {
        $msg = "Sorry, your file is too large, make sure your file is not more than 2MB.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "PNG" && $fileType != "JPG" && $fileType != "JPEG" && $fileType != "gif" && $fileType != "GIF") {
        $msg = "Sorry, Only Image file is allowed.";
        $uploadOk = 0;
    }
    $coverImage = '';
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $coverImage = $path;
        $msg .= " Client is not Updated.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
            $coverImage = $target_file;

            if (unlink($path)) {
                $msg .= "file Deleted";
            }
        } else {
            $coverImage = $path;
            $msg = "Sorry, there was an error while updating Client.";
        }
    }

    $msg = "Client has been updated.";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];
    $about = $_POST['about'];
    $client->updateClient($id, $name, $email, $website, $location, $phone,$coverImage,$about);
    header("location:clients?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Client</title>
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
                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" id="editClientForm">
                                <div class="panel panel-default"> 
                                    <div class="panel-body"><h4>Edit Client</h4>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" class="form-control" id="name"  value="<?php echo "$name"; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Phone" class="col-sm-2 control-label">Phone</label>
                                            <div class="col-sm-8">
                                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="location" class="col-sm-2 control-label">Location</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="websiteInput" class="col-sm-2 control-label">Website</label>
                                            <div class="col-sm-8">
                                                <input type="url" class="form-control" name="website" id="website" value="<?php echo $website; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputImage" class="col-sm-2 control-label">Logo</label>
                                            <div class="col-sm-8">
                                                <input type="file" name="coverImage" class="form-control" id="inputImage"
                                                    title="Select Cover Image">
                                                    <a href="#" data-image="../images/client/<?php echo "$path"; ?>" class="btn btn-link view-image">View Image</a>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="about" class="col-sm-2 control-label">About</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control textarea" id="about" name="about"
                                                          style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $about; ?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" name="updateClientBtn">Update</button>
                                        <a href="clients" class="btn btn-warning" >Cancel</a>
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
                    Pace.restart()
                });
                $('#clientNav').addClass('active');
                $('.textarea').wysihtml5();
                $(document).on('click', '.view-image', function (e) {
                    e.preventDefault();
                    var imageSrc = $(this).attr('data-image');
                    $('#modalImage').html("<img src='" + imageSrc + "' class='img-responsive' />");
                    $('#viewItemImage').modal('show');
                });
                $('#editClientForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                       
                        name: {
                            message: 'Client name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Client name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 100,
                                    message: 'Client name be more than 2 and less than 100 characters long'
                                }
                            }
                        }
                    }
                });

            });
        </script>

    </body>
</html>
