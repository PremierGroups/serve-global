<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/Testimonial.php';
require 'vendor/autoload.php';
$clientId = "641815381795-2hq61ine5pir5culd2388an9q6edun21.apps.googleusercontent.com";
$clientSecret = "fsRnZiKxCoYHHkTWIFPyokf-";
$gClient = new Google_Client();
$redirectUri = "http://localhost/serveglobal/g-callback";
$email = '';
//Creating Client Request

$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setApplicationName("Serve Global");
$gClient->setRedirectUri($redirectUri);
$gClient->addScope('email');
$gClient->addScope('profile');
$loginUrl = $gClient->createAuthUrl();
$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
//Add Testimonial
if (isset($_POST['addTestimonial'])) {
    $testimonial = new Testimonial();
    if (isset($_POST['description']) && isset($_POST['fullName'])) {
        $secretKey = "6LdAnfcUAAAAAAnleaEnM7NKs2RiLdHCONCC03rY";
        $responseKey = $_POST['g-recaptcha-response'];
        $userIp = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIp";
        try {
            $response = file_get_contents($url);
            $response = json_decode($response);
            if ($response->success) {
                $respo = $_POST['respo'];
                $fullName = $_POST['fullName'];
                $fullName = strip_tags($fullName);
                $description = $_POST['description'];
                $description = strip_tags($description);
                $email = $_POST['email'];
                $email = strip_tags($email);
                $picture = $_POST['picture'];
                $msg = "Testimonial has been added successfully.";
                $msg = $testimonial->addTestimonial($fullName, $description, $email, $respo, $picture, "gmail");
                if ($msg) {
                    header("location:writeReview?msg=Thank you for your Review!&type=success");
                    exit(1);
                } else {
                    header("location:writeReview?msg=Your Review not Submittd! Please try again.&type=danger");
                    exit(1);
                }
            } else {
                header("location:writeReview?msg=You are not verified! Please try again.&type=danger");
                exit(1);
            }
        } catch (Exception $e) {
            header("location:writeReview?msg=Please try again.&type=danger");
            exit(1);
        }
    } else {
        header("location:writeReview?msg=Please write something on  the textarea! Please try again.&type=danger");
        exit(1);
    }
}

?>
<!doctype html>
<html class="no-js" lang="en-us">

 <head>
  <!-- =====  BASIC PAGE NEEDS  ===== -->
  <meta charset="utf-8">
  <title>Write Review | Serve Global</title>
  <!-- =====  SEO MATE  ===== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="distribution" content="global">
  <meta name="revisit-after" content="2 Days">
  <meta name="robots" content="ALL">
  <meta name="rating" content="8 YEARS">
  <meta name="Language" content="en-us">
  <meta name="GOOGLEBOT" content="NOARCHIVE">
  <!-- =====  MOBILE SPECIFICATION  ===== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="viewport" content="width=device-width">
  <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

        <!-- Bootsrap css-->
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
  
  <link rel="shortcut icon" href="images/favicon.png">
 
</head>

    <body>
     
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <h2>Write Your Review</h2>
                        </div>
                    </div>
                </div>

                <div class="row mt-60">
                    <div class="col-lg-12">
                        <?php
                        if ($msg != '') {
                            ?>
                            <div class="alert alert-<?php echo $type; ?>" role='alert' id='artMsg'>
                                <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
                                <?php echo $msg; ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if (isset($_SESSION['email'])) {
                            $userImage = $_SESSION['picture'];
                        if (isset($userImage) && filter_var($userImage, FILTER_VALIDATE_URL)) {
                            
                        } elseif (!file_exists("images/" . $userImage) || empty($userImage)) {
                            $userImage = ($userSex == "M") ? "images/avatar.png" : "images/avatar2.png";
                        } else {
                            $userImage = "images/" . $userImage;
                        }
                            ?>
                            <div class="text-center">
                                <div class="well">
                                    <img src="<?php echo $userImage; ?>" class="img-circle" style="width: 100px;">
                                    <?php echo ucwords($_SESSION['name']); ?>
                                </div>
                            </div>
                            <br>
                            <form class="form-horizontal" action="?" method="post" id="addTestimonialForm">
                                <input type="hidden" name="picture" value="<?php echo $_SESSION['picture']; ?>">
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <input type="hidden" class="form-control" id="fullName" name="fullName" placeholder="Enter Full Name Here" required="" value="<?php echo ucwords($_SESSION['name']); ?>" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <input type="hidden" name="email" class="form-control" id="inputEmail" title="Email" placeholder="E.g someone@domain.com" value="<?php echo $_SESSION['email']; ?>">
                                    </div>
                                </div>

                                <!-- Rating -->
                              <div class="form-group row">
                                        <label for="inputRespo" class="col-sm-2 col-form-label">Responsibility</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="respo" class="form-control" id="inputRespo" title="Add User Responsibility" placeholder="E.g CEO at SIGMA Engineering">
                                        </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">

                                        <textarea class="form-control" id="inputDescription" name="description" placeholder="Share details of your own experience at Serve Global." rows="5"></textarea>

                                    </div>
                                </div>
                              <div class="g-recaptcha" data-sitekey="6LdAnfcUAAAAADqUtWZgEExIPRDc-G7xJn5JnbkZ"></div>
                               <br/>
                                <div class="offset-5"><button type="submit" class="btn btn-primary" name="addTestimonial" > <i class="fa fa-save"></i> Submit</button></div>

                            </form>
                            <?php
                        } else {
                            echo "<div class='text-center'><a class='btn btn-primary text-center' href=" . $loginUrl . ">Give Review Using My Google Acoount. </a></div>";
                        }
                        ?>

                    </div>
                </div>
            </div>
 
       <script src="dist/js/jquery-2.2.4.min.js"></script>
  <script src="dist/js/bootstrap.min.js"></script>
 
        <!-- jquery-validation -->
        <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="plugins/jquery-validation/additional-methods.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            
<script>
            $(function () {
                $('#addTestimonialForm').validate({
                    rules: {
                        rate: {
                            required: true

                        },
                        description: {
                            required: true,
                            minlength: 10,
                            maxlength: 400
                        }
                    },
                    messages: {
                        rate: {
                            required: "Please enter your rate"

                        },

                        description: {
                            required: "Please provide a message Description",
                            minlength: "Message description must be at least 10 characters long",
                            maxlength: "Reveiew must be lees than 400 characters long"
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback offset-sm-2');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
    </body>

</html>