<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../include/User.php";
include_once "../include/Category.php";
include_once '../include/Region.php';
include_once "../include/City.php";
include_once "../include/Zone.php";
include_once '../include/Woreda.php';
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
        <!-- Table Responsive -->
        <link rel="stylesheet" href="../plugins/RWD-table-pattern/css/rwd-table.min.css">
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
                        <small><span class="fa fa-users"></span> Volunteers</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Volunteers</li>
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
                       <div class="col-xs-12">
                           <div class="box box-default">
                            <div class="box-body">
                                <div class="table-responsive" data-pattern="priority-columns">
                                    <table id="tech-companies-1" class="table table-small-font table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                 <th>Email</th>
                                                  <th>Phone</th>
                                                <th>Country</th>
                                                <th data-priority="1">Region</th>
                                                <th>City</th>
                                                <th data-priority="2">Sub City</th>
                                                <th data-priority="3">Woreda</th>
                                                <th data-priority="6">Sex</th>
<!--                                                <th data-priority="6">Profession</th>
                                                <th data-priority="6">Support By</th>-->
                                                 <th data-priority="6">Registered Date</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $userObj=new User();
                                            $regionObj=new Region();
                                            $cityObj=new City();
                                            $zoneObj=new Zone();
                                            $woredaObj=new Woreda();
                                            $volunteers=$userObj->getActiveVolunteers();
                                            while ($row = mysqli_fetch_array($volunteers)) {
                                                $worda=(isset($row['woreda']) && !empty(trim($row['woreda'])))?$woredaObj->getWoredaNameById($row['woreda']):"";
                                                $zone=(isset($row['zone']) && !empty(trim($row['zone'])))?$zoneObj->getZoneNameById($row['zone']):"";
                                                $city=(isset($row['city']) && !empty(trim($row['city'])))?$cityObj->getCityNameById($row['city']):"";
                                                $region=(isset($row['region']) && !empty(trim($row['region'])))?$regionObj->getRegionNameById($row['region']):"";
                                               $fromFormat = new DateTime($row['date_created']);
                                                $dateCreated = $fromFormat->format("M j, Y");
                                                //userProfile?u=$row['username'];
                                                ?>
                                             <tr>
                                                 <th><a href="#"><?php echo $row['fname']." ". $row['mname'];?></a></th>
                                                <td><?php echo $row['email'];?></td>
                                                <td><?php echo $row['phone'];?></td>
                                                <td><?php echo $row['country'];?></td>
                                                <td><?php echo $region;?></td>
                                                <td><?php echo $city;?></td>
                                                <td><?php echo $zone;?></td>
                                                <td><?php echo $worda;?></td>
                                                <td><?php echo $row['sex'];?></td>
                                                <td><?php echo $dateCreated;?></td>
                                            </tr>  
                                            <?php
                                            }
                                            ?>
                                          
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
                            <!-- /.box -->
                           </div>
                        </div>
                    </div>
                    <!-- /.row -->
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
        <!-- Sparkline -->
        <script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

        <!-- Slimscroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>
        <!-- Responsive Table -->
        <script src="../plugins/RWD-table-pattern/js/rwd-table.min.js"></script>
        <script src="../plugins/RWD-table-pattern/js/rwd.demo.min.js"></script>
        <script>
            $(function(e){
                $('#volunteerNav').addClass('active');
                       $('.focus-btn-group').append("<a href='addVolunteer' target='_blank' class='btn btn-primary' id='newUser'><span class='fa fa-user'></span> Add New Volunteer</a>");
                      /* $('.dropdown-btn-group').prepend("<button class='btn btn-primary' id='export'>Export to Excel</button>");*/
          
            });
        </script>
    </body>
</html>

