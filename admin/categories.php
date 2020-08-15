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
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
$type = 'info';
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
if (isset($_POST['delete'])) {

    $id = $_POST['delete'];
    $category = new Category();
    if ($category->removeCategory($id)) {
        $msg = "Category have benn Deleted Successfully!";
    } else {
        $msg = "Category have not Deleted Successfully!";
    }
    header("location:addCategory?msg=$msg");
    exit(1);
}

if (isset($_POST['addCategory'])) {
    $categoryName = $_POST['categoryName'];
    $desc = $_POST['description'];
    $category = strip_tags($categoryName);
    $slugify = new Slugify();
    $slug = $slugify->slugify($category);
    $coverImage = $_POST['coverImage'];
    $newCategory = new Category();
    $msg = $newCategory->addCategory($categoryName, $slug, $desc, $coverImage);
    header("location:addCategory?msg=$msg");
    exit(1);
}
if (isset($_POST['updateCategory'])) {
    $categoryName = $_POST['categoryName'];
    $id = $_POST['id'];
    $desc = $_POST['description'];
    $coverImage = $_POST['coverImage'];
    $category = new Category();
    if ($category->updateCategory($id, $categoryName, $desc, $coverImage)) {
        $msg = "Category Updated Successfully!";
    } else {
        $msg = "Category not Updated Successfully!";
    }
    header("location:addCategory?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Serve Global| Categories</title>
    <link rel="shorcut icon" href="dist/img/favicon.ico"/>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- pace-progress -->
    <link rel="stylesheet" href="../plugins/pace-progress/themes/black/pace-theme-flat-top.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php
        include '../layout/admin/nav.php';
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #fff !important;">
            <!-- Modal start here-->

            <div class="modal fade" id="updateCategoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="form-horizontal" role="form" id="categoryEditForm" method="post" action="addCategory.php">

                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Update Category</h4>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" id="categoryId" value="">
                                </div>

                                <div class="form-group row">
                                    <label for="categoryName" class="col-sm-2 col-form-label">Category</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="categoryName" id="categoryName" class="form-control" value="" />

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="categoryCover" class="col-sm-2 col-form-label">Cover Image</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="coverImage" id="categoryCover" class="form-control" value="" />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEditDescription" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control textarea" id="inputEditDescription" rows="5" name="description">
                                    <div id="inDesc"></div>                     
                                    </textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Update" name="updateCategory" />
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal end here-->

            <!-- Modal start here-->

            <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form class="form-horizontal form-group" action="<?php $_PHP_SELF ?>" method="post" id="addCategoryForm">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="addModalLabel">Add Category</h4>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                            </div>
                            <div class="modal-body">

                                <div class="form-group row">
                                    <label for="inputCategory" class="col-sm-2 col-form-label">Category</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="categoryName" class="form-control" id="inputCategory" autofocus="" placeholder="Enter Category Name Here...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputCover" class="col-sm-2 col-form-label">Cover Image</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="coverImage" id="inputCover" class="form-control" value="" />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control textarea" id="inputDescription" rows="5" name="description">
                                                            </textarea>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="addCategory">Submit</button>

                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal end here-->

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>
                                Vintage Trainnig <small> <span class="fa fa-list-ol"> </span> Categories</small>

                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><button type="button" id="addCategoryBtn" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left" title="Click this button to add New Category"> <span class="fa fa-plus"></span> New</button><br /> <br />
                                </li>

                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->

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
                        <table id="table1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th class="hidden-xs">Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php
                            $rowCount = 1;
                            $category = new Category();
                            $getCategories = $category->getAllCategories();
                            echo "<tbody>";

                            while ($row = mysqli_fetch_array($getCategories)) {
                                echo '<tr>';
                                echo "<td>$rowCount</td>";
                                echo "<td>$row[name]</td>";
                                $toFormat = new DateTime($row['dateCreated']);
                                $toDate = $toFormat->format("M j, Y");
                                echo "<td class='hidden-xs'>$toDate</td>";
                                $categoryName = addslashes($row['name']);
                                $categoryDesc = addslashes($row['description']);
                                $cateCoverImage = $row['coverImage'];
                                echo "<td><a href='#' class='btn btn-primary btn-sm updateCategory' data-id='$row[id]' data-name='$categoryName' data-desc='$categoryDesc' data-cover='$cateCoverImage'> <span class='fas fa-pencil-alt'></span> Edit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> | <a class='btn btn-danger btn-sm' onclick='deleteFunction($row[id])' data-id='$row[id]' data-toggle='modal' data-target='#deletemodal'><span class='fas fa-trash'></span> Delete</a></td>";
                                $rowCount++;
                                echo '</tr>';
                            }

                            echo "</tbody>";
                            ?>

                        </table>

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

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- pace-progress -->
    <script src="../plugins/pace-progress/pace.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Summernote -->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
    <script src="../dist/js/bootstrapValidator.min.js"></script>


    <script>
        function deleteFunction(temp) {
            document.getElementById("deleteId").value = temp;
        }
        // function getId(id, name,desc) {
        //     $('#categoryEditForm')[0].reset();
        //     document.getElementById("categoryId").value = id;
        //     document.getElementById("categoryName").value = name;
        //     console.log("Name " +name+", Id "+id+", Desc"+ desc);
        //     $('#inDesc').empty();
        //    $('#inDesc').html(desc);
        // }
        $(document).ready(function() {
            //bootstrap WYSIHTML5 - text editor
            $('textarea').summernote({
                height: 200
            });
            $("#artMsg").fadeOut(5000);
            $('[data-toggle="tooltip"]').tooltip();
            $('#cateNav').addClass('active');
            $('#addCategoryBtn').click(function() {
                $('#addCategoryModal').modal('show');
            });
            $(document).on('click', '.updateCategory', function(e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                var desc = $(this).attr('data-desc');
                var coverImage = $(this).attr('data-cover');
                $('#categoryEditForm')[0].reset();
                $("#categoryId").val(id);
                $("#categoryCover").val(coverImage);
                $("#categoryName").val(name);
                console.log("Name " + name + ", Id " + id + ", Desc" + desc);
                $('#inDesc').empty();
                $('#inDesc').html(desc);
                $('#updateCategoryModal').modal('show');
            });
            $("#table1").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
            // To make Pace works on Ajax calls
            $(document).ajaxStart(function() {
                Pace.restart();
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