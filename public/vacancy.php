<?php
    include_once '../models/Company.php'; 
    include_once '../models/Service.php';
    include_once '../models/Vacancy.php'; 
    include_once '../models/Applicant.php'; 
    $company = new Company();
    $companyData = $company->getOrganization();
    $row = mysqli_fetch_array($companyData);
    $address = $row['address'];
    $email = $row['email'];
    $phone = $row['phone'];
    $facebook = $row['facebook'];
    $instagram = $row['instagram'];
    $telegram=$row["telegram"];

    if (isset($_POST['applyForjob'])) {
        //File Upload
        $target_dir = "../images/applicantCV/";
        $target_file = date('dmYHis') . '_' . basename($_FILES["applicantCV"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if file already exists
        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists.";
            $uploadOk = 0;
        }
    // Check file size
        if ($_FILES["applicantCV"]["size"] > 12288800) {
            $msg = "Sorry, your file is too large, make sure your file is not more than 12MB.";
            $uploadOk = 0;
        }
    // Allow certain file formats
        if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "PNG" && $fileType != "JPG" && $fileType != "JPEG" && $fileType != "gif" && $fileType != "GIF") {
            $msg = "Sorry, Only Image file is allowed.";
            $uploadOk = 0;
        }
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg .= " CV not uploaded.";
    
    // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["applicantCV"]["tmp_name"], $target_dir . $target_file)) {
                $vacancyId = $_POST['applicantVacancyId'];
                $name = $_POST['applicantName'];
                $email = $_POST['applicantEmail'];
                $phone = $_POST['applicantPhone'];
                $address = $_POST['applicantAddress'];
                $applicantObj = new Applicant();
                $apply = $applicantObj->addApplicant($vacancyId,$name, $email, $phone, $address, $target_file);
                if($apply){
                    echo '<script type="text/javascript">';
                    echo ' alert("Thank You For Applying. We Will Contact You Soon!!")';
                    echo '</script>';
                }else{
                    echo '<script type="text/javascript">';
                    echo ' alert("We couldnot proceed your request.Try Again!")';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';
                echo ' alert("We couldnot proceed your request.Try Again!")';
                echo '</script>';
            }
           
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>The Premier Groups | Job Vacancies</title>
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
            <h1 class="mb-2 bread">Job Vacancies</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Vacancies <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
      <!-- end of Top section -->
    <section >
        <div class="container">
            <div class="row justify-content-center mt-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <h2 class="mb-4">JOB VACANCIES</h2>
                    <p>FEEL FREE TO APPLY IF YOU FULLFILL THE REQUIREMENTS</p>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row row-eq-height">
                <?php
                    $vacancyObj = new Vacancy();
                    $vacancies = $vacancyObj->getAllVacancies();
                    $totalVacancies = $vacancyObj->getTotalVacancies();
                    if (mysqli_num_rows($vacancies) > 0) {
                        while ($vacancyRow = mysqli_fetch_array($vacancies)) {
                            $date = $vacancyRow['dateCreated'];
                            $dateValue = strtotime($date); 
                            ?>
                            <div class="col-md-6 col-lg-4 ftco-animate">
                                <div class="blog-entry  bg-white" style=" height: 100%;width: 100%;">
                                   
                                    <div class="text bg-white p-4">
                                        <h3 class="heading"><?php echo $vacancyRow['title']?></h3>
                                        <p> <?php 
                                            $description = strip_tags( $vacancyRow['description']);
                                            if (strlen($description) > 120) {
                                                $descData = substr($description, 0, 120) . "..".'<a href="#"  vacancyId="'.$vacancyRow['id'].'" class="btn btn-default viewVacancy" vacancy-title="'.$vacancyRow['title'].'" vacancy-desc="'.$vacancyRow['description'].'"> Read More </a>';
                                                echo $descData; 
                                                
                                            } else {
                                                $descData = $description;
                                                echo $vacancyRow['description']; 
                                            }
                                        ?></p>
                                        <div class="d-flex align-items-center mt-4">
                                            <p class="mb-0"><?php echo $vacancyRow['location']?></p>
                                           
                                            <p class="ml-auto mb-0">
                                            <p class="mb-0">
                                            <span class="day"><?php echo date("d", $dateValue)?></span>
                                            <span class="mos"><?php echo date("F", $dateValue)?></span>
                                            <span class="yr"><?php echo date("y", $dateValue)?></span>
                                            </p>
                                           
                                        </div>
                                    </div>
                                    <div class="bg-white d-flex align-items-center justify-content-center mb-3">
                                        <p><a href="#" vacancyId="<?php echo $vacancyRow['id']; ?>" class="btn btn-primary" data-toggle="modal" data-target="#applyModal" onclick="applyForJob(<?php echo $vacancyRow['id']; ?>)">APPLY <span class="ion-ios-arrow-round-forward"></span></a></p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                    <?php
                    }
                    }else{
                        echo '<div class="text-center">
                                    <h2> THERE ARE NO JOB VACANCIES FOR NOW!!! </h2>
                              </div>';
                    }
                ?>
        </div>
        </div>
    </section>
    <!-- view vacancy modal -->
    <div class="modal fade" id="viewVacancyModal" tabindex="-1" role="dialog" aria-labelledby="vacancyTitleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vacancyTitleLabel">View Vacancy</h4>
                </div>
                <div class="modal-body">
                    <div id="vacancyDiv">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
     <!-- end vacancy modal -->

     <!-- view vacancy modal -->
    <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="vacancyTitleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="applyTitleLabel">Apply For Job</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    
                </div>
                <form class="appointment-form ftco-animate" action="<?php $_PHP_SELF ?>" role="form" method="post" enctype="multipart/form-data" id="applyForJobForm">
                    <div class="modal-body">
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="applicantVacancyId" id="applicantVacancyId" value="">
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Full name" name="applicantName" id="applicantName">
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Phone" name="applicantPhone" id="applicantPhone">
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Email" name="applicantEmail" id="applicantEmail">
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Address" name="applicantAddress" id="applicantAddress">
                            </div>
                        </div>

                        <div class="">
                            <div>
                            <label for="cv" class="control-label">Scanned CV </label>
                            </div>
                            <div class="form-group">
                                 <input type="file" class="form-control" name="applicantCV" id="applicantCV" title="Select CV">
                            </div>
                        </div>
                       
                    </div>
                    <div class="form-group">
                        <div class="modal-footer pull-right">
                            <button type="submit" class="btn btn-primary" name="applyForjob">Apply Now</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- end vacancy modal -->

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
        $('#vacancyNav').css('color','#007bff');
        $(document).ready(function () {
            $(document).on('click', '.viewVacancy', function (e) {
                e.preventDefault();
                var desc = $(this).attr('vacancy-desc');
                var title = $(this).attr('vacancy-title');
                $('#vacancyTitleLabel').html(title);
                $('#vacancyDiv').html(desc);
                $('#viewVacancyModal').modal('show');
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

          $('#applyForJobForm').bootstrapValidator({
            message: 'This value is not valid',
              fields: {
                  applicantName: {
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
                  applicantPhone: {
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
                  applicantAddress: {
                      message: 'Address is not valid',
                      validators: {
                          notEmpty: {
                              message: 'Address is required and can\'t be empty'
                          }
                      }
                  },
                  applicantCV: {
                      message: 'CV is not valid',
                      validators: {
                          notEmpty: {
                              message: 'CV is required and can\'t be empty'
                          }
                      }
                  }
              }
          });
         
        });
        function applyForJob(id){
            $('#applicantVacancyId').val(id);
        }
    </script>
</body>
</html>