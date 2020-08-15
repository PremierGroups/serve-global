<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../include/Gallery.php';
if (!isset($_SESSION['username'])) {
    header('location:../login.php');
    exit(1);
}
if ($_SESSION['role'] != "admin") {
    session_destroy();
    unset($_SESSION["email"]);
    unset($_SESSION["role"]);
    header('location:../login?msg=You have not a permission to access this page!');
    die(1);
}
$msg = '';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}

// Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
// Number of results to show on each page.
$num_results_on_page = 25; //limit
// Calculate the page to get the results we need from our table.
$calc_page = ($page - 1) * $num_results_on_page; //offset

$gallery = new Gallery();
if (isset($_POST['addGallery'])) {
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
        $msg .= " Gallery was not added.";

// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
            $msg = "Gallery has been added.";
            $caption = $_POST['caption'];
            $msg = $gallery->addGallery($caption, $target_file);
        } else {
            $msg = "Sorry, there was an error while adding the cover image.";
        }
    }
}

// Update Gallery
if (isset($_POST['updateGallery'])) {
    $path=$_POST['currentPath'];
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
        $msg .= " Gallery was not Updated.";
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
            $msg = "Sorry, there was an error while updating the gallery.";
        }
    }

    $msg = "Gallery has been updated.";
    $id=$_POST['id'];
    $caption = $_POST['caption'];
    $gallery = new Gallery();
    $gallery->updateGallery($id, $caption, $coverImage);
    header("location:galleries.php?msg=$msg");
    exit(1);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Serve Global | Galleries </title>
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
        <!--   AdminLTE Skins. We have chosen the skin-blue for this starter
                      page. However, you can choose any other skin. Make sure you
                      apply the skin class to the body tag so the changes take effect. -->
        <link rel="stylesheet" href="../dist/css/skins/skin-yellow.min.css">
        <link rel="stylesheet" href="../plugins/pace/pace.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
        <!-- Ekko Lightbox -->
        <link rel="stylesheet" href="../plugins/ekko-lightbox/ekko-lightbox.css">
        <link rel="stylesheet" href="../plugins/toastr/toastr.min.css" type="text/css">
        <link rel="stylesheet" href="../dist/css/sweetalert2.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Google Font -->
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"></head>
    <body class="hold-transition skin-yellow fixed sidebar-mini">
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
                        <small><span class="fa fa-image"></span> Galleries</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Galleries</li>
                    </ol>
                </section>
                <!-- Add Gallery Modal-->
                <div id="addGalleryModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form class="form-horizontal form-group-sm" enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="post" id="addGalleryForm">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add Gallery</h4>
                                </div>
                                <div class="modal-body">                      <div class="form-group">
                                        <label for="inputTitle" class="col-sm-2 control-label">Caption</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="caption" class="form-control" id="inputTitle"  autofocus="" placeholder="Enter Picture caption here...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputImage" class="col-sm-2 control-label">Cover Image</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="coverImage" class="form-control" id="inputImage" title="Select Cover Image" >
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="addGallery"><span class="fa fa-save"></span> Save</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End add gallery modal-->
                <!-- edit Gallery Modal-->
                <div id="editGalleryModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <form class="form-horizontal form-group-sm" enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="post" id="editGalleryForm">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Update Gallery</h4>
                                </div>
                                <div class="modal-body">         
                                    <input type="hidden" name="id" value="" id="inputEditId">
                                    <input type="hidden" name="currentPath" value="" id="inputEditPath">
                                    <div class="form-group">
                                        <label for="inputEditCaption" class="col-sm-2 control-label">Caption</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="caption" class="form-control" id="inputEditCaption"  value="<?php echo "$galleryCaption"; ?>" placeholder="Enter Picture Caption Text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEditImage" class="col-sm-2 control-label">Cover Image</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="coverImage" class="form-control" id="inputEditImage" title="Select Cover Image">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="updateGallery"><span class="fa fa-save"></span> Update</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <!-- End edit gallery modal-->
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12" style="background-color: #FFF;">
                                <br>                
                                <!-- Trigger the modal with a button -->
                                <button type="button" class="btn btn-primary pull-right" id="addGalleryBtn" data-toggle="tooltip" data-placement="auto" title="Click this button to add new image"> <span class="fa fa-plus-circle"></span> Add Image</button>
                                <br>
                                <br>
                                <?php
                                if ($msg != '') {
                                    echo "<div class='alert alert-info' role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>" . $msg . "</div>";
                                }
                                ?>

                                <table id="imagesDT" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class='hidden-xs'><small>No.</small></th>
                                            <th>Caption</th>
                                            <th>Date Posted</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $galleries = $gallery->getAllGalleriesByOffset($num_results_on_page, $calc_page);
                                        $rowCount = 1;
                                        while ($galleryRow = mysqli_fetch_array($galleries)) {
                                            $toFormat = new DateTime($galleryRow['dateCreated']);
                                            $toDate = $toFormat->format("M j, Y");
                                            ?>
                                            <tr id="row<?php echo $rowCount; ?>">
                                                <td class='hidden-xs'><?php echo $rowCount; ?></td>

                                                <td><a href="../images/<?php echo $galleryRow['path']; ?>" data-toggle="lightbox" data-title="<?php echo $galleryRow['caption']; ?>" data-gallery="gallery"> <?php echo $galleryRow['caption']; ?></a></td>
                                                <td><?php echo $toDate; ?></td>
                                                <td>
                                                    <?php
                                                    if (file_exists("../images/" . $galleryRow['path'])) {
                                                        $image_url = "https://africanviewbycalyo.com/images/" . $galleryRow['path'];
                                                        ?>
                                                        <button class="btn btn-secondary btn-sm copy-address" data-clipboard-text="<?php echo $image_url; ?>" data-toggle="tooltip" data-placement="top" title="Click this button to copy the image url address to clipboard"><span class="fa fa-copy"></span> Copy Address</button>
                                                        <?php
                                                    }
                                                    ?>
                                                    <button  class="btn btn-primary btn-sm edit-gallery"  data-id="<?php echo $galleryRow['id']; ?>" data-path="<?php echo $galleryRow['path']; ?>" data-caption="<?php echo $galleryRow['caption']; ?>"   ><span class="fa fa-edit"></span> Edit</button> | 
                                                    <button class="btn btn-danger btn-sm delete-gallery" row-id="<?php echo $rowCount; ?>" data-id="<?php echo $galleryRow['id']; ?>"><span class="fa fa-trash"></span> Delete</button>
                                                </td>
                                            </tr>
                                            <?php
                                            $rowCount++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                $total_pages = $gallery->getTotalGallery();
                                ?>  
                                <?php if (ceil($total_pages / $num_results_on_page) > 1): ?>
                                    <ul class="pagination float-lg-right" style="display: inline-flex;">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item"><a class="page-link" href="viewGallery?page=<?php echo $page - 1 ?>">&laquo;</a></li>
                                        <?php endif; ?>

                                        <?php if ($page > 3): ?>
                                            <li class="page-item start"><a class="page-link" href="viewGallery?page=1">1</a></li>
                                            <li class="dots">...</li>
                                        <?php endif; ?>

                                        <?php if ($page - 2 > 0): ?><li class="page-item"><a class="page-link" href="viewGallery?page=<?php echo $page - 2 ?>"><?php echo $page - 2 ?></a></li><?php endif; ?>
                                        <?php if ($page - 1 > 0): ?><li class="page-item"><a class="page-link" href="viewGallery?page=<?php echo $page - 1 ?>"><?php echo $page - 1 ?></a></li><?php endif; ?>

                                        <li class="page-item active"><a class="page-link" href="viewGallery?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                                        <?php if ($page + 1 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page-item"><a class="page-link" href="viewGallery?page=<?php echo $page + 1 ?>"><?php echo $page + 1 ?></a></li><?php endif; ?>
                                        <?php if ($page + 2 < ceil($total_pages / $num_results_on_page) + 1): ?><li class="page-item"><a class="page-link" href="viewGallery?page=<?php echo $page + 2 ?>"><?php echo $page + 2 ?></a></li><?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                            <li class="dots">...</li>
                                            <li class="page-item end"><a class="page-link" href="viewGallery?page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                                        <?php endif; ?>

                                        <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                            <li class="page-item"><a class="page-link" href="viewGallery?page=<?php echo $page + 1 ?>">&raquo;</a></li>
                                            <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <?php
            include 'layout/footer.php';
            ?>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
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
        <!-- Ekko Lightbox -->
        <script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
        <!-- Ekko Lightbox -->
        <script src="../plugins/clipboard/clipboard.min.js"></script>
        <script src="../plugins/toastr/toastr.min.js"></script>
        <script src="../dist/js/sweetalert2.all.js"></script>
        <script>
            $(document).ready(function () {
                $('#artMsg').fadeOut(5000);
                $('[data-toggle="tooltip"]').tooltip();
                var clipboard = new ClipboardJS('.copy-address');

                clipboard.on('success', function (e) {
                    toastr.info("Image url Address copied to clipboard Successfuly!");
                });

                clipboard.on('error', function (e) {
                    toastr.error("Image url address not copied to clipboard Successfuly!");
                });
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart();
                });
                $('#addGalleryBtn').click(function (e) {
                    e.preventDefault();
                    $('#addGalleryModal').modal('show');
                });
                $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                    event.preventDefault();
                    $(this).ekkoLightbox({
                        alwaysShowClose: true
                    });
                });
                $('#imagesDT').DataTable({
                    'paging': false,
                    'lengthChange': false,
                    'searching': true,
                    'ordering': true,
                    'info': false,
                    'autoWidth': true
                });

                $('#galleryNav').addClass('active');
                
                $(document).on('click', '.edit-gallery', function (e) {
                    e.preventDefault();
                    $('#editGalleryForm')[0].reset();
                    var id=$(this).attr('data-id');
                    var caption=$(this).attr('data-caption');
                    var currentPath=$(this).attr('data-path');
                    if (!isNaN(id) || id.length > 0) {
                        $('#inputEditId').val(id);
                        $('#inputEditCaption').val(caption);
                        $('#inputEditPath').val(currentPath);
                        $('#editGalleryModal').modal('show');
                    }else{
                       toastr.error("OOPS... <br/>Something is happen. Please try Again!"); 
                    }
                    
                });
                //Delete Gallery
                $(document).on('click', '.delete-gallery', function (e) {
                    e.preventDefault();
                    var galleryId = $(this).attr('data-id');
                    var rowId = $(this).attr('row-id');
                    if (isNaN(galleryId) || galleryId.length > 0) {
                        Swal.fire({
                            title: 'Are you sure?',
                            width: 400,
                            html: "<h3>You want to delete this <b> Gallery </b></h3>",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "../include/deleteGallery.php",
                                    type: "POST",
                                    dataType: "json",
                                    data: {"galleryId": galleryId},
                                    success: function (response) {
                                        if (response.status === 'success') {
                                            Swal.fire(
                                                    'Message',
                                                    response.msg,
                                                    response.status
                                                    );
                                            $('#row' + rowId.trim()).fadeOut(1000);
                                        } else {
                                            Swal.fire(
                                                    'OOPS...',
                                                    response.msg,
                                                    response.status
                                                    );
                                        }

                                    },
                                    error: function (error) {
                                        //console.log(error);
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
