<?php
    include_once '../models/Company.php'; 
    include_once '../models/Service.php';
    include_once '../models/Blog.php';
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
    <title>The Premier Groups | Blogs</title>
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

    <section class="hero-wrap hero-wrap-2" style="background-image: url('../images/bg/bg_1.jpg');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Blog</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Blog <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section bg-light">
			<div class="container">
				<div class="row">
          <?php
              $blogObj = new Blog();
              $blogs = $blogObj->getBlogsByLimit(9, 0);
              $totalBlogs = $blogObj->getTotalBlogs();
              if (mysqli_num_rows($blogs) > 0) {
                  while ($blogRow = mysqli_fetch_array($blogs)) {
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
                    <?php
                        }
                    }
                    ?>
                 
                </div>
                <div class="row" id="moreBlogDiv"></div>
                <?php
                    if($totalBlogs==0){
                        echo '<div class="d-flex justify-content-center align-items-center">
                                    <div class="col-md-4">
                                        <h2> No Blogs Found!!! </h2>
                                    </div>
                                </div>
                                ';
                    }
                ?>

        </div>
      </div>
      <?php
        if ($totalBlogs > 6) {
            ?>
            <div class="col-md topper d-flex align-items-center justify-content-center mt-0 mb-3">
                <div class="col-md-4">
                    <p class="mb-0 d-block">
                        <button class="btn py-2 px-3 btn-primary" id="moreBlogBtn">
                            <span> MORE BLOGS </span>
                        </button>
                    </p>
                </div>
            </div>
            <?php
        }
        ?>
         
    </section>
    
    
        <input type="hidden" value="<?php echo $totalBlogs; ?>" id="totalBlogs">

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
        $('#blogNav').css('color','#007bff');
        $(document).ready(function () {

        $(document).on('click', '.viewBlog', function (e) {
                e.preventDefault();
                var desc = $(this).attr('blog-desc');
                var title = $(this).attr('blog-title');
                $('#blogTitleLabel').html(title);
                $('#blogDiv').html(desc);
                $('#viewBlogModal').modal('show');

            });
          
        var offset = 6;
        var totalBlogs = $('#totalBlogs').val();
        var flag = true;
        $("#moreBlogBtn").click(function () {
            if (totalBlogs > offset && flag === true) {
                $("body").css("cursor", "wait");
                flag = false;
                $.ajax({
                    url: "moreBlog.php",
                    method: "GET",
                    data: {"offset": offset},
                    success: function (data) {
                        flag = true;
                        $("#moreBlogDiv").append(data);
                        offset += 6;
                        if (offset >= totalBlogs) {
                            $("#moreBlogBtn").fadeOut(1000);
                        }
                        $("body").css("cursor", "default");
                    },
                    error: function (error) {
                        $("body").css("cursor", "default");
                    }
                });
            } else {
                if (offset > totalProjects) {
                    $("#moreBlogBtn").addClass("hide");
                }
            }
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