<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../models/User.php";
include "../models/ServiceRequest.php";
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
    $requestObj = new ServiceRequest();
    if($requestObj->removeRequest($id)){
        $msg="Service Request Is Deleted Successfully!";
    }else{
        $msg="Service Request Is not Deleted!";
    }
    header("location:serviceRequest?msg=$msg");
    exit(1);
}
    $serviceRequestObj = new ServiceRequest();
    $seen = $serviceRequestObj->requestSeen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Service Requests</title>
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

                    <!-- Add sales modal    -->
                    <div class="modal fade" id="viewMessage" tabindex="-1" role="dialog" aria-labelledby="viewMessageLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="viewName">Message</h4>
                                </div>
                                <div class="modal-body" >
                                    <div id="message"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#applicantsTab" data-toggle="tab"><span class="fa fa-list text-success"></span><strong class="text-primary"> Applicants For Service</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="applicantsTab">
                                <table id="applicantDT" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Service</th>
                                        <th>Message</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php
                                        $requestObj = new ServiceRequest();
                                        $requests = $requestObj->getAllRequests();
                                        echo "<tbody>";
                                    $rowcount = 1;
                                    while ($row = mysqli_fetch_array($requests)) {
                                        echo "<tr id='row$rowcount'>";
                                        echo "<td>
                                                $row[name]<br>
                                             </td>";
                                        echo "<td>$row[email]</td>";
                                        echo "<td>$row[phone]</td>";
                                        echo "<td>$row[address]</td>";
                                        echo "<td>$row[service]</td>";
                                        echo "<td><a href='#' data-message='$row[message]' data-name='$row[name]' class='btn btn-link view-message'>View Message</a></td>";
                                        $toFormat = new DateTime($row['dateCreated']);
                                        $toDate = $toFormat->format("M j, Y");
                                        echo "<td >$toDate</td>";
                                        echo "<td>
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
        $('#applicantNav').addClass('active');
        $("#applicantDT").DataTable({
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
        $(document).on('click', '.view-message', function (e) {
            e.preventDefault();
            var message = $(this).attr('data-message');
            var name = $(this).attr('data-name');
            $('#message').html("<p>"+message+"</p>");
            $('#viewName').html("<h5>"+name+"</h5>");
            $('#viewMessage').modal('show');
        });
    });
</script>
</body>
</html>
