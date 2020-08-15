<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/Company.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Serve Global | Contact Us</title>
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
        <!-- Animate css-->
        <link rel="stylesheet" href="dist/css/animate.css">
        <!-- Style-->
        <link rel="stylesheet" href="dist/css/style.css">
        <!-- Color Swhicher css-->
        <link data-style="color-style" rel="stylesheet" href="dist/css/color-blue.css">
        <!-- Modernizr-->
        <script src="dist/js/modernizr-2.8.3.min.js"></script>
        <link rel="stylesheet" href="plugins/toastr/toastr.min.css" type="text/css">
    </head>
    <body>
        <?php include_once "./layout/nav.php"; ?>
        <div class="main-menu-area">
            <?php include_once "./layout/topnav.php"; ?>
        </div>
        <div class="banner-area banner-area--contact all-text-white text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-title">CONTACT US</h1>
                        <ul class="fund-breadcumb">
                            <li><a href="index">Home</a> </li>
                            <li><a href="contact-us">Contact Us</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="body-overlay"></div>
        <section class="section-padding">
            <div class="col-md-12">
                <div class="section-heading text-center">
                    <h2 class="section-title">Get in <span class="base-color">touch</span> </h2>
                    <span class="section-sub-title">If have any questions please feel free to get in touch with us</span>
                    <div class="section-heading-separator"></div>
                </div>
            </div>
            <div id="mapContainer"></div>
            <div class="container no-padding">
                <div class="main-contact">
                    <form class="contact-form" id="feedbackFormId" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" name="fname" placeholder="Name" class="input-group__input form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="email" name="email" placeholder="email" class="input-group__input form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text"  name="subject"  placeholder="Subject" class="input-group__input form-control" />
                        </div>
                        <div class="input-group">
                            <textarea  name="message"  class="input-group__textarea form-control" placeholder="Message" rows="8" cols="80"></textarea>
                        </div>
                        <input type="hidden" name="recipient_email" value="contact@iglyphic.com" />
                        <div class="g-recaptcha" data-sitekey="6LdAnfcUAAAAADqUtWZgEExIPRDc-G7xJn5JnbkZ"></div>
                        <br/>
                        <input type="submit" class="btn base-bg" value="Submit">
                        <span class="text-mute pdl15">* All fields are mandatory</span>
                    </form>
                    <div class="contact-address">
                        <div class="contact-address-item">
                            <span class="icon-wrap"><i class="fa fa-map-marker contact-icon"></i></span>
                            <div class="text-content">
                                <div class="base-color contact-title">Office Location</div>
                                One Franklin Square, 1315 K St NW, Washington, DC 20005, United States
                            </div>
                        </div><!--/.contact-address-item-->
                        <div class="contact-address-item">
                            <span class="icon-wrap"><i class="fa fa-phone contact-icon"></i></span>
                            <div class="text-content">
                                <div class="base-color contact-title">Contact Number</div>
                                +1 2689254 - +1 2685987
                            </div>
                        </div><!--/.contact-address-item-->
                        <div class="contact-address-item">
                            <span class="icon-wrap"><i class="fa fa-envelope contact-icon"></i></span>
                            <div class="text-content">
                                <div class="base-color contact-title">Contact Mail</div>
                                info@serveglobal.org<br/>                               
                            </div>
                        </div><!--/.contact-address-item-->

                        <div class="contact-address-item">
                            <span class="icon-wrap"><i class="fa fa-map-marker contact-icon"></i></span>
                            <div class="text-content">
                                <div class="base-color contact-title">Website</div>
                                www.serveglobal.org<br/>
                            </div>
                        </div><!--/.contact-address-item-->
                    </div>
                </div>
            </div>
        </section>

<?php
$sponsorObj=new Company();
$sponsors=$sponsorObj->getSponsor(10, 0);
if (mysqli_num_rows($sponsors) > 0) {
    ?>
        <section class="sponser-section section-padding ash-white-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading text-center">
                            <h2 class="section-title">Our  <span class="base-color">Sponsors</span> </h2>
                            <span class="section-sub-title">These are the organizations helping us to build a better world for everyone through out the world</span>
                            <div class="section-heading-separator"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="client-carusel">
                            <?php
                                while ($row = mysqli_fetch_array($sponsors)) {
                                    $link=(!empty($row['website']) && filter_var($row['website'], FILTER_VALIDATE_URL))?$row['website']:'#';
                                   $target=($link=='#')?'':'_blank';
                                    ?>
                            <div class="carusel-item">
                                 <a href="<?php echo $link;?>" target="<?php echo $target;?>">
                                <img src="images/<?php echo $row['logo'];?>" alt="<?php echo $row['name'];?>">
                                  </a>
                            </div>
                            <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section> 
    <?php
}
?>
       
        <?php include_once "./layout/footer.php"; ?>
        <!-- // End Footer  -->
        <!-- == jQuery Librery == -->
        <script src="dist/js/jquery-2.2.4.min.js"></script>
        <!-- == Bootsrap js File == -->
        <script src="dist/js/bootstrap.min.js"></script>
        <!-- == mixitup == -->
        <script src="dist/js/mixitup.min.js"></script>
        <!-- == Select 2 == -->
        <script src="dist/js/select2.min.js"></script>
        <!-- == Select 2 == -->
        <script src="dist/js/jquery.colorbox-min.js"></script>
        <!-- == Slick == -->
        <script src="dist/js/slick.min.js"></script>
        <!-- jquery-validation -->
        <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="plugins/jquery-validation/additional-methods.min.js"></script>
        <script src="dist/js/wow.min.js"></script>
        <!-- == Google Maps == -->
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBjaOVpxq-vyWE7EOrUjmYsDdxRSrlar08"></script>
        <script src="dist/js/jquery.mapit.min.js"></script>
        <script src="dist/js/map-init.js"></script>
        <!-- == custom Js File == -->
        <script src="dist/js/custom.js"></script>
        <script src="plugins/toastr/toastr.min.js"></script>
        <script src="dist/js/script.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            $(function () {
                // $('#contactNav').addClass('active');
                $('#feedbackFormId').validate({
                    rules: {
                        fname: {
                            required: true,
                            minlength: 3,
                            maxlength: 50
                        },
                        message: {
                            required: true,
                            minlength: 10,
                            maxlength: 300
                        },
                        email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        fname: {
                            required: "Please enter your name",
                            minlength: "name must be at least 3 characters long",
                            maxlength: "name must be lees than 50 characters long"
                        },
                        email: {
                            required: "Please enter email address",
                            email: "Please enter a valid email address"
                        },
                        message: {
                            required: "Please provide a message Description",
                            minlength: "Message description must be at least 10 characters long",
                            maxlength: "message must be lees than 300 characters long"
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback offset-sm-2');
                        element.closest('.form-input ').append(error);
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
