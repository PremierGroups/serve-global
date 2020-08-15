<?php
include_once '../models/User.php';
ob_start();
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
    header('location:../public/login');
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    header('location:../public/login?msg=You do not a permission to access this page!');
    exit(1);
}
$msg = '';
if (isset($_REQUEST['msg'])) {
    $msg = $_REQUEST['msg'];
}
if (isset($_POST['addUser'])) {
    $fname = strip_tags($_POST['fname']);
    $lname = strip_tags($_POST['lname']);
    $tel = strip_tags($_POST['tel']);
    $email = strip_tags($_POST['email']);
    //$role = strip_tags($_POST['role']);
    $user = new User();
    $msg = $user->addUser($fname, $lname, $email, $tel);
    header("location:users?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Users</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrapValidator.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../css/AdminLTE.min.css">
        <link rel="stylesheet" href="../css/pace.css">
        <link rel="stylesheet" href="../css/bootstrapValidator.min.css">
        <link rel="stylesheet" href="../css/skins/skin-blue.min.css">
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
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#activeUsers" data-toggle="tab"> <span class="glyphicon glyphicon-check text-success"></span><strong class="text-success"> Active Users</strong></a></li>
                                    <li><a href="#timeline" class="fa fa-warning text-danger" data-toggle="tab"> <strong class="text-danger">Blocked Users</strong></a></li>
                                    <li><a href="#addUser" class="fa fa-plus-circle text-primary" data-toggle="tab"> <strong class="text-primary">Add User</strong></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activeUsers">
                                        <table id="activeUsersDT" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Tel</th>
                                                    <th>Email</th>   
                                                    <th>Group</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $user = new User();
                                            $getUser = $user->getAcceptedUsers();
                                            echo "<tbody>";
                                            $acceptedRowcount = 1;
                                            while ($row = mysqli_fetch_array($getUser)) {
                                                echo "<tr id='row$acceptedRowcount'>";
                                                echo "<td><a href='userProfile.php?customerId=$row[id]'>$row[fname] $row[lname]</a></td>";
                                                echo "<td>$row[phoneNo]</td>";
                                                echo "<td>$row[email]</td>";
                                                echo "<td>$row[role]</td>";
                                                echo "<td><button class='btn btn-danger btn-sm fa fa-warning block-user' user-id='$row[id]' row-id='row$acceptedRowcount'> Block</button></td>";
                                                echo '</tr>';
                                                $acceptedRowcount++;
                                            }
                                            echo "</tbody>";
                                            ?>
                                        </table> 
                                    </div>
                                    <div class="tab-pane" id="timeline">
                                        <table id="blockedUsersDT" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><small>Name</small></th>
                                                    <th><small>Tel</small></th>
                                                    <th class='hidden-xs'><small>Email</small></th>   
                                                    <th><small>Action</small></th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $user = new User();
                                            $getUser = $user->getBlockedUsers();
                                            echo "<tbody>";
                                            $rowcount = 1;
                                            while ($row = mysqli_fetch_array($getUser)) {
                                                echo "<tr id='row$rowcount'>";
                                                echo "<td><a href='userProfile.php?customerId=$row[id]'>$row[fname] $row[lname]</a></td>";
                                                echo "<td>$row[phoneNo]</td>";
                                                echo "<td class='hidden-xs'>$row[email]</td>";
                                                echo "<td><button class='btn btn-primary btn-sm glyphicon glyphicon-check accept-user' user-id='$row[id]' row-id='row$rowcount'> Accept</button></td>";
                                                echo '</tr>';
                                                $rowcount++;
                                            }
                                            echo "</tbody>";
                                            ?>
                                        </table>
                                    </div><!-- /.tab-pane -->
                                    <div class="tab-pane" id="addUser">
                                        <form class="form-horizontal" action="<?php $_PHP_SELF ?>" role="form" method="post" id="employeeForm">
                                            <div class="panel panel-default"> 
                                                 <div class="panel-body"><h4>Add User Details</h4>
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-2 control-label">First Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="fname" class="form-control" id="inputName"  autofocus="" placeholder="Enter First Name Here...">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputfName" class="col-sm-2 control-label">Father Name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="lname" class="form-control" id="inputfName"  placeholder="Enter Father Name Here...">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="phoneNu" class="col-sm-2 control-label">Phone Number</label>
                                                        <div class="col-sm-8">
                                                            <input type="tel" name="tel"  class="form-control" id="phoneNu" placeholder="Enter Phone Number Here..." >
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="emailInput" class="col-sm-2 control-label">Email</label>
                                                        <div class="col-sm-8">
                                                            <input type="email" name="email" class="form-control" id="emailInput"  placeholder="Enter Email Here...E.g: daniel@gmail.com">
                                                        </div>
                                                    </div>
                                                </div>
                                             </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary" name="addUser">Submit</button>
                                                    <button type="reset" class="btn btn-warning" >Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
            ?>
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
        <!-- AdminLTE App -->
        <script src="../js/adminlte.min.js"></script>
        <script src="../js/pace.min.js"></script>

        <script>
            $(document).ready(function () {
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart()
                });
                $('#activeUsersDT').DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });
                $('#blockedUsersDT').DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });
                $('#employeeForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        fname: {
                            message: 'First name  is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'First name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 1,
                                    max: 25,
                                    message: 'First name must be more than 1 and less than 25 characters long'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\.]+$/,
                                    message: 'First name can only consist of alphabetical'
                                }
                            }
                        },
                        lname: {
                            message: 'Father name  is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Father name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 25,
                                    message: 'Father name must be more than 2 and less than 25 characters long'
                                },
                                different: {
                                    field: 'fname',
                                    message: 'Father name can\'t be the same as first name'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z\.]+$/,
                                    message: 'Father name can only consist of alphabetical'
                                }
                            }
                        },
                        tel: {
                            validators: {
                                notEmpty: {
                                    message: 'Phone number is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 9,
                                    max: 10,
                                    message: 'Mobile number must be more than 9 and less than 10 characters long'
                                },
                                digits: {
                                    message: 'Phone number value can contain only digits'
                                }
                            }
                        },
                      email: {
                            validators: {
                                emailAddress: {
                                    message: 'The input is not a valid email address'
                                }

                            }
                        }
                    }
                });

                $('#userNav').addClass('active');
                 $(document).on('click', ".accept-user", function () {
                    var userId = $(this).attr('user-id');
                    var rowId = $(this).attr('row-id');
                    if (confirm("Do You want to Accept this User?")) {
                        $.ajax({
                            url: "acceptUser.php",
                            method: "POST",
                            data: {"userId": userId},
                            success: function (data, textStatus, jqXHR) {
                                $('#' + rowId).fadeOut(1000);
                                alert(data);
                                location.reload(true);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                        });
                    }
                });
                $(document).on('click', ".block-user", function () {
                    var userId = $(this).attr('user-id');
                    var rowId = $(this).attr('row-id');
                    if (confirm("Do You want to Block this User?")) {
                        $.ajax({
                            url: "blockUser.php",
                            method: "POST",
                            data: {"userId": userId},
                            success: function (data, textStatus, jqXHR) {
                                $('#' + rowId).fadeOut(1000);
                                alert(data);
                                location.reload(true);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>
