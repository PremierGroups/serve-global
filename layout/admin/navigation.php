<?php
//include_once './Feedback.php';
include_once '../models/User.php';
include_once '../models/Feedback.php';
include_once '../models/Applicant.php';
include_once '../models/ServiceRequest.php';
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit(1);
}
$user = new User();
$userId = $user->getUserIdByUsername($_SESSION['username']);
$profile = $user->getUser($userId);
$row = mysqli_fetch_array($profile);
$fname = $row['fname'];
$lname = $row['lname'];
$fullname = $fname . " " . $lname;
$phone = $row['phoneNo'];
$email = $row['email'];
$toFormat = new DateTime($row['dateCreated']);
$memeberedAt = $toFormat->format("M. Y");

$applicantObj = new Applicant();
$unseenApplicant = $applicantObj->getUnseenApplicant();
?>
<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="index" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Premier</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>PREMIER</b> GROUPS</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications Menu -->
                <li class="notifications-menu">
                    <?php
                    $serviceObj = new ServiceRequest();
                    $unReadRequest = $serviceObj->unReadRequests();
                   
                    ?>
                    <a href="../admin/serviceRequest">Request For Service
                        <?php if($unReadRequest != 0):?>
                            <span class="label label-warning"><?php echo "$unReadRequest"; ?></span>
                        <?php else:?>
                            <span class="label"><?php echo "$unReadRequest"; ?></span>   
                        <?php endif;?>
                    </a>
                </li>
                <li class="dropdown notifications-menu">
                    <?php
                    $feedbackObj = new Feedback();
                    $totalFeedback = $feedbackObj->unReadMessage();
                   
                    ?>
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <?php if($totalFeedback != 0):?>
                            <span class="label label-warning"><?php echo "$totalFeedback"; ?></span>
                        <?php else:?>
                            <span class="label"><?php echo "$totalFeedback"; ?></span>   
                        <?php endif;?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"> <?php echo "$totalFeedback"; ?> new feedbacks today</li>
                        
                        <li class="footer"><a href="viewFeedback">View</a></li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="../images/avatar.png" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><?php echo "$fname"; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="../images/avatar.png" class="img-circle" alt="User Image">
                            <p>
                                <?php echo "$fullname"; ?>
                                <small>Member since  <?php echo "$memeberedAt"; ?></small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="profile" class="btn btn-warning btn-flat"> <span class="fa fa-user"></span> Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="../public/logout" class="btn btn-danger btn-flat"><span class="glyphicon glyphicon-log-out"></span> Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
<!--                <p class="img-circle"><script src=https://www.avatarapi.com/js.aspx?email=aemiromekete12@gmail.com&size=128></script></p>-->
                <img src="../images/avatar.png" class="img-circle" alt="Admin Image">
            </div>
            <div class="pull-left info">
                <p><?php echo "$fname"; ?></p>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menus</li>
            <!-- Optionally, you can add icons to the links -->
            <li id="dashboardNav"><a href="../admin/index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li id="serviceNav"><a href="services" title="Services"><i class="fa fa-list-alt"></i> <span>Services </span></a></li>           
            <li id="userNav"><a href="users"><i class="fa fa-users"></i> <span>Users</span></a></li>
            <li id="projectNav"><a href="projects.php" title="Projects"><i class="fa fa-building-o"></i> <span>Project </span></a></li>
            <li id="clientNav"><a href="clients" title="Clients"><i class="fa fa-building"></i> <span>Clients </span></a></li>
            <li class="treeview" id="blogNav">
                <a href="#">
                <i class="fa fa-newspaper-o"></i>
                <span>Blog</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li id="blogsNav"><a href="blogs"><i class="fa fa-newspaper-o"></i> <span>Manage Blogs</span></a></li>
                    <li id="addBlogNav"><a href="addBlog"><i class="fa fa-newspaper-o"></i> <span>Add Blog</span></a></li>
                </ul>
            </li>
            <li class="treeview" id="vacancyNav">
                <a href="#">
                <i class="fa fa-tasks"></i>
                <span>Vacancy<span class="label text-primary" style="color:red"><?php echo $unseenApplicant;?></span></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li id="vacanciesNav"><a href="vacancies"><i class="fa fa-tasks"></i> <span>Manage Vacancies</span></a></li>
                    <li id="addVacancyNav"><a href="addVacancy"><i class="fa fa-tasks"></i> <span>Add Vacancy</span></a></li>
                </ul>
            </li>
            <li class="treeview" id="propertyNav">
                <a href="#">
                <i class="fa fa-product-hunt"></i>
                <span>Property</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li id="propertiesNav"><a href="properties"><i class="fa fa-product-hunt"></i> <span>Manage Properties</span></a></li>
                    <li id="addPropertyNav"><a href="addProperty"><i class="fa fa-product-hunt"></i> <span>Add Property</span></a></li>
                </ul>
            </li>
            <li id="organizationNav"><a href="organization" title="Organization"><i class="fa fa-building-o"></i> <span>Company </span></a></li>           
            <li id="feedbackNav"><a href="viewFeedback"><i class="fa fa-feed"></i> <span>Feedback </span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
