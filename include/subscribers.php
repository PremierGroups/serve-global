<?php
ob_start();
session_start();
session_regenerate_id();
include_once './Subscriber.php';
if (!isset($_SESSION['email'])) {
    header('location:../login.php');
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    session_destroy();
    unset($_SESSION["email"]);
    unset($_SESSION["role"]);
    header('location:../login?msg=You have not a permission to access this page!');
    die(1);
}
$msg = '';
if (isset($_REQUEST['msg'])) {
    $msg = $_REQUEST['msg'];
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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title>African View | Subscribers</title>

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/adminlte.min.css">
        <!-- pace-progress -->
        <link rel="stylesheet" href="../plugins/pace-progress/themes/black/pace-theme-flat-top.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">

            <?php
            include '../layout/admin/nav.php';
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background-color: #fff !important;">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        African View  
                        <small> <span class="fas fa-users"></span> Subscribers</small>
                    </h1>

                </section>

                <!-- Main content -->
                <section class="content container-fluid">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    
                                    <div class="card-body">
                                       <table id="example2" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class='hidden-xs'><small>NO.</small></th>
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
                                                <?php
                                                $total_pages = $subscriberObj->getTotalSubscriber();
                                                ?>  
                                                <?php if (ceil($total_pages / $num_results_on_page) > 1): ?>
                                                    <ul class="pagination float-lg-right" style="display: inline-flex;">
                                                        <?php if ($page > 1): ?>
                                                        <li class="page-item"><a class="page-link" href="subscribers?page=<?php echo $page - 1 ?>">&laquo;</a></li>
                                                        <?php endif; ?>

                                                        <?php if ($page > 3): ?>
                                                            <li class="page-item start"><a class="page-link" href="subscribers?page=1">1</a></li>
                                                            <li class="dots">...</li>
                                                        <?php endif; ?>

                                                        <?php if ($page - 2 > 0): ?><li class="page-item"><a class="page-link" href="subscribers?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                                                        <?php if ($page - 1 > 0): ?><li class="page-item"><a class="page-link" href="subscribers?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                                                        <li class="page-item active"><a class="page-link" href="subscribers?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                                        <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page-item"><a class="page-link" href="subscribers?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                                                        <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page-item"><a class="page-link" href="subscribers?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                                                        <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                                            <li class="dots">...</li>
                                                            <li class="page-item end"><a class="page-link" href="subscribers?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                                        <?php endif; ?>

                                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                                            <li class="page-item"><a class="page-link" href="subscribers?page=<?php echo $page + 1 ?>">&raquo;</a></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                <?php endif; ?>
                                          
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
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
            include '../layout/admin/footer.php';
            ?>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery -->
        <script src="../plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- FastClick -->
        <script src="../plugins/fastclick/fastclick.js"></script>
        <!-- DataTables -->
        <script src="../plugins/datatables/jquery.dataTables.js"></script>
        <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
        <!-- overlayScrollbars -->
        <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- pace-progress -->
        <script src="../plugins/pace-progress/pace.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. -->
        <script>
            $(document).ready(function () {
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart();
                });
               
                $('#example2').DataTable({
                    'paging': false,
                    'lengthChange': false,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });

                $('#subscibeNav').addClass('active');
               
            });
        </script>
    </body>
</html>
