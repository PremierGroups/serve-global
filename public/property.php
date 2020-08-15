<?php
    include_once '../models/Company.php'; 
    include_once '../models/Service.php'; 
    include_once '../models/Property.php';
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
    <title>The Premier Groups | Properties</title>
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
            <h1 class="mb-2 bread">properties</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Properties <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
      <!-- end of Top section -->
        <section>
            <div class="container">
				<div class="row justify-content-center mt-5 pb-2">
                    <div class="col-md-8 text-center heading-section ftco-animate">
                        <h2 class="mb-4">OUR PROPERTIES</h2>
                        <p>TAKE A LOOK AT OUR PROPERTIES</p>
                    </div>
                </div>
            </div>
        </section>
      <!--projects -->
      <section  class="ftco-section ftco-counter bg-grey">
			<div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                    <?php
                    $propertyObj = new Property();
                    $properties = $propertyObj->getPropertiesByLimit(9, 0);
                    $totalProperties = $propertyObj->getTotalProperties();
                    if (mysqli_num_rows($properties) > 0) {
                        while ($propertyRow = mysqli_fetch_array($properties)) {
                            $images = explode(',',$propertyRow['images']);
                            ?>
                       	<div class=" row col-md-10 mb-5 pb-2 shadow bg-white" style=" padding-left:0px !important;margin-left:0px !important">
                           <div class="tab-content  col-md-5"  style=" padding:0px !important;margin:0px !important">
                                <div id="product1<?php echo $propertyRow['id']?>" class="tab-pane fade in show active">
                                    <img class=" col-md-12 d-flex align-items-center img-responsive"  style=" padding:0px !important;margin:0px !important;height:270px !important" src="<?php echo '../images/property/'.$images[0]?>" >
                                </div>

                                <?php if(count($images)>1):?>
                                <div id="product2<?php echo $propertyRow['id']?>" class="tab-pane fade">
                                    <img class=" col-md-12 d-flex align-items-center img-responsive" style=" padding:0px !important;margin:0px !important;height:270px !important" src="<?php echo '../images/property/'.$images[1]?>" >
                                </div>
                                <?php endif;?>
                                <?php if(count($images)>2):?>
                                <div id="product3<?php echo $propertyRow['id']?>" class="tab-pane fade">
                                    <img class=" col-md-12 d-flex align-items-center img-responsive" style=" padding:0px !important;margin:0px !important;height:270px !important" src="<?php echo '../images/property/'.$images[2]?>" >
                                </div>
                                <?php endif;?>
                                <div>
                                    <ul class="nav nav-tabs products-nav-tabs horizontal quick-view mt-10">
                                        <li style=" padding:0px !important;margin:0px !important"><a class="active" data-toggle="tab" href="#product1<?php echo $propertyRow['id']?>"><img src="<?php echo '../images/property/'.$images[0]?>" alt="" height="100px" width="100px" /></a></li>
                                        <?php if(count($images)>1):?>
                                            <li style=" padding:0px !important;margin:0px !important"><a data-toggle="tab" href="#product2<?php echo $propertyRow['id']?>"><img src="<?php echo '../images/property/'.$images[1]?>" alt="" height="100px" width="100px" /></a></li>
                                        <?php endif;?>
                                        <?php if(count($images)>2):?>
                                            <li style=" padding:0px !important;margin:0px !important"><a data-toggle="tab" href="#product3<?php echo $propertyRow['id']?>"><img src="<?php echo '../images/property/'.$images[2]?>" alt="" height="100px" width="100px"/></a></li>
                                        <?php endif;?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-7 heading-section ftco-animate pl-lg-5 pt-md-0 pt-5 mt-3">
                                <h3 class="mb-4"><?php echo $propertyRow['title'] ?></h3>
                                <p> <?php 
                                    $description = strip_tags( $propertyRow['description']);
                                    if (strlen($description) > 120) {
                                        $descData = substr($description, 0, 120) . "..".'<a href="property_detail?property-id='.$propertyRow['id'].'" class="btn detailsBtn viewVacancy"> View More </a>';
                                        echo $descData; 
                                        
                                    } else {
                                        $descData = $description. "..".'<a href="property_detail?property-id='.$propertyRow['id'].'" class="btn detailsBtn viewVacancy" > View More </a>';
                                        echo $descData; 
                                    }
                                ?></p>
                                <div>
                                    <p><span style="color:#007bff;">CONTACT US </span><span class="ion-ios-arrow-round-forward"></span> 
                                    <?php
                                    if($propertyRow['phone_two']!=null){
                                        echo $propertyRow['phone_one'].' '.'OR'.' '.$propertyRow['phone_two'];
                                    }else{
                                        echo $propertyRow['phone_one'];
                                    }?></p>
                                </div>    
                            </div>
                        </div>	
                       
                    <?php } } ?>
                    </div>
                <div class="row d-flex align-items-center justify-content-center" id="moreProperties">
                   
                </div>
                <?php
                    if($totalProperties==0){
                        echo '<div class="d-flex justify-content-center align-items-center">
                                    <div class="col-md-4">
                                        <h2> No Properties Found!!! </h2>
                                    </div>
                                </div>
                                ';
                    }
                ?>
            </div>
		</section>
       
        <?php
        if ($totalProperties > 6) {
            ?>
            <div class="col-md topper d-flex align-items-center justify-content-center mt-0 mb-3">
                <div class="col-md-4">
                    <p class="mb-0 d-block">
                        <button class="btn py-2 px-3 btn-primary" id="morePropertyBtn">
                            <span> LOAD MORE PROPERTIES </span>
                        </button>
                    </p>
                </div>
            </div>
            <?php
        }
        ?>
         
        <input type="hidden" value="<?php echo $totalProperties; ?>" id="totalProperties">
      <!-- end of projects-->

      <!-- view project modal -->
    <div class="modal fade" id="viewPropertyModal" tabindex="-1" role="dialog" aria-labelledby="propertyTitleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="propertyTitleLabel">View Property</h4>
                </div>
                <div class="modal-body">
                    <div id="propertyDiv">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end project modal -->
        
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
        $('#propertyNav').css('color','#007bff');
        $(document).ready(function () {
        var offset = 6;
        var totalProperties = $('#totalProperties').val();
        var flag = true;
        $("#morePropertyBtn").click(function () {
            if (totalProperties > offset && flag === true) {
                $("body").css("cursor", "wait");
                flag = false;
                $.ajax({
                    url: "moreProperty.php",
                    method: "GET",
                    data: {"offset": offset},
                    success: function (data) {
                        flag = true;
                        $("#moreProperties").append(data);
                        offset += 6;
                        if (offset >= totalProperties) {
                            $("#morePropertyBtn").fadeOut(1000);
                        }
                        $("body").css("cursor", "default");
                    },
                    error: function (error) {
                        $("body").css("cursor", "default");
                    }
                });
            } else {
                if (offset > totalProperties) {
                    $("#morePropertyBtn").addClass("hide");
                }
            }
        });

        $(document).on('click', '.viewProperty', function (e) {
                e.preventDefault();
                var desc = $(this).attr('property-desc');
                var title = $(this).attr('property-title');
                $('#propertyTitleLabel').html(title);
                $('#propertyDiv').html(desc);
                $('#viewPropertyModal').modal('show');

            });

         
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