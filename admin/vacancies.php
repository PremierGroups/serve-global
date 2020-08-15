<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../models/User.php";
include "../models/Vacancy.php";
include "../models/Applicant.php";
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
    $vacancy = new Vacancy();
    if($vacancy->deleteVacancy($id)){
        $msg="Vacancy Is Deleted Successfully!";
    }else{
        $msg="Vacancy Is not Deleted!";
    }
    header("location:vacancies?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vacancies</title>
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
                    <div class="modal fade" id="viewDescription" tabindex="-1" role="dialog" aria-labelledby="viewDescriptionLAbel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="viewDesc">View Description</h4>
                                </div>
                                <div class="modal-body" >
                                    <div id="description"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#vacancyTab" data-toggle="tab"><span class="fa fa-list text-success"></span><strong class="text-primary"> Vacancies</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="vacancyTab">
                                <table id="vacancyDT" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Vacancy Title</th>
                                        <th>Location</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $vacancyObj = new Vacancy();
                                    $vacancies = $vacancyObj->getAllVacancies();
                                    echo "<tbody>";
                                    $rowcount = 1;
                                    while ($row = mysqli_fetch_array($vacancies)) {
                                        $applicantObj = new Applicant();
                                        $unseenApplicants = $applicantObj->getApplicantByVacancyUnSeen($row['id']);
                                        echo "<tr id='row$rowcount'>";
                                        echo "<td>
                                                $row[title]<br>
                                                <a href='#' data-description='$row[description]' class='btn btn-link view-description'>View Description</a>
                                            </td>";
                                        echo "<td>$row[location]</td>";
                                        $toFormat = new DateTime($row['dateCreated']);
                                        $toDate = $toFormat->format("M j, Y");
                                        echo "<td >$toDate</td>";
                                        echo "<td>
                                                <a href='editVacancy?vacancy-id=$row[id]' class='btn btn-primary glyphicon glyphicon-edit' data-id='$row[id]' row-id='row$rowcount'> Edit</a>
                                                <a class='btn btn-danger glyphicon glyphicon-trash' onclick='deleteFunction($row[id])' data-id='$row[id]' data-toggle='modal' data-target='#deletemodal'> Delete</a>
                                                <a href='viewApplicants?vacancy-id=$row[id]' class='btn btn-default glyphicon glyphicon-list' data-id='$row[id]' row-id='row$rowcount'> Applicants<span class='label' style='color:red'>$unseenApplicants</span></a>
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
        $('#vacancyNav').addClass('active');
        $('#vacanciesNav').addClass('active');
        $("#vacancyDT").DataTable({
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
        $(document).on('click', '.view-description', function (e) {
            e.preventDefault();
            var description = $(this).attr('data-description');
            $('#description').html("<h6>" + description + "</h6>");
            $('#viewDescription').modal('show');
        });
    });
</script>
</body>
</html>
