
<?php
    include_once '../models/Company.php'; 
    include_once '../models/Service.php'; 
    include_once '../models/Project.php';
    include_once '../models/Client.php';
    include_once '../models/Blog.php';
    include_once '../models/ServiceRequest.php';
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
    <title>The Premier Groups | Home</title>
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

    <!--slider section -->
    <section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image:url(../images/bg/bg1.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<span class="subheading">Welcome to The Premier Groups</span>
            <h1 class="mb-4">We Are The Best Consulting Company Based in Ethiopia</h1>
            <p><a href="service.php" class="btn btn-primary px-4 py-3 mt-3">Our Services</a></p>
          </div>
        </div>
        </div>
      </div>

      <div class="slider-item" style="background-image:url(../images/bg/bg2.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<span class="subheading">Todays Talent, Tommorow Success</span>
            <h1 class="mb-4">We Help to Grow Your Business</h1>
            <p><a href="service.php" class="btn btn-primary px-4 py-3 mt-3">Our Services</a></p>
          </div>
        </div>
        </div>
      </div>
    </section>
      <!-- end of slider section -->

      <!--services -->
      <section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center mb-5 pb-2">
                    <div class="col-md-8 text-center heading-section ftco-animate">
                        <h2 class="mb-4">Our Best Services</h2>
                        <p>We Are Best Consulting Company Based In Ethiopia.We Help You Grow Your Business.Check Out The Services We Offer You.</p>
                    </div>
                </div>
				<div class="row no-gutters">
                <?php
                    $serviceObj = new Service();
                    $services = $serviceObj->getServiceByLimit(6, 0);
                    $totalServices = $serviceObj->getTotalService();
                    if (mysqli_num_rows($services) > 0) {

                        foreach ($services as $key => $serviceRow) {
                         ?>
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
        <?php if($totalServices > 6): ?>
        <div class="container">
            <div class="row mb-3">
                <div class="col-md topper d-flex align-items-center justify-content-center">
                    <div class="col-md-4">
                        <p class=" d-block">
                            <a href="service.php" class="btn py-2 px-3 btn-primary">
                                <span> MORE SERVICES </span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?>
      <!-- end of services-->

        <section class="ftco-intro ftco-no-pb img" style="background-image: url(images/bg_1.jpg);">
            <div class="container">
                <div class="row justify-content-center">
            <div class="col-lg-9 col-md-8 d-flex align-items-center heading-section heading-section-white ftco-animate">
                <h2 class="mb-3 mb-md-0">You Always Get the Best Guidance</h2>
            </div>
            <div class="col-lg-3 col-md-4 ftco-animate">
                <p class="mb-0"><a href="#" class="btn btn-white py-3 px-4" data-toggle="modal" data-target="#applyForServiceModal">Request For Service</a></p>
            </div>
            </div>	
            </div>
        </section>

        <!--projects -->
        <section class="ftco-section ftco-no-pb">
			<div class="container-fluid px-0">
				<div class="row no-gutters justify-content-center mb-5">
                    <div class="col-md-7 text-center heading-section ftco-animate">
                        <h2 class="mb-4">Our Projects</h2>
                        <p>Check Out The Projects We Have Achieved So Far.</p>
                        
                    </div>
                </div>
                <div class="row no-gutters">
                    <?php
                        $projectObj = new Project();
                        $projects = $projectObj->getProjectsByLimit(8, 0);
                        $totalProjects = $projectObj->getTotalProject();
                        if (mysqli_num_rows($projects) > 0) {
                            while ($projectRow = mysqli_fetch_array($projects)) {?>
                            <div class="col-md-3">
                                <div class="project img ftco-animate d-flex justify-content-center align-items-center" style="background-image: url(../images/project/<?php echo $projectRow['coverImage']?>)">
                                    <div class="overlay"></div>
                                    <a href="#" projectId="<?php echo $projectRow['id']; ?>" project-title="<?php echo $projectRow['title']; ?>" project-desc="<?php echo $projectRow['description']; ?>" class="btn-site d-flex align-items-center justify-content-center viewProject"><span class="icon-subdirectory_arrow_right"></span></a>
                                    <div class="text text-center p-4">
                                        <h3><?php echo $projectRow['title'] ?></h3>
                                        <span><?php echo $projectRow['service'] ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <?php
                    if($totalProjects==0){
                        echo '<div class="d-flex justify-content-center align-items-center">
                                    <div class="col-md-4">
                                        <h2> No Projects Found!!! </h2>
                                    </div>
                                </div>
                                ';
                    }
                ?>
              
            </div>
		</section>
        <!--end of projects -->

        <section class="ftco-section ftco-consult ftco-no-pt ftco-no-pb" style="background-image: url(../images/bg/bg1.jpg);" data-stellar-background-ratio="0.5">
    	<div class="overlay"></div>
    	<div class="container">
    		<div class="row justify-content-end">
    			<div class="col-md-6 py-5 px-md-5">
    				<div class="py-md-5">
		                <div class="heading-section heading-section-white ftco-animate mb-3">
                            <h2 class="mb-4">Request A Service</h2>
		                </div>
                        <form class="appointment-form2 ftco-animate" action="<?php $_PHP_SELF ?>" role="form" method="post" id="requestServiceIndexForm" style="color:white !important;">
                        
                            <div class="d-md-flex">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Full name" name="serviceApplicantName" id="serviceApplicantName">
                                </div>
                                <div class="form-group ml-md-4">
                                    <input type="tel" class="form-control" placeholder="Phone" name="serviceApplicantPhone" id="serviceApplicantPhone">
                                </div>
                            </div>
                            <div class="d-md-flex">
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Email" name="serviceApplicantEmail" id="serviceApplicantEmail">
                                </div>
                                <div class="form-group ml-md-4">
                                    <input type="tel" class="form-control" placeholder="Address" name="serviceApplicantAddress" id="serviceApplicantAddress">
                                </div>
                            </div>
                            <div class="d-md-flex">
                                <div class="form-group">
                                    <div class="form-field">
                                        <div class="select-wrap">
                                          
                                            <select name="selectedService" id="selectedService" class="form-control">
                                                <option value="">Select Service</option>
                                                <?php 
                                                $serviceObj = new Service();
                                                $services = $serviceObj->getAllServices();
                                                if (mysqli_num_rows($services) > 0) {
                                                    while ($serviceRow = mysqli_fetch_array($services)) {?>
                                                            <option style="color:black" value="<?php echo $serviceRow['name'] ?>"><?php echo $serviceRow['name']?></option>
                                                    <?php }}?>
                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ml-md-4">
                                    <textarea name="serviceApplicantMessage" id="serviceApplicantMessage" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" name="applyForService" style="background: white !important;color:black !important;">Send Request</button>
                                </div>
                            </div>
                        </form>
		    		</div>
    			</div>
        </div>
    	</div>
    </section>

    <?php 
        $blogObj = new Blog();
        $blogs = $blogObj->getBlogsByLimit(3,0);
        if (mysqli_num_rows($blogs) > 0) {
    ?>
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4"><span>Recent</span> Blog</h2>
                    <p>Check Out Recent Blogs</p>
                </div>
            </div>
            <div class="row">
                <?php while ($blogRow = mysqli_fetch_array($blogs)) {
                    $date = $blogRow['dateCreated'];
                    $dateValue = strtotime($date); ?>
                    <div class="col-md-6 col-lg-4 ftco-animate">
                      <div class="blog-entry" style=" height: 100%;width: 100%;">
                        <div  class="block-20 d-flex align-items-end" style="background-image: url('<?php echo '../images/blog/'.$blogRow['coverImage']?>');">
                          <div class="meta-date text-center p-2">
                            <span class="day"><?php echo date("d", $dateValue)?></span>
                            <span class="mos"><?php echo date("F", $dateValue)?></span>
                            <span class="yr"><?php echo date("y", $dateValue)?></span>
                          </div>
                        </div>
                        <div class="text bg-white p-4">
                          <h3 class="heading"><?php echo $blogRow['title']?></h3>
                          <p> <?php 
                                $description = strip_tags( $blogRow['description']);
                                if (strlen($description) > 120) {
                                    $descData = substr($description, 0, 120) . "..".'</p>'.'<div class="d-flex align-items-center mt-4"><p class="mb-0"><a href="#" class="btn btn-primary viewBlog" blogId="'.$blogRow['id'].'" blog-title="'.$blogRow['title'].'" blog-desc="'.$blogRow['description'].'">Read More <span class="ion-ios-arrow-round-forward"></span></a></p></div>';
                                    echo $descData; 
                                    
                                } else {
                                    $descData = $description;
                                    echo $blogRow['description'].'</p>'; 
                                }

                                
                            ?>
                         
                        </div>
                      </div>
                    </div>
                    <?php } ?>
            </div>
        </div>
    </section>
    <?php }  ?>
    
    <section class="ftco-intro ftco-no-pb img" style="background-image: url(images/bg_3.jpg);">
    	<div class="container">
    		<div class="row justify-content-center mb-5">
          <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
            <h2 class="mb-0">You Always Get the Best Guidance</h2>
          </div>
        </div>	
    	</div>
    </section>
    <section class="ftco-counter" id="section-counter">
        <?php 
            $projectObj = new Project();
            $serviceObj = new Service();
            $clientObj = new Client();
            $totalProjects = $projectObj->getTotalProject();
            $totalServices = $serviceObj->getTotalService();
            $totalClients = $clientObj->getTotalClients();
        ?>
    	<div class="container">
    		<div class="row d-md-flex align-items-center justify-content-center">
    			<div class="wrapper">
    				<div class="row d-md-flex align-items-center">
		          <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18">
		            	<div class="icon"><span class="flaticon-doctor"></span></div>
		              <div class="text">
		                <strong class="number" data-number="<?php echo $totalServices ?>">0</strong>
		                <span>Services We Offer</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18">
		            	<div class="icon"><span class="flaticon-doctor"></span></div>
		              <div class="text">
		                <strong class="number" data-number="<?php echo $totalProjects ?>">0</strong>
		                <span>Projects Completed</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18">
		            	<div class="icon"><span class="flaticon-doctor"></span></div>
		              <div class="text">
		                <strong class="number" data-number="<?php echo $totalClients ?>">0</strong>
		                <span>Our Clients</span>
		              </div>
		            </div>
		          </div>
		          
	          </div>
          </div>
        </div>
    	</div>
    </section>

    <?php 
    $clientObj = new Client();
    $clients = $clientObj->getAllClients();
    $totalClients = $clientObj->getTotalClients();
    if (mysqli_num_rows($clients) > 0) {
    ?>
        <section class="ftco-section testimony-section">
            <div class="container">
                <div class="row justify-content-center mb-3">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4">Our Clients</h2>
                </div>
                </div>
                <div class="row ftco-animate justify-content-center">
                    <div class="col-md-12">
                        <div class="carousel-testimony owl-carousel" >
                            <?php 
                                while ($clientRow = mysqli_fetch_array($clients)) {?>
                                    <div class="item">
                                        <div class="testimony-wrap d-flex"  style=" height: 100%;width: 100%;">
                                        <div class="user-img" style="background-image: url(../images/client/<?php echo $clientRow['logo']?>)">
                                        </div>
                                        <div class="text pl-4">
                                            <span class="quote d-flex align-items-center justify-content-center">
                                            <i class="icon-quote-left"></i>
                                            </span>
                                            <p><?php echo $clientRow['about']?></p>
                                            <?php if($clientRow['website'] !=null):?>
                                                <a href="<?php echo $clientRow['website']?>" class="name"><?php echo $clientRow['name']?></a>
                                            <?php else:?>
                                                <p class="name"><?php echo $clientRow['name']?></p>
                                            <?php endif;?>
                                        </div>
                                        </div>
                                    </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                </div>
            </section> 
        <?php }  ?>

    <!-- view service modal -->
    <div class="modal fade" id="viewServiceModal" tabindex="-1" role="dialog" aria-labelledby="serviceTitleLabel" aria-hidden="true">

        <div class="modal-dialog">
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
    <!-- view project modal -->
    <div class="modal fade" id="viewProjectModal" tabindex="-1" role="dialog" aria-labelledby="projectTitleLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="projectTitleLabel">View Project</h4>
                </div>
                <div class="modal-body">
                    <div id="projectDiv">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

    </div>
<!-- end project modal -->
 <!-- view blog modal -->
 <div class="modal fade" id="viewBlogModal" tabindex="-1" role="dialog" aria-labelledby="blogTitleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="blogTitleLabel">View Blog</h4>
                </div>
                <div class="modal-body">
                    <div id="blogDiv">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end blog modal -->



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
        $('#homeNav').css('color','#007bff');
        $(document).ready(function () {
            $(document).on('click', '.viewService', function (e) {
                e.preventDefault();
                var desc = $(this).attr('service-desc');
                var title = $(this).attr('service-title');
                $('#serviceTitleLabel').html(title);
                $('#serviceDiv').html(desc);
                $('#viewServiceModal').modal('show');

            });

            $(document).on('click', '.viewProject', function (e) {
                e.preventDefault();
                var desc = $(this).attr('project-desc');
                var title = $(this).attr('project-title');
                $('#projectTitleLabel').html(title);
                $('#projectDiv').html(desc);
                $('#viewProjectModal').modal('show');

            });

            $(document).on('click', '.viewBlog', function (e) {
                e.preventDefault();
                var desc = $(this).attr('blog-desc');
                var title = $(this).attr('blog-title');
                $('#blogTitleLabel').html(title);
                $('#blogDiv').html(desc);
                $('#viewBlogModal').modal('show');

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

            $('#requestServiceIndexForm').bootstrapValidator({
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