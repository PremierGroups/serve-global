<?php
include_once "../models/User.php";
include_once '../models/Service.php';
include_once '../models/Project.php';
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
$title = '';
$projectId = 0;
$description = '';
$service = '';
$path = '';
if (isset($_REQUEST['project-id'])) {
    $id = $_REQUEST['project-id'];
    $projectObj = new Project();
    $getItem = $projectObj->getProjectById($id);
    $row = mysqli_fetch_array($getItem);

    $title = $row['title'];
    $description = $row['description'];
    $service=$row['service'];
    $projectId = $row['id'];
    if (empty($row['id'])) {
        header("location:projects?msg=Please select project to edit.Project not found!");
        exit(1);
    }
    $path = $row['coverImage'];
} else {
    $msg = 'Please select project to edit';
    header("location:projects?msg=Please select project to edit!");
    exit(1);
}
if (isset($_POST['updateProjectBtn'])) {
    //File Upload
    $target_dir = "../images/project/";
    $target_file = date('dmYHis') . '_' . basename($_FILES["coverImage"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if file already exists
    if (file_exists($target_file)) {
        $msg = "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["coverImage"]["size"] > 4096000) {
        $msg = "Sorry, your file is too large, make sure your file is not more than 4MB.";
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
        $msg .= " Project was not Updated.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
            $coverImage = $target_file;

            if (unlink($path)) {
                $msg .= "file Deleted";
            }
        } else {
            $coverImage = $path;
            $msg = "Sorry, there was an error while updating the Project.";
        }
    }

    $msg = "Project has been updated.";
    $title = $_POST['title'];
    $description = $_POST['description'];
    $service=$_POST['service'];
    $project = new Project();
    if ($project->updateProject($id,$title,$service,$coverImage,$description)) {
        $msg = "Project is Updated Successfully!";
    } else {
        $msg = "Failed to update project.Try again!";
    }
    header("location:projects?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Edit Project</title>
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
                            <form class="form-horizontal" enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="post" id="editProjectForm">
                            <div class="panel panel-default"> 
                                <div class="panel-body"><h4>Edit Project</h4>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="title" class="form-control" id="title"  value="<?php echo "$title"; ?>">
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label for="inputImage" class="col-sm-2 control-label">Cover Image</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="coverImage" class="form-control" id="coverImage" title="Select Cover Image">
                                        <a href="#" data-image="../images/project/<?php echo "$path"; ?>" class="btn btn-link view-image">View Image</a>
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

                                
                                <div class="form-group">
                                    <label for="service" class="col-sm-2 control-label">Service</label>
                                    <div class="col-sm-8">
                                        <select name="service" class="form-control select2" id="service" style="width:100%;" data-placeholder="Select Country">
                                            <?php
                                               $serviceObj=new Service();
                                                $services = $serviceObj->getAllServices();
                                                    while ($service = mysqli_fetch_array($services)) {
                                                        if (in_array(in_array($service['name'], $service))) {
                                                            echo "<option value='$service[name]' selected='true'>$service[name] </option>";
                                                        }else{
                                                        echo "<option value='$service[name]'>$service[name] </option>"; 
                                                        }
                                                }

                                                if (in_array(in_array('others', $service))) {
                                                    echo "<option value='others' selected='true'>Other</option>";
                                                }else{
                                                    echo "<option value='others'>Other</option>"; 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                </div>
                            </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" name="updateProjectBtn">Update</button>
                                        <a href="projects" class="btn btn-warning">Cancel</a>
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
               
                $('#projectNav').addClass('active');
                $('.textarea').wysihtml5();
                $(document).on('click', '.view-image', function (e) {
                    e.preventDefault();
                    var imageSrc = $(this).attr('data-image');
                    $('#modalImage').html("<img src='" + imageSrc + "' class='img-responsive' />");
                    $('#viewItemImage').modal('show');
                });
                $('#editProjectForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        title: {
                            message: 'Project title is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Project title is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 200,
                                    message: 'Project title must be more than 2 and less than 200 characters long'
                                }

                            }
                        },
                        description: {
                            validators: {
                                notEmpty: {
                                    message: 'Description is required and can\'t be empty'
                                }

                            }
                        },
                        service: {
                            validators: {
                                notEmpty: {
                                    message: 'Service is required and can\'t be empty'
                                }

                            }
                        }
                    }
                });
            });
        </script>

    </body>
</html>
