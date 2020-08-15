<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/Blog.php';
include_once './include/City.php';
include_once './include/User.php';
include_once './include/Event.php';
include_once './include/Gallery.php';
include_once './include/Category.php';
include_once './include/Company.php';
include_once './include/Donate.php';
include_once './include/Testimonial.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Serve Global | Home</title>
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
        <link href="plugins/venobox/venobox.css" rel="stylesheet">
        <!-- Modernizr-->
        <script src="dist/js/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <?php include_once "./layout/nav.php"; ?>
        <div class="slider-area">
            <div class="main-menu-area main-menu-area--absolute">

                <?php include_once "./layout/topnav.php"; ?>
            </div>
            <div data-scroll-index="0" id="rev_slider_1052_1_wrapper" class="all-text-white rev_slider_wrapper fullscreen-container" data-alias="web-product-dark122" data-source="gallery">
                <!-- START REVOLUTION SLIDER 5.3.0.2 fullscreen mode -->
                <div id="rev_slider_1052_1" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.3.0.2">
                    <ul>	<!-- SLIDE  -->
                       
                        <?php
                        $requiredSlides = 4;
                        $eventObj = new Event();
                        $latestEvents = $eventObj->getLatestEvents(4, 0);
                        $eventCount= mysqli_num_rows($latestEvents);
                        $slideIndex = 0;
                        $data_index = 2948;
                        $data_lable = "";
                        while ($slideRow = mysqli_fetch_array($latestEvents)) {
                            $toFormat = new DateTime($slideRow['dueDate']);
                            $dueDate = $toFormat->format("M j");
                            $data_lable = "rs-" . $data_index;
                            $eventDesc1 = strip_tags($slideRow["description"]);
                            if (strlen($eventDesc1) > 100) {
                                $slideDesc = substr($eventDesc1, 0, 100) . "...";
                            } else {
                                $slideDesc = $eventDesc1;
                            }
                            if ($slideIndex % 2 == 0) {
                                ?>
                                <li data-index="<?php echo $data_lable; ?>" data-transition="fade" data-slotamount="1" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="1500"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off"  data-title="Intro" >
                                    <!-- MAIN IMAGE -->
                                    <img src="images/<?php echo $slideRow['coverImage']; ?>" alt="Event Cover Image"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                                    <!-- LAYERS 1-->
                                    <div class="tp-caption tp-resizeme"
                                         id="slide-2946-layer-7"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-237','-217',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['-60','-60','-60','-60']"
                                         data-fontsize="['48','48','48','30']"
                                         data-lineheight="['60','60','50','30']"
                                         data-width="['710','710','none','none']"
                                         data-height="none"
                                         data-whitespace="wrap"
                                         data-type="text"
                                         data-responsive_offset="on"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1000,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"
                                         ><span class="slider-title"><?php echo $slideRow['title']; ?></span></div>
                                    <!-- LAYER NR. 2 -->
                                    <div class="tp-caption tp-resizeme slider-sub-heading-wrap"
                                         id="slide-2946-layer-10"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-237','-217',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['40','40','40','20']"
                                         data-fontsize="['15','15','15','15']"
                                         data-lineheight="['24','24','24','24']"
                                         data-width="['710','710','510','300']"
                                         data-height="none"
                                         data-whitespace="wrap"
                                         data-type="text"
                                         data-responsive_offset="on"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1250,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]">
                                        <span class="slider-sub-heading"><?php echo $slideDesc; ?> </span></div>
                                    <!-- LAYER NR. 3 -->

                                    <!-- LAYER NR. 4 -->
                                    <div class="tp-caption  tp-resizeme slider-button"
                                         id="slide-2946-layer-8"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-225','-147',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['135','125','115','115']"
                                         data-width="['710','710','none','none']"
                                         data-height="['48','48','48','48']"
                                         data-whitespace="nowrap"
                                         data-type="text"
                                         data-actions='[{"event":"click","action":"jumptoslide","slide":"rs-2947","delay":""}]'
                                         data-responsive_offset="on"
                                         data-responsive="off"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1750,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]" >
                                        <a href="viewEvent?s=<?php echo $slideRow['slug']; ?>" class="btn">Read More</a>
                                    </div>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li data-index="<?php echo $data_lable; ?>" data-transition="fade" data-slotamount="1" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="1500"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off"  data-title="Intro" >
                                    <!-- MAIN IMAGE -->
                                    <img src="images/<?php echo $slideRow['coverImage']; ?>" alt="Event Cover Image"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                                    <!-- LAYERS 1-->
                                    <div class="tp-caption tp-resizeme"
                                         id="slide-2947-layer-7"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-237','-217',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['-60','-60','-60','-60']"
                                         data-fontsize="['48','48','48','30']"
                                         data-lineheight="['60','60','50','30']"
                                         data-width="['710','710','none','none']"
                                         data-height="none"
                                         data-whitespace="wrap"
                                         data-type="text"
                                         data-responsive_offset="on"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1000,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"
                                         ><span class="slider-title"><?php echo $slideRow['title']; ?></span></div>
                                    <!-- LAYER NR. 2 -->
                                    <div class="tp-caption tp-resizeme slider-sub-heading-wrap"
                                         id="slide-2947-layer-10"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-237','-217',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['40','40','40','20']"
                                         data-fontsize="['15','15','15','15']"
                                         data-lineheight="['24','24','24','24']"
                                         data-width="['710','710','510','300']"
                                         data-height="none"
                                         data-whitespace="wrap"
                                         data-type="text"
                                         data-responsive_offset="on"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1250,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]">
                                        <span class="slider-sub-heading"><?php echo $slideDesc; ?> </span></div>
                                    <!-- LAYER NR. 3 -->

                                    <!-- LAYER NR. 4 -->
                                    <div class="tp-caption  tp-resizeme slider-button"
                                         id="slide-2947-layer-8"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-225','-147',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['135','125','115','115']"
                                         data-width="['710','710','none','none']"
                                         data-height="['48','48','48','48']"
                                         data-whitespace="nowrap"
                                         data-type="text"
                                         data-actions='[{"event":"click","action":"jumptoslide","slide":"rs-2947","delay":""}]'
                                         data-responsive_offset="on"
                                         data-responsive="off"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1750,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]" >
                                        <a href="viewEvent?s=<?php echo $slideRow['slug']; ?>" class="btn">Read More</a>
                                    </div>
                                </li>
                                <?php
                            }
                            $data_index++;
                            $slideIndex++;
                        }
                      if($requiredSlides-$eventCount>0){
                          $blogObj=new Blog();
                          $latestBlogs=$blogObj->getBlogs($requiredSlides-$eventCount, 0);
                          while ($row1 = mysqli_fetch_array($latestBlogs)) {
                            
                            $data_lable = "rs-" . $data_index;
                            $blogDesc1 = strip_tags($row1["description"]);
                            if (strlen($blogDesc1) > 100) {
                                $blogDesc = substr($blogDesc1, 0, 100) . "...";
                            } else {
                                $blogDesc = $blogDesc1;
                            }
                            if ($slideIndex % 2 == 0) {
                                ?>
                                <li data-index="<?php echo $data_lable; ?>" data-transition="fade" data-slotamount="1" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="1500"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off"  data-title="Intro" >
                                    <!-- MAIN IMAGE -->
                                    <img src="images/<?php echo $row1['coverImage']; ?>" alt="Blog Cover Image"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                                    <!-- LAYERS 1-->
                                    <div class="tp-caption tp-resizeme"
                                         id="slide-2946-layer-7"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-237','-217',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['-60','-60','-60','-60']"
                                         data-fontsize="['48','48','48','30']"
                                         data-lineheight="['60','60','50','30']"
                                         data-width="['710','710','none','none']"
                                         data-height="none"
                                         data-whitespace="wrap"
                                         data-type="text"
                                         data-responsive_offset="on"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1000,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"
                                         ><span class="slider-title"><?php echo $row1['title']; ?></span></div>
                                    <!-- LAYER NR. 2 -->
                                    <div class="tp-caption tp-resizeme slider-sub-heading-wrap"
                                         id="slide-2946-layer-10"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-237','-217',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['40','40','40','20']"
                                         data-fontsize="['15','15','15','15']"
                                         data-lineheight="['24','24','24','24']"
                                         data-width="['710','710','510','300']"
                                         data-height="none"
                                         data-whitespace="wrap"
                                         data-type="text"
                                         data-responsive_offset="on"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1250,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]">
                                        <span class="slider-sub-heading"><?php echo $blogDesc; ?> </span></div>
                                    <!-- LAYER NR. 3 -->

                                    <!-- LAYER NR. 4 -->
                                    <div class="tp-caption  tp-resizeme slider-button"
                                         id="slide-2946-layer-8"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-225','-147',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['135','125','115','115']"
                                         data-width="['710','710','none','none']"
                                         data-height="['48','48','48','48']"
                                         data-whitespace="nowrap"
                                         data-type="text"
                                         data-actions='[{"event":"click","action":"jumptoslide","slide":"rs-2947","delay":""}]'
                                         data-responsive_offset="on"
                                         data-responsive="off"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1750,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]" >
                                        <a href="viewBlog?s=<?php echo $row1['slug']; ?>" class="btn">Read More</a>
                                    </div>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li data-index="<?php echo $data_lable; ?>" data-transition="fade" data-slotamount="1" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="1500"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off"  data-title="Intro" >
                                    <!-- MAIN IMAGE -->
                                    <img src="images/<?php echo $row1['coverImage']; ?>" alt="Blog Cover Image"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                                    <!-- LAYERS 1-->
                                    <div class="tp-caption tp-resizeme"
                                         id="slide-2947-layer-7"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-237','-217',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['-60','-60','-60','-60']"
                                         data-fontsize="['48','48','48','30']"
                                         data-lineheight="['60','60','50','30']"
                                         data-width="['710','710','none','none']"
                                         data-height="none"
                                         data-whitespace="wrap"
                                         data-type="text"
                                         data-responsive_offset="on"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1000,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"
                                         ><span class="slider-title"><?php echo $row1['title']; ?></span></div>
                                    <!-- LAYER NR. 2 -->
                                    <div class="tp-caption tp-resizeme slider-sub-heading-wrap"
                                         id="slide-2947-layer-10"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-237','-217',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['40','40','40','20']"
                                         data-fontsize="['15','15','15','15']"
                                         data-lineheight="['24','24','24','24']"
                                         data-width="['710','710','510','300']"
                                         data-height="none"
                                         data-whitespace="wrap"
                                         data-type="text"
                                         data-responsive_offset="on"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1250,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]">
                                        <span class="slider-sub-heading"><?php echo $blogDesc; ?> </span></div>
                                    <!-- LAYER NR. 3 -->

                                    <!-- LAYER NR. 4 -->
                                    <div class="tp-caption  tp-resizeme slider-button"
                                         id="slide-2947-layer-8"
                                         data-x="['middle','middle','middle','middle']"
                                         data-hoffset="['-225','-147',0,'0']"
                                         data-y="['middle','middle','middle','middle']"
                                         data-voffset="['135','125','115','115']"
                                         data-width="['710','710','none','none']"
                                         data-height="['48','48','48','48']"
                                         data-whitespace="nowrap"
                                         data-type="text"
                                         data-actions='[{"event":"click","action":"jumptoslide","slide":"rs-2947","delay":""}]'
                                         data-responsive_offset="on"
                                         data-responsive="off"
                                         data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1750,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;"}]'
                                         data-textAlign="['left','left','center','center']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]" >
                                        <a href="viewBlog?s=<?php echo $row1['slug']; ?>" class="btn">Read More</a>
                                    </div>
                                </li>
                                <?php
                            }
                            $data_index++;
                            $slideIndex++; 
                          }
                      }
                        ?>

                    </ul>
                    <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>	</div>
            </div><!-- END REVOLUTION SLIDER -->
        </div>
        <div class="body-overlay"></div>
        <section class="section-padding feature-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading text-center">
                            <h2 class="section-title wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s">Our <span class="base-color">CAUSES</span> </h2>
                            <span class="section-sub-title wow fadeInUpXsd disinb" data-wow-duration=".9s" data-wow-delay=".1s">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</span>
                            <div class="section-heading-separator wow fadeInUpXsd" data-wow-duration="1.1s" data-wow-delay=".1s"></div>
                        </div>
                    </div>
                </div>
                <div class="row row-eq-rs-height">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="feature-item wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div class="feature-item__icon-wrap">
                                <i class="feature-item__icon fa fa-book"></i>
                            </div>
                            <h4 class="feature-item__title heading-label-four"><a href="#">CHARITY FOR EDUCATION</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Ut enim ad minim </p>
                        </div><!--/.feature-item-->
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="feature-item wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".4s">
                            <div class="feature-item__icon-wrap">
                                <i class="feature-item__icon fa fa-cutlery"></i>
                            </div>
                            <h4 class="feature-item__title heading-label-four"><a href="#">FEED FOR HUNGRY CHILD</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Ut enim ad minim </p>
                        </div><!--/.feature-item-->
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="feature-item wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".6s">
                            <div class="feature-item__icon-wrap">
                                <i class="feature-item__icon fa fa-home"></i>
                            </div>
                            <h4 class="feature-item__title heading-label-four"><a href="#">CHARITY FOR EDUCATION</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Ut enim ad minim </p>
                        </div><!--/.feature-item-->
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="feature-item wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div class="feature-item__icon-wrap">
                                <i class="feature-item__icon fa fa-sun-o"></i>
                            </div>
                            <h4 class="feature-item__title heading-label-four"><a href="#">CHARITY FOR EDUCATION</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Ut enim ad minim </p>
                        </div><!--/.feature-item-->
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="feature-item wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".4s">
                            <div class="feature-item__icon-wrap">
                                <i class="feature-item__icon fa fa-gift"></i>
                            </div>
                            <h4 class="feature-item__title heading-label-four"><a href="#">FEED FOR HUNGRY CHILD</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Ut enim ad minim </p>
                        </div><!--/.feature-item-->
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="feature-item wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".6s">
                            <div class="feature-item__icon-wrap">
                                <i class="feature-item__icon fa fa-heartbeat"></i>
                            </div>
                            <h4 class="feature-item__title heading-label-four"><a href="#">CHARITY FOR EDUCATION</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore  dolore magna aliqua. Ut enim ad minim </p>
                        </div><!--/.feature-item-->
                    </div>
                </div>
            </div>
        </section>
        <section class="help-us-section section-padding all-text-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading text-center">
                            <h2 class="section-title wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s">HOW CAN YOU HELP <span class="base-color">US</span> </h2>
                            <span class="section-sub-title wow fadeInUpXsd disinb" data-wow-duration=".9s" data-wow-delay=".1s">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</span>
                            <div class="section-heading-separator wow fadeInUpXsd" data-wow-duration="1.1s" data-wow-delay=".1s"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="help-us wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div class="help-us__icon-wrap">
                                <i class="help-us__icon fa fa-users"></i>
                            </div>
                            <div class="help-us__text-content">
                                <h4 class="help-us__title heading-label-four">BECOME VOLUNTEER</h4>
                                <p>Lorem ipsum dolor sit amet, risus adipisci elit. Praesent laoreet condimentum</p>
                                <a href="register" class="btn">JOIN NOW</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="help-us wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".4s">
                            <div class="help-us__icon-wrap">
                                <i class="help-us__icon fa fa-money"></i>
                            </div>
                            <div class="help-us__text-content">
                                <h4 class="help-us__title heading-label-four">BECOME DONATOR</h4>
                                <p>Lorem ipsum dolor sit amet, risus adipisci elit. Praesent laoreet condimentum</p>
                                <a href="donate" class="btn visible-xs">Donate Now</a>
                                <button class="btn hidden-xs" onclick="window.open('donate', 'Donate Serve Global', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=900,height=600')"> Donate Now</button>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="help-us wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".6s">
                            <div class="help-us__icon-wrap">
                                <i class="help-us__icon fa fa-child"></i>
                            </div>
                            <div class="help-us__text-content">
                                <h4 class="help-us__title heading-label-four">ADOPT A CHILD</h4>
                                <p>Lorem ipsum dolor sit amet, risus adipisci elit. Praesent laoreet condimentum</p>
                                <a href="donate" class="btn visible-xs">Donate Now</a><button class="btn hidden-xs" onclick="window.open('donate', 'Donate Serve Global', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=900,height=600')"> Donate Now</button>

                            </div>
                        </div>
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
                        if (isset($userImage) && filter_var($userImage, FILTER_VALIDATE_URL)) {
                            
                        } elseif (!file_exists("images/" . $userImage) || empty($userImage)) {
                            $userImage = ($userRow['sex'] == "M") ? "images/avatar.png" : "images/avatar2.png";
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
                                        <a class="venobox preview-link gallery-item  wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".2s" href="images/<?php echo $galleryRow['path']; ?>" data-gall="portfolioGallery" title="<?php echo $galleryRow['caption']; ?>" >
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
        <?php
        $eventObj = new Event();
        $events = $eventObj->getLatestEvents(12, 0);
        if (mysqli_num_rows($events) > 0) {
            ?>
            <section class="upcomming-event-section section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="section-heading">
                                <h2 class="section-title section-title--small wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s">UPCOMING  <span class="base-color">EVENTS</span></h2>
                                <div class="section-heading-separator section-heading-separator--left-align wow fadeInUpXsd" data-wow-duration=".9s" data-wow-delay=".1s"></div>
                            </div>
                            <div class="upcommig-event-carousel wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".3s">
                                <?php
                                $categoryObj = new Category();

                                while ($row = mysqli_fetch_array($events)) {
                                    $toFormat = new DateTime($row['dueDate']);
                                    $dueDate = $toFormat->format("M j");
                                    $eventTitle = strip_tags($row["title"]);
                                    if (strlen($eventTitle) > 30) {
                                        $eventTitleLable = substr($eventTitle, 0, 30) . "...";
                                    } else {
                                        $eventTitleLable = $eventTitle;
                                    }
                                    $eventDesc = strip_tags($row["description"]);
                                    if (strlen($eventDesc) > 220) {
                                        $eventDescLabel = substr($eventDesc, 0, 220) . "...";
                                    } else {
                                        $eventDescLabel = $eventDesc;
                                    }
                                    $ids = explode(',', $row['category_id']);
                                    $categoryNames = '';

                                    foreach ($ids as $cId) {
                                        $categoryNames .= $categoryObj->getCategoryNameById($cId) . ", ";
                                    }
                                    $categoryNames = rtrim($categoryNames, ", ");
                                    $categoryName = substr($categoryNames, 0, 30) . "..."
                                    ?>
                                    <div class="upcomming-event">
                                        <div class="upcomming-event__image-wrap">
                                            <img src="images/<?php echo $row['coverImage']; ?>" class="upcomming-event__image" alt="Event cover Image" style="width: 100%; height: 170px;">
                                            <div class="upcomming-event__date">
                                                <i class="fa fa-calendar"></i>
                                                <span><?php echo $dueDate; ?></span>
                                            </div>
                                        </div>
                                        <div class="upcomming-event__text-content">
                                            <h4 class="upcomming-event__title"><a href="viewEvent?s=<?php echo $row['slug']; ?>"><?php echo $eventTitleLable; ?></a></h4>
                                            <div class="upcomming-event__meta-info">
                                                <span class="upcomming-event__time"><i class="fa fa-clone base-color"></i><?php echo $categoryName; ?>  </span>
                                                <span class="upcomming-event__place"><i class="fa fa-map-marker base-color"></i><?php echo $row['location']; ?></span>
                                            </div>
                                            <p><?php echo $eventDescLabel; ?></p>
                                        </div>
                                    </div><!--/.upcomming-event-->

                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                        <div class="col-md-5">

                            <div class="section-heading">
                                <h2 class="section-title section-title--small wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s">Latest  <span class="base-color">Donations</span></h2>
                                <div class="section-heading-separator section-heading-separator--left-align wow fadeInUpXsd" data-wow-duration=".9s" data-wow-delay=".1s"></div>
                            </div>
                            <div class="upcommig-event-carousel wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".3s">

                                <?php
                                $donationObj = new Donate();
                                $donations = $donationObj->getPublicDonation(12, 0);
                                if (mysqli_num_rows($donations) > 0) {
                                    while ($donationRow = mysqli_fetch_array($donations)) {
                                        $toFormat = new DateTime($donationRow['date_created']);
                                        $donatedDate = $toFormat->format("M j, Y");
                                        ?>

                                        <div class="col-md-4 col-xs-12">
                                            <div class="help-us wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay=".4s">
                                                <div class="help-us__icon-wrap">
                                                    <i class="help-us__icon fa fa-money"></i>
                                                </div>
                                                <div class="help-us__text-content">
                                                    <h4 class="help-us__title heading-label-four"><?php echo $donationRow['name'] . "( $" . $donationRow['amount'] . ")"; ?></h4>
                                                    <p><span class="fa fa-map-marker"> <?php echo $donationRow['country']; ?></span> | <span class="fa fa-calendar"> <?php echo $donatedDate; ?></span></p>
                                                    <small> <a href="#" data-toggle="popover" title="Donor Comment" data-content="<?php echo strip_tags($donationRow['description']); ?>" class="btn-sm btn view-comment"><span class="fa fa-comment"></span> View Comment</a></small>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="alert alert-info">
                                        <strong>Info! </strong> No Recent Donation yet.
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

        $blogObj = new Blog();
        $blogs = $blogObj->getBlogs(3, 0);
        if (mysqli_num_rows($blogs) > 0) {
            ?>
            <section class="blog-section section-padding ash-white-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-heading text-center">
                                <h2 class="section-title wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s">Latest  <span class="base-color">Blog</span></h2>
                                <div class="section-heading-separator wow fadeInUpXsd" data-wow-duration="1.1s" data-wow-delay=".1s"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-eq-rs-height">
                        <?php
                        $bCount = 1;
                        while ($blogRow = mysqli_fetch_array($blogs)) {
                            $toFormat = new DateTime($blogRow['dateCreated']);
                            $dateCreated = $toFormat->format("M j, Y");
                            $title = strip_tags($blogRow["title"]);
                            if (strlen($title) > 30) {
                                $titleLabel = substr($title, 0, 30) . "...";
                            } else {
                                $titleLabel = $title;
                            }
                            $desc = strip_tags($blogRow["description"]);
                            if (strlen($desc) > 120) {
                                $descLabel = substr($desc, 0, 120) . "...";
                            } else {
                                $descLabel = $desc;
                            }
                            $wowDelay = ($bCount == 1) ? ".2s" : ".4s";
                            ?>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="blog-post wow fadeInUpSmd" data-wow-duration="1.5s" data-wow-delay="<?php echo $wowDelay; ?>">
                                    <div class="blog-post__thumbnail-wrap">
                                        <img src="images/<?php echo $blogRow['coverImage']; ?>" alt="Blog header Picture" style="width: 100%; height: 235px;">
                                        <div class="blog-post__like-comment">
                                            <span><i class="fa fa-comments"></i><?php echo $blogObj->getCommentCountForBlog($blogRow['id']); ?> Comment(s)</span>
                                            <span>|</span>
                                            <span><i class="fa fa-eye"></i><?php echo $blogObj->getBlogView($blogRow['id']); ?> Views</span>
                                        </div>
                                    </div>
                                    <div class="blog-post__text-content">
                                        <h4 class="blog-post__title heading-label-four"><a href="viewBlog?s=<?php echo $blogRow['slug']; ?>"><?php echo $titleLabel; ?></a></h4>
                                        <div class="blog-post__meta-info">
                                            <span class="small-text"><i class="fa fa-user base-color"></i>Admin</span>
                                            <span class="small-text"><i class="fa fa-calendar base-color"></i><?php echo $dateCreated; ?></span>
                                        </div>
                                        <p><?php echo $descLabel; ?></p>
                                        <a href="viewBlog?s=<?php echo $blogRow['slug']; ?>" class="btn">Read More</a>
                                    </div>
                                </div><!--/.blog-post-->
                            </div>
                            <?php
                            $bCount++;
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php
        }
        ?>
        <section class="testimonial-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading text-center">
                            <h2 class="section-title wow fadeInUpXsd" data-wow-duration=".7s" data-wow-delay=".1s">WHAT PEOPLE  <span class="base-color">SAY</span> <button class="btn btn-primary btn-sm" onclick="window.open('writeReview', 'Write Review', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=900,height=600')"> <i class="fa fa-star"></i> Write my own Review</button></h2>
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
        $sponsorObj = new Company();
        $sponsors = $sponsorObj->getSponsor(10, 0);
        if (mysqli_num_rows($sponsors) > 0) {
            ?>
            <section class="sponser-section section-padding ash-white-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-heading text-center">
                                <h2 class="section-title">Our  <span class="base-color">Sponsors</span> </h2>
                                <div class="section-heading-separator"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="client-carusel">
                                <?php
                                while ($row = mysqli_fetch_array($sponsors)) {
                                    $link = (!empty($row['website']) && filter_var($row['website'], FILTER_VALIDATE_URL)) ? $row['website'] : '#';
                                    $target = ($link == '#') ? '' : '_blank';
                                    ?>
                                    <div class="carusel-item">
                                        <a href="<?php echo $link; ?>" target="<?php echo $target; ?>">
                                            <img src="images/<?php echo $row['logo']; ?>" alt="<?php echo $row['name']; ?>">
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
        <!-- == Color box == -->
<!--        <script src="dist/js/jquery.colorbox-min.js"></script>-->
        <!-- == Slick == -->
        <script src="dist/js/slick.min.js"></script>
        <!-- == Wow js == -->
        <script src="dist/js/wow.min.js"></script>
        <!-- == Revolution Slider JS == -->
        <script src="dist/js/revolution/jquery.themepunch.tools.min.js"></script>
        <script src="dist/js/revolution/jquery.themepunch.revolution.min.js"></script>
        <script src="dist/js/revolution/extensions/revolution.extension.actions.min.js"></script>
        <script src="dist/js/revolution/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="dist/js/revolution/extensions/revolution.extension.navigation.min.js"></script>
        <script src="dist/js/revolution/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="dist/js/revolution-active.js"></script>
        <script src="plugins/venobox/venobox.min.js"></script>
        <!-- == custom Js File == -->
        <script src="dist/js/custom.js"></script>
        <script>
            // Initiate venobox (lightbox feature used in portofilo)
            $(document).ready(function () {
                $(document).on('click', '.view-comment', function (e) {
                    e.preventDefault();
                });
                $('.venobox').venobox();
                $('[data-toggle="popover"]').popover();
            });
        </script>
    </body>
</html>
