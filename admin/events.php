    <?php
    ob_start();
    session_start();
    session_regenerate_id();
    //error_reporting(E_ALL | E_STRICT);
    //ini_set('display_errors', 1);
    include_once "../include/User.php";
    include_once"../include/Event.php";
    include_once '../include/Category.php';

    use Cocur\Slugify\Slugify;

    // Load Composer's autoloader
    require'../vendor/autoload.php';
    if (!isset($_SESSION['username'])) {
        header('location:../login');
        die(1);
    }
    if ($_SESSION['role'] != "admin") {
        session_destroy();
        unset($_SESSION["username"]);
        unset($_SESSION["role"]);
        header('location:../login?msg=You have not a permission to access this page!');
        die(1);
    }

    // Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    // Number of results to show on each page.
    $num_results_on_page = 25; //limit
    // Calculate the page to get the results we need from our table.
    $calc_page = ($page - 1) * $num_results_on_page; //offset
    $msg = '';
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
    }
    if (isset($_POST['addEventBtn'])) {
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
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg .= " Event was not added.";
    // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
                $eventTitle = $_POST['title'];
                $description = $_POST['description'];
                $eventLocation = $_POST['eventLocation'];
                $toFormat = new DateTime($_POST['toDate']);
                $dueDate = $toFormat->format("Y-m-d");
                $category = $_POST['category'];
                $categories = implode(',', $category);
                $newEvent = new Event();
                $slugify = new Slugify();
                $title = strip_tags($eventTitle);
                $slug = $slugify->slugify($title);
                if ($newEvent->checkIfSlugExist($slug) > 0) {
                    $slug = $slug . "-" . date('h-i-s');
                }
    //$title, $location, $description, $dueDate, $coverImage, $createdBy
                if ($newEvent->createEvent($eventTitle, $eventLocation, $description, $dueDate, $target_file, $categories, $slug)) {
                    $msg = "Event has been saved Successfully!";
                } else {
                    $msg = "Event does not saved! Please Try Again.";
                }
            } else {
                $msg = "Sorry, there was an error while publishing the news.";
            }
            header("location:events?msg=$msg");
            exit(1);
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Events </title>
         <link rel="shorcut icon" href="dist/img/favicon.ico"/>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shorcut icon" href="../assets/logo.ico"/>
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/bootstrapValidator.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
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
    <link rel="stylesheet" href="../dist/css/sweetalert2.min.css">
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
                    <small><span class="fa fa-clock-o"></span> Events</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Events</li>
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
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#allEvents" data-toggle="tab"> <span class="fa fa-calendar-check-o"></span> Events</a></li>
                                <li><a href="#events" class="text-primary" data-toggle="tab"><span class="fa fa-plus-circle"></span> New Event</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="allEvents">
                                    <table id="eventsDT" class="table table-responsive table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th class='hidden-sm'>Location</th>
                                                <th>Category</th>
                                                <th class='hidden-sm'>Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $eventObj = new Event();
                                        $events = $eventObj->getEvents($num_results_on_page, $calc_page);
                                        echo "<tbody>";
                                        $rowcount = 1;
                                        $categoryObj = new Category();
                                        while ($row = mysqli_fetch_array($events)) {
                                            echo "<tr id='row$rowcount'>";
                                            echo "<td>$row[title] </td>";
                                            echo "<td class='hidden-sm'>$row[location]</td>";
                                            $ids = explode(',', $row['category_id']);
                                            $categoryNames = '';

                                            foreach ($ids as $cId) {
                                                $categoryNames .= $categoryObj->getCategoryNameById($cId) . ", ";
                                            }
                                            $categoryNames = rtrim($categoryNames, ", ");
                                            echo "<td>$categoryNames</td>";
                                            $toFormat = new DateTime($row['dueDate']);
                                            $toDate = $toFormat->format("M j, Y");

                                            echo "<td class='hidden-sm'>$toDate</td>";
                                            echo "<td><button class='btn btn-warning btn-sm view-event' event-title='$row[title]' event-description='$row[description]'><span class='fa fa-eye'></span> View</button> | <a href='editEvent?event-id=$row[id]' class='btn btn-primary btn-sm' data-id='$row[id]' row-id='row$rowcount'><span class='fa fa-edit'></span> Edit</a> | <button class='btn btn-danger btn-sm delete-event' data-id='$row[id]' data-title='$row[title]'><span class='fa fa-trash'></span> Delete</button></td>";
                                            echo '</tr>';
                                            $rowcount++;
                                        }
                                        echo "</tbody>";
                                        ?>
                                    </table>
                                    <?php
                                    $total_pages = $eventObj->getTotalEvents();
                                    ?>  
                                    <?php if (ceil($total_pages / $num_results_on_page) > 1): ?>
                                        <ul class="pagination pull-right" style="display: inline-flex;">
                                            <?php if ($page > 1): ?>
                                                <li class="prev"><a href="events?page=<?php echo $page - 1 ?>">&laquo;</a></li>
                                            <?php endif; ?>

                                            <?php if ($page > 3): ?>
                                                <li class="start"><a href="events?page=1">1</a></li>
                                                <li class="dots">...</li>
                                            <?php endif; ?>

                                            <?php if ($page - 2 > 0): ?><li class="page"><a href="postBlog?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                                            <?php if ($page - 1 > 0): ?><li class="page"><a href="postBlog?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                                            <li class="active"><a href="events?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                            <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="events?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                                            <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="events?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                                            <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                                <li class="dots">...</li>
                                                <li class="end"><a href="events?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                            <?php endif; ?>

                                            <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                                <li class="next"><a href="events?page=<?php echo $page + 1 ?>">&raquo;</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                                <div class="tab-pane" id="events">
                                    <form class="form-horizontal form-group-sm" enctype="multipart/form-data" action="?" method="post" id="addEventForm">
                                        <div class="panel panel-default"> 
                                            <div class="panel-body"><h4>Post new Event</h4>
                                                <div class="form-group">
                                                    <label for="inputTitle" class="col-sm-2 control-label">Title</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="title" class="form-control" id="inputTitle"
                                                        placeholder="Enter Event Title Here...">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputImage" class="col-sm-2 control-label">Cover Image</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" name="coverImage" class="form-control" id="inputImage"
                                                        title="Select Cover Image">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="eventLocation" class="col-sm-2 control-label">Location</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="eventLocation" class="form-control" id="eventLocation"
                                                        placeholder="Enter Event Location Here...">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputCategory" class="col-sm-2 control-label">Category</label>
                                                    <div class="col-sm-8">
                                                        <select name="category[]" class="form-control select2" id="inputCategory"  multiple="multiple" style="width:100%;" data-placeholder="Select Category">
                                                            <option value="">Select Category</option>
                                                            <?php
                                                            $cateObj = new Category();
                                                            $categories = $cateObj->getAllCategories();
                                                            while ($rowCat = mysqli_fetch_array($categories)) {
                                                                echo "<option value='$rowCat[id]'>$rowCat[name] </option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="help-block text-aqua">You can select multiple event categories</span>
                                                    </div>
                                                </div>
                                                <?php
                                                $curDate = date('m/d/Y');
                                                ?>
                                                <!-- Date -->
                                                <div class="form-group">
                                                    <label for="toDatePicker" class="col-sm-2 control-label">Due Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="toDate" id="toDatePicker" value="<?php echo $curDate; ?>">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
    <!--                                                <div class="form-group">
                                        <div class="checkbox col-sm-offset-2 col-sm-8">
                                            <label>
                                                <input type="checkbox" id="donatableInput" name="donatable" > Is donatable?
                                            </label>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control textarea" id="inputDescription" name="description"
                                            placeholder="Enter Detail Event Description Here..."
                                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                        </textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" name="addEventBtn"><span class="fa fa-save"></span> Save</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.tab-pane -->
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
include 'layout/footer.php';
?>
<!-- Control Sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- bootstrap datepicker -->
<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
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
<script src="../plugins/pace/pace.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="../plugins/iCheck/icheck.min.js"></script>
<!-- Summernote -->
<script src="../bower_components/summernote/summernote-bs4.min.js"></script>
<script src="../dist/js/sweetalert2.all.js"></script>
<script>
    $(document).ready(function () {
        $('#artMsg').fadeOut(5000);
        $('.select2').select2({
            theme: "classic",
            allowClear: true
        });

        $(document).on("click", ".view-event", function (e) {
            e.preventDefault();
            var eventTitle = $(this).attr('event-title');
            var eventDesc = $(this).attr('event-description');
            if (eventTitle.length > 0) {
                Swal.fire({
                    title: "<strong>" + eventTitle + "</strong",
                    icon: 'info',
                    html: "<h4>" + eventDesc + "</h4>",
                    width: 650,
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false

                });
            }
        });
        $('#toDatePicker').datepicker({
            autoclose: true,
            startDate:'0'
        });
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').summernote();
    $('#eventNav').addClass('active');
   
    $("#eventsDT").DataTable({
                    "paging": false,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                });
    // To make Pace works on Ajax calls
    $(document).ajaxStart(function () {
        Pace.restart();
    });
    $(document).on('click', '.delete-event', function (e) {
        e.preventDefault();
        var eventId = $(this).attr('data-id');
        var name = $(this).attr('data-title');
        if (isNaN(eventId) || eventId.length > 0) {
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
                        url: "../include/deleteEvent.php",
                        type: "POST",
                        dataType: "json",
                        data: {"eventId": eventId},
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Message',
                                    response.msg,
                                    response.status
                                    );
                                $('#row' + eventId.trim()).fadeOut(2500);
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
    $('#addEventForm').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            eventLocation: {
                validators: {
                    notEmpty: {
                        message: 'Event location is required and can\'t be empty'
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
                    }

                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'Event description is required and can\'t be empty'
                    }

                }
            },
            toDate: {
                validators: {
                    notEmpty: {
                        message: 'Due date is required and can\'t be empty'
                    }

                }
            }
        }
    });
});
</script>
</body>
</html>
