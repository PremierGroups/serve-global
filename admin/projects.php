<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../models/User.php";
include "../models/Service.php";
include "../models/Project.php";
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
if (isset($_POST['delete'])) {

    $id=$_POST['delete'];
    $projectObj = new Project();

    $getItem = $projectObj->getProjectById($id);
    $row = mysqli_fetch_array($getItem);
    unlink('../images/project/'.$row['coverImage']);

    if($projectObj->removeProject($id)){
        $msg="Project Deleted Successfully!";
    }else{
        $msg="Project Not Deleted!";
    }
    header("location:projects?msg=$msg");
    exit(1);
}


if (isset($_POST['addProjectBtn'])) {
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
    if ($_FILES["coverImage"]["size"] > 12288800) {
        $msg = "Sorry, your file is too large, make sure your file is not more than 12MB.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "PNG" && $fileType != "JPG" && $fileType != "JPEG" && $fileType != "gif" && $fileType != "GIF") {
        $msg = "Sorry, Only Image file is allowed.Descriptive image is required!";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $msg .= " Project is not added.";

// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $service = $_POST['service'];
            $newProject = new Project();
            $msg=$newProject->addProject($title,$service,$target_file,$description);
            header("location:projects?msg=$msg");
            exit(1);
       
    }
     header("location:projects?msg=$msg");
        exit(1);
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Projects</title>
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
                            <li class="active"><a href="#projectTab" data-toggle="tab"><span class="fa fa-list text-success"></span><strong class="text-primary"> Projects</strong></a></li>
                            <li><a href="#addProjectTab" class="fa fa-plus-circle text-primary" data-toggle="tab"> <strong class="text-primary"> Add Project</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="projectTab">
                                <table id="projectDT" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Project Title</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $projectObj = new Project();
                                    $projects = $projectObj->getAllProjects();
                                    echo "<tbody>";
                                    $rowcount = 1;
                                    while ($row = mysqli_fetch_array($projects)) {
                                        echo "<tr id='row$rowcount'>";
                                        echo "<td>$row[title]</td>";
                                        $toFormat = new DateTime($row['dateCreated']);
                                        $toDate = $toFormat->format("M j, Y");
                                        echo "<td >$toDate</td>";
                                        echo "<td>
                                        <a href='editProject?project-id=$row[id]' class='btn btn-primary glyphicon glyphicon-edit' data-id='$row[id]' row-id='row$rowcount'> Edit</a>
                                                <a class='btn btn-danger glyphicon glyphicon-trash' onclick='deleteFunction($row[id])' data-id='$row[id]' data-toggle='modal' data-target='#deletemodal'> Delete</a>
                                            </td>";
                                        echo '</tr>';
                                        $rowcount++;
                                    }

                                    echo "</tbody>";
                                    ?>
                                </table>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="addProjectTab">
                                <form class="form-horizontal" action="<?php $_PHP_SELF ?>" role="form" method="post" id="addProjectForm" enctype="multipart/form-data">
                                    <div class="panel panel-default"> 
                                        <div class="panel-body"><h4>Add Project</h4>
                                            <div class="form-group">
                                                <label for="title" class="col-sm-2 control-label">Title</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="title" class="form-control" id="title" autofocus=""
                                                            placeholder="Enter the Project title here...">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputImage" class="col-sm-2 control-label">Cover Image</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="coverImage" class="form-control" id="inputImage"
                                                            title="Select Cover Image">
                                                </div>

                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control textarea" id="description" name="description"
                                                                placeholder="Add Project Description here..."
                                                                style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                    </textarea>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="service" class="col-sm-2 control-label">Service</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" name="service" id="service" style="width:100%">
                                                        <option value="">Select Service</option>
                                                        <?php
                                                            $service = new Service();
                                                            $services = $service->getAllServices();
                                                            while ($row = mysqli_fetch_array($services)) {
                                                                echo "<option value='$row[name]'>$row[name] </option>";
                                                            }
                                                        ?>
                                                        <option value="others">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" name="addProjectBtn">Submit</button>
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
    include './deleteForm.php';
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
    function deleteFunction(temp) {
        document.getElementById("deleteId").value=temp;
    }
    $(document).ready(function () {
        $('#projectNav').addClass('active');
        $("#projectDT").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function () {
            Pace.restart();
        });
        $('.select2').select2();
        //bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5();
        $('#addProjectForm').bootstrapValidator({
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
