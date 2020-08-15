<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../include/User.php";
include_once '../include/Event.php';
include_once '../include/Donate.php';
include_once "../include/Category.php";
include_once '../include/Subscriber.php';
include_once '../include/Company.php';
include_once '../include/Testimonial.php';
if (!isset($_SESSION['username'])) {
    header('location:../login?msg=Please login before try to access this page&type=danger');
    die(1);
}
if (!$_SESSION['role'] == 'admin') {
    session_destroy();
    unset($_SESSION["username"]);
    unset($_SESSION["role"]);
    header('location:../login?msg=You don\'t have permission to access this page!&type=danger');
    die(1);
}
$msg = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$type = '';
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Dashboard</title>
        <link rel="shorcut icon" href="dist/img/favicon.ico"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../dist/css/skins/skin-yellow.min.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="../bower_components/jvectormap/jquery-jvectormap.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-yellow sidebar-mini">
        <div class="wrapper">
            <?php include_once "./layout/nav.php"; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <?php
                    if ($msg != '') {
                        ?>
                        <div class="alert alert-<?php echo $type; ?>" role='alert'> 
                            <button type='button' class='close' data-dismiss='alert'>
                                <span aria-hidden='true'>&times;</span>
                                <span class='sr-only'>Close</span>
                            </button><?php echo $msg; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <?php
                                    $eventObj = new Event();
                                    $totalActiveEvents = $eventObj->getTotalActiveEvents();
                                    ?>
                                    <h3><?php echo $totalActiveEvents; ?></h3>
                                    <p>Active Events</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-calendar"></i>
                                </div>
                                <a href="events" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <?php
                                    $sponsorObj = new Company();
                                    $totalSponsors = $sponsorObj->getTotalCompanies();
                                    ?>
                                    <h3><?php echo $totalSponsors; ?></h3>
                                    <p>Sponsors</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-handshake-o"></i>
                                </div>
                                <a href="sponsors" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <?php
                                    $userObj = new User();
                                    $totalVolunteers = $userObj->getTotalVolunteers();
                                    ?>
                                    <h3><?php echo $totalVolunteers; ?></h3>
                                    <p>Total Volunteers</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios-people-outline"></i>
                                </div>
                                <a href="volunteers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <?php
                                    $totalForeignVolunteers = $userObj->getTotalForeignVolunteers();
                                    ?>
                                    <h3><?php echo $totalForeignVolunteers; ?></h3>
                                    <p>Foreign Volunteers</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                            <!-- Map box -->
                            <div class="box box-solid bg-light-blue-gradient">
                                <div class="box-header">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">

                                        <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                                                data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                                            <i class="fa fa-minus"></i></button>
                                    </div>
                                    <!-- /. tools -->

                                    <i class="fa fa-map-marker"></i>

                                    <h3 class="box-title">
                                        World Wide Volunteers
                                    </h3>
                                </div>
                                <div class="box-body">
                                    <div id="world-map" style="height: 350px; width: 100%;"></div>
                                </div>

                            </div>
                            <!-- /.box -->
                        </section>

                        <!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-5 connectedSortable"> 
                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Volunteers By Sex</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="chart-responsive">
                                                <canvas id="pieChart" height="350"></canvas>
                                            </div>
                                            <!-- ./chart-responsive -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-4">
                                            <ul class="chart-legend clearfix" id="chartLegend">

                                            </ul>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.box-body -->
                                <!--            <div class="box-footer no-padding">
                                              <ul class="nav nav-pills nav-stacked">
                                                <li><a href="#">United States of America
                                                  <span class="pull-right text-red"><i class="fa fa-angle-down"></i> 12%</span></a></li>
                                                <li><a href="#">India <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 4%</span></a>
                                                </li>
                                                <li><a href="#">China
                                                  <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>
                                              </ul>
                                            </div>-->
                                <!-- /.footer -->
                            </div>
                            <!-- /.box -->

                        </section>
                        <!-- right col -->
                    </div>
                    <!-- /.row (main row) -->
                    <div class="row">
                        <div class="col-md-7">
                            <!-- USERS LIST -->
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Latest Members</h3>

                                    <div class="box-tools pull-right">
                                        <span class="label label-danger"><?php echo $totalVolunteers; ?> Total Members</span>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <ul class="users-list clearfix">
                                        <?php
                                        $latestVolunteers = $userObj->getActiveVolunteers(16, 0);
                                        while ($userRow = mysqli_fetch_array($latestVolunteers)) {
                                            $userImage = $userRow['profile_image'];
                                            if (isset($userImage) && filter_var($userImage, FILTER_VALIDATE_URL)) {
                                                
                                            } elseif (!file_exists("images/" . $userImage) || empty($userImage)) {
                                                $userImage = ($userRow['sex'] == "M") ? "../images/avatar.png" : "../images/avatar2.png";
                                            } else {
                                                $userImage = "../images/" . $userImage;
                                            }
                                            $dateFormat = new DateTime($userRow['date_created']);
                                            $registeredDate = $dateFormat->format("M j, Y");
                                            ?>
                                            <li>
                                                <img src="<?php echo $userImage; ?>" alt="User Image" style="max-height: 90px;" class="img-circle">
                                                <a class="users-list-name" href="#"><?php echo $userRow['fname'] . " " . $userRow['mname']; ?></a>
                                                <span class="users-list-date"><?php echo $registeredDate; ?></span>
                                            </li>
                                            <?php
                                        }
                                        ?>

                                    </ul>
                                    <!-- /.users-list -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="volunteers" class="uppercase">View All Volunteers</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!--/.box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-5">
                            <!-- PRODUCT LIST -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Recent Donations</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="products-list product-list-in-box">
                                        <?php
                                        $donationObj = new Donate();
                                        $recentDonations = $donationObj->getDonation(5, 0);
                                        while ($donationRow = mysqli_fetch_array($recentDonations)) {
                                            $dFormat = new DateTime($donationRow['date_created']);
                                            $donatedDate = $dFormat->format("M, j Y");
                                            ?>
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="../dist/img/default-50x50.gif" alt="Donor Image">
                                                </div>
                                                <div class="product-info">
                                                    <a href="javascript:void(0)" class="product-title"> <?php echo $donationRow['name']; ?> (<?php echo $donationRow['country']; ?>)
                                                        <span class="label label-warning pull-right">$ <?php echo $donationRow['amount']; ?>.00</span></a>
                                                    <span class="product-description">
                                                        <?php echo $donationRow['email']; ?> &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-clock-o"></span> <?php echo $donatedDate; ?>
                                                    </span>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>

                                    </ul>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="donations" class="uppercase">View All Donations</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <!-- TABLE: LATEST ORDERS -->
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Latest Testimonials</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">

                                    <div class="table-responsive">
                                        <table id="testimonialsDT" class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th><small>Name</small></th>
                                                    <th><small>Email</small></th>
                                                    <th class='hidden-xs'><small>Created Date</small></th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $testimonialObj = new Testimonial();
                                            $testimonials = $testimonialObj->getAllTestimonial(8, 0);
                                            echo "<tbody>";
                                            $rowCount = 1;
                                            while ($row = mysqli_fetch_array($testimonials)) {
                                                echo "<tr id='row$rowCount'>";
                                                echo "<td> $row[name] <button data-toggle='popover' title='User Testimonial' data-content='$row[content]' class='btn btn-link'><span class='fa fa-eye'></span></button></td>";
                                                echo "<td>$row[email]</td>";
                                                $toFormat = new DateTime($row['dateCreated']);
                                                $toDate = $toFormat->format("M j, Y");
                                                echo "<td class='hidden-xs'>$toDate</td>";

                                                echo '</tr>';
                                                $rowCount++;
                                            }
                                            echo "</tbody>";
                                            ?>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <a href="viewTestimonial" class="btn btn-sm btn-info btn-flat pull-left">View Testimonial</a>
                                    <a href="viewTestimonial" class="btn btn-sm btn-default btn-flat pull-right">View All Testimonials</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-5">
                            <!-- PRODUCT LIST -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Recent Subscriptions</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>

                                                <th>Email</th>

                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $subscriberObj = new Subscriber();
                                            $subscribers = $subscriberObj->getAllSubscribersByOffset(5);

                                            while ($subscriberRow = mysqli_fetch_array($subscribers)) {
                                                $toFormat = new DateTime($subscriberRow['dateCreated']);
                                                $toDate = $toFormat->format("M j, Y");
                                                ?>
                                                <tr>


                                                    <td> <?php echo $subscriberRow['email']; ?></td>
                                                    <td><?php echo $toDate; ?></td>

                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="subscribers" class="uppercase">View All Subscribers</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include_once "./layout/footer.php"; ?>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- jvectormap -->
        <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

        <!-- Slimscroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>

        <!-- ChartJS -->
        <script src="../plugins/chart.js/Chart.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="../dist/js/dashboard.js"></script>
        <!--<script src="../dist/js/script.js"></script>-->
        <!-- Random Color Generator -->
        <script src="../dist/js/randomColor.min.js"></script>

        <script>
            $(function () {
                $('#dashboardNav').addClass('active');
                $('[data-toggle="popover"]').popover();
                //-------------
                //- PIE CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var dataset = [];
                var label = [];
                var userCount = 0;
                //var bgColors=[];
                $.ajax({
                    url: "../include/getUserStatics.php",
                    dataType: 'json',
                    method: 'GET',
                    success: function (data, textStatus, jqXHR) {
                        //console.log(data);
                        if (typeof (data) === 'object') {
                            for (var d in data) {
                                //  console.log(data[d].volunteerCount);
                                dataset.push(parseInt(data[d].volunteerCount));
                                label.push(data[d].sex);
                                userCount++;

                            }
                            //

                            var bgColors = randomColor({
                                count: userCount,
                                hue: 'blue',
                                alpha: 0.5
                            });

                            for (var i = 0; i < userCount; i++) {
                                $('#chartLegend').append(" <li><strong><i class='fa fa-circle' style='color:" + bgColors[i] + "; font-size:24px;'></i></strong><small> " + label[i] + "</small></li>");
                            }

        //                            console.log(label);
        //                            console.log(dataset);
                            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
                            var pieData = {
                                labels: label,
                                datasets: [
                                    {
                                        data: dataset,
                                        backgroundColor: bgColors
                                    }
                                ]
                            };
                            var pieOptions = {
                                legend: {
                                    display: false
                                }
                            };
                            //Create pie or douhnut chart
                            // You can switch between pie and douhnut using the method below.
                            var pieChart = new Chart(pieChartCanvas, {
                                type: 'doughnut',
                                data: pieData,
                                options: pieOptions
                            });

                            //
                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                //-----------------
                //- END PIE CHART -
                //-----------------
            });
        </script>
    </body>
</html>
