<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/Category.php';
include_once './include/Event.php';
include_once './include/Subscriber.php';
include_once './include/Blog.php';
$eventSlug = '';
$eventTitle = '';
$eventId = 0;
$description = '';
$eventCoverIamge = '';
$eventLocation = '';
$eventCategory = '';
$dueDate = '';

if (isset($_GET['s']) && !empty($_GET['s'])) {
    $eventSlug = $_GET['s'];
    $eventObj = new Event();
    $getItem = $eventObj->getEventBySlug($eventSlug);
    $row = mysqli_fetch_array($getItem);
    $eventTitle = $row['title'];
    $description = $row['description'];
    $eventId = $row['id'];
    $ids = explode(',', $row['category_id']);

    $categoryObj = new Category();
    foreach ($ids as $cId) {
        $eventCategory .= " <span class='label label-default'>" . $categoryObj->getCategoryNameById($cId) . "</span> ";
    }
    $eventLocation = $row['location'];
    $toFormat = new DateTime($row['dueDate']);
    $dueDate = $toFormat->format("M j, Y");
    if (empty($row['id'])) {
        header("location:events");
        exit(1);
    }
    if (file_exists("images/$row[coverImage]")) {
        $eventCoverIamge = $row['coverImage'];
    }
    $lastUpdated = $row['lastUpdated'];
    $publishedDate = $row['dateCreated'];
} else {
    header("location: events");
    exit(1);
}
$domainUrl = "https://serveglobal.org";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $eventTitle; ?> | Serve Global-Events</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- ================= Favicon ================== -->
        <link rel="icon" sizes="72x72" href="images/favicon-96x96.png">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900%7COpen+Sans:300,400,600,700,800" rel="stylesheet">
        <!--   SEO  -->
        <meta name="referrer" content="no-referrer-when-downgrade" />
        <link rel="amphtml" href="<?php echo $domainUrl; ?>/viewEvent?s=<?php echo $eventSlug; ?>" />
        <meta property="og:site_name" content="Serve Global" />
        <meta property="og:type" content="Event and Blog" />
        <meta property="og:title" content="<?php echo $eventTitle; ?>" />
        <meta property="og:description" content="<?php echo strip_tags($description); ?>" />
        <meta property="og:url" content="<?php echo $domainUrl; ?>/viewEvent?s=<?php echo $eventSlug; ?>" />
        <meta property="og:image" content="<?php echo $domainUrl; ?>/images/<?php echo $eventCoverIamge; ?>" />
        <meta property="article:published_time" content="<?php echo $lastUpdated; ?>" />
        <meta property="article:modified_time" content="<?php echo $publishedDate; ?>" />
        <meta property="article:tag" content="Event and Blog " />

        <meta name="twitter:card" content="Serve Global" />
        <meta name="twitter:title" content="<?php echo $eventTitle; ?>" />
        <meta name="twitter:description" content="<?php echo strip_tags($description); ?>" />
        <meta name="twitter:url" content="<?php echo $domainUrl; ?>/viewEvent?s=<?php echo $eventSlug; ?>" />
        <meta name="twitter:image" content="<?php echo $domainUrl; ?>/images/<?php echo $eventCoverIamge; ?>" />
        <!-- <meta name="twitter:label1" content="Written by" />
            <meta name="twitter:data1" content="themeix" />
            <meta name="twitter:label2" content="Filed under" />
            <meta name="twitter:data2" content="Business" /> -->
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="533" />
        <!--SEO END -->

        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Bootsrap css-->
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <!-- Magnific Popup-->
        <link rel="stylesheet" href="dist/css/magnific-popup.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="dist/css/select2.min.css">
        <!-- Countdown css-->
        <link rel="stylesheet" href="dist/css/jquery.countdown.css">
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
        <?php include_once "./layout/nav.php"; ?>
        <div class="main-menu-area">
            <?php include_once "./layout/topnav.php"; ?>
        </div>
        <div class="banner-area banner-area--events all-text-white text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-title">Events</h1>
                        <ul class="fund-breadcumb">
                            <li><a href="index">Home</a> </li>
                            <li><a href="events">Events</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="event-detial-wrap">
                            <div class="image-wrap mb40">
                                <img src="images/<?php echo $eventCoverIamge; ?>" class="img-round img-responsive" alt="Event Cover Image" style="width: 100%; max-height: 500px;">
                            </div>
                            <h3 class="pdb10"><?php echo $eventTitle; ?></h3>
                            <ul class="event-detail-meta nv-color">
                                <li>
                                    <span class="event-detail-meta__title"><i class="fa fa-calendar base-color icon"></i> Date</span>
                                    <span class="desc"><?php echo $dueDate; ?></span>
                                </li>
                                <li>
                                    <span class="event-detail-meta__title"><i class="fa fa-map-marker base-color icon"></i> Location</span>
                                    <span class="desc"><?php echo $eventLocation; ?></span>
                                </li>
                                <li>
                                    <span class="event-detail-meta__title"><i class="fa fa-clone base-color icon"></i> Category </span>
                                    <span class="desc"> <span class="base-color"><?php echo $eventCategory; ?></span> </span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <br>
                            <p><?php echo $description; ?></p>
                        </div>
                        <div class="social-icons ">
                            <span>Share this On : </span>
                            <ul class="list-inline pdl20">
                                <li>  <a style="font-size: 18px;" data-toggle="tooltip" title="Share On Twitter"
                                         href="https://twitter.com/share?text=<?php echo $eventTitle; ?>&amp;url=<?php echo $domainUrl; ?>/viewEvent?s=<?php echo $eventSlug; ?>"
                                         onclick="window.open(this.href, 'twitter-share', 'width=650,height=350');return false;"><i
                                            class="fa fa-twitter"></i></a> </li>
                                <li> <a style="font-size: 18px;" data-toggle="tooltip" title="Share On Facebook"
                                        href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $domainUrl; ?>/viewEvent?s=<?php echo $eventSlug; ?>"
                                        onclick="window.open(this.href, 'facebook-share', 'width=650,height=350');return false;"><i
                                            class="fa fa-facebook-f"></i></a> </li>
                                <li><a style="font-size: 18px;" data-toggle="tooltip" title="Share On Telegram"
                                       href="https://telegram.me/share/url?url=<?php echo $domainUrl; ?>/viewEvent?s=<?php echo $eventSlug; ?>&text=<?php echo $eventTitle; ?>"
                                       onclick="window.open(this.href, 'telegram-share', 'width=650,height=350');return false;"><i
                                            class="fa fa-telegram"></i></a></li>
                                <li> <a style="font-size: 18px;" data-toggle="tooltip" title="Share On LinkedIn"
                                        href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $domainUrl; ?>/viewEvent?s=<?php echo $eventSlug; ?>&title=<?php echo $eventTitle; ?>&source=Serve Global"
                                        onclick="window.open(this.href, 'linkedin-share', 'width=650,height=350');return false;"><i
                                            class="fa fa-linkedin"></i></a> </li>
                                <li><a href="https://vk.com/share.php?url=<?php echo $domainUrl;?>/viewEvent?s=<?php echo $eventSlug;?>" target="_blank"><i class="fa fa-vk"></i> </a> </li>
                                <li><a href="http://pinterest.com/pin/create/link/?url=<?php echo $domainUrl;?>/viewEvent?s=<?php echo $eventSlug;?>&description=<?php echo strip_tags($description);?>&media=<?php echo $domainUrl;?>/images/<?php echo $eventCoverIamge;?>" onclick="window.open(this.href, 'pinterest-share', 'width=850,height=450');return false;"><i class="fa fa-pinterest"></i> </a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <aside class="sidebar">
                            <form class="search-form widget">
                                <input type="search" placeholder="Search" class="form-control search-form__input" />
                                <button type="submit" class="search-form__submit"><i class="fa fa-search base-color"></i> </button>
                            </form>
                            <?php
                            $eventObj = new Event();
                            $events = $eventObj->getLatestEvents(12, 0);
                            if (mysqli_num_rows($events) > 0) {
                                ?>
                                <div class="widget">
                                    <div class="widget__heading">
                                        <h4 class="widget__title">UPCOMING <span class="base-color">EVENTS</span></h4>
                                    </div>
                                    <div class="widget__text-content">
                                        <div class="upcomming-event-carousel" id="upcomming-event-carousel">
                                            <?php
                                            $categoryObj = new Category();

                                            while ($row = mysqli_fetch_array($events)) {
                                                $toFormat = new DateTime($row['dueDate']);
                                                $dueDate = $toFormat->format("M j, Y");
                                                $eventTitle = strip_tags($row["title"]);
                                                if (strlen($eventTitle) > 30) {
                                                    $eventTitleLable = substr($eventTitle, 0, 30) . "...";
                                                } else {
                                                    $eventTitleLable = $eventTitle;
                                                }

                                                $ids = explode(',', $row['category_id']);
                                                $categoryNames = '';

                                                foreach ($ids as $cId) {
                                                    $categoryNames .= $categoryObj->getCategoryNameById($cId) . ", ";
                                                }
                                                $categoryNames = rtrim($categoryNames, ", ");
                                                $categoryName = substr($categoryNames, 0, 30) . "..."
                                                ?>
                                                <div class="upcomming-event-carousel__item">
                                                    <div class="image text-center">
                                                        <a href="viewEvent?s=<?php echo $row['slug']; ?>"><img class="event-thumbnail" src="images/<?php echo $row['coverImage']; ?>" alt="Event Cover Image" style="width: 100%; height: 275px;">
                                                            <h4 class="upcomming-event-carousel__title"><?php echo $eventTitleLable; ?></h4></a>

                                                    </div>

                                                    <div class="event-counter" style="padding-left: 5px; padding-right: 10px; padding-top: 10px; padding-bottom: 0px; margin-bottom: 0px; left: 50%; right: 50%;">

                                                        
                                                        <span class="fa fa-map-marker" style="align-content: center;"></span> &nbsp;&nbsp; <span class="base-color"> <?php echo $row['location']; ?></span> &nbsp;&nbsp;
                                                              
                                                                    <span class="nv-color" style="align-content: center;"><span class="fa fa-calendar"></span> </span> &nbsp; &nbsp;<span> <?php echo $dueDate; ?> </span>
                                                                
                                                    </div>
                                                </div><!--/.upcomming-event-carousel__item-->
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>


                            <div class="widget">
                                <div class="widget__heading">
                                    <h4 class="widget__title">LATEST <span class="base-color">Blogs</span></h4>
                                </div>
                                <div class="widget__text-content">
                                    <?php
                                    $blogObj = new Blog();
                                    $blogs = $blogObj->getBlogs(5, 0);
                                    while ($blogRow = mysqli_fetch_array($blogs)) {
                                        $toFormat = new DateTime($blogRow['dateCreated']);
                                        $dateCreated = $toFormat->format("M j, Y");
                                        $title = strip_tags($blogRow["title"]);
                                        if (strlen($title) > 20) {
                                            $titleLabel = substr($title, 0, 20) . "...";
                                        } else {
                                            $titleLabel = $title;
                                        }
                                        ?>
                                        <div class="widget-latest-causes">
                                            <div class="widget-latest-causes__image-wrap">
                                                <a href="viewBlog?s=<?php echo $blogRow['slug']; ?>"><img class="widget-latest-causes__thubnail img-round" src="images/<?php echo $blogRow['coverImage']; ?>" alt="Blog Cover Picture"></a>
                                            </div>
                                            <div class="widget-latest-causes__text-content">
                                                <h4 class="widget-latest-causes__title"><a href="viewBlog?s=<?php echo $blogRow['slug']; ?>"><?php echo $titleLabel; ?></a></h4>
                                                <div class="widget-latest-causes__admin small-text">
                                                    <i class="base-color fa fa-user widget-latest-causes__admin-icon"></i>
                                                    by <a href="#">Admin</a>
                                                </div>
                                                <div class="widget-latest-causes__time text-mute">
                                                    <?php echo $dateCreated; ?>
                                                </div>
                                            </div>
                                        </div><!--/.widget-latest-causes-->
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
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
        <!-- == Counter == -->
        <script src="dist/js/jquery.waypoints.min.js"></script>
        <script src="dist/js/jquery.counterup.min.js"></script>
        <!-- == Countdown == -->
        <script src="dist/js/jquery.plugin.js"></script>
        <script src="dist/js/jquery.countdown.min.js"></script>
        <!-- == Wow js == -->
        <script src="dist/js/wow.min.js"></script>
        <!-- == Google Maps == -->
    <!--    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBjaOVpxq-vyWE7EOrUjmYsDdxRSrlar08"></script>
        <script src="dist/js/jquery.mapit.min.js"></script>
        <script src="dist/js/map-init.js"></script>-->
        <!-- == custom Js File == -->
        <script src="dist/js/custom.js"></script>
    </body>
</html>
