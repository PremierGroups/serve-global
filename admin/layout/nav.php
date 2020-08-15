
<header class="main-header">
    <!-- Logo -->
    <a href="index" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><span class="fa fa-globe"></span></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Serve</b> <span class="fa fa-globe"></span> <b>Global</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
               <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="../dist/img/avatar.png" class="user-image" alt="User Image">
                        <span class="hidden-xs">Serve Global</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="../dist/img/avatar.png" class="img-circle" alt="User Image">
                            <p>
                                Serve Global - Admin
                                <small>Manage since- 2020</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <!--                  <div class="col-xs-4 text-center">
                                                    <a href="#">Followers</a>
                                                  </div>
                                                  <div class="col-xs-4 text-center">
                                                    <a href="#">Sales</a>
                                                  </div>
                                                  <div class="col-xs-4 text-center">
                                                    <a href="#">Friends</a>
                                                  </div>-->
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="changePassword" class="btn btn-primary btn-flat">Change Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="../logout" class="btn btn-danger btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="../logout"><i class="fa fa-sign-out"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

<!--         search form 
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..." id="searchKeyword">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree" id="mainMenu">
            <li class="header">MAIN NAVIGATION</li>

            <li id="dashboardNav">
                <a href="index">
                    <i class="fa fa-dashboard text-fuchsia"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview" id="basicNav">
                <a href="#">
                    <i class="fa fa-gears text-fuchsia"></i>
                    <span>Settings</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right text-fuchsia"></i>
                    </span>
                </a>
                <ul class="treeview-menu" >
                    <li id="regionNav"><a href="regions"><i class="fa fa-circle-o text-fuchsia"></i> Regions</a></li>
                    <li id="zoneNav"><a href="zones"><i class="fa fa-circle-o text-fuchsia"></i> Subcity</a></li>
                    <li id="cityNav"><a href="cities"><i class="fa fa-circle-o text-fuchsia"></i> City</a></li>
                    <li id="woredaNav"><a href="woredas"><i class="fa fa-circle-o text-fuchsia"></i> Woreda</a></li>
                    <li id="cateNav"><a href="addCategory"><i class="fa fa-circle-o text-fuchsia"></i> Categories</a></li>
                </ul>
            </li>
          
            <li id="volunteerNav">
                <a href="volunteers">
                    <i class="fa fa-users text-fuchsia"></i> <span>Volunteers</span>
                </a>
            </li>
<!--            <li id="partnerNav">
                <a href="partners">
                    <i class="fa fa-building text-fuchsia"></i> <span>Partners</span>
                </a>
            </li>-->
            <li id="eventNav">
                <a href="events">
                    <i class="fa fa-clock-o text-fuchsia"></i> <span>Events</span>
                </a>
            </li>
            <li id="blogNav">
                <a href="blogs">
                    <i class="fa fa-newspaper-o text-fuchsia"></i> <span>Blogs</span>
                </a>
            </li>
            
            <li id="galleryNav">
                <a href="galleries">
                    <i class="fa fa-image text-fuchsia"></i> <span>Gallery</span>
                </a>
            </li>
            <li id="donationNav">
                <a href="donations">
                    <i class="fa fa-dollar text-fuchsia"></i> <span>Donations</span>
                </a>
            </li>
            <li id="sponsorNav">
                <a href="sponsors">
                    <i class="fa fa-adn text-fuchsia"></i> <span>Sponsors</span>
                </a>
            </li>
            <li id="testimonialNav">
                <a href="viewTestimonial">
                    <i class="fa fa-comments text-fuchsia"></i> <span>Testimonials</span>
                </a>
            </li>
            <li id="feedbackNav"><a href="viewFeedback"><i class="fa fa-feed text-fuchsia"></i> <span>Feedback</span></a></li>
             <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart text-fuchsia"></i>
                    <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right text-fuchsia"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li><a href="report/viewVolunteersByAge" target="_blank"><i class="fa fa-circle-o text-fuchsia"></i> View Volunteers By Age</a></li>
                    <li><a href="report/viewVolunteersBySex" target="_blank"><i class="fa fa-circle-o text-fuchsia"></i> View Volunteers By Gender</a></li>
                    <li><a href="report/viewVolunteersByCountry" target="_blank"><i class="fa fa-circle-o text-fuchsia"></i> View Volunteers By Geography</a></li>
                    <li><a href="report/viewVolunteersByRegion" target="_blank"><i class="fa fa-circle-o text-fuchsia"></i> Volunteers By Region</a></li>
                    <li><a href="report/viewVolunteersByCity" target="_blank"><i class="fa fa-circle-o text-fuchsia"></i> Volunteers By City</a></li>
                    <li><a href="report/viewVolunteersBySubCity" target="_blank"><i class="fa fa-circle-o text-fuchsia"></i> Volunteers By Sub City</a></li>
                    <li><a href="report/viewVolunteersByWoreda" target="_blank"><i class="fa fa-circle-o text-fuchsia"></i> Volunteers By Woreda</a></li>
                    <!-- <li><a href="#"><i class="fa fa-circle-o"></i> View Volunteers By Category</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> View Volunteers By Profession</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Advanced Report</a></li> -->
                </ul>
            </li>
             <li id="subscibeNav"><a href="subscribers"><i class="fa fa-share text-fuchsia"></i> <span>Subscribers</span></a></li>
           

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
