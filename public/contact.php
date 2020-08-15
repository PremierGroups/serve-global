<?php
    include_once '../models/Company.php'; 
    include_once '../models/Service.php'; 
    include_once '../models/Feedback.php'; 
    $company = new Company();
    $companyData = $company->getOrganization();
    $row = mysqli_fetch_array($companyData);
    $address = $row['address'];
    $email = $row['email'];
    $phone = $row['phone'];
    $facebook = $row['facebook'];
    $instagram = $row['instagram'];
    $telegram=$row["telegram"];
    $msg = '';
    if (isset($_REQUEST['msg'])) {
        $msg = $_REQUEST['msg'];
    }
    if (isset($_POST['sendFeedback'])) {
      $name = $_POST['senderName'];
      $email = $_POST['senderEmail'];
      $comment = $_POST['senderMessage'];
      $feedback = new Feedback();
      $feedback->addFeedback($name, $email, $comment);
      $msg="Your Message Is Sent!";
      header("location:contact?msg=$msg");
      exit(1);
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>The Premier Groups | Contact Us</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/public/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="../css/public/animate.css">
    
    <link rel="stylesheet" href="../css/public/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/public/owl.theme.default.min.css">
    <link rel="stylesheet" href="../css/public/magnific-popup.css">

    <link rel="stylesheet" href="../css/public/aos.css">

    <link rel="stylesheet" href="../css/public/ionicons.min.css">
    
    <link rel="stylesheet" href="../css/public/flaticon.css">
    <link rel="stylesheet" href="../css/public/icomoon.css">
    <link rel="stylesheet" href="../css/public/style.css">
    <link rel="stylesheet" href="../css/bootstrapValidator.min.css">
  </head>
  <body>
    <!-- =====  HEADER START  ===== -->
    <?php include_once '../layout/nav.php'; ?>

    <!--Top section -->
    <section class="hero-wrap hero-wrap-2" style="background-image: url('../images/bg/bg_1.jpg');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Contact Us</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact Us <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
      <!-- end of Top section -->
      
    <section class="ftco-section contact-section">
      <div class="container">
        <div class="row d-flex mb-5 contact-info justify-content-center">
        	<div class="col-md-8">
        		<div class="row mb-5">
		          <div class="col-md-4 text-center py-4">
		          	<div class="icon">
		          		<span class="icon-map-o"></span>
		          	</div>
		            <p><span>Address:</span> <?php echo $address ?></p>
		          </div>
		          <div class="col-md-4 text-center border-height py-4">
		          	<div class="icon">
		          		<span class="icon-mobile-phone"></span>
		          	</div>
		            <p><span>Phone:</span> <?php echo $phone ?></p>
		          </div>
		          <div class="col-md-4 text-center py-4">
		          	<div class="icon">
		          		<span class="icon-envelope-o"></span>
		          	</div>
		            <p><span>Email:</span><?php echo $email ?></p>
		          </div>
		        </div>
          </div>
        </div>
        <div class="row block-9 justify-content-center mb-5">
         
          <div class="col-md-8 mb-md-5">
          	<h2 class="text-center">If you got any questions <br>please do not hesitate to send us a message</h2>
            <?php
              if ($msg != '') {
                  echo "<div class='alert alert-info' role='alert' id='artMsg'>" . $msg . "</div>";
              }
            ?>
            <form class="bg-light p-5 contact-form" action="<?php $_PHP_SELF ?>" role="form" method="post" id="sendFeedbackForm">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Your Name" name="senderName" id="senderName">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Your Email" name="senderEmail" id="senderEmail">
              </div>
              <div class="form-group">
                <textarea cols="30" rows="7" class="form-control" placeholder="Message" name="senderMessage" id="senderMessage"></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5" name="sendFeedback">
              </div>
            </form>
          
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-no-pb ftco-no-pt">
    	<div class="container">
    		<div class="row justify-content-center">
                <div class="col-md-12">
                    <div id="map" class="bg-white"></div>
                </div>
            </div>
    	</div>
    </section>
        
    <?php include_once '../layout/footer.php'; ?>

     <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
    <script src="../js/public/jquery.min.js"></script>
    <script src="../js/public/jquery-migrate-3.0.1.min.js"></script>
    <script src="../js/public/popper.min.js"></script>
    <script src="../js/public/bootstrap.min.js"></script>
    <script src="../js/public/jquery.easing.1.3.js"></script>
    <script src="../js/public/jquery.waypoints.min.js"></script>
    <script src="../js/public/jquery.stellar.min.js"></script>
    <script src="../js/public/owl.carousel.min.js"></script>
    <script src="../js/public/jquery.magnific-popup.min.js"></script>
    <script src="../js/public/aos.js"></script>
    <script src="../js/public/jquery.animateNumber.min.js"></script>
    <script src="../js/public/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="../js/public/google-map.js"></script>
    <script src="../js/public/main.js"></script>
    <script src="../js/bootstrapValidator.min.js"></script>
    <script>
        $('#contactNav').css('color','#007bff');
        $(document).ready(function () {
        $('#requestServiceForm').bootstrapValidator({
            message: 'This value is not valid',
              fields: {
                  serviceApplicantName: {
                      message: 'Name is not valid',
                      validators: {
                          notEmpty: {
                              message: 'Full Name is required and can\'t be empty'
                          },
                          stringLength: {
                              min: 2,
                              max: 200,
                              message: 'Name must be more than 2 and less than 200 characters long'
                          }

                      }
                  },
                  serviceApplicantPhone: {
                      message: 'Phone Number is not valid',
                      validators: {
                          notEmpty: {
                              message: 'Phone number is required and can\'t be empty'
                          },
                          stringLength: {
                              min: 9,
                              max: 10,
                              message: 'Mobile number must be more than 9 and less than 10 characters long'
                          },
                          digits: {
                              message: 'Phone number value can contain only digits'
                          }
                      }
                  },
                  serviceApplicantAddress: {
                      message: 'Address is not valid',
                      validators: {
                          notEmpty: {
                              message: 'Address is required and can\'t be empty'
                          }
                      }
                  },
                  selectedService: {
                      message: 'Selected Service is not valid',
                      validators: {
                          notEmpty: {
                              message: 'The desired service is required and can\'t be empty'
                          }
                      }
                  }
              }
          });

          $('#sendFeedbackForm').bootstrapValidator({
            message: 'This value is not valid',
              fields: {
                  senderName: {
                      message: 'Name is not valid',
                      validators: {
                          notEmpty: {
                              message: 'Full Name is required and can\'t be empty'
                          },
                          stringLength: {
                              min: 2,
                              max: 200,
                              message: 'Name must be more than 2 and less than 200 characters long'
                          }

                      }
                  },
                  senderEmail: {
                      message: 'Email Address is not valid',
                      validators: {
                          notEmpty: {
                              message: 'Email Address is required and can\'t be empty'
                          },
                          emailAddress: {
                              message: 'Email Address is not valid'
                          }
                      }
                  },
                  senderMessage: {
                      message: 'Message is not valid',
                      validators: {
                          notEmpty: {
                              message: 'Message is required and can\'t be empty'
                          }
                      }
                  }
              }
          });

        });
    </script>
</body>
</html>