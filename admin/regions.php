<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../include/User.php";
include_once "../include/Region.php";
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
        <title>Serve Global | Regions</title>
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
                        <li class="active">Regions</li>
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
                   
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-4 connectedSortable">
                            <!-- TO DO List -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Regions</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="todo-list">
                                        <?php
                                        $userObj = new User();
                                        $regionObj = new Region();
                                        $regions = $regionObj->getAllRegions();
                                        while ($row = mysqli_fetch_array($regions)) {
                                            $numOfVolunteersInRegion = $userObj->getTotalUsersInRegion($row['id']);
                                            ?>
                                            <li id="region<?php echo$row['id']; ?>">
                                                <!-- drag handle -->
                                                <span class="handle">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </span>
                                                <!-- todo text -->
                                                <a href="report/viewVolunteersByRegion?region_id=<?php echo $row['id']; ?>" target="_blank"><span class="text" id="regionLabel<?php echo $row['id']; ?>"><?php echo $row['name']; ?></span></a>
                                                <small class="label label-info"><i class="fa fa-info-circle"></i> <?php echo $numOfVolunteersInRegion; ?> Volunteers</small>

                                                <!-- General tools such as edit or delete-->
                                                <div class="tools">
                                                    <a href="#" class="fa fa-edit editRegionBtn" region-id="<?php echo $row['id']; ?>" region-name="<?php echo $row['name']; ?>"></a>
                                                    <a href="#" class="fa fa-trash-o deleteRegion" region-id="<?php echo $row['id']; ?>" region-name="<?php echo $row['name']; ?>"></a>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>


                                    </ul>
                                </div>
                               <!-- /.box-body -->
                                <div class="box-footer clearfix no-border">
                                    <button type="button" class="btn btn-primary pull-right" id="addRegionBtn"><i class="fa fa-plus-circle"></i> Add Region</button>
                                </div>
                            </div>
                            <!-- /.box -->
                        </section>
                        <!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-8 connectedSortable">
                            <!-- solid sales graph -->
                            <div class="box box-solid" >
                                <div class="box-header">
                                    <i class="fa fa-th"></i>

                                    <h3 class="box-title">Volunteers distribution based on gender </h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" id="expandChart" class="btn bg-teal btn-sm"><i class="fa fa-expand"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="box-body border-radius-none" style="background-color: #f4f4f4;" id="chartBody" >
                                    <div class="chart">
                                        <canvas id="barChart" style="height:500px"></canvas>
                                    </div>
                                </div>
                                <!-- /.box-body -->

                            </div>
                            <!-- /.box -->

                        </section>
                        <!-- right col -->
                    </div>
                    <!-- /.row (main row) -->

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
        <!-- Morris.js charts -->
        <script src="../bower_components/raphael/raphael.min.js"></script>
        <!-- Sparkline -->
        <script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
        <script src="../bower_components/moment/min/moment.min.js"></script>
        <!-- Slimscroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>

        <script src="../dist/js/sweetalert2.all.js"></script>

        <!-- ChartJS -->
        <script src="../bower_components/chart.js/Chart.js"></script>
        <script>
            $(function () {
                $('#basicNav').addClass('active');
                $('#regionNav').addClass('active');
                $(document).on('click', '.deleteRegion', function (e) {
                    e.preventDefault();
                    var regionId = $(this).attr('region-id');
                    var name = $(this).attr('region-name');
                    if (isNaN(regionId) || regionId.length > 0) {
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
                                    url: "deleteRegion.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {"regionId": regionId},
                                    success: function (response) {
                                        if (response.status === 'success') {
                                            Swal.fire(
                                                    'Message',
                                                    response.msg,
                                                    response.status
                                                    );
                                            $('#region' + regionId.trim()).fadeOut(2500);
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
                $('#addRegionBtn').click(function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Add New Region',
                        input: 'text',
                        inputPlaceholder: "Enter Region Name",
                        inputAttributes: {
                            autocapitalize: 'off'

                        },
                        showCancelButton: true,
                        confirmButtonText: 'ADD',
                        showLoaderOnConfirm: true,
                        preConfirm: function (name) {
                            return new Promise(function (resolve) {
                                $.ajax({
                                    url: "addRegion.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {"name": name},
                                    success: function (response) {
                                        Swal.fire(
                                                'Message',
                                                response.msg,
                                                response.type
                                                );
                                    },
                                    error: function (error) {
                                        Swal.fire(
                                                'ERROR',
                                                "Something is happen. Please try Again",
                                                'error'
                                                );
                                    }
                                });
                            });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    });

                });

                // Edit Region
                $(document).on('click', '.editRegionBtn', function (e) {
                    var regionId = $(this).attr('region-id');
                    var name = $(this).attr('region-name');
                    e.preventDefault();
                    if (isNaN(regionId) || regionId.length > 0) {
                        Swal.fire({
                            title: 'Edit Region',
                            input: 'text',
                            icon: "info",
                            inputPlaceholder: "Enter Region Name",
                            inputValue: name,
                            inputAttributes: {
                                autocapitalize: 'off'

                            },
                            showCancelButton: true,
                            confirmButtonText: 'Update',
                            showLoaderOnConfirm: true,
                            preConfirm: function (name) {
                                return new Promise(function (resolve) {
                                    $.ajax({
                                        url: "editRegion.php",
                                        type: "POST",
                                        dataType: "json",
                                        data: {"regionId": regionId, "name": name},
                                        success: function (response) {
                                            if (response.status === 'success') {
                                                Swal.fire(
                                                        'Message',
                                                        response.msg,
                                                        response.status
                                                        );
                                                var id = 'regionLabel' + regionId.trim();
                                                $('#' + id).html(name);

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
                                });
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        });
                    }
                });
                var maleData=[];
                var label=[];
                var femaleData=[];
                var total=[];
                 $.ajax({
                    url: "../include/getVolunteersGroupByGender.php",
                    dataType: 'json',
                    method: 'GET',
                    success: function (data, textStatus, jqXHR) {
                        //console.log(data);
                        if (typeof (data) === 'object') {
                            for (var d in data) {
                                //  console.log(data[d].volunteerCount);
                                total.push(parseInt(data[d].totalVolunteers));
                                maleData.push(parseInt(data[d].male));
                                femaleData.push(parseInt(data[d].female));
                                label.push(data[d].name);
                            }
                            
                var areaChartData = {
                    labels:label,
                    datasets: [
                        {
                            label: 'Female',
                            fillColor: '#f012be',
                            strokeColor: 'rgba(210, 214, 222, 1)',
                            pointColor: 'rgba(210, 214, 222, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data: femaleData
                        },
                        {
                            label: 'Male',
                            fillColor: '#2c3b41',
                            strokeColor: 'rgba(60,141,188,0.8)',
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: maleData
                        },
                        {
                            //20c0ef
                            label: 'Total',
                            fillColor: '#6757ba',
                            strokeColor: 'rgba(60,141,188,0.8)',
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: total
                        }
                    ]
                };
                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $('#barChart').get(0).getContext('2d');
                var barChart = new Chart(barChartCanvas);
                var barChartData = areaChartData;
                var barChartOptions = {
                    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                    scaleBeginAtZero: true,
                    //Boolean - Whether grid lines are shown across the chart
                    scaleShowGridLines: true,
                    //String - Colour of the grid lines
                    scaleGridLineColor: 'rgba(0,0,0,.05)',
                    //Number - Width of the grid lines
                    scaleGridLineWidth: 1,
                    //Boolean - Whether to show horizontal lines (except X axis)
                    scaleShowHorizontalLines: true,
                    //Boolean - Whether to show vertical lines (except Y axis)
                    scaleShowVerticalLines: true,
                    //Boolean - If there is a stroke on each bar
                    barShowStroke: true,
                    //Number - Pixel width of the bar stroke
                    barStrokeWidth: 2,
                    //Number - Spacing between each of the X value sets
                    barValueSpacing: 5,
                    //Number - Spacing between data sets within X values
                    barDatasetSpacing: 1,
                    //String - A legend template
                    legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                    //Boolean - whether to make the chart responsive
                    responsive: true,
                    maintainAspectRatio: true
                };
                barChartOptions.datasetFill = false;
                barChart.Bar(barChartData, barChartOptions);
                        }
                    },
                       error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                
                $('#expandChart').click(function(e) {
                e.preventDefault();
                var elem = document.getElementById("chartBody");
                openFullscreen(elem);
            });
            });
            
             function openFullscreen(elem) {

            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                /* Firefox */
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                /* Chrome, Safari and Opera */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                /* IE/Edge */
                elem.msRequestFullscreen();
            }

        }
        </script>
    </body>
</html>
