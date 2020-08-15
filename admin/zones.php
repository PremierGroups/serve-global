<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../include/User.php";
include_once "../include/Region.php";
include_once "../include/Zone.php";
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
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
if (isset($_POST['addZoneBtn'])) {
    if (isset($_POST['name']) && isset($_POST['region'])) {
        $name = $_POST['name'];
        $region = $_POST['region'];
// echo $name." ". $region;
// exit(1);
        $zoneObj = new Zone();
        $msg = $zoneObj->addZone($name, $region);
        header("location:zones?msg=$msg");
        exit(1);
    }
}
if (isset($_POST['updateZoneBtn'])) {
    if (isset($_POST['zoneId']) && isset($_POST['name']) && isset($_POST['region'])) {
        $name = $_POST['name'];
        $zoneId = $_POST['zoneId'];
        $region = $_POST['region'];
        $type = 'info';
        $zoneObj = new Zone();
        if ($zoneObj->updateZone($zoneId, $region, $name)) {
            $type = 'success';
            $msg = "Sub city has been updated Successfully!";
        } else {
            $type = 'danger';
            $msg = "Sub city does not updated Successfully!";
        }
        header("location:zones?msg=$msg&type=$type");
        exit(1);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Sub cities</title>
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
        <link rel="stylesheet" href="../dist/css/sweetalert2.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

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
                        Setting
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
                        <li class="active">Subcities</li>
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

                    <!-- Add zone Modal -->
                    <div id="addZoneModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add New Subcity</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="nameInput">Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="nameInput" placeholder="Enter city name" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="regionInput">Region:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="regionInput" name="region" placeholder="Select region" required="">
                                                    <?php
                                                    $regionObj = new Region();
                                                    $regions = $regionObj->getAllRegions();
                                                    while ($row1 = mysqli_fetch_array($regions)) {
                                                        ?>
                                                        <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="addZoneBtn"><span class="fa fa-save"></span> Save</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <!-- End Modal-->

                    <!-- Add zone Modal -->
                    <div id="editZoneModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="editZoneForm">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Update Subcity</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="zoneId" id="idEditInput" value="">
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="nameEditInput">Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="nameEditInput" placeholder="Enter sub city name" required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="regionEditInput">Region:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="regionEditInput" name="region" placeholder="Select region" required="">
                                                    <?php
                                                    $regions = $regionObj->getAllRegions();
                                                    while ($row1 = mysqli_fetch_array($regions)) {
                                                        ?>
                                                        <option value="<?php echo $row1['id']; ?>" id="option<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="updateZoneBtn"><span class="fa fa-save"></span> Update</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <!-- End Modal-->
                    
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-md-8">


                            <!-- TABLE: LATEST ORDERS -->
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Subcities</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table no-margin" id="zoneTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Region</th>
                                                    <th>#Volunteers</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $zoneObj = new Zone();
                                                $zones = $zoneObj->getAllZones();
                                                $userObj = new User();
                                                while ($row = mysqli_fetch_array($zones)) {
                                                    $noOfVolunteers = $userObj->getTotalVolunteersInZone($row['id']);
                                                    ?>
                                                    <tr id="zone<?php echo $row['id']; ?>">
                                                        <td><a href="report/viewVolunteersBySubCity?subcity_id=<?php echo $row['id'];?>" target="_blank"><?php echo $row['name']; ?></a></td>
                                                        <td><?php echo $row['regionName']; ?></td>
                                                        <td><span class="label label-default"><?php echo $noOfVolunteers; ?></span></td>
                                                        <td>
                                                            <button  class="btn btn-primary editZoneBtn btn-sm" zone-id="<?php echo $row['id']; ?>" zone-name="<?php echo $row['name']; ?>" zone-region="<?php echo $row['region-id']; ?>"><span class="fa fa-edit"></span> Edit</button>
                                                            <?php
                                                            if ($noOfVolunteers == 0) {
                                                                ?>
                                                                | <button  class="btn btn-danger deleteZoneBtn btn-sm" zone-id="<?php echo $row['id']; ?>" zone-name="<?php echo $row['name']; ?>"><span class="fa fa-trash"></span> Delete</button>

                                                                <?php
                                                            }
                                                            ?>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.box-body -->
                               <div class="box-footer clearfix">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-flat pull-left" data-toggle="modal" data-target="#addZoneModal"><i class="fa fa-plus-circle"></i> Add New</a>

                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->

                        <div class="col-md-4">
                            <!-- PRODUCT LIST -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Top Volunteered Subcities</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <?php
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th># Volunteers</th>

                                                </tr>
                                            </thead>
                                            <tbody>
<?php
$topZones = $zoneObj->getZonesHavingMostVolunters(5);
while ($row2 = mysqli_fetch_array($topZones)) {
    ?>
                                                    <tr>
                                                        <td><a href="#"><?php echo $row2['name']; ?></a></td>
                                                        <td><span class="label label-default"><?php echo $row2['volunteerCount']; ?></span></td>

                                                    </tr>
    <?php
}
?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.box-body -->

                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
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
        <!-- DataTables -->
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <!-- Slimscroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>

        <script src="../dist/js/sweetalert2.all.js"></script>
        <script>
            $(function () {
                $('#basicNav').addClass('active');
                $('#zoneNav').addClass('active');
                $('#zoneTable').DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': false
                });
                $(document).on('click', '.editZoneBtn', function (e) {
                    e.preventDefault();
                    $('#editZoneForm')[0].reset();
                    var zoneId = $(this).attr('zone-id');
                    var zoneName = $(this).attr('zone-name');
                    var regionId = $(this).attr('zone-region');
                    $('#nameEditInput').val(zoneName);
                    $('#idEditInput').val(zoneId);
                    $('#regionEditInput').prop('selectedIndex', regionId);
                    $('#editZoneModal').modal('show');
                });
                $(document).on('click', '.deleteZoneBtn', function (e) {
                    e.preventDefault();
                    var zoneId = $(this).attr('zone-id');
                    var name = $(this).attr('zone-name');
                    if (isNaN(zoneId) || zoneId.length > 0) {
                        Swal.fire({
                            title: 'Are you sure?',
                            width: 400,
                            html: "<h3>You want to delete <b>" + name + "</b></h3>",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "../include/deleteZone.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {"zoneId": zoneId},
                                    success: function (response) {
                                        if (response.status === 'success') {
                                            Swal.fire(
                                                    'Message',
                                                    response.msg,
                                                    response.status
                                                    );
                                            $('#zone' + zoneId.trim()).fadeOut(2500);
                                        } else {
                                            Swal.fire(
                                                    'OOPS...',
                                                    response.msg,
                                                    response.status
                                                    );
                                        }

                                    },
                                    error: function (error) {
                                        console.log(error);
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
