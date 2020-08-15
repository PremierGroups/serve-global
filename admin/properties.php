<?php
ob_start();
session_start();
session_regenerate_id();
include_once "../models/User.php";
include "../models/Property.php";
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
if (isset($_POST['delete'])) {

    $id=$_POST['delete'];
    $property = new Property();
    
    $getItem = $property->getSinglePropertyById($id);
    $row = mysqli_fetch_array($getItem);
    $images= explode(',',$row['images']);

    foreach ($images as $key => $value) {
        
        unlink('../images/property/'.$value);
    }
    if($property->deleteProperty($id)){
        $msg="Property Is Deleted Successfully!";
    }else{
        $msg="Property Is not Deleted!";
    }
    header("location:properties?msg=$msg");
    exit(1);
}
if (isset($_POST['updatePropertyBtn'])) {
    $msg = "Property has been updated.";
    $id = $_POST['editId'];
    $title = $_POST['editTitle'];
    $description = $_POST['editDescription'];
    $phoneOne = $_POST['phoneOne'];
    $phoneTwo = $_POST['phoneTwo'];
    $images = $_POST['images'];
    $propertyObj = new Property();
    if ($propertyObj->updateProperty($id,$title,$description,$phoneOne,$phoneTwo,$images)) {
        $msg = "Property is Updated Successfully!";
    } else {
        $msg = "Failed to update Property.Try again!";
    }
    //$msg=$images;
    header("location:properties?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Properties</title>
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
        <link rel="stylesheet" href="../skins/css/skin-blue.min.css">
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

                    <!-- Add sales modal    -->
                    <div class="modal fade" id="viewDescription" tabindex="-1" role="dialog" aria-labelledby="viewDescriptionLAbel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="viewDescTitle">View Description</h4>
                                </div>
                                <div class="modal-body" >
                                    <div id="description"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Add sales modal    -->
                    <div class="modal fade" id="editProperty" tabindex="-1" role="dialog" aria-labelledby="editPropertyLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="editPropertyLabel">Edit</h4>
                                </div>
                                <div class="modal-body" >
                                    <form class="form-horizontal" role="form" action="<?php $_PHP_SELF ?>"  method="post" id="editPropertyForm">
                                        
                                        <div class="form-group">
                                            <div class="col-sm-8">
                                                <input type="hidden" name="editId" class="form-control" id="editId">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-8">
                                                <input type="hidden" name="images" class="form-control" id="images">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="title" class="col-sm-2 control-label">title</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="editTitle" class="form-control" id="editTitle">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="title" class="col-sm-2 control-label">Phone #1</label>
                                            <div class="col-sm-8">
                                                <input type="tel" name="phoneOne" class="form-control" id="phoneOne">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="title" class="col-sm-2 control-label">Phone #2</label>
                                            <div class="col-sm-8">
                                                <input type="tel" name="phoneTwo" class="form-control" id="phoneTwo">
                                            </div>
                                        </div>
                                           
                                        <div class="form-group">
                                            <label for="emailInput" class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-8">
                                                    <textarea class="form-control textarea" id="editDescription" name="editDescription"
                                                                style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                                    </textarea>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <div class="col-md-offset-2">
                                                <button type="submit" class="btn btn-primary" name="updatePropertyBtn">Submit</button>
                                                <button class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#propertyTab" data-toggle="tab"><span class="fa fa-list text-success"></span><strong class="text-primary"> Properties</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="propertyTab">
                                <table id="propertyDT" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th> Title</th>
                                        <th> Phone</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $propertyObj = new Property();
                                    $properties = $propertyObj->getAllProperties();
                                    echo "<tbody>";
                                    $rowcount = 1;
                                    while ($row = mysqli_fetch_array($properties)) {
                                        echo "<tr id='row$rowcount'>";
                                        echo "<td>
                                                $row[title]<br>
                                                <a href='#' data-description='$row[description]' class='btn btn-link view-description'>View Description</a>
                                            </td>";
                                            if($row['phone_two'] != null){
                                                echo "<td>$row[phone_one] and $row[phone_two]</td>";
                                            }else{
                                                echo "<td>$row[phone_one]</td>";
                                            }
                                           
                                        $toFormat = new DateTime($row['dateCreated']);
                                        $toDate = $toFormat->format("M j, Y");
                                        echo "<td >$toDate</td>";
                                        echo "<td>
                                                <a href='#' class='btn btn-default glyphicon glyphicon-list view-images' data-id='$row[id]' data-images='$row[images]' data-title='$row[title]'> View Images</a>
                                                <a href='editProperty?property-id=$row[id]' class='btn btn-primary glyphicon glyphicon-edit' data-id='$row[id]' row-id='row$rowcount'> Edit</a>
                                                <a class='btn btn-danger glyphicon glyphicon-trash' onclick='deleteFunction($row[id])' data-id='$row[id]' data-toggle='modal' data-target='#deletemodal'> Delete</a>
                                            </td>";
                                        echo '</tr>';
                                        $rowcount++;
                                    }

                                    echo "</tbody>";
                                    ?>
                                </table>
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
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
        $('#propertyNav').addClass('active');
        $('#propertiesNav').addClass('active');
        $('.select2').select2();
        $('.textarea').wysihtml5();
        $("#propertyDT").DataTable({
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
        $(document).on('click', '.view-description', function (e) {
            e.preventDefault();
            var description = $(this).attr('data-description');
            $('#description').html("<h6>" + description + "</h6>");
            $('#viewDescription').modal('show');
        });
        
        $(document).on('click', '.view-images', function (e) {
            e.preventDefault();
            var imageSrc = $(this).attr('data-images');
            var title = $(this).attr('data-title');
            var images= imageSrc.split(',');
            var imageDiv='';
            for (let i = 0; i < images.length; i++) {
               imageDiv = imageDiv + "<img src='"+'../images/property/'+ images[i] + "' class='img-responsive' height='300px' width='300px' />";
            }
            $('#description').html(imageDiv);
            $('#viewDescTitle').html(title);
            $('#viewDescription').modal('show');
        });

        $(document).on('click', '.edit-property', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var title = $(this).attr('data-title');
            var images = $(this).attr('data-images');
            var description = $(this).attr('data-description');
            var phoneOne = $(this).attr('data-phoneOne');
            var phoneTwo = $(this).attr('data-phoneTwo');
            $('#editId').val(id);
            $('#images').val(images);
            $('#editTitle').val(title);
            $('#editDescription').val(description);
            $('#phoneOne').val(phoneOne);
            $('#phoneTwo').val(phoneTwo);
            $('#editPropertyLabel').html("<h6>" + title + "</h6>");
            $('#editProperty').modal('show');
        });

        $('#editPropertyForm').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                editTitle: {
                    message: 'Title is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Title is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 2,
                            max: 200,
                            message: 'Title must be more than 2 and less than 200 characters long'
                        }

                    }
                },
                editDescription: {
                    message: 'Description is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Description is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 2,
                            message: 'Description must be more than 2'
                        }

                    }
                },
                phoneOne: {
                    message: 'Phone number is not valid',
                    validators: {
                        notEmpty: {
                            message: 'Phone number is required and can\'t be empty'
                        },
                        stringLength: {
                            min: 9,
                            max: 15,
                            message: 'Mobile number must be more than 9 and less than 15 characters long'
                        },
                        digits: {
                            message: 'Phone number value can contain only digits'
                        }

                    }
                }
            }
        });
    });
</script>
</body>
</html>
