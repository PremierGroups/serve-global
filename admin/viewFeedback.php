<?php
include_once '../models/Feedback.php';
ob_start();
session_start();
session_regenerate_id();
if (!isset($_SESSION['username'])) {
    header('location:../public/login.php?msg=Please Login!');
    exit(1);

}
if ($_SESSION['role'] != "admin") {
    header('location:../public/login.php?msg=You have not a permission to access this page!');
    exit(1);
}
$offset = 0;
if (isset($_REQUEST['offset'])) {
    $offset = $_REQUEST['offset'];
}
    $feedbackObj = new Feedback();
    $seen = $feedbackObj->feedbackSeen();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Feedbacks</title>

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
                <section class="content-header">
                    <h1>
                        PREMIER GROUPS
                        <small><span class="fa fa-feed"></span> User Feedback</small>
                    </h1>

                </section>
                <br>
                <!-- Main content -->
                <section class="content container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $feedback = new Feedback();
                            $feedbacks = $feedback->getFeedbacks($offset);
                            $rowCount=1;
                            while ($row = mysqli_fetch_array($feedbacks)) {

                                echo "<div class='col-md-6' id='row$rowCount'>";
                                echo "<div class='thumbnail'>";
                                echo "<span class='pull-right'><a href='#' class='delete-feedback text-danger fa fa-trash fa-lg' row-id='row$rowCount' feedback-id='$row[id]'></a></span>";
                                echo "<h4><span class='fa fa-user'></span> $row[sender]</h4>";
                                echo "<h6><a href='mailto:$row[email]' target='_blank'> <span class='fa fa-envelope'></span> $row[email]</a></h6>";
                                echo "<p>$row[content]</p>";
                                $toFormat = new DateTime($row['dateCreated']);
                                $toDate = $toFormat->format("M j, Y \a\\t h:m a");
                                echo "<small class='pull-right'><span class='fa fa-clock-o'></span> "
                                . "$toDate.</small><br/>";
                                echo "</div>";
                                echo "</div>";
                                if($rowCount%2==0){
                                    echo "<div class='clearfix'></div>";
                                }
                                $rowCount++;
                            }
                            ?> 
                            <div class="col-md-12">
                                <ul class="pager">
                                    <?php
                                    if($offset>0){
                                        if ($offset < 12) {
                                            $nextoffset = $offset + 12;
                                            echo "<li class='previous disable'><a href='viewFeedback.php?offset=0'>Previous</a></li>";
                                            echo "<li class='next'><a href='viewFeedback.php?offset=$nextoffset'>Next</a></li>";
                                        }
                                        else {
                                            $nextoffset = $offset + 12;
                                            $preoffset = $offset - 12;
                                            echo "<li class='previous'><a href='viewFeedback.php?offset=$preoffset'>Previous</a></li>";
                                            echo "<li class='next'><a href='viewFeedback.php?offset=$nextoffset'>Next</a></li>";
                                        }
                                    }

                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            <?php
            include '../layout/admin/footer.php';
            ?>
            <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
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

        <script>
            $(document).ready(function () {
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart()
                });
                $('#feedbackNav').addClass('active');
                $(document).on('click','.delete-feedback',function(e){
                    e.preventDefault();
                    if(confirm("Do you want to delete this Feedback?")){
                        var feedbackId=$(this).attr('feedback-id');
                        var rowId=$(this).attr('row-id');
                        $.ajax({
                           url: "deleteFeedback.php",
                           data: {"feedbackId": feedbackId},
                           method: "POST",
                           success: function (data, textStatus, jqXHR) {
                        $('#'+rowId).fadeOut(3000);
                    }
                        });
                            
                    }
                });
            });
        </script>            
    </body>
</html>
