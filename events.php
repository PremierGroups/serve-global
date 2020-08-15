<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/Blog.php';
include_once './include/Category.php';
include_once './include/Event.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Serve Global | Events</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- ================= Favicon ================== -->
        <link rel="icon" sizes="72x72" href="dist/img/favicon.ico">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900%7COpen+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Font Awesome css-->
        <link rel="stylesheet" href="dist/css/font-awesome.min.css">
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
                        <div class="row">
                            <?php
                            $eventObj = new Event();
                            $events = $eventObj->getLatestEvents(12, 0);
                            if (mysqli_num_rows($events) > 0) {

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
                                    if (strlen($eventDesc) > 100) {
                                        $eventDescLabel = substr($eventDesc, 0, 100) . "...";
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
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="our-causes">
                                            <div class="our-causes__image-wrap">
                                                <img src="images/<?php echo $row['coverImage']; ?>"  class="our-causes__image img-round" alt="<?php echo $eventTitleLable; ?>">
                                                <div class="our-causes__percentage base-bg">
                                                    <div class="our-causes__rised">
                                                        <span class="fa fa-map-marker"></span> &nbsp;&nbsp; <span class="base-color"> <?php echo $row['location']; ?></span>
                                                    </div>
                                                    <div class="our-causes__goal">
                                                        <span class="nv-color"><span class="fa fa-calendar"></span> </span> &nbsp; &nbsp;<span> <?php echo $dueDate; ?> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="our-causes__text-content text-center">
                                                <h4 class="text-uppercase our-causes__title"><a href="viewEvent?s=<?php echo $row['slug']; ?>"><?php echo $eventTitleLable; ?></a></h4>
                                                <p><?php echo $eventDescLabel; ?></p>
                                                <a href="viewEvent?s=<?php echo $row['slug']; ?>" class="btn">Read More</a>
                                            </div>
                                        </div><!--/.our-causes-->
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="alert alert-info">
                                    <strong>Sorry!</strong> No Active Event in our System yet
                                </div>
                                <?php
                            }
                            ?>

                        </div>

                    </div>
                    <div class="col-md-4">
                        <aside class="sidebar">

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
<?php include_once './layout/footer.php'; ?>
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
        <!-- == custom Js File == -->
        <script src="dist/js/custom.js"></script>
    </body>
</html>
