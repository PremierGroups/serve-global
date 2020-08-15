<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../include/User.php";
include "../include/Category.php";
use Cocur\Slugify\Slugify;

// Load Composer's autoloader
require '../vendor/autoload.php';
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

$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
$type = 'info';
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
// Add Category
if (isset($_POST['addCategory'])) {
    $categoryName = $_POST['categoryName'];
    $categoryName = trim($categoryName);
    $desc = $_POST['description'];
    $mainCategory = $_POST['category'];

    $category = strip_tags($categoryName);
    $slugify = new Slugify();
    $slug = $slugify->slugify($category);
    $newCategory = new Category();
    $msg = $newCategory->addCategory($categoryName, $slug, $desc, $mainCategory);
    header("location:addCategory?msg=$msg");
    exit(1);
}
// Update Category
if (isset($_POST['updateCategory'])) {
    $categoryName = trim($_POST['categoryName']);
    $id = $_POST['id'];
    $mainCategory = $_POST['category'];
    $desc = $_POST['description'];
    $category = new Category();
    $type = "info";
    $categoryName = filter_var($categoryName, FILTER_SANITIZE_STRING);
    if (!empty(trim($categoryName))) {
        if ($category->updateCategory($id, $categoryName, $desc, $mainCategory)) {
            $type = "success";
            $msg = "Category has been updated Successfully!";
        } else {
            $type = "danger";
            $msg = "Category does not updated Successfully!";
        }
    } else {
        $type = "warning";
        $msg = "Category Name can not be empty!";
    }

    header("location:addCategory?msg=$msg&type=$type");
    exit(1);
}

// Add Main Category
if (isset($_POST['addMainCategory'])) {
    $categoryName = $_POST['name'];
    $is_mandatory = 0;
    if (isset($_POST['is_mandatory'])) {
        $is_mandatory = 1;
    }
    $newCategory = new Category();

    $msg = $newCategory->addMainCategory($categoryName, $is_mandatory);
    header("location:addCategory?msg=$msg");
    exit(1);
}
// Update Main Category
if (isset($_POST['updateMainCategory'])) {
    $categoryName = $_POST['name'];
    $categoryName = filter_var($categoryName, FILTER_SANITIZE_STRING);
    $id = $_POST['id'];
    $is_mandatory = 0;
    if (isset($_POST['is_mandatory'])) {
        $is_mandatory = 1;
    }
    $category = new Category();
    $type = "info";
    if (!empty(trim($categoryName))) {
        if ($category->updateMainCategory($id, $categoryName, $is_mandatory)) {
            $type = "success";
            $msg = "Main Category has been updated Successfully!";
        } else {
            $type = "danger";
            $msg = "Main Category does not Updated Successfully!";
        }
    } else {
        $type = "warning";
        $msg = "Main category can not be empty!";
    }

    header("location:addCategory?msg=$msg&type=$type");
    exit(1);
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Categories</title>
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
        <link rel="stylesheet" href="../dist/css/sweetalert2.min.css">
        <link rel="stylesheet" href="../dist/css/bootstrapValidator.min.css">
        <link rel="stylesheet" href="../plugins/pace/pace.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
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
                <!-- Update category Modal start here-->
                <div class="modal fade" id="updateCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form class="form-horizontal" role="form" id="categoryEditForm" method="post" action="addCategory.php">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Update Category</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id" class="form-control" id="categoryId" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="categoryName" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="categoryName" id="categoryName" class="form-control" value="" />

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputCategoryEdit" class="col-sm-2 control-label">Category</label>
                                        <div class="col-sm-10">
                                            <select name="category" class="form-control" id="inputCategoryEdit" placeholder="Select Category...">
                                                <option value="">Select Category</option>
                                                <?php
                                                $categoryObj = new Category();
                                                $mainCategories = $categoryObj->getAllMainCategories();
                                                while ($mainRow = mysqli_fetch_array($mainCategories)) {
                                                    ?>
                                                    <option value="<?php echo $mainRow['id']; ?>"><?php echo $mainRow['name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="inputEditDescription" class="col-sm-2 control-label">Description <small>(Optional)</small></label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control textarea" id="inputEditDescription" rows="5" name="description" placeholder="Update Category description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"name="updateCategory" > <span class="fa fa-save"></span> Update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- update category Modal end here-->
                <!-- Add category Modal start here-->
                <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form class="form-horizontal form-group" action="<?php $_PHP_SELF ?>" method="post" id="addCategoryForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="addModalLabel">Add Category</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="categoryName" class="form-control" id="inputName" placeholder="Enter Category Name Here...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputCategory" class="col-sm-2 control-label">Category</label>
                                        <div class="col-sm-10">
                                            <select name="category" class="form-control" id="inputCategory">
                                                <option value="">Select Category</option>
                                                <?php
                                                $categoryObj = new Category();
                                                $mainCategories = $categoryObj->getAllMainCategories();
                                                while ($mainRow = mysqli_fetch_array($mainCategories)) {
                                                    ?>
                                                    <option value="<?php echo $mainRow['id']; ?>"><?php echo $mainRow['name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label for="inputDescription" class="col-sm-4 control-label">Description <small>(Optional)</small></label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control textarea" id="inputDescription" rows="5" name="description" placeholder="Enter Category description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="addCategory"><span class="fa fa-save"></span> Save</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal category end here-->
                <!-- Update main category Modal start here-->
                <div class="modal fade" id="updateMainCategoryModal" tabindex="-1" role="dialog" aria-labelledby="mainModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form class="form-horizontal" role="form" id="mainCategoryEditForm" method="post" action="?">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="mainModalLabel">Update Main Category</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="id" class="form-control" id="categoryIdEdit" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="mainCategoryNameEdit" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" id="mainCategoryNameEdit" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox col-sm-offset-2 col-sm-8">
                                            <label>
                                                <input type="checkbox" id="mandatoryInputEdit" name="is_mandatory" > Is Mandatory?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="updateMainCategory" > <span class="fa fa-save"></span> Update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- update main  category Modal end here-->
                <!-- Add main category Modal start here-->
                <div class="modal fade" id="addMainCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addMainModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form class="form-horizontal form-group" action="<?php $_PHP_SELF ?>" method="post" id="addMainCategoryForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="addMainModalLabel">Add Main Category</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="inputMainCategory" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control" id="inputMainCategory" autofocus="" placeholder="Enter Main Category Name Here...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox col-sm-offset-2 col-sm-8">
                                            <label>
                                                <input type="checkbox" id="mandatoryInput" name="is_mandatory" > Is Mandatory?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="addMainCategory"><span class="fa fa-save"></span> Save</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- add  main category Modal end here-->
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Setting
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
                        <li class="active">Categories</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if ($msg != '') {
                                ?>
                                <div class="alert alert-<?php echo $type; ?>" role='alert' id="alertMsg"> 
                                    <button type='button' class='close' data-dismiss='alert'>
                                        <span aria-hidden='true'>&times;</span>
                                        <span class='sr-only'>Close</span>
                                    </button><?php echo $msg; ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-sm-8">
                                <div class="box box-default">
                                    <div class="box-header with-border"><h3 class="box-title">Categories</h3>
                                        <button type="button" id="addCategoryBtn" class="btn btn-primary btn-sm pull-right" data-toggle="tooltip" data-placement="left" title="Click this button to add New SubCategory"> <span class="fa fa-plus-circle"></span> New</button><br /> <br />
                                    </div>
                                    <div class="box-body">
                                        <table id="categoriesDT" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $category = new Category();
                                            $getCategories = $category->getAllCategories();
                                            echo "<tbody>";

                                            while ($row = mysqli_fetch_array($getCategories)) {
                                                echo "<tr id='categoryRow$row[id]'>";
                                                echo "<td>$row[name]</td>";
                                                echo "<td>$row[category_name]</td>";

                                                $categoryName = addslashes($row['name']);
                                                $categoryDesc = addslashes($row['description']);
                                                echo "<td><button href='#' class='btn btn-primary btn-sm updateCategory' data-id='$row[id]' data-name='$categoryName' data-desc='$categoryDesc' data-category='$row[parent_id]'> <span class='fa fa-edit'></span> Edit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button> | <button class='btn btn-danger btn-sm deleteCategory' data-id='$row[id]' data-name='$categoryName'><span class='fa fa-trash'></span> Delete</button></td>";

                                                echo '</tr>';
                                            }

                                            echo "</tbody>";
                                            ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="box box-default">
                                    <div class="box-header">Main Categories
                                        <button type="button" id="addMainCategoryBtn" class="btn btn-primary btn-sm pull-right" data-toggle="tooltip" data-placement="left" title="Click this button to add New Main Category"> <span class="fa fa-plus-circle"></span> New</button><br /> <br />
                                    </div>
                                    <div class="box-body">

                                        <ul class="todo-list">
                                            <?php
                                            $mainCategories = $category->getAllMainCategories();
                                            while ($row1 = mysqli_fetch_array($mainCategories)) {
                                                ?>
                                                <li id="mainRow<?php echo $row1['id']; ?>">
                                                    <!-- drag handle -->
                                                    <span class="handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>
                                                    <!-- todo text -->
                                                    <span class="text" id="mainRowLabel<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></span>

                                                    <!-- General tools such as edit or delete-->
                                                    <div class="tools">
                                                        <a href="#" class="fa fa-edit updateMainCategory" data-id="<?php echo $row1['id']; ?>" data-name="<?php echo $row1['name']; ?>" data-mandatory="<?php echo $row1['is_mandatory']; ?>"></a>
                                                        <a href="#" class="fa fa-trash-o deleteMainCategory" data-id="<?php echo $row1['id']; ?>" data-name="<?php echo $row1['name']; ?>" ></a>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
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
        <!-- DataTables -->
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <!-- Slimscroll -->
        <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/adminlte.min.js"></script>
        <!-- bootstrap validator  -->
        <script src="../dist/js/bootstrapValidator.min.js"></script>
        <script src="../dist/js/sweetalert2.all.js"></script>
        <script src="../plugins/iCheck/icheck.min.js"></script>
        <script src="../plugins/pace/pace.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#alertMsg").fadeOut(10000);
                $('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_flat-blue'
                });
                $('[data-toggle="tooltip"]').tooltip();
                $('#addCategoryBtn').click(function () {
                    $('#inputName').attr("autofocus", true);
                    $('#addCategoryModal').modal('show');
                });
                $('#addMainCategoryBtn').click(function () {
                    $('#addMainCategoryModal').modal('show');
                });
                $('#basicNav').addClass('active');
                $('#cateNav').addClass('active');
                $(document).on('click', '.deleteCategory', function (e) {
                    e.preventDefault();
                    var categoryId = $(this).attr('data-id');
                    var name = $(this).attr('data-name');
                    if (isNaN(categoryId) || categoryId.length > 0) {
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
                                    url: "../include/deleteCategory.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {"categoryId": categoryId},
                                    success: function (response) {
                                        if (response.status === 'success') {
                                            Swal.fire(
                                                    'Message',
                                                    response.msg,
                                                    response.status
                                                    );
                                            $('#categoryRow' + categoryId.trim()).fadeOut(2500);
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
                $(document).on('click', '.deleteMainCategory', function (e) {
                    e.preventDefault();
                    var mainCategoryId = $(this).attr('data-id');
                    var name = $(this).attr('data-name');
                    if (isNaN(mainCategoryId) || mainCategoryId.length > 0) {
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
                                    url: "../include/deleteMainCategory.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {"mainCategoryId": mainCategoryId},
                                    success: function (response) {
                                        console.log(response);
                                        if (response.status === 'success') {
                                            Swal.fire(
                                                    'Message',
                                                    response.msg,
                                                    response.status
                                                    );
                                            $('#mainRow' + mainCategoryId.trim()).fadeOut(2500);
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
                $(document).on('click', '.updateCategory', function (e) {
                    e.preventDefault();
                    var id = $(this).attr('data-id');
                    var name = $(this).attr('data-name');
                    var desc = $(this).attr('data-desc');
                    var category = $(this).attr('data-category');
                    $('#categoryEditForm')[0].reset();
                    $("#categoryId").val(id);
                    $("#categoryName").val(name);
                    if (category.trim().length > 0) {
                        $("#inputCategoryEdit").val(category);
                    }
                    //console.log("Name " + name + ", Id " + id + ", Desc" + desc);
                    $('#inputEditDescription').html(desc);
                    $('#updateCategoryModal').modal('show');
                });
                $("#categoriesDT").DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true
                });
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart();
                });
                $(document).on('click', '.updateMainCategory', function (e) {
                    e.preventDefault();
                    var id = $(this).attr('data-id');
                    var name = $(this).attr('data-name');
                    var mandatory = $(this).attr('data-mandatory');
                    // categoryIdEdit mainCategoryNameEdit 
                    //console.log(mandatory);
                    $('#mainCategoryEditForm')[0].reset();
                    $("#categoryIdEdit").val(id);
                    $("#mainCategoryNameEdit").val(name);
                    if (mandatory == 1) {
                        $('#mandatoryInputEdit').iCheck('check');
                    }
                    $('#updateMainCategoryModal').modal('show');
                });
                $('#addCategoryForm,#categoryEditForm').bootstrapValidator({
                    message: 'This value is not valid',
                    fields: {
                        categoryName: {
                            message: 'Category name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Category name is required and can\'t be empty'
                                },
                                stringLength: {
                                    min: 2,
                                    max: 100,
                                    message: 'Category name must be more than 2 and less than 100 characters long'
                                }

                            }
                        }
                    }
                });
            });
        </script>
    </body>
</html>