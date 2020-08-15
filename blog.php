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
    <title>Serve Global | Blogs</title>
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
<?php include_once "./layout/nav.php";?>
    <div class="main-menu-area">
    <?php include_once "./layout/topnav.php";?>
    </div>
    <div class="banner-area banner-area--blog all-text-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title">LATEST BLOG</h1>
                    <ul class="fund-breadcumb">
                        <li><a href="index">Home</a> </li>
                        <li><a href="blog">Latest Blog</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row row-eq-rs-height">
                        <?php
                        $blogObj=new Blog();
                        $blogs=$blogObj->getBlogs(6, 0);
                        $totalBlogs=$blogObj->getTotalBlogs();
                        while ($row = mysqli_fetch_array($blogs)) {
                             $toFormat = new DateTime($row['dateCreated']);
                                                $dateCreated = $toFormat->format("M j, Y");
                                                      $title = strip_tags($row["title"]);
                                if (strlen($title) > 30) {
                                    $titleLabel = substr($title, 0, 30) . "...";
                                } else {
                                    $titleLabel = $title;
                                }
                                    $desc = strip_tags($row["description"]);
                                if (strlen($desc) > 130) {
                                    $descLabel = substr($desc, 0, 130) . "...";
                                } else {
                                    $descLabel = $desc;
                                }
                            ?>
                         <div class="col-sm-6 col-xs-12">
                            <div class="blog-post">
                                <div class="blog-post__thumbnail-wrap">
                                    <img src="images/<?php echo $row['coverImage'];?>" alt="Blog Heading Picture" class="img-responsive" style="width: 100%; height: 235px;" >
                                    <div class="blog-post__like-comment">
                                        <span><i class="fa fa-comments"></i><?php echo $blogObj->getCommentCountForBlog($row['id']);?> Comment(s)</span>
                                        <span>|</span>
                                        <span><i class="fa fa-thumbs-up"></i><?php echo $blogObj->getBlogView($row['id']);?> Views</span>
                                    </div>
                                </div>
                                <div class="blog-post__text-content">
                                    <h4 class="blog-post__title heading-label-four"><a href="viewBlog?s=<?php echo $row['slug'];?>"><?php echo $titleLabel;?></a></h4>
                                    <div class="blog-post__meta-info">
                                        <span class="small-text"><i class="fa fa-user base-color"></i>Admin</span>
                                        <span class="small-text"><i class="fa fa-calendar base-color"></i><?php echo $dateCreated;?></span>
                                    </div>
                                    <p><?php echo $descLabel;?></p>
                                    <a href="viewBlog?s=<?php echo $row['slug'];?>" class="btn">Read More</a>
                                </div>
                            </div><!--/.blog-post-->
                        </div>
                        <?php
                        }
                        ?>
                       
                    </div>
<!--                    <div class="fund-pagination mb30">
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#" class="next">Next</a>
                    </div>-->
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


<!--                        <div class="widget widget--category">
                            <div class="widget__heading">
                                <h4 class="widget__title">CATEGORY</h4>
                            </div>
                            <div class="widget__text-content">
                                <ul>
                                    <?php
//                                    $categories=$blogObj->getCategoriesHavingMostBlogs(10);
//                                    while ($categoryRow = mysqli_fetch_array($categories)) {
                                        ?>
                                      <li><a href="blogsByCategory?s=<?php echo $categoryRow['slug'];?>" class="pdr10"><?php echo $categoryRow['name'];?></a><span class="post-count"><?php echo $categoryRow['categoryCount'];?></span></li>
                                  
                                     <?php
                                   // }
                                    ?>
                                    
                                </ul>

                            </div>
                        </div>-->
                      
                    </aside>
                </div>
            </div>
        </div>
    </div>
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
    <!-- == Slick == -->
    <script src="dist/js/slick.min.js"></script>
    <!-- == Wow js == -->
    <script src="dist/js/wow.min.js"></script>
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
