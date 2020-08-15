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
    <title>The Premier Groups | Projects</title>
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
            <h1 class="mb-2 bread">Projects</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Projects <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
      <!-- end of Top section -->
        <section >
            <div class="container">
				<div class="row justify-content-center mt-5 pb-2">
                    <div class="col-md-8 text-center heading-section ftco-animate">
                        <h2 class="mb-4">OUR PROJECTS</h2>
                        <p>TAKE A LOOK AT OUR PROJECTS</p>
                    </div>
                </div>
            </div>
        </section>
      <!--projects -->
        <section class="ftco-section">
			<div class="container">
				<div class="row">
                    <?php
                    $projectObj = new Project();
                    $projects = $projectObj->getProjectsByLimit(9, 0);
                    $totalProjects = $projectObj->getTotalProject();
                    if (mysqli_num_rows($projects) > 0) {
                        while ($projectRow = mysqli_fetch_array($projects)) {?>
                            <div class="col-md-4">
                                <div class="project mb-3 img ftco-animate d-flex justify-content-center align-items-center" style="background-image: url(../images/project/<?php echo $projectRow['coverImage']?>);">
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
                <div class="row" id="moreProjectDiv"></div>
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
       
        <?php
        if ($totalProjects > 9) {
            ?>
            <div class="col-md topper d-flex align-items-center justify-content-center mt-0 mb-3">
                <div class="col-md-4">
                    <p class="mb-0 d-block">
                        <button class="btn py-2 px-3 btn-primary" id="moreProjectBtn">
                            <span> MORE PROJECTS </span>
                        </button>
                    </p>
                </div>
            </div>
            <?php
        }
        ?>
         
        <input type="hidden" value="<?php echo $totalProjects; ?>" id="totalProjects">
      <!-- end of projects-->

      <!-- view project modal -->
    <div class="modal fade" id="viewProjectModal" tabindex="-1" role="dialog" aria-labelledby="projectTitleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
        $('#projectNav').css('color','#007bff');
        $(document).ready(function () {
        var offset = 9;
        var totalProjects = $('#totalProjects').val();
        var flag = true;
        $("#moreProjectBtn").click(function () {
            if (totalProjects > offset && flag === true) {
                $("body").css("cursor", "wait");
                flag = false;
                $.ajax({
                    url: "loadMoreProject.php",
                    method: "GET",
                    data: {"offset": offset},
                    success: function (data) {
                        flag = true;
                        $("#moreProjectDiv").append(data);
                        offset += 9;
                        if (offset >= totalProjects) {
                            $("#moreProjectBtn").fadeOut(1000);
                        }
                        $("body").css("cursor", "default");
                    },
                    error: function (error) {
                        $("body").css("cursor", "default");
                    }
                });
            } else {
                if (offset > totalProjects) {
                    $("#moreProjectBtn").addClass("hide");
                }
            }
        });

        $(document).on('click', '.viewProject', function (e) {
                e.preventDefault();
                var desc = $(this).attr('project-desc');
                var title = $(this).attr('project-title');
                $('#projectTitleLabel').html(title);
                $('#projectDiv').html(desc);
                $('#viewProjectModal').modal('show');

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