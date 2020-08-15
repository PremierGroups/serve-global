<?php
    include_once '../models/Company.php'; 
    include_once '../models/Service.php'; 
    include_once '../models/Project.php';
    include_once '../models/Client.php';
    $company = new Company();
    $companyData = $company->getOrganization();
    $row = mysqli_fetch_array($companyData);
    $address = $row['address'];
    $email = $row['email'];
    $phone = $row['phone'];
    $facebook = $row['facebook'];
    $instagram = $row['instagram'];
    $telegram=$row["telegram"];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>The Premier Groups | Services</title>
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
            <h1 class="mb-2 bread">Services</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Services <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
      <!-- end of Top section -->

      <!--services -->
      <section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center mb-5 pb-2">
                    <div class="col-md-8 text-center heading-section ftco-animate">
                        <h2 class="mb-4">OUR SERVICES</h2>
                        <p>TAKE A LOOK AT OUR SERVICES</p>
                    </div>
                </div>
				<div class="row no-gutters">
                <?php
                    $serviceObj = new Service();
                    $services = $serviceObj->getAllServices();
                    $totalServices = $serviceObj->getTotalService();
                    if (mysqli_num_rows($services) > 0) {
                        foreach ($services as $key => $serviceRow) {?>
                         <div class="col-lg-4 d-flex">
                            <?php if($key==0 || ($key%3 == 0)):?>
                                <div class="services-2 noborder-left text-center ftco-animate">
                            <?php else:?>
                                <div class="services-2 text-center ftco-animate">
                            <?php endif;?>
                                <div class="icon mt-2 d-flex justify-content-center align-items-center"><span class="flaticon-analysis"></span></div>
                                <div class="text media-body">
                                    <h3><?php echo $serviceRow['name']?></h3>
                                    <p> <?php 
                                        $description = strip_tags( $serviceRow['description']);
                                        if (strlen($description) > 30) {
                                            $descData = substr($description, 0, 30) . "..".'<a href="#"  serviceId="'.$serviceRow['id'].'" class="btn btn-default viewService" service-title="'.$serviceRow['name'].'" service-desc="'.$serviceRow['description'].'"> Read More </a>';;
                                            echo $descData; 
                                        } else {
                                            $descData = $description;
                                            echo $descData; 
                                        }
                                    ?></p>
                                </div>
                            </div>
                        </div>  
                    <?php
                    }
                    }else{
                        echo '<div class="text-center">
                                    <h2> No Service Found!!! </h2>
                              </div>';
                    }
                ?>
				</div>
			</div>
		</section>
      <!-- end of services-->
        <!-- view service modal -->
    <div class="modal fade" id="viewServiceModal" tabindex="-1" role="dialog" aria-labelledby="serviceTitleLabel" aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="serviceTitleLabel">View Service</h4>
              </div>
              <div class="modal-body">
                  <div id="serviceDiv">

                  </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>

    </div>
<!-- end service modal -->
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
        $('#serviceNav').css('color','#007bff');
        $(document).on('click', '.viewService', function (e) {
                e.preventDefault();
                var desc = $(this).attr('service-desc');
                var title = $(this).attr('service-title');
                $('#serviceTitleLabel').html(title);
                $('#serviceDiv').html(desc);
                $('#viewServiceModal').modal('show');

            });

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
        });
    </script>
</body>
</html>