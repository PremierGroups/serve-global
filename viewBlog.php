<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/Blog.php';
include_once './include/Category.php';
include_once './include/Event.php';
include_once './include/Subscriber.php';
$blogSlug = '';
$blogTitle = '';
$blogId = 0;
$description = '';
$eventCoverIamge = '';
if (isset($_GET['s']) && !empty($_GET['s'])) {
    $blogSlug = $_GET['s'];
    $blogObj = new Blog();
    $getItem = $blogObj->getBlogBySlug($blogSlug);
    $row = mysqli_fetch_array($getItem);
    $blogTitle = $row['title'];
    $description = $row['description'];
    $blogId = $row['id'];
    $categoryId = $row['category_id'];
    if (empty($row['id'])) {
        header("location:index");
        exit(1);
    }
    if (file_exists("images/$row[coverImage]")) {
        $eventCoverIamge = $row['coverImage'];
    }
    $lastUpdated=$row['lastUpdated'];
    $publishedDate=$row['dateCreated'];
} else {
    header("location: index");
    exit(1);
}
$domainUrl = "https://serveglobal.org";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $blogTitle; ?> | Serve Global-Blog</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- ================= Favicon ================== -->
        <link rel="icon" sizes="72x72" href="images/favicon-96x96.png">
        <!--   SEO  -->
        <meta name="referrer" content="no-referrer-when-downgrade" />
        <link rel="amphtml" href="<?php echo $domainUrl; ?>/viewBlog?s=<?php echo $blogSlug; ?>" />
        <meta property="og:site_name" content="Serve Global" />
        <meta property="og:type" content="Blog" />
        <meta property="og:title" content="<?php echo $blogTitle; ?>" />
        <meta property="og:description" content="<?php echo strip_tags($description); ?>" />
        <meta property="og:url" content="<?php echo $domainUrl; ?>/viewBlog?s=<?php echo $blogSlug; ?>" />
        <meta property="og:image" content="<?php echo $domainUrl; ?>/images/<?php echo $eventCoverIamge; ?>" />
        <meta property="article:published_time" content="<?php echo $lastUpdated;?>" />
        <meta property="article:modified_time" content="<?php echo $publishedDate;?>" />
        <meta property="article:tag" content="Event and Blog" />

        <meta name="twitter:card" content="Serve Global" />
        <meta name="twitter:title" content="<?php echo $blogTitle; ?>" />
        <meta name="twitter:description" content="<?php echo strip_tags($description); ?>" />
        <meta name="twitter:url" content="<?php echo $domainUrl; ?>/viewBlog?s=<?php echo $blogSlug; ?>" />
        <meta name="twitter:image" content="<?php echo $domainUrl; ?>/images/<?php echo $eventCoverIamge; ?>" />
        <!-- <meta name="twitter:label1" content="Written by" />
            <meta name="twitter:data1" content="themeix" />
            <meta name="twitter:label2" content="Filed under" />
            <meta name="twitter:data2" content="Business" /> -->
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="533" />
        <!--SEO END -->

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
        <?php include_once "./layout/nav.php"; ?>
        <div class="main-menu-area">
            <?php include_once "./layout/topnav.php"; ?>
        </div>
        <div class="banner-area banner-area--blog all-text-white text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-title">BLOG DETAILS</h1>
                        <ul class="fund-breadcumb">
                            <li><a href="index">Home</a> </li>
                            <li><a href="viewBlog?s=<?php echo $blogSlug; ?>">Blog details</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="blog-details">
                            <div class="blog-details-top mb40">
                                <div class="blog-details-image mb10">
                                    <img src="images/<?php echo $eventCoverIamge; ?>" alt="Blog header picture" style="width: 100%; max-height: 500px;">
                                </div>
                                <div class="blog-details-top__text-content">
                                    <h3 class="blog-details__title"><?php echo $blogTitle; ?></h3>
                                    <div class="blog-details__meta">
                                        <div class="blog-details__meta-item base-color"><i class="fa fa-calendar pdr5"></i>25 January</div>
                                        <div class="blog-details__meta-item"><i class="fa fa-user pdr5"></i>Admin</div>
                                        <div class="blog-details__meta-item"><i class="fa fa-comments-o pdr5"></i>5</div>
                                        <div class="blog-details__meta-item"><i class="fa fa-heart pdr5"></i>15</div>
                                    </div>
                                </div>
                            </div>

                            <p><?php echo $description; ?></p>
                            <div class="social-icons ">
                                <span>Share this On : </span>
                                <ul class="list-inline pdl20">
                                    <li>  <a style="font-size: 18px;" data-toggle="tooltip" title="Share On Twitter"
                                             href="https://twitter.com/share?text=<?php echo $blogTitle; ?>&amp;url=<?php echo $domainUrl; ?>/viewBlog?s=<?php echo $blogSlug; ?>"
                                             onclick="window.open(this.href, 'twitter-share', 'width=650,height=350');return false;"><i
                                                class="fa fa-twitter"></i></a> </li>
                                    <li> <a style="font-size: 18px;" data-toggle="tooltip" title="Share On Facebook"
                                            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $domainUrl; ?>/viewBlog?s=<?php echo $blogSlug; ?>"
                                            onclick="window.open(this.href, 'facebook-share', 'width=650,height=350');return false;"><i
                                                class="fa fa-facebook-f"></i></a> </li>
                                    <li><a style="font-size: 18px;" data-toggle="tooltip" title="Share On Telegram"
                                           href="https://telegram.me/share/url?url=<?php echo $domainUrl; ?>/viewBlog?s=<?php echo $blogSlug; ?>&text=<?php echo $blogTitle; ?>"
                                           onclick="window.open(this.href, 'telegram-share', 'width=650,height=350');return false;"><i
                                                class="fa fa-telegram"></i></a></li>
                                    <li> <a style="font-size: 18px;" data-toggle="tooltip" title="Share On LinkedIn"
                                            href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $domainUrl; ?>/viewBlog?s=<?php echo $blogSlug; ?>&title=<?php echo $blogTitle; ?>&source=Serve Global"
                                            onclick="window.open(this.href, 'linkedin-share', 'width=650,height=350');return false;"><i
                                                class="fa fa-linkedin"></i></a> </li>
                                       <li><a href="https://vk.com/share.php?url=<?php echo $domainUrl;?>/viewBlogt?s=<?php echo $blogSlug;?>" target="_blank"><i class="fa fa-vk"></i> </a> </li>
                                <li><a href="http://pinterest.com/pin/create/link/?url=<?php echo $domainUrl;?>/viewBlog?s=<?php echo $blogSlug;?>&description=<?php echo strip_tags($description);?>&media=<?php echo $domainUrl;?>/images/<?php echo $eventCoverIamge;?>" onclick="window.open(this.href, 'pinterest-share', 'width=850,height=450');return false;"><i class="fa fa-pinterest"></i> </a> </li>
                            
                                </ul>
                            </div>
<!--                            <div class="blog-details-bottom mt40">
                                <div class="blog-details-navigation mt35 mb50">
                                    <a href="#" class="previous-post">Previous Post</a>
                                    <a href="#" class="next-post pull-right" >Next Post</a>
                                </div>
                            </div>-->

<!--                            <div class="comments-wrap pdt50 mt45">
                                <h3 class="comments-title">5 COMMENTS</h3>
                                <div class="single-comment-wrap">
                                    <div class="single-comment">
                                        <div class="single-comment__image">
                                            <img src="images/blog/comment1.jpg" class="img-circle" alt="">
                                        </div>
                                        <div class="single-comment__text-content">
                                            <h4 class="single-comment__name">Ibrahim ibn al-Walid</h4>
                                            <a href="#" class="single-comment__reply-button base-color">Reply</a>
                                            <em class="single-comment__time-ago">23 minutes</em>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nec justo fringilla, laoreet mauris vitae, fringilla elit. Curabitur semper tristique nisi, at ultricies leo ornare rutrum. Proin laci vulputate urna, non pharetra ligula finibus nec. Vestibulum id mattis risus.</p>
                                        </div>
                                    </div>
                                    <div class="single-comment-wrap">
                                        <div class="single-comment">
                                            <div class="single-comment__image">
                                                <img src="images/blog/comment2.jpg" class="img-circle" alt="">
                                            </div>
                                            <div class="single-comment__text-content">
                                                <h4 class="single-comment__name">Ibrahim ibn al-Walid</h4>
                                                <a href="#" class="single-comment__reply-button base-color">Reply</a>
                                                <em class="single-comment__time-ago">18 minutes</em>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nec justo fringilla, laoreet mauris vitae, fringilla elit. Curabitur semper tristique nisi, at ultricies leo ornare rutrum. Proin laci vulputate urna, non pharetra ligula finibus nec. Vestibulum id mattis risus.</p>
                                            </div>
                                        </div>
                                        <div class="single-comment-wrap">
                                            <div class="single-comment">
                                                <div class="single-comment__image">
                                                    <img src="images/blog/comment3.jpg" class="img-circle" alt="">
                                                </div>
                                                <div class="single-comment__text-content">
                                                    <h4 class="single-comment__name">Admin</h4>
                                                    <a href="#" class="single-comment__reply-button base-color">Reply</a>
                                                    <em class="single-comment__time-ago">16 minutes</em>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nec justo fringilla, laoreet mauris vitae, fringilla elit. Curabitur semper tristique nisi, at ultricies leo ornare rutrum. Proin laci vulputate urna, non pharetra ligula finibus nec. Vestibulum id mattis risus.</p>
                                                </div>
                                            </div>
                                        </div>/.single-comment-wrap
                                    </div>/.single-comment-wrap
                                </div>/.single-comment-wrap
                                <div class="single-comment-wrap">
                                    <div class="single-comment">
                                        <div class="single-comment__image">
                                            <img src="images/blog/comment1.jpg" class="img-circle" alt="">
                                        </div>
                                        <div class="single-comment__text-content">
                                            <h4 class="single-comment__name">Admin</h4>
                                            <a href="#" class="single-comment__reply-button base-color">Reply</a>
                                            <em class="single-comment__time-ago">23 Days</em>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nec justo fringilla, laoreet mauris vitae, fringilla elit. Curabitur semper tristique nisi, at ultricies leo ornare rutrum. Proin laci vulputate urna, non pharetra ligula finibus nec. Vestibulum id mattis risus.</p>
                                        </div>
                                    </div>
                                </div>/.single-comment-wrap
                                <div class="single-comment-wrap">
                                    <div class="single-comment">
                                        <div class="single-comment__image">
                                            <img src="images/blog/comment4.jpg" class="img-circle" alt="">
                                        </div>
                                        <div class="single-comment__text-content">
                                            <h4 class="single-comment__name">Uthman ibn Affan</h4>
                                            <a href="#" class="single-comment__reply-button base-color">Reply</a>
                                            <em class="single-comment__time-ago">Nov, 23, 2013</em>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum nec justo fringilla, laoreet mauris vitae, fringilla elit. Curabitur semper tristique nisi, at ultricies leo ornare rutrum. Proin laci vulputate urna, non pharetra ligula finibus nec. Vestibulum id mattis risus.</p>
                                        </div>
                                    </div>
                                </div>/.single-comment-wrap
                            </div>
                            <div class="leave-comment pdt50 mt20 mb30">
                                <h3 class="leave-comment__title text-uppercase">Leave Your COMMENT</h3>
                                <form class="leave-comment__form mt40" method="post">
                                    <div class="leave-comment__top-fields">
                                        <div class="input-group">
                                            <input type="text" placeholder="Name" class="input-group__input form-control" name="name">
                                        </div>
                                        <div class="input-group">
                                            <input type="email" placeholder="Email" class="input-group__input form-control" name="email">
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <textarea class="input-group__textarea form-control" placeholder="Message" rows="8" cols="80" name="comment"></textarea>
                                    </div>
                                    <input type="submit" class="btn base-bg" value="Leave a Comment"/>
                                </form>
                            </div>-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <aside class="sidebar">
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


                            <div class="widget widget--category">
                                <div class="widget__heading">
                                    <h4 class="widget__title">CATEGORY</h4>
                                </div>
                                <div class="widget__text-content">
                                    <ul>
                                        <?php
                                    $categories=$blogObj->getCategoriesHavingMostBlogs(10);
                                    while ($categoryRow = mysqli_fetch_array($categories)) {
                                        ?>
                                      <li><a href="blogsByCategory?s=<?php echo $categoryRow['slug'];?>" class="pdr10"><?php echo $categoryRow['name'];?></a><span class="post-count"><?php echo $categoryRow['categoryCount'];?></span></li>
                                  
                                     <?php
                                    }
                                    ?>
                                    </ul>

                                </div>
                            </div>
                           
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
                                        <a href="viewBlog?s=<?php echo $blogRow['slug'];?>"><img class="widget-latest-causes__thubnail img-round" src="images/<?php echo $blogRow['coverImage'];?>" alt="Blog Cover Picture"></a>
                                    </div>
                                    <div class="widget-latest-causes__text-content">
                                        <h4 class="widget-latest-causes__title"><a href="viewBlog?s=<?php echo $blogRow['slug'];?>"><?php echo $titleLabel;?></a></h4>
                                        <div class="widget-latest-causes__admin small-text">
                                            <i class="base-color fa fa-user widget-latest-causes__admin-icon"></i>
                                            by <a href="#">Admin</a>
                                        </div>
                                        <div class="widget-latest-causes__time text-mute">
                                           <?php echo $dateCreated;?>
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
        <!-- == custom Js File == -->
        <script src="dist/js/custom.js"></script>
        <script>
                                                $(function () {
                                                    $('[data-toggle="tooltip"]').tooltip();
                                                    var blogId = "<?php echo $blogId; ?>";
                                                    if (blogId.trim().length > 0) {
                                                        $.ajax({
                                                            url: "include/addBlogView.php",
                                                            method: "POST",
                                                            data: {
                                                                "blogId": blogId
                                                            },
                                                            success: function (response) {
                                                                //console.log(response);
                                                            },
                                                            error: function (error) {
                                                                console.log(error);
                                                            }

                                                        });
                                                    }

                                                });
        </script>
    </body>
</html>
