<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/User.php';
include_once './include/Category.php';
include_once './include/Company.php';
include_once './include/Gallery.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Gallery | Serve Global</title>
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
                    <h1 class="page-title">Gallery</h1>
                    <ul class="fund-breadcumb">
                        <li><a href="index">Home</a> </li>
                        <li><a href="gallery">Gallery</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

   <div class="body-overlay"></div>
    <section class="gallery-section section-padding all-text-white">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading text-center">
                            <h2 class="section-title wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s">OUR <span class="base-color">GALLERY</span></h2>
                            <div class="section-heading-separator wow fadeInUpXsd" data-wow-duration="1.1s" data-wow-delay=".1s"></div>
                        </div>
                    </div>
                </div>
                <!--                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-center pdb35 wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".3s">
                                            <ul class="list-inline filter-options">
                                                <li><a href="#!" class="filter-options__item active filter btn" data-filter=".all">Show All</a></li>
                                                <li><a href="#!" class="filter-options__item filter btn" data-filter=".charity">Charity</a></li>
                                                <li><a href="#!" class="filter-options__item filter btn" data-filter=".children">Children</a></li>
                                                <li><a href="#!" class="filter-options__item filter btn" data-filter=".natureal">Natureal</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>-->
                <div class="row wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".3s">
                    <div class="col-md-12">
                        <div class="row row-eq-height" id="mixitup-grid">
                            <?php
                            $galleryObj = new Gallery();
                            $galleries = $galleryObj->getAllGalleriesByOffset(8, 0);
                            while ($galleryRow = mysqli_fetch_array($galleries)) {
                                if (isset($galleryRow['path']) && file_exists("images/" . $galleryRow['path'])) {
                                    ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mix all">
                                        <a class="venobox preview-link gallery-item  wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".2s" href="images/<?php echo $galleryRow['path']; ?>" data-gall="portfolioGallery" title="<?php echo $galleryRow['caption'];?>" >
                                            <img  src="images/<?php echo $galleryRow['path']; ?>" class="gallery-item__photo img-responsive" alt="<?php echo $galleryRow['caption']; ?>" style="width: 100%; height: 200px;"/>
                                        </a><!--/.portfolio-item-->
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
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
    <!-- == Select 2 == -->
    <script src="dist/js/jquery.colorbox-min.js"></script>
     <!-- == Wow js == -->
        <script src="dist/js/wow.min.js"></script>
    <!-- == Slick == -->
    <script src="dist/js/slick.min.js"></script>
    <!-- == Counter == -->
    <script src="dist/js/jquery.waypoints.min.js"></script>
    <script src="dist/js/jquery.counterup.min.js"></script>
    <script src="plugins/venobox/venobox.min.js"></script>
    <!-- == custom Js File == -->
    <script src="dist/js/custom.js"></script>
       <script>
          
                // Initiate venobox (lightbox feature used in portofilo)
    $(document).ready(function() {
      $('.venobox').venobox();
    }); 
          
        </script>
    </body>

</html>
