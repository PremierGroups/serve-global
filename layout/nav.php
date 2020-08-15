<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <div class="preloader">
      <div class="loader-inner ball-scale-multiple">
          <div></div>
          <div></div>
          <div></div>
      </div>
  </div>
  <header class="fund-header">
      <div class="top-bar base-bg">
          <div class="container">
              <div class="row">
                  <div class="col-sm-6 col-xs-6 text-xs-center">
                      <div class="top-bar__contact">
                          <i class="fa fa-envelope"></i> <span class="pdl5">info@serveglobal.org</span>
                          <span class="pdl15 pdr15">|</span>
                          <i class="fa fa-phone-square"></i> <span class="pdl5">+251 911 8444 87</span>
                      </div>
                  </div>
                  <div class="col-sm-6 col-xs-6 text-right text-xs-center">
                      <div class="social-icons ">
                          <span>Follow Us On : </span>
                          <ul class="list-inline pdl20">
                              <li><a href="#"><i class="fa fa-facebook"></i> </a> </li>
                              <li><a href="#"><i class="fa fa-twitter"></i> </a> </li>
                              <li><a href="#"><i class="fa fa-linkedin"></i> </a> </li>
                              <li><a href="#"><i class="fa fa-instagram"></i> </a> </li>
                              <li><a href="#"><i class="fa fa-vk"></i> </a> </li>
                              <li><a href="#"><i class="fa fa-pinterest"></i> </a> </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </header>
  <nav class="mobile-background-nav">
      <div class="mobile-inner">
          <span class="mobile-menu-close"><i class="icon-icomooon-close"></i></span>
          <ul class="menu-accordion">
              <li id="homeNav" class="active"><a href="index">Home</a> </li>
              <li><a href="events">Events</a></li>
              <li><a href="blog">Blog</a></li>
               <li id="galleryNav"><a href="gallery">Gallery</a></li>
              <li><a href="about-us">About Us</a></li>
              <li><a href="contact-us">Contact</a></li>
              <li><a href="donate" class="btn btn-warning">Donate Now</a></li>
              <?php
              if(isset($_SESSION['username'])){
                  ?>
               <li><a href="#" class="has-submenu"><?php echo $_SESSION['fname'];?><i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown">
                        <li><a href="profile">Profile</a></li>
                        <li><a href="logout">Logout</a></li>
                    </ul>
                </li>
              <?php
              }else{
                     ?>
                <li><a href="login">Login</a></li>
              <?php
              }
              ?>
               
          </ul>
      </div>
  </nav>