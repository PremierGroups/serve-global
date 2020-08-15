<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/City.php';
include_once './include/User.php';
include_once './include/Category.php';
include_once './include/Company.php';
include_once './include/Testimonial.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Serve Global | About Us</title>
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
    <!-- Magnific Popup-->
    <link rel="stylesheet" href="dist/css/magnific-popup.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="dist/css/select2.min.css">
    <!-- REVOLUTION SLIDER STYLES -->
    <link rel="stylesheet" type="text/css" href="dist/css/settings.css">
    <link rel="stylesheet" type="text/css" href="dist/css/layers.css">
    <link rel="stylesheet" type="text/css" href="dist/css/navigation.css">
    <!-- Animate css-->
    <link rel="stylesheet" href="dist/css/animate.css">
    <!-- Style-->
    <link rel="stylesheet" href="dist/css/style.css">
    <!-- Color Swhicher css-->
    <link data-style="color-style" rel="stylesheet" href="dist/css/color-blue.css">
    <!-- Modernizr-->
    <script src="dist/js/modernizr-2.8.3.min.js"></script>
</head>
<body>
    <?php include_once "./layout/nav.php";?>
    <div class="main-menu-area">
    <?php include_once "./layout/topnav.php";?>
    </div>
    <div class="banner-area banner-area--about-us all-text-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title">About Us</h1>
                    <ul class="fund-breadcumb">
                        <li><a href="index">Home</a> </li>
                        <li><a href="about-us">About</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

   <div class="body-overlay"></div>
    <section class="section-padding ash-white-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading text-center">
                        <h2 class="section-title">Welcome to  <span class="base-color">The Fund</span> </h2>
                        <span class="section-sub-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</span>
                        <div class="section-heading-separator"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="about-us-carousel mb30">
                        <div>
                            <img src="images/about/carousel1.jpg" alt="">
                        </div>
                        <div>
                            <img src="images/about/carousel2.jpg" alt="">
                        </div>
                        <div>
                            <img src="images/about/carousel3.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-us-text-content mb30">
                        <h4>WE ARE NON PROFIT TEAM</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <ul class="fund-arrow-left-list pdb10">
                            <li>Charity sees the need not the cause</li>
                            <li>Be devoted to one another in brotherly love</li>
                            <li>Feed the hungry, and help those in trouble</li>
                            <li>Distributing to the necessity of saints given to hospitality</li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
                        <a href="#" class="btn base-bg">Donet Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="counter-section all-text-white section-padding">
        <div class="container">
            <div class="row pdt15">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="counter-item">
                        <div class="counter-item__icon-wrap">
                            <img src="images/about/icon-maney.png" class="counter-item__icon" alt="">
                            <span class="counter-item__label">Donation</span>
                        </div>
                        <div class="counter-item__count-wrap">
                            $ <span class="counter-item__count">1700</span>K
                        </div>
                    </div><!--/.counter-item-->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="counter-item">
                        <div class="counter-item__icon-wrap">
                            <img src="images/about/icon-hand.png" class="counter-item__icon" alt="">
                            <span class="counter-item__label">Volunteers</span>
                        </div>
                        <div class="counter-item__count-wrap">
                            <span class="counter-item__count">250</span>+
                        </div>
                    </div><!--/.counter-item-->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="counter-item">
                        <div class="counter-item__icon-wrap">
                            <img src="images/about/icon-man.png" class="counter-item__icon" alt="">
                            <span class="counter-item__label">Helped People</span>
                        </div>
                        <div class="counter-item__count-wrap">
                            <span class="counter-item__count">4000</span>+
                        </div>
                    </div><!--/.counter-item-->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="counter-item">
                        <div class="counter-item__icon-wrap">
                            <img src="images/about/icon-country.png" class="counter-item__icon" alt="">
                            <span class="counter-item__label">Countries</span>
                        </div>
                        <div class="counter-item__count-wrap">
                            <span class="counter-item__count">20</span>+
                        </div>
                    </div><!--/.counter-item-->
                </div>
            </div>
        </div>
    </section>
     <section class="volunteer-section section-padding ash-white-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading text-center">
                            <h2 class="section-title wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s"> Some of Our <span class="base-color">VOLUNTEERS</span> </h2>
<!--                            <span class="section-sub-title wow fadeInUpXsd disinb" data-wow-duration=".9s" data-wow-delay=".1s">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</span>-->
                            <div class="section-heading-separator wow fadeInUpXsd" data-wow-duration="1.1s" data-wow-delay=".1s"></div>
                        </div>
                    </div>
                </div>
                <div class="row row-eq-rs-height">
                    <?php
                    $userObj = new User();
                    $volunteers = $userObj->getActiveVolunteers(6, 0);
                    $userIndex = .2;
                    $cityObj = new City();
                    while ($userRow = mysqli_fetch_array($volunteers)) {

                        $address = (isset($userRow['city']) && !empty($userRow['city'])) ? $cityObj->getCityNameById($userRow['city']) . ", " : " ";
                        $address .= $userRow['country'];
                        $userImage = $userRow['profile_image'];
                        $userSex=$userRow['sex'];
                        if (isset($userImage) && filter_var($userImage, FILTER_VALIDATE_URL)) {
                            
                        } elseif (!file_exists("images/" . $userImage) || empty($userImage)) {
                            $userImage = ($userSex == "M") ? "images/avatar.png" : "images/avatar2.png";
                        } else {
                            $userImage = "images/" . $userImage;
                        }
                        ?>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="fund-volunteer text-center wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay="<?php echo $userIndex . "s"; ?>">
                                <div class="fund-volunteer__photo-wrap">
                                    <img src="<?php echo $userImage; ?>" class="img-circle fund-volunteer__photo" alt="volunteer" style="height: 110px;">
                                </div>
                                <div class="fund-volunteer__text-content">
                                    <h3 class="fund-volunteer__name"><?php echo $userRow['fname'] . " " . $userRow['mname']; ?></h3>
                                    <div class="section-heading-separator section-heading-separator--small"></div>
                                    <h4><?php echo $address; ?></h4>
                                    <ul class="list-inline round-social-icons mb30">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    </ul>
                                  
                                </div>
                            </div><!--/.fund-volunteer-->
                        </div>
                        <?php
                        $userIndex += .2;
                    }
                    ?>

                </div>
            </div>
        </section>
        <section class="testimonial-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading text-center">
                            <h2 class="section-title wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s">WHAT PEOPLE  <span class="base-color">SAY</span> <button class="btn btn-primary btn-sm" onclick="window.open('writeReview', 'Write Review', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=900,height=600')"> <i class="fa fa-star"></i> Click here to give us a Review</button></h2>
                            <div class="section-heading-separator wow fadeInUpXsd" data-wow-duration="1.1s" data-wow-delay=".1s"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="fund-testimonial-carousel wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".3s">
                            <?php
                            $testimonialObj = new Testimonial();
                            $testimonials = $testimonialObj->getTestimonialByOffset(8, 0);
                            while ($testimonialRow = mysqli_fetch_array($testimonials)) {
                                $userImage = $testimonialRow['image'];
                                if (isset($userImage) && filter_var($userImage, FILTER_VALIDATE_URL)) {
                                    
                                } elseif (!file_exists("images/" . $userImage) || empty($userImage)) {
                                    $userImage = "images/user.png";
                                } else {
                                    $userImage = "images/" . $userImage;
                                }
                                ?>
                                <div class="fund-testimonial">
                                    <div class="fund-testimonial__quote base-bg">
                                        <?php echo $testimonialRow['content']; ?>
                                    </div>
                                    <div class="fund-testimonial__author">
                                        <div class="fund-testimonial__author-image">
                                            <img src="<?php echo $userImage; ?>" alt="User Picture">
                                        </div>
                                        <div class="fund-testimonial__author-text">
                                            <h4 class="fund-testimonial__author-name"><?php echo $testimonialRow['name']; ?></h4>
                                            <span class="fund-testimonial__designation"><?php echo $testimonialRow['respo']; ?></span>
                                        </div>
                                    </div>
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
$sponsorObj=new Company();
$sponsors=$sponsorObj->getSponsor(10, 0);
if (mysqli_num_rows($sponsors) > 0) {
    ?>
        <section class="sponser-section section-padding ash-white-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading text-center">
                            <h2 class="section-title">OUr  <span class="base-color">Sponsors</span> </h2>
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
    <?php include_once "./layout/footer.php";?>
    <!-- // End Footer  -->
    <!-- == jQuery Librery == -->
    <script src="dist/js/jquery-2.2.4.min.js"></script>
    <!-- == Bootsrap js File == -->
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- == mixitup == -->
    <script src="dist/js/mixitup.min.js"></script>
    <!-- == Select 2 == -->
    <script src="dist/js/select2.min.js"></script>
     <!-- == Wow js == -->
        <script src="dist/js/wow.min.js"></script>
    <!-- == Slick == -->
    <script src="dist/js/slick.min.js"></script>
    <!-- == Counter == -->
    <script src="dist/js/jquery.waypoints.min.js"></script>
    <script src="dist/js/jquery.counterup.min.js"></script>
    <!-- == custom Js File == -->
    <script src="dist/js/custom.js"></script>
    </body>

</html>
