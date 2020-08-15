<style>
    .has-error{
    color: red;
    }
</style>

<?php
    include_once '../models/Company.php'; 
    include_once '../models/ServiceRequest.php';
    if (isset($_POST['applyForService'])) {
        $name = $_POST['serviceApplicantName'];
        $phone = $_POST['serviceApplicantPhone'];
        $email = $_POST['serviceApplicantEmail'];
        $address = $_POST['serviceApplicantAddress'];
        $service = $_POST['selectedService'];
        $message = $_POST['serviceApplicantMessage'];
        $serviceApplicantObj = new ServiceRequest();
        $apply = $serviceApplicantObj->addServiceApplicant($name, $email, $phone, $address, $service, $message);
        if($apply){
            echo '<script type="text/javascript">';
            echo ' alert("Thank You For Applying. We Will Contact You Soon!!")';
            echo '</script>';
        }else{
            echo '<script type="text/javascript">';
            echo ' alert("We couldnot proceed your request.Try Again!")';
            echo '</script>';
        }
    }
?>
<div class="bg-top navbar-light">
        <div class="container">
            <div class="row no-gutters d-flex align-items-center align-items-stretch">
                <div class="col-md-4 d-flex align-items-center py-4">
                    <a class="navbar-brand" href="index.php">Premier</a>
                </div>
                <div class="col-lg-8 d-block">
                    <div class="row d-flex">
                        <div class="col-md d-flex topper align-items-center align-items-stretch py-md-4">
                            <div class="icon d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                            <div class="text">
                                <span>Email</span>
                                <span><?php echo $email?></span>
                            </div>
                        </div>
                        <div class="col-md d-flex topper align-items-center align-items-stretch py-md-4">
                            <div class="icon d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                            <div class="text">
                                <span>Call</span>
                                <span>Call Us: <?php echo $phone?></span>
                            </div>
                        </div>
                        <div class="col-md topper d-flex align-items-center justify-content-end">
                            <p class="mb-0 d-block">
                                <a href="#" class="btn py-2 px-3 btn-primary" data-toggle="modal" data-target="#applyForServiceModal">
                                    <span>Request For Service</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container d-flex align-items-center">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>
           
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link pl-0"  id="homeNav">Home</a></li>
                    <li class="nav-item"><a href="service.php" id="serviceNav" class="nav-link">Services</a></li>
                    <li class="nav-item"><a href="project.php" id="projectNav" class="nav-link">Projects</a></li>
                    <li class="nav-item"><a href="blog.php" id="blogNav" class="nav-link">Blogs</a></li>
                    <li class="nav-item"><a href="vacancy.php" id="vacancyNav" class="nav-link">Jobs</a></li>
                    <li class="nav-item"><a href="property.php" id="propertyNav" class="nav-link">Properties</a></li>
                    <!-- <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>-->
                    <li class="nav-item"><a href="about.php" id="aboutNav" class="nav-link">About</a></li>
                <li class="nav-item"><a href="contact.php" id="contactNav" class="nav-link">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->

        <!-- request for a service modal -->
    <div class="modal fade" id="applyForServiceModal" tabindex="-1" role="dialog" aria-labelledby="applyForServiceLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:#1b9ce3;color:white;">
                    <h4 class="modal-title text-white">Request For A Service</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
                </div>
                <form class="appointment-form ftco-animate" action="<?php $_PHP_SELF ?>" role="form" method="post" id="requestServiceForm">
                    <div class="modal-body">
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Full name" name="serviceApplicantName" id="serviceApplicantName">
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Phone" name="serviceApplicantPhone" id="serviceApplicantPhone">
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Email" name="serviceApplicantEmail" id="serviceApplicantEmail">
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Address" name="serviceApplicantAddress" id="serviceApplicantAddress">
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <div class="form-field">
                                    <div class="select-wrap">
                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                        <select name="selectedService" id="selectedService" class="form-control">
                                            <option value="">Select Service</option>
                                            <?php 
                                            $serviceObj = new Service();
                                            $services = $serviceObj->getAllServices();
                                            if (mysqli_num_rows($services) > 0) {
                                                while ($serviceRow = mysqli_fetch_array($services)) {?>
                                                        <option value="<?php echo $serviceRow['name'] ?>"><?php echo $serviceRow['name']?></option>
                                                <?php }}?>
                                    
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-md-flex">
                            <div class="form-group">
                                <textarea name="serviceApplicantMessage" id="serviceApplicantMessage" cols="30" rows="3" class="form-control" placeholder="Message"></textarea>
                            </div>
                        </div>
                
                    </div>
                    <div class="form-group">
                        <div class="modal-footer pull-right">
                            <button type="submit" class="btn btn-primary" name="applyForService">Send Request</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
<!-- end request for service modal -->




