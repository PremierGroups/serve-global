<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../include/User.php";
include_once"../include/Blog.php";
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
if (isset($_POST['addBlogBtn'])) {
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
        $msg .= " Blog was not added.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $category = $_POST['category'];
            $slugify = new Slugify();
            $title = strip_tags($title);
            $slug = $slugify->slugify($title);
            $newBlog = new Blog();

            if ($newBlog->checkIfSlugExist($slug) > 0) {
                $slug = $slug . "-" . date('h-i-s');
            }

            //$title, $location, $description, $dueDate, $coverImage, $createdBy
            if ($newBlog->addBlog($title, $description, $target_file, $slug, $category)) {
                $msg = "Blog have been  Added Successfully!";
            } else {
                $msg = "Blog not saved successfully! Please try Again.";
            }
        } else {
            $msg = "Sorry, there was an error while publishing the blog.";
        }
        header("location:blogs?msg=$msg");
        exit(1);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Blogs</title>
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
                        <small><span class="fa fa-newspaper-o"></span> Blogs</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Blogs</li>
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
                                    <li class="active"><a href="#blogsNav" data-toggle="tab"> <span class="fa fa-newspaper-o"></span> Blogs</a></li>
                                    <li><a href="#postBlog" class="text-primary" data-toggle="tab"><span class="fa fa-plus-circle"></span> New Blog</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="blogsNav">
                                        <table id="blogsDT" class="table table-responsive table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Created Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $blogObj = new Blog();
                                            $categoryObj = new Category();
                                            $blogs = $blogObj->getBlogs($num_results_on_page, $calc_page);
                                            echo "<tbody>";
                                            while ($row = mysqli_fetch_array($blogs)) {
                                                echo "<tr id='row$row[id]'>";
                                                echo "<td>$row[title] </td>";
                                                $categoryName = (isset($row['category_id']) && !empty(trim($row['category_id']))) ? $categoryObj->getCategoryNameById($row['category_id']) : "";
                                                echo "<td>$categoryName</td>";
                                                $toFormat = new DateTime($row['dateCreated']);
                                                $toDate = $toFormat->format("M j, Y");
                                                echo "<td>$toDate</td>";
                                                echo "<td><button class='btn btn-warning btn-sm view-blog'  blog-title='$row[title]' blog-description='$row[description]'><span class='fa fa-eye'></span> View</button> | <a href='editBlog?blog-id=$row[id]' class='btn btn-primary btn-sm' data-id='$row[id]'><span class='fa fa-edit'></span> Edit</a> | <button class='btn btn-danger btn-sm delete-blog' data-id='$row[id]' data-name='$row[title]'><span class='fa fa-trash'></span> Delete</button></td>";
                                                echo '</tr>';
                                               
                                            }
                                            echo "</tbody>";
                                            ?>
                                        </table>
                                        <?php
                                        $total_pages = $blogObj->getTotalBlogs();
                                        ?>  
                                        <?php if (ceil($total_pages / $num_results_on_page) > 1): ?>
                                            <ul class="pagination pull-right" style="display: inline-flex;">
                                                <?php if ($page > 1): ?>
                                                    <li class="prev"><a href="blogs?page=<?php echo $page - 1 ?>">&laquo;</a></li>
                                                <?php endif; ?>

                                                <?php if ($page > 3): ?>
                                                    <li class="start"><a href="blogs?page=1">1</a></li>
                                                    <li class="dots">...</li>
                                                <?php endif; ?>

                                                <?php if ($page - 2 > 0): ?><li class="page"><a href="blogs?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                                                <?php if ($page - 1 > 0): ?><li class="page"><a href="blogs?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                                                <li class="active"><a href="blogs?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                                <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="blogs?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                                                <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page"><a href="blogs?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                                                <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                                    <li class="dots">...</li>
                                                    <li class="end"><a href="blogs?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                                <?php endif; ?>

                                                <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                                    <li class="next"><a href="blogs?page=<?php echo $page + 1 ?>">&raquo;</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <div class="tab-pane" id="postBlog">
                                        <form class="form-horizontal form-group-sm" enctype="multipart/form-data" action="?" method="post" id="addBlogForm">
                                            <div class="box box-default"> 
                                                <div class="box-header"><h4>Add New Blog </h4></div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="inputTitle" class="col-sm-2 control-label">Title</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="title" class="form-control" id="inputTitle"
                                                                   placeholder="Enter Blog title here...">
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
                                                        <label for="inputCategory" class="col-sm-2 control-label">Category</label>
                                                        <div class="col-sm-8">
                                                            <select name="category" class="form-control" id="inputCategory" style="width:100%;" placeholder="Select Category">
                                                                <option value="">Select Category</option>
                                                                <?php
                                                                $cateObj = new Category();
                                                                $categories = $cateObj->getAllCategories();
                                                                while ($rowCat = mysqli_fetch_array($categories)) {
                                                                    echo "<option value='$rowCat[id]'>$rowCat[name] </option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control textarea" id="inputDescription" name="description"
                                                                      placeholder="Enter Detail Blog Description Here..."
                                                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                            </textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="box-footer">
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" class="btn btn-primary" name="addBlogBtn"><span class="fa fa-save"></span> Publish</button>
                                                            <button type="reset" class="btn btn-warning">Reset</button>
                                                        </div>
                                                    </div>
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
        <!-- Summernote -->
        <script src="../bower_components/summernote/summernote-bs4.min.js"></script>
         <script src="../dist/js/sweetalert2.all.js"></script>
       
        <script>
            $(document).ready(function () {
                $('#artMsg').fadeOut(5000);
                $('.textarea').summernote();
                $('#blogNav').addClass('active');
                $("#blogsDT").DataTable({
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

                $(document).on("click", ".view-blog", function (e) {
                    e.preventDefault();
                    var blogTitle = $(this).attr('blog-title');
                    var blogDesc = $(this).attr('blog-description');
                    if (blogTitle.length > 0) {
                        Swal.fire({
                            title: "<strong>"+blogTitle+"</strong",
                            icon: 'info',
                            html:"<h4>"+blogDesc+"</h4>",
                            width: 650,
                            showCloseButton: false,
                            showCancelButton: false,
                            focusConfirm: false
                           
                        });
                    }
                });
                $('#addBlogForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        title: {
                            message: 'Blog title  is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Blog title is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 100,
                                    message: 'Blog title must be more than 2 and less than 100 characters long'
                                }
                            }
                        },
                        description: {
                            validators: {
                                notEmpty: {
                                    message: 'Blog description is required and can\'t be empty'
                                }

                            }
                        }
                    }
                });
                  $(document).on('click', '.delete-blog', function (e) {
                    e.preventDefault();
                    var blogId = $(this).attr('data-id');
                    var name = $(this).attr('data-name');
                    if (isNaN(blogId) || blogId.length > 0) {
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
                                    url: "../include/deleteBlog.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {"blogId": blogId},
                                    success: function (response) {
                                        if (response.status === 'success') {
                                            Swal.fire(
                                                    'Message',
                                                    response.msg,
                                                    response.status
                                                    );
                                            $('#row' + blogId.trim()).fadeOut(2500);
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
