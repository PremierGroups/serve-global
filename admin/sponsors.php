<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../include/Company.php';
include_once '../include/User.php';
$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
if (isset($_POST['renewBtn']) && isset($_POST['id'])) {
    if (is_numeric($_POST['id'])) {
        $sponsorId = $_POST['id'];
        $type = $_POST['level'];
        $fromFormat = new DateTime($_POST['fromDate']);
        $startDate = $fromFormat->format("Y-m-d");
        $endDate = $_POST['toDate'];
        $toFormat = new DateTime($_POST['toDate']);
        $endDate = $toFormat->format("Y-m-d");
        $comanyObj = new Company();
        $type='info';
        if ($comanyObj->renewSponsor($sponsorId, $type, $startDate, $endDate)) {
            $msg = "Sponsorship Agreement has been updated Successfully.";
            $type='success';
        } else {
            $msg = "Sponsorship Agreement not updated Successfully.";
            $type='danger';
        }
    } else {
        $msg = "Not Renewed!. Please select proper Sponsorship.";
        $type='danger';
    }

    header("location: sponsors?msg=$msg&type=$type");
    exit(1);
}
if (isset($_POST['register'])) {
    //File Upload
    $target_dir = "../images/";
    $target_file = date('dmYHis') . '_' . basename($_FILES["coverImage"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($target_file)) {
        $msg = "Sorry, file already exists.";
         $msgtype='warning';
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["coverImage"]["size"] > 2048000) {
        $msg = "Sorry, your file is too large, make sure your file is not more than 2MB.";
         $msgtype='info';
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "PNG" && $fileType != "JPG" && $fileType != "JPEG" && $fileType != "gif" && $fileType != "GIF") {
        $msg = "Sorry, Only Image file is allowed.";
         $msgtype='info';
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $msg .= " Sponsor was not added.";
         $msgtype='info';

        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
            $msg = "Sponsor has been added.";
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $phone2 = $_POST['phone2'];
            $email = $_POST['email'];
            $description = $_POST['description'];
            $organWebsite = $_POST['website'];
            $type = $_POST['level'];

            $fromFormat = new DateTime($_POST['fromDate']);
            $startDate = $fromFormat->format("Y-m-d");
            $endDate = $_POST['toDate'];
            $toFormat = new DateTime($_POST['toDate']);
            $endDate = $toFormat->format("Y-m-d");
            $location = $_POST['location'];
            $company = new Company();
           
            $add = $company->create($name, $phone, $phone2, $email, $target_file, $organWebsite, $description, $type, $startDate, $endDate, $location);
            if ($add == false) {
                 $msgtype='danger';
                $msg = "Sponsor does not Added!";
            } else {
                $msg = "Sponsor has been added Successfully!.";
                 $msgtype='success';
            }
        } else {
            $msg = "Sorry, there was an error while adding the Sponsor.";
             $msgtype='danger';
        }
        header("location:sponsors?msg=$msg&type=$msgtype");
        exit(1);
    }
}
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
    <title>Serve Global | Sponsors</title>
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
        <?php
        include 'layout/nav.php';
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
              <section class="content-header">
                    <h1>
                        Dashboard 
                        <small>Sponsors</small>
                    </h1>
                    <div class="breadcrumb">
                       <span class="btn btn-sm" style="background-color:#e5e4e2;">Platinium</span>
                    <span class="btn btn-sm" style="background-color:#d4af37; color: #fff;">Golden</span>
                    <span class="btn btn-sm" style="background-color:#cd7f32; color: #fff;">Bronze</span>
                    <span class="btn btn-sm" style="background-color:#aaa9ad; color: #fff;">Silver</span>
                    </div>
                </section>
            <!-- Modal start here-->
            <div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" id="renewForm" method="post" action="?">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Renew Sponsor Agreement</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" id="sponsorId" value="">
                                </div>
                                <div class="form-group">
                                    <label for="typeInputEdit" class="col-sm-3 control-label">Sponsorship Type(Level)</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="typeInputEdit" name="level">
                                            <option value="platinium">Platinium</option>
                                            <option value="golden">Golden</option>
                                            <option value="bronze">Bronze</option>
                                            <option value="siliver">Siliver</option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                                $curDate = date('m/d/Y');
                                ?>
                                <div class="form-group">
                                    <label for="fromdatepickerEdit" class="col-sm-3 control-label">Start Date</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="fromDate" id="fromdatepickerEdit" value="<?php echo $curDate; ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="todatepickerEdit" class="col-sm-3 control-label">End Date</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="toDate" id="todatepickerEdit" class="form-control" value="<?php echo $curDate; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Renew" name="renewBtn" />
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal end here-->
            <!-- Main content -->
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-md-12">

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
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#sponsors" class="fa fa-list" data-toggle="tab"> Sponsors</a></li>
                                <li><a href="#addCompany" data-toggle="tab"> <span class="fa fa-plus-circle"></span> New Sponsor</a></li>

                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="sponsors">
                                    <table id="sponsorsDT" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Duration</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $company = new Company();
                                        $getCompanies = $company->getAllOrgan();
                                        echo "<tbody>";

                                        while ($row = mysqli_fetch_array($getCompanies)) {
                                            $bgColor = "";
                                            $url = isset($row['website']) && (filter_var($row['website'], FILTER_VALIDATE_URL)) ? "<a href='$row[website]' target='_blank' data-toggle='tooltip' data-placement='right' title='$row[about]'>$row[name]</a>" : "<a href='#' data-toggle='tooltip' data-placement='right' title='$row[about]'>$row[name]</a>";
                                            if ($row['type'] == 'platinium') {
                                                $bgColor = "#e5e4e2";
                                            } else if ($row['type'] == 'golden') {
                                                $bgColor = "#d4af37";
                                            } else if ($row['type'] == 'bronze') {
                                                $bgColor = "#cd7f32";
                                            } else if ($row['type'] == 'silver') {
                                                $bgColor = "#aaa9ad ";
                                            }
                                            $toFormat = new DateTime($row['endDate']);
                                            $toDate = $toFormat->format("M j, Y");
                                            $fromFormat = new DateTime($row['startDate']);
                                            $startDate = $fromFormat->format("M j, Y");
                                            echo "<tr style='background-color:$bgColor;' id='row$row[id]'>";
                                            echo "<td>$url</td>";
                                            echo "<td>$row[email]</td>";
                                            echo "<td>$row[phone1] /$row[phone2]</td>";
                                            echo "<td>$startDate--$toDate</td>";
                                            echo "<td>$row[location]</td>";
                                            $companyName =  addslashes($row['name']);
                                            $companyDesc =  addslashes($row['about']);
                                            echo "<td>";
                                            if ($company->getRemainingDays($row['endDate']) <= 0) {
                                                echo "<a href='#' data-id='$row[id]' class='btn btn-success btn-sm renew-btn'><span class='fa fa-check'></span> Renew</a> | ";
                                            } 
                                                echo "<a href='editSponsor?sponsorId=$row[id]' class='btn btn-primary btn-sm'><span class='fa fa-edit'></span> Edit &nbsp;</a> | <button class='btn btn-danger btn-sm delete-sponsor' sponsor-id='$row[id]' sponsor-name='$companyName'><span class='fa fa-trash'></span> Delete</button>";
                                            
                                            echo "</td>";
                                            echo '</tr>';
                                        }

                                        echo "</tbody>";
                                        ?>

                                    </table>
                                </div><!-- /.tab-pane -->
                                <div class="tab-pane" id="addCompany">
                                    <form class="form-horizontal form-group-sm" role="form" method="POST" enctype="multipart/form-data" id="addCompanyForm">
                                        <div class="panel panel-default"> 
                                        <div class="panel-body"><h4>Sponsorship Registration Form</h4>
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Sponsor Name e.g Vintage Technologies PLC" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="locationInput" class="col-sm-2 control-label">Address</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="locationInput" name="location" placeholder="Enter Address e.g Addis Ababa, Ethiopia" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="typeInput" class="col-sm-2 control-label">Sponsorship Type(Level)</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="typeInput" name="level">
                                                    <option value="platinium">Platinium</option>
                                                    <option value="golden">Golden</option>
                                                    <option value="bronze">Bronze</option>
                                                    <option value="siliver">Siliver</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phoneNo" class="col-sm-2 control-label">Mobile</label>
                                            <div class="col-sm-8">
                                                <input type="tel" class="form-control" id="phoneNo" name="phone" placeholder="Enter mobile number" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone2" class="col-sm-2 control-label">Tel No.</label>
                                            <div class="col-sm-8">
                                                <input type="tel" class="form-control" id="phone2" name="phone2" placeholder="Enter tel number(optional)" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Organization Email" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="websiteInput" class="col-sm-2 control-label">Website</label>
                                            <div class="col-sm-8">
                                                <input type="url" class="form-control" name="website" id="websiteInput" placeholder="Enter Organization Website(if any) e.g http://vintechplc.com" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputImage" class="col-sm-2 control-label">Logo</label>
                                            <div class="col-sm-8">
                                                <input type="file" name="coverImage" class="form-control" id="inputImage" title="Select Logo Image">
                                            </div>

                                        </div>
                                        <?php
                                        $curDate = date('m/d/Y');
                                        ?>
                                        <div class="form-group">
                                            <label for="fromdatepicker" class="col-sm-2 control-label">Start Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="fromDate" id="fromdatepicker" value="<?php echo $curDate; ?>" class="form-control" />
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="todatepicker" class="col-sm-2 control-label">End Date</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="toDate" id="todatepicker" class="form-control" value="<?php echo $curDate; ?>" />
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control textarea" id="inputDescription" name="description" placeholder="Write Something about the Company here" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-8">
                                                <button type="submit" class="btn btn-primary" name="register"><span class="fa fa-save"></span>  Save</button>
                                                <button type="reset" class="btn btn-warning">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- /.row -->
                    </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <?php
        include 'layout/footer.php';
        ?>
        <!-- Control Sidebar -->
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
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#sponsorNav').addClass('active');
            $('#artMsg').fadeOut(50000);
            $("#todatepicker").datepicker({
                autoclose: true,
                startDate:'0'
            });
            $("#fromdatepicker").datepicker({
                autoclose: true,
                endDate:'0'
            });
            $("#todatepickerEdit").datepicker({
                autoclose: true,
                startDate:'0'
            });
            $("#fromdatepickerEdit").datepicker({
                autoclose: true,
                endDate:'0'
            });
            $(document).on('click', '.renew-btn', function(e) {
                e.preventDefault();
                var sponsorId = $(this).attr('data-id');
                console.log('SponsorId: ' + sponsorId);
                if (sponsorId.length > 0) {
                    $('#sponsorId').val(sponsorId);
                    $('#renewModal').modal('show');
                }
            });
            $("#sponsorsDT").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
               $(document).on('click', '.delete-sponsor', function (e) {
                e.preventDefault();
                var sponsorId = $(this).attr('sponsor-id');
                var name = $(this).attr('sponsor-name');
                if (isNaN(sponsorId) || sponsorId.length > 0) {
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
                                url: "../include/deleteSponsor.php",
                                type: "POST",
                                dataType: "json",
                                data: {"sponsorId": sponsorId},
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire(
                                            'Message',
                                            response.msg,
                                            response.status
                                            );
                                        $('#row' + sponsorId.trim()).fadeOut(2500);
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
             $('#addCompanyForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        name: {
                            message: 'Name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Sponsor name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 100,
                                    message: 'Name must be more than 2 and less than 100 characters long'
                                }
                            }
                        },
                        phone: {
                            message: 'Sponsor Phone number is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Sponsor phone Number is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 15,
                                    message: 'Phone Number must be more than 3 and less than 15 characters long'
                                }
                            }
                        },
                         email: {
                            message: 'Sponsor Email address is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Sponsor email addressis required and can\'t be empty'
                                },
                                emailAddress: {
                                   
                                    message: 'Please enter correct email address'
                                }
                            }
                        }

                    }
                });
        });
    </script>
</body>

</html>