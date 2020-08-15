<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../include/Company.php';

if (!isset($_SESSION['username'])) {
    header("location:../login?msg=Please login to access this page!&type=danger");
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    header("location:../login?msg=You have not a permission to access this page!&type=danger");
    exit(1);
}
$msg = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$id = 0;
$companyName = '';
$companyId = 0;
$description = '';
$companyPhone1 = '';
$companyPhone2 = '';
$companyEmail = '';
$companyWebsite = '';
$companyLocation = '';
$path = '';
if (isset($_GET['sponsorId'])) {
    $id = $_GET['sponsorId'];
    $company = new Company();
    $getItem = $company->getOrganById($id);
    $row = mysqli_fetch_array($getItem);

    $companyName = $row['name'];
    $description = $row['about'];
    $companyId = $row['id'];
    $companyPhone1 = $row['phone1'];
    ;
    $companyPhone2 = $row['phone2'];
    ;
    $companyEmail = $row['email'];
    ;
    $companyWebsite = $row['website'];
    ;
    $companyLocation = $row['location'];
    if (empty($row['id'])) {
        header("location:sponsors?msg=Please select the sponsor to edit! &type=warning");
        exit(1);
    }
    $path = $row['logo'];
} else {
    $msg = 'Please Select Sponsor first then  edit It';
    header("location:sponsors?msg=$msg &type=warning");
    exit(1);
}
if (isset($_POST['updateCompanyBtn'])) {
    //File Upload
    $target_dir = "../images/";
    $target_file = date('dmYHis') . '_' . basename($_FILES["coverImage"]["name"]);
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
        $msg = "Sorry, Only Image file is allowed.";
        $uploadOk = 0;
    }
    $coverImage = '';
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $coverImage = $path;
        $msg .= " Sponsor was not Updated.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
            $coverImage = $target_file;

            if (file_exists($target_dir . $path)) {
                if (unlink($target_dir . $path)) {
                    
                }
            }
        } else {
            $coverImage = $path;
            $msg = "Sorry, there was an error while updating the Sponsor.";
        }
    }
    $name = $_POST['name'];
    $description = $_POST['description'];
    $phone = $_POST['phone'];
    $phone2 = $_POST['phone2'];
    $email = $_POST['email'];
    $description = $_POST['description'];
    $organWebsite = $_POST['website'];
    $location = $_POST['location'];
    $type = 'info';
    if ($company->updateOrganization($id, $name, $phone, $phone2, $email, $coverImage, $organWebsite, $description, $location)) {
        $msg = "Sponsor has been updated.";
        $type = 'success';
    } else {
        $msg = "Sponsor does not updated. Please try again!";
        $type = 'warning';
    }
    header("location:sponsors?msg=$msg&type=$type");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Edit Sponsor</title>
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
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/bootstrapValidator.min.css">
        <link rel="stylesheet" href="../plugins/pace/pace.css">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="../dist/css/skins/skin-yellow.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-yellow fixed sidebar-mini">
        <div class="wrapper">
<?php
include './layout/nav.php';
?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard 
                        <small><span class="fa fa-edit"></span> Edit Sponsor</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="sponsors"><i class="fa fa-dollar"></i> Sponsors</a></li>
                        <li class="active">Edit Sponsor</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Add sales modal    -->
                            <div class="modal fade" id="viewItemImage" tabindex="-1" role="dialog" aria-labelledby="viewItemImageLAbel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title" id="viewItemImageLAbel">View Sponsor Logo</h4>
                                        </div>
                                        <div class="modal-body" >
                                            <div id="modalImage"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--End of add sales modal -->
                            <?php
                            if ($msg != '') {
                                echo "<div class='alert alert-info' role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
                            }
                            ?>
                            <form class="form-horizontal form-group-sm" enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="post" id="editCompanyForm">

                                <div class="box box-default">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="inputTitle" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" class="form-control" id="inputTitle"  value="<?php echo "$companyName"; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="locationInput" class="col-sm-2 control-label">Address</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="locationInput" name="location" placeholder="Enter Address e.g Addis Ababa, Ethiopia" value="<?php echo $companyLocation; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phoneNo" class="col-sm-2 control-label">Phone1</label>
                                            <div class="col-sm-8">
                                                <input type="tel" class="form-control" id="phoneNo" name="phone" value="<?php echo $companyPhone1; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone2" class="col-sm-2 control-label">Phone2</label>
                                            <div class="col-sm-8">
                                                <input type="tel" class="form-control" id="phone2" name="phone2" value="<?php echo $companyPhone2; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" name="email" id="email" value="<?php echo $companyEmail; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="websiteInput" class="col-sm-2 control-label">Website</label>
                                            <div class="col-sm-8">
                                                <input type="url" class="form-control" name="website" id="websiteInput" value="<?php echo $companyWebsite; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputImage" class="col-sm-2 control-label">Cover Image</label>
                                            <div class="col-sm-8">
                                                <input type="file" name="coverImage" class="form-control" id="inputImage" title="Select sponsor logo image Image">
                                                <a href="#" data-image="../images/<?php echo "$path"; ?>" class="btn btn-link view-image">View Sponsor logo</a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control textarea" id="inputDescription" name="description"
                                                          style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $description; ?>
                                                </textarea>
                                            </div>

                                        </div> 
                                    </div>
                                    <div class="box-footer">
                                        <div class="form-group">
                                            <div class="col-md-offset-4 col-sm-10">
                                                <button type="submit" class="btn btn-primary" name="updateCompanyBtn"><span class="fa fa-save"></span> Update</button> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="sponsors" class="btn btn-default"><span class="fa fa-backward"></span> Cancel</a>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </form>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
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
        <!-- DataTables -->
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>

        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>
        <script src="../plugins/pace/pace.min.js"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. -->
        <script>
            $(document).ready(function () {
        // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart();
                });
                $('#sponsorNav').addClass('active');
                $(document).on('click', '.view-image', function (e) {
                    e.preventDefault();
                    var imageSrc = $(this).attr('data-image');
                    $('#modalImage').html("<img src='" + imageSrc + "' class='img-responsive' />");
                    $('#viewItemImage').modal('show');
                });
                $('#editCompanyForm').bootstrapValidator({
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
