<?php
$status = '';
$msgHeader = '';
$transaction='';
if (isset($_GET['transaction'])) {
    $transaction = $_GET['transaction'];
}
$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['type'])) {
    $status = $_GET['type'];
    $msgHeader = (strcmp($status, 'success')==0) ? "<div class='alert alert-success'>
   <strong>Success!</strong> Thank You for Your Donation. Your transaction Id is <i><b>$transaction</b></i> <br>Your Ivoice is attached to your Email Address. 
 </div>" : 
 "<div class='alert alert-danger'>
 <strong>Failed!</strong> Your Donation Is Failed Please try again!.
</div>";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Serve Global | Donation</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- ================= Favicon ================== -->
        <link rel="icon" sizes="72x72" href="dist/img/favicon.ico">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900%7COpen+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Bootsrap css-->
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <script src="dist/js/modernizr-2.8.3.min.js"></script>
</head>

<body>

    <div class="container" style="padding-top: 50px">
            <?php
            if (isset($_GET['msg'])) {
                ?>
                <?php echo $msgHeader; ?> 
            <?php
            }
            ?>
        <p><a href="index" class="btn btn-secondary">Return to Home Page</a></p>
        
    </div>
</body>

</html>