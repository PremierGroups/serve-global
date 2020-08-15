<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../../include/User.php';
include_once "../../include/Category.php";
include_once '../../include/Region.php';
include_once "../../include/City.php";
include_once "../../include/Zone.php";
include_once '../../include/Woreda.php';
if (!isset($_SESSION['username'])) {
    header('location:../login.php');
    exit(1);
} else {
    if (!($_SESSION['role'] == 'admin')) {
        header('location:../../login.php');
        exit(1);
    }
}
$toDate = date("Y-m-d");
$fromDate = date("Y-m-d");
$gender="";
if (isset($_GET['toDate'])) {
    $testDate = explode('-', $_GET['toDate']);
    if (count($testDate) == 3) {
        if (checkdate($testDate[1], $testDate[2], $testDate[0])) {
            // valid date ...
            $toFormat = new DateTime($_GET['toDate']);
            $toDate = $toFormat->format("Y-m-d");
        }
    }
}
if(isset($_GET['gender']) && !empty(trim($_GET['gender']))){
    $gender=trim($_GET['gender']);
}
if (isset($_GET['fromDate'])) {
    $testDate = explode('-', $_GET['fromDate']);
    if (count($testDate) == 3) {
        if (checkdate($testDate[1], $testDate[2], $testDate[0])) {
            // valid date ...
            $fromFormat = new DateTime($_GET['fromDate']);
            $fromDate = $fromFormat->format("Y-m-d");
        }
    }
}
if (isset($_GET['getReport'])) {
    if (isset($_GET['fromCheck'])) {
        $fromDate = $_GET['fromDate'];
        $toFormat = new DateTime($fromDate);
        $fromDate = $toFormat->format("Y-m-d");
    }
    if (isset($_GET['toCheck'])) {
        $toDate = $_GET['toDate'];
        $toFormat = new DateTime($toDate);
        $toDate = $toFormat->format("Y-m-d");
    }
    $gender=$_GET['gender'];
    header("location:viewVolunteersBySex.php?fromDate=$fromDate&toDate=$toDate&gender=$gender");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | View Volunteers By Sex </title>
        <link rel="shorcut icon" href="../assets/img/logo.ico"/>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link rel="stylesheet" href="../../dist/css/skins/skin-yellow.min.css">
    
        <!-- iCheck -->
        <link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            #spinnerImage{
                position: fixed;
                margin: 20%;
            }
            #panel{
                bottom: 0px !important;
                height: 100%;
            }
            #loading {
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                position: fixed;
                display: block;
                opacity: 0.7;
                background-color: #fff;
                z-index: 99;
                text-align: center;
            }

            #loading-image {
                position: absolute;
                top: 50%;
                left: 50%;
                z-index: 100;
            }
        </style>
    </head>
    <body class="hold-transition layout-top-nav">
        <div class="wrapper" id="panel">

            <div id="loading">
                <img id="loading-image" src="../../dist/img/loader.gif" alt="Loading..." class="no-print" />
            </div>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="container-fluid">
                    <br>
                    <div class="no-print">
                        <form class="form-inline form-group" role="form" id="reportForm" get="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <?php
                            $dateToLabel = date('m/d/Y');
                            $dateFromLabel = date('m/d/Y');
                            if (isset($_GET['toDate'])) {
                                $testDate = explode('-', $_GET['toDate']);
                                if (count($testDate) == 3) {
                                    if (checkdate($testDate[1], $testDate[2], $testDate[0])) {
                                        // valid date ...
                                        $dateToFormat = new DateTime($_GET['toDate']);
                                        $dateToLabel = $dateToFormat->format('m/d/Y');
                                    }
                                }
                            }
                            if (isset($_GET['fromDate'])) {
                                $testDate = explode('-', $_GET['fromDate']);
                                if (count($testDate) == 3) {
                                    if (checkdate($testDate[1], $testDate[2], $testDate[0])) {
                                        // valid date ...
                                        $dateFromFormat = new DateTime($_GET['fromDate']);
                                        $dateFromLabel = $dateFromFormat->format('m/d/Y');
                                    }
                                }
                            }
                            ?>
                            <div class="form-group">
                                <label>From:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class=""><input type="checkbox" checked="" name="fromCheck"></i>
                                    </div>
                                    <input type="text" name="fromDate" value="<?php echo "$dateFromLabel"; ?>" class="form-control pull-right" id="datepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>To:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class=""><input type="checkbox" checked="" name="toCheck"></i>
                                    </div>
                                    <input type="text" name="toDate" value="<?php echo "$dateToLabel"; ?>" class="form-control pull-right" id="todatepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group" id="customDiv">

                         <label>Gender </label>
                          <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-info-circle text-aqua"></i>
                                    </div>
                              <select class="form-control" name="gender"  id="genderInput">                                   
                             <option value="">All</option>
                             <option value="M">Male</option>
                             <option value="F">Female</option>
                         </select>
                                </div>
                        
                            </div>
                            <input type="submit" name="getReport" class="btn btn-primary" value="Display"/>
                            <button class="btn btn-default pull-right no-print" id="printOPD"><i class="fa fa-print"></i> Print</button>
                        </form>
                        
                    </div>

                    <section class="invoice">
                        <!--                <div class="row invoice-info">
                                            <div class="col-md-12">
                                                <div class="col-sm-6 invoice-col">
                                                    <img src="../dist/img/logo.ico" alt="logo" />Federal Democratic Republic of Ethiopia <br>Ministry of Health
                                                </div>
                                                <div class="col-md-offset-2 col-sm-4 invoice-col pull-right">
                                                    <strong>
                                                        Addis Ababa <br>
                                                        Facility ownership: Private<br>
                                                        Facility Name: Menillick Clinic<br>
                        <?php
//echo" Date:" . " " . $fromDate . "  - " . "" . $toDate;
                        ?>
                                                    </strong>
                                                </div>
                        
                                            </div>
                                        </div>-->
                        <section class="col-sm-12 invoice-col" style="background-color: #245269;">

                            <h3  style="color: white;"><span class="col-sm-offset-3">Volunteers By Gender</span></h3>

                        </section>
                        <br>


                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-default">
                                    <div class="box-header">  
                                    </div>
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
                                                        <th data-priority="2">Sub City/ Zone</th>
                                                        <th data-priority="3">Woreda</th>
                                                        <th data-priority="6">Sex</th>
                                                        <th data-priority="6">Registered Date</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $userObj = new User();
                                                    $regionObj = new Region();
                                                    $cityObj = new City();
                                                    $zoneObj = new Zone();
                                                    $woredaObj = new Woreda();
                                                    $volunteers = $userObj->getVolunteersBySex($fromDate, $toDate, $gender);
                                                    while ($row = mysqli_fetch_array($volunteers)) {
                                                        $worda = (isset($row['woreda']) && !empty(trim($row['woreda']))) ? $woredaObj->getWoredaNameById($row['woreda']) : "";
                                                        $zone = (isset($row['zone']) && !empty(trim($row['zone']))) ? $zoneObj->getZoneNameById($row['zone']) : "";
                                                        $city = (isset($row['city']) && !empty(trim($row['city']))) ? $cityObj->getCityNameById($row['city']) : "";
                                                        $region = (isset($row['region']) && !empty(trim($row['region']))) ? $regionObj->getRegionNameById($row['region']) : "";
                                                        $fromFormat = new DateTime($row['date_created']);
                                                        $dateCreated = $fromFormat->format("M j, Y");
                                                        ?>
                                                        <tr>
                                                            <th><?php echo $row['fname'] . " " . $row['mname']; ?></th>
                                                            <td><?php echo $row['email']; ?></td>
                                                            <td><?php echo $row['phone']; ?></td>
                                                            <td><?php echo $row['country']; ?></td>
                                                            <td><?php echo $region; ?></td>
                                                            <td><?php echo $city; ?></td>
                                                            <td><?php echo $zone; ?></td>
                                                            <td><?php echo $worda; ?></td>
                                                            <td><?php echo $row['sex']; ?></td>
                                                            <td><?php echo $dateCreated; ?></td>
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

                    </section><!-- /.content -->
                </div>
            </div><!-- /.content-wrapper -->

            <!--Footer-->
            <?php include_once '../layout/footer.php';
            ?>

        </div><!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->
        <!-- jQuery 3 -->
        <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <!-- AdminLTE App -->
        <script src="../../dist/js/adminlte.min.js"></script>
     
        <!-- iCheck -->
        <script src="../../plugins/iCheck/icheck.min.js"></script>
        <script>
            $(document).ready(function () {
                //        $(window).load(function() {
                $('#loading').hide();
                //});
                //Date picker
                $('#datepicker').datepicker({
                    autoclose: true
                });
                //Date picker
                $('#todatepicker').datepicker({
                    autoclose: true
                });
                $('#printOPD').click(function () {
                    window.print();
                });
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' /* optional */
                });
                $('.btn-toolbar').addClass('no-print');
                var gender="<?php echo $gender; ?>";
                $('#genderInput').val(gender);
            });

        </script>
    </body>
</html>