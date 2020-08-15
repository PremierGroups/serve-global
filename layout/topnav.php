    <div class="container">
        <div class="menu-logo">
            <div class="logo">
                <a href="index" class="logo-index"><img src="dist/img/logo2.png" alt="Logo" /></a>
            </div>
            <nav id="easy-menu">
                <ul class="menu-list">
                    <li id="homeNav" class="active"><a href="index">Home </a></li>
                    <li id="eventNav"><a href="events">Events </a></li>
                    <li id="blogNav"><a href="blog">Blog</a></li>
                    <li id="aboutNav"><a href="about-us">About Us</a></li>
                    <li id="galleryNav"><a href="gallery">Gallery</a></li>
                    <li id="contactNav"><a href="contact-us">Contact</a></li>
                    <?php
                    if (isset($_SESSION['username'])) {
                        ?>
                        <li><a href="#" class="has-submenu"><?php echo $_SESSION['fname']; ?><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown">
                                <li><a href="profile">Profile</a></li>
                                <li><a href="logout">Logout</a></li>
                            </ul>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li><a href="login">Login</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </nav>
            <!--#easy-menu-->
            <div class="donate-button-wrap">
    <!--  <a href="donate" class="btn base-bg hidden-xs hidden-sm">Donate Now</a>-->
    <button class="btn base-bg hidden-xs hidden-sm" onclick="window.open('donate', 'Donate Serve Global', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=900,height=600')"> Donate Now</button>
                <a href="#" class="hidden-lg hidden-md" id="humbarger-icon"><i class="fa fa-bars"></i> </a>
            </div>
        </div>
    </div>