<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../include/Feedback.php';
if (!isset($_SESSION['username'])) {
    header('location:../login.php?msg=Please Login!');
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    header('location:../login.php?msg=You have not a permission to access this page!');
    exit(1);
}
// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
// Number of results to show on each page.
$num_results_on_page = 25; //limit
// Calculate the page to get the results we need from our table.
$calc_page = ($page - 1) * $num_results_on_page; //offset
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Feedbacks</title>
         <link rel="shorcut icon" href="dist/img/favicon.ico"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../plugins/pace/pace.css">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
             page. However, you can choose any other skin. Make sure you
             apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="../dist/css/skins/skin-yellow.min.css">
        <link rel="stylesheet" href="../dist/css/sweetalert2.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-yellow sidebar-mini">
        <div class="wrapper">
            <?php
            include 'layout/nav.php';
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small><span class="fa fa-feed"></span> User Feedbacks</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Feedbacks</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-body">
                                    <table id="feedbackDT" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><small>Name</small></th>
                                                <th><small>Email</small></th>
                                                <th class='hidden-xs'><small>Subject</small></th>
                                                <th class='hidden-xs'><small>Created Date</small></th>
                                                <th><small>Action</small></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $feedbackObj = new Feedback();
                                        $testimonials = $feedbackObj->getFeedbacks($num_results_on_page, $calc_page);
                                        echo "<tbody>";
                                        $rowCount = 1;
                                        while ($row = mysqli_fetch_array($testimonials)) {
                                            echo "<tr id='row$rowCount'>";
                                            echo "<td> $row[sender]</td>";
                                            echo "<td>$row[email]</td>";
                                            echo "<td class='hidden-xs'>$row[subject]</td>";
                                            $toFormat = new DateTime($row['dateCreated']);
                                            $toDate = $toFormat->format("M j, Y");
                                            echo "<td class='hidden-xs'>$toDate</td>";
                                            echo "<td><button class='btn btn-primary btn-sm view-feedback'  data-name='$row[sender]' data-content='$row[content]'><span class='fa fa-eye'></span> View</button> | <button class='btn btn-danger btn-sm delete-feedback' feedback-id='$row[id]' row-id='row$rowCount'><span class='fa fa-trash'></span> Delete</button></td>";

                                            echo '</tr>';
                                            $rowCount++;
                                        }
                                        echo "</tbody>";
                                        ?>
                                    </table>
                                </div>
                                <div class="box-footer">
                                    <?php
                                    $total_pages = $feedbackObj->getTotalFeedbacks();
                                    ?>  
                                    <?php if (ceil($total_pages / $num_results_on_page) > 1): ?>
                                        <ul class="pagination pull-right" style="display: inline-flex;">
                                            <?php if ($page > 1): ?>
                                                <li class="prev"><a href="viewFeedback?page=<?php echo $page - 1 ?>">&laquo;</a></li>
                                            <?php endif; ?>

                                            <?php if ($page > 3): ?>
                                                <li class="start"><a href="viewFeedback?page=1">1</a></li>
                                                <li class="dots">...</li>
                                            <?php endif; ?>

                                            <?php if ($page - 2 > 0): ?><li class="page"><a href="viewFeedback?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                                            <?php if ($page - 1 > 0): ?><li class="page"><a href="viewFeedback?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                                            <li class="active"><a href="viewFeedback?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                            <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="viewFeedback?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                                            <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="viewFeedback?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                                            <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                                <li class="dots">...</li>
                                                <li class="end"><a href="viewFeedback?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                            <?php endif; ?>

                                            <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                                <li class="next"><a href="viewFeedback?page=<?php echo $page + 1 ?>">&raquo;</a></li>
                                                <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!-- Main Footer -->
            <?php
            include 'layout/footer.php';
            ?>
        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 3 -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>
        <script src="../plugins/pace/pace.min.js"></script>
        <script src="../dist/js/sweetalert2.all.js"></script>
        <script>
            $(document).ready(function () {
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart();
                });
                $('#feedbackNav').addClass('active');
                $('#feedbackDT').DataTable({
                    'paging': false,
                    'lengthChange': false,
                    'searching': true,
                    'ordering': true,
                    'info': false,
                    'autoWidth': true
                });
                $(document).on("click", ".view-feedback", function (e) {
                    e.preventDefault();
                    var name = $(this).attr('data-name');
                    var content = $(this).attr('data-content');
                    if (content.length > 0) {
                        Swal.fire({
                            title: "<strong>" + name + "</strong",
                            icon: 'info',
                            html: "<h4>" + content + "</h4>",
                            width: 650,
                            showCloseButton: false,
                            showCancelButton: false,
                            focusConfirm: false

                        });
                    }
                });

                $(document).on('click', '.delete-feedback', function (e) {
                    e.preventDefault();
                    var feedbackId = $(this).attr('feedback-id');

                    var rowId = $(this).attr('row-id');
                    if (isNaN(feedbackId) || feedbackId.length > 0) {
                        Swal.fire({
                            title: 'Are you sure?',
                            width: 400,
                            html: "<h3>You want to delete this <b>Feedback</b></h3>",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "../include/deleteFeedback.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {"feedbackId": feedbackId},
                                    success: function (response) {
                                        if (response.status === 'success') {
                                            Swal.fire(
                                                    'Message',
                                                    response.msg,
                                                    response.status
                                                    );
                                            $('#' + rowId).fadeOut(3000);
                                        } else {
                                            Swal.fire(
                                                    'OOPS...',
                                                    response.msg,
                                                    response.status
                                                    );
                                        }

                                    },
                                    error: function (error) {
                                        Swal.fire(
                                                'ERROR',
                                                "Something is happen. Please try Again",
                                                'error'
                                                );
                                    }
                                });
                            }
                        });
                    }
                });
            });
        </script>            
    </body>
</html>
