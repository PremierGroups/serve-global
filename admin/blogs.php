<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../models/User.php";
include "../models/Blog.php";
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
    $blogObj = new Blog();
    $getItem = $blogObj->getBlogById($id);
    $row = mysqli_fetch_array($getItem);
    unlink('../images/blog/'.$row['coverImage']);
   
    if($blogObj->deleteBlog($id)){
        $msg="Blog Deleted Successfully!";
    }else{
        $msg="Blog not Deleted!";
    }
    header("location:blogs?msg=$msg");
    exit(1);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blogs</title>
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
                            <li class="active"><a href="#blogTab" data-toggle="tab"><span class="fa fa-list text-success"></span><strong class="text-primary"> Blogs</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="blogTab">
                                <table id="blogDT" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Blog Title</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $blogObj = new Blog();
                                    $blogs = $blogObj->getAllBlogs();
                                    echo "<tbody>";
                                    $rowcount = 1;
                                    while ($row = mysqli_fetch_array($blogs)) {
                                        echo "<tr id='row$rowcount'>";
                                        echo "<td>$row[title]</td>";
                                        $toFormat = new DateTime($row['dateCreated']);
                                        $toDate = $toFormat->format("M j, Y");
                                        echo "<td >$toDate</td>";
                                        echo "<td>
                                        <a href='editBlog?blog-id=$row[id]' class='btn btn-primary glyphicon glyphicon-edit' data-id='$row[id]' row-id='row$rowcount'> Edit</a>
                                                <a class='btn btn-danger glyphicon glyphicon-trash' onclick='deleteFunction($row[id])' data-id='$row[id]' data-toggle='modal' data-target='#deletemodal'> Delete</a>
                                            </td>";
                                        echo '</tr>';
                                        $rowcount++;
                                    }

                                    echo "</tbody>";
                                    ?>
                                </table>
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
          // To make Pace works on Ajax calls
          $(document).ajaxStart(function () {
            Pace.restart();
        });
        
        $('#blogNav').addClass('active');
        $('#blogsNav').addClass('active');
        $("#blogDT").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
      
       
    });
</script>
</body>
</html>
