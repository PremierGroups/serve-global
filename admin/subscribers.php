<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../include/Subscriber.php';
if (!isset($_SESSION['username'])) {
    header('location:../login.php');
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    session_destroy();
    unset($_SESSION["username"]);
    unset($_SESSION["role"]);
    header('location:../login?msg=You have not a permission to access this page!');
    die(1);
}
$msg = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
// Number of results to show on each page.
$num_results_on_page = 25; //limit
// Calculate the page to get the results we need from our table.
$calc_page = ($page - 1) * $num_results_on_page; //offset
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<!--<![endif]-->

<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Serve Global | Subcribers</title>
     <link rel="shorcut icon" href="dist/img/favicon.ico"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shorcut icon" href="../assets/logo.ico"/>
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../dist/css/bootstrapValidator.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!--        <link rel="stylesheet" href="dist/css/bootstrapValidator.min.css">
             AdminLTE Skins. We have chosen the skin-blue for this starter
                  page. However, you can choose any other skin. Make sure you
                  apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="../dist/css/skins/skin-yellow.min.css">
    <link rel="stylesheet" href="../plugins/pace/pace.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
    <body class="hold-transition skin-yellow fixed sidebar-mini">
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
                        <small> <span class="fa fa-users"></span> Subscribers</small>
                    </h1>

                </section>

                <!-- Main content -->
                <section class="content container-fluid">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    
                                    <div class="box-body">
                                       <table id="subscribersDT" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class='hidden-xs'><small>No.</small></th>
                                                            <th>Email</th>
                                                            <th> Date Created</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $subscriberObj=new Subscriber();
                                                        $subscribers = $subscriberObj->getAllSubscribersByOffset($num_results_on_page, $calc_page);
                                                        $rowCount = 1;
                                                        while ($subscriberRow = mysqli_fetch_array($subscribers)) {
                                                            $toFormat = new DateTime($subscriberRow['dateCreated']);
                                                            $toDate = $toFormat->format("M j, Y");
                                                            ?>
                                                            <tr id="<?php echo $rowCount; ?>">
                                                                <td class='hidden-xs'><?php echo $rowCount; ?></td>

                                                                <td> <?php echo $subscriberRow['email']; ?></td>
                                                                <td><?php echo $toDate; ?></td>
                                                               
                                                            </tr>
                                                            <?php
                                                            $rowCount++;
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                               
                                        <!-- /.tab-content -->
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                    <?php
                                    $total_pages = $subscriberObj->getTotalSubscriber();
                                    ?>  
                                    <?php if (ceil($total_pages / $num_results_on_page) > 1): ?>
                                        <ul class="pagination pull-right" style="display: inline-flex;">
                                            <?php if ($page > 1): ?>
                                                <li class="prev"><a href="subscribers?page=<?php echo $page - 1 ?>">&laquo;</a></li>
                                            <?php endif; ?>

                                            <?php if ($page > 3): ?>
                                                <li class="start"><a href="subscribers?page=1">1</a></li>
                                                <li class="dots">...</li>
                                            <?php endif; ?>

                                            <?php if ($page - 2 > 0): ?><li class="page"><a href="subscribers?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                                            <?php if ($page - 1 > 0): ?><li class="page"><a href="subscribers?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                                            <li class="active"><a href="subscribers?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                            <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="subscribers?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                                            <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="subscribers?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                                            <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                                <li class="dots">...</li>
                                                <li class="end"><a href="subscribers?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                            <?php endif; ?>

                                            <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                                <li class="next"><a href="subscribers?page=<?php echo $page + 1 ?>">&raquo;</a></li>
                                                <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </div>
                        </div>
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <?php
            include './layout/footer.php';
            ?>
        </div>
        <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../dist/js/bootstrapValidator.min.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- DataTables -->
    <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../bower_components/fastclick/lib/fastclick.js"></script>
    <script src="../plugins/pace/pace.min.js"></script>

    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
      <script src="../dist/js/sweetalert2.all.js"></script>
        <script>
            $(document).ready(function () {
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart();
                });
               
                $('#subscribersDT').DataTable({
                    'paging': false,
                    'lengthChange': false,
                    'searching': false,
                    'ordering': true,
                    'info': false,
                    'autoWidth': true
                });

                $('#subscibeNav').addClass('active');
               
            });
        </script>
    </body>
</html>
