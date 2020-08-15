<?php
ob_start();
session_start();
session_regenerate_id();
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', 1);
include_once"../include/Event.php";
include_once '../include/Category.php';
if (!isset($_SESSION['username'])) {
    header('location:../login');
    die(1);
}
if ($_SESSION['role'] != "admin") {
    header('location:../login?msg=You have not a permission to access this page!');
    die(1);
}
$eventId = 0;
if (isset($_GET['event-id'])) {
    $eventId = $_GET['event-id'];
    $eventObj = new Event();
    $event = $eventObj->getEventById($eventId);
    $row = mysqli_fetch_array($event);
    if (!isset($row['id'])) {
        $msg = 'Please select event first and then  edit it';
        header("location:events?msg=$msg");
        exit(1);
    }
    $eventTitleRow = $row['title'];
    $descriptionRow = $row['description'];
    $eventLocationRow = $row['location'];
    $toFormat = new DateTime($row['dueDate']);
    $dueDateRow = $toFormat->format("m/d/Y");
    $path = $row['coverImage'];
    $eventCategory = $row['category_id'];
} else {
    $msg = 'Please Select Event first and then  edit it';
    header("location:events?msg=$msg");
    exit(1);
}
$msg = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

if (isset($_POST['updateEventBtn'])) {

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
        $msg .= " Blog was not Updated.";
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
            $msg = "Sorry, there was an error while updating the news.";
        }
    }

    $eventTitle = $_POST['title'];
    $description = $_POST['description'];
    $eventLocation = $_POST['eventLocation'];
    $toFormat = new DateTime($_POST['toDate']);
    $category = $_POST['category'];
    $categories = implode(',', $category);
    $dueDate = $toFormat->format("Y-m-d");
    $updateEvent = new Event();
    //$id, $title, $location, $description, $dueDate, $coverImage
    if ($updateEvent->updateEvent($eventId, $eventTitle, $eventLocation, $description, $dueDate, $coverImage, $categories)) {
        $msg = "Event has been updated Successfully!";
    } else {
        $msg = "Event does  not updated! Please Try Again.";
    }
    header("location:events?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Edit Event</title>
         <link rel="shorcut icon" href="dist/img/favicon.ico"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shorcut icon" href="../assets/logo.ico"/>
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

        <!-- Ionicons -->
        <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/bootstrapValidator.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <!--        <link rel="stylesheet" href="dist/css/bootstrapValidator.min.css">
                 AdminLTE Skins. We have chosen the skin-blue for this starter
                      page. However, you can choose any other skin. Make sure you
                      apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="../dist/css/skins/skin-yellow.min.css">
        <link rel="stylesheet" href="../plugins/pace/pace.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
        <!-- summernote -->
        <link rel="stylesheet" href="../bower_components/summernote/summernote-bs4.css">
        <!-- Ekko Lightbox -->
        <link rel="stylesheet" href="../plugins/ekko-lightbox/ekko-lightbox.css">
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
                        <small><span class="fa fa-edit"></span> Edit Event</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="events">Event</a></li>
                        <li class="active">Edit Event</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <?php
                            if ($msg != '') {
                                echo "<div class='alert alert-info' role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
                            }
                            ?>
                            <form class="form-horizontal form-group-sm" enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="post" id="editEventForm">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Edit Event </h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="inputTitle" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="title" class="form-control" id="inputTitle"
                                                       value="<?php echo $eventTitleRow; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputImage" class="col-sm-2 control-label">Cover Image</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="coverImage" class="form-control" id="inputImage" title="Select Cover Image">
                                                <?php
                                                if (isset($path) && file_exists("../images/" . $path)) {
                                                    ?>

                                                    <a href="../images/<?php echo $path; ?>" data-toggle="lightbox" data-title="Event Cover Picture" data-gallery="gallery"><span class="label label-primary"><i class="fa fa-eye"></i> View Cover Image</span> </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <strong class="label label-warning"><span class="fa fa-exclamation-triangle"></span> Cover Image not found</strong>     
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEventLocation" class="col-sm-2 control-label">Location</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="eventLocation" class="form-control" id="inputEventLocation"
                                                       value="<?php echo $eventLocationRow; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSkill" class="col-sm-2 control-label">Category</label>
                                            <div class="col-sm-10">
                                                <select name="category[]" class="form-control select2" id="inputSkill"  multiple="multiple" style="width:100%;" data-placeholder="Select Category">

                                                    <?php
                                                    $cateObj = new Category();
                                                    $categories = $cateObj->getAllCategories();
                                                    $categoryArray = explode(',', $eventCategory);
                                                    while ($rowCat = mysqli_fetch_array($categories)) {
                                                        if (in_array($rowCat['id'], $categoryArray)) {
                                                            echo "<option value='$rowCat[id]' selected='true'>$rowCat[name] </option>";
                                                        } else {
                                                            echo "<option value='$rowCat[id]'>$rowCat[name] </option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <span class="help-block text-aqua">You may select multiple event categories</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control textarea" id="inputDescription" name="description"
                                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $descriptionRow; ?>
                                                </textarea>
                                            </div>
                                        </div>
                                        <?php
                                        $curDate = date('m/d/Y');
                                        ?>
                                        <div class="form-group">
                                            <label for="todatepicker" class="col-sm-2 control-label">Due Date</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="toDate" id="toDate" value="<?php echo $dueDateRow; ?>"  class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" name="updateEventBtn"><span class="fa fa-save"></span> Update</button>
                                        <a href="events" class="btn btn-default"><span class="fa fa-backward"></span> Cancel</a>
                                    </div>
                                </div>
                                </div>
                                </div>
                            </form>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section>
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
<?php
include 'layout/footer.php';
?>

        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 3 -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <script src="../dist/js/bootstrapValidator.min.js"></script>
        <!-- SlimScroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <script src="../plugins/pace/pace.min.js"></script>

        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>
        <!-- Summernote -->
        <script src="../bower_components/summernote/summernote-bs4.min.js"></script>
        <!-- Select2 -->
        <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
        <!-- Ekko Lightbox -->
        <script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#artMsg').fadeOut(5000);
                $('.select2').select2({
                    theme: "classic",
                    allowClear: true
                });
                $('.textarea').summernote();
                $('#eventNav').addClass('active');
                $("#toDate").datepicker({
                    autoclose: true
                });
                $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                    event.preventDefault();
                    $(this).ekkoLightbox({
                        alwaysShowClose: true
                    });
                });
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart();
                });

                $('#editEventForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        eventLocation: {

                            validators: {
                                notEmpty: {
                                    message: 'Event location is required and please select one'
                                }

                            }
                        },
                        title: {
                            message: 'Event title  is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Event title is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 100,
                                    message: 'Event title must be more than 2 and less than 100 characters long'
                                },
                                regexp: {
                                    message: 'Event title can only consist of alphabetical'
                                }

                            }
                        },
                        description: {
                            validators: {
                                notEmpty: {
                                    message: 'Event description is is required and can\'t be empty'
                                }
                            }
                        },
                        toDate: {
                            validators: {
                                notEmpty: {
                                    message: 'Due Date is required and can\'t be empty'
                                }

                            }
                        }
                    }
                });
            });
        </script>
    </body>
</html>
