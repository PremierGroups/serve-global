<?php
include_once '../models/Client.php';
include_once '../models/User.php';
ob_start();
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
    header('location:../public/login');
    die(1);
}
if ($_SESSION['role'] != "admin") {
    session_destroy();
    unset($_SESSION["username"]);
    unset($_SESSION["role"]);
    header('location:../public/login?msg=You have not a permission to access this page!');
    die(1);
}
$msg = '';
if (isset($_REQUEST['msg'])) {
    $msg = $_REQUEST['msg'];
}
if(isset($_POST['addClient'])){
    //File Upload
    $target_dir = "../images/client/";
    $target_file = date('dmYHis') . '_'. basename($_FILES["coverImage"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if file already exists
    if (file_exists($target_file)) {
        $msg = "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["coverImage"]["size"] > 2048000) {
        $msg = "Sorry, your file is too large, make sure your file is not more than 2MB.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "PNG" && $fileType != "JPG" && $fileType != "JPEG" && $fileType != "gif" && $fileType != "GIF") {
        $msg = "Sorry, Only Image file is allowed.Logo is required";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $msg .= " Client is not added.";

// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir.$target_file)) {
            $msg = "Client has been added.";
            $name=$_POST['name'];
            $email=$_POST['email'];
            $website=$_POST['website'];
            $location=$_POST['location'];
            $phone = $_POST['phone'];
            $about=$_POST['about'];
            $client=new Client();
            $add=$client->addClient($name, $email, $website, $location,$phone, $target_file, $about);
            if($add==true){
                $msg = "Client Is Added Successfully!.";
            }else{
                $msg="Client Is Not Added!";
            }
        } else {
            $msg = "Sorry, there was an error while adding the Client.";
        }
        
    }
    header("location:clients?msg=$msg");
    exit(1);
}

if (isset($_POST['delete'])) {

    $id=$_POST['delete'];
    $clientObj = new Client();

    $getItem = $clientObj->getClientById($id);
    $row = mysqli_fetch_array($getItem);
    unlink('../images/client/'.$row['logo']);

    if($clientObj->deleteClient($id)){
        $msg="Client Is Deleted Successfully!";
    }else{
        $msg="Client Is Not Deleted!";
    }
    header("location:clients?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>

<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Clients</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="../dist/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../css/ionicons.min.css">
    <link rel="stylesheet" href="../css/bootstrapValidator.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../css/AdminLTE.min.css">
    <link rel="stylesheet" href="../css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="../css/pace.min.css">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../css/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="../css/select2.min.css">
        <link rel="stylesheet" href="../css/skins/css/skin-blue.min.css">
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
        <!-- Content Header (Page header) -->
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
                            <li class="active"><a href="#clients" data-toggle="tab"><span class="fa fa-list text-success"></span><strong class="text-primary"> Clients</strong></a></li>
                            <li><a href="#addClient" class="fa fa-plus-circle text-primary" data-toggle="tab"> <strong class="text-primary"> New Client</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="clients">
                                <table id="clientDT" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Website</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $client = new Client();
                                    $clients = $client->getAllClients();
                                    echo "<tbody>";

                                    while ($row = mysqli_fetch_array($clients)) {
                                        echo '<tr>';
                                        echo "<td>$row[name]</td>";
                                        echo "<td>$row[email]</td>";
                                        echo "<td>$row[phone]</td>";
                                        echo "<td>$row[location]</td>";
                                        echo "<td>$row[website]</td>";
                                        echo "<td>
                                                <a href='editClient?client-id=$row[id]' class='btn btn-primary' >Edit<span class='glyphicon glyphicon-edit'></span></a>
                                                <a class='btn btn-danger glyphicon glyphicon-trash' onclick='deleteFunction($row[id])' data-id='$row[id]' data-toggle='modal' data-target='#deletemodal'> Delete</a></td>";

                                        echo '</tr>';
                                    }

                                    echo "</tbody>";
                                    ?>
                                </table>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="addClient">
                                <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" id="addClientForm">
                                    <div class="panel panel-default"> 
                                    <div class="panel-body"><h4>Add Client</h4>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter client name here..." />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phoneNo" class="col-sm-2 control-label">Mobile</label>
                                        <div class="col-sm-8">
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number here..." />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="location" class="col-sm-2 control-label">Location</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter landline number here..." />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email here..." >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="websiteInput" class="col-sm-2 control-label">Website</label>
                                        <div class="col-sm-8">
                                            <input type="url" class="form-control" name="website" id="website" placeholder="Enter website here..." >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputImage" class="col-sm-2 control-label">Logo</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="coverImage" class="form-control" id="inputImage"
                                                   title="Select Cover Image">
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label for="about" class="col-sm-2 control-label">About</label>
                                            <div class="col-sm-8">
                                            <textarea class="form-control textarea" id="about" name="about"
                                            placeholder="Place some text here"
                                            style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary" name="addClient">Submit</button>
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                        </div>
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
    include '../layout/admin/footer.php';
    include './deleteForm.php';
    ?>
    <!-- Control Sidebar -->
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
<script src="../js/pace.min.js"></script>

<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
<script src="../js/select2.full.min.js"></script>
<script src="../js/bootstrap3-wysihtml5.all.min.js"></script>

<script>
     $("#artMsg").fadeOut(5000);
    function deleteFunction(temp) {
        document.getElementById("deleteId").value=temp;
    }
    $(document).ready(function () {
        // Display Search Form
        $('#clientNav').addClass('active');
        //bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5();
        //Disable login nitifier after 20 seconds
        $('#artMsg').fadeOut(50000);
        //data table
         $('#clientDT').DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });
                  $('#addClientForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        name: {
                            message: 'Client name  is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Client name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 100,
                                    message: 'Client name must be more than 2 and less than 100 characters long'
                                },
                                 regexp: {
                                        regexp: /^[a-zA-Z0-9_\. ]+$/,
                                        message: 'Client name can only consist of alphabetical, number, dot and underscore'
                                    }
                            }
                        }
                         
                    }
                });

    });
</script>
</body>
</html>
