<?php
ob_start();
session_start();
session_regenerate_id();
include_once '../include/User.php';
include_once '../include/Region.php';
include_once '../include/City.php';
include_once '../include/Zone.php';
include_once '../include/Woreda.php';
include_once '../include/countries.php';
include_once "../include/Category.php";
if (!isset($_SESSION['username'])) {
    header('location:../login?msg=Please login before try to access this page&type=danger');
    die(1);
}
$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
$username = '';
$password = '';
$account='';
if (isset($_GET['username']) && !empty(trim($_GET['username']))) {
    $username = $_GET['username'];
    $account="Username= <b><i class='label label-primary'>$username</b></i>";
}
if (isset($_GET['password']) && !empty(trim($_GET['password']))) {
    $password = $_GET['password'];
    $account.="Password= <b><i class='label label-danger'>$password</b></i>";
   
}
if(strlen($account)>0)
$msg.="<br>".$account;
$userObj = new User();
if (isset($_POST['finish']) && !empty($_POST['firstname']) && !empty($_POST['lastname'])) {
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $fname = strip_tags($POST['firstname']);
    $lname = strip_tags($POST['mname']);
    $mname = strip_tags($POST['lastname']);
    $tel = strip_tags($POST['phone']);
    $email = strip_tags($POST['email']);
    $username = (isset($email) && !empty($email)) ? $email : $tel;
    $password=$userObj->getPassword();
    $city = "";
    $region = "";
    $zone = "";
    $woreda = "";
    $birth_date = "";
    if (isset($POST['region'])) {
        $region = $POST['region'];
    }
    if (isset($POST['city'])) {
        $city = strip_tags(trim($POST['city']));
    }
    if (isset($POST['zone'])) {
        $subCity = strip_tags(trim($POST['zone']));
    }
    if (isset($POST['woreda'])) {
        $woreda = strip_tags(trim($POST['woreda']));
    }
    if (isset($POST['birth_date'])) {
        $birth_date = $POST['birth_date'];
        $toFormat = new DateTime($birth_date);
        $birth_date = $toFormat->format("Y-m-d");
    }
    if (isset($POST['sex'])) {
        $sex = $POST['sex'];
    }

    $nationality = strip_tags(trim($POST['country']));
    //  $career = strip_tags(trim($_POST['career']));
    $supportBy = "";
    $support = "";
    if (isset($POST['support'])) {
        if (count($POST['support']) > 0) {
            $supportBy = $POST['support'];
            $support = implode(',', $supportBy);
        }
    }
    //New
    //File Upload
    $target_dir = "../images/";
    $target_file = date('dmYHis') . '_' . basename($_FILES["coverImage"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($target_file)) {
        $msg .= "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["coverImage"]["size"] > 2048000) {
        $msg .= "Sorry, your file is too large, make sure your file is not more than 2MB.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "PNG" && $fileType != "JPG" && $fileType != "JPEG" && $fileType != "gif" && $fileType != "GIF") {
        $msg .= "Sorry, Only Image file is allowed.";
        $uploadOk = 0;
    }
    $coverImage = '';
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $msg .= " User Profile was not saved.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
          
        } else {
         
            $msg .= "Sorry, there was an error while uploading the user profile image.";
        }
    }
    $msg = "User has been registered.";
    //$userId, $fname, $mname, $phoneNo, $email, $sex, $country, $mname="", $region="", $city="", $zone="", $woreda="", $userImage="", $supportBy="", $birth_date=""
    // if ($userObj->addVolunteer($fname, $mname, $tel, $email, $username, $password, $sex, $nationality, $lname, $region, $city, $zone, $woreda, $coverImage, $support, $birth_date)) {
    //     $msg = "User has been registered Successfully!";
    // } else {
    //     $msg = "User does not saved successfully! Please Try again";
    // }


    if (strlen($fname) >= 2 || strlen($mname) >= 2) {
        if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (strlen($tel) > 9 && strlen($tel) < 15) {
                $userObj = new User();
                if (!empty($email) && $userObj->checkIfEmailExists($email) == 0) {
                    if (!empty($username) && $userObj->checkIfUsernameExists($username) == 0) {
                        if ($userObj->addVolunteer($fname, $mname, $tel, $email, $username, $password, $sex, $nationality, $lname, $region, $city, $zone, $woreda, $target_file, $support, $birth_date)) {
                            if ($userObj->checkIfUsernameExists($username) > 0) {
                                $msg = "User have been registered successfully. Please use this credential to login to the system";
                                $type = 'success';
                                header("location:addVolunteer?msg=$msg&type=$type&username=$username&password=$password");
                                exit(0);
                            } else {
                                $msg = "User Registration is failed! Please try again";
                                $type = 'danger';
                                header("location:addVolunteer?msg=$msg&type=$type");
                                exit(0);
                            }
                        } else {
                            $msg = "User Registration is failed! Please try again";
                            $type = 'danger';
                            header("location:addVolunteer?msg=$msg&type=$type");
                            exit(0);
                        }
                    } else {
                        $msg = "This username is already used by other user. Please use another unique username!";
                        $type = 'danger';
                        header("location:addVolunteer?msg=$msg&type=$type");
                        exit(0);
                    }
                } else {
                    $msg = "This email is already taken by other user. Please use another email address!";
                    $type = 'danger';
                    header("location:addVolunteer?msg=$msg&type=$type");
                    exit(0);
                }
            } else {
                $msg = "Please enter correct phone number!";
                $type = 'danger';
                header("location:addVolunteer?msg=$msg&type=$type");
                exit(0);
            }
        } else {
            $msg = "Please enter correct email address!";
            $type = 'danger';
            header("location:addVolunteer?msg=$msg&type=$type");
            exit(0);
        }
    } else {
        $msg = "Please enter user name!";
        $type = 'danger';
        header("location:addVolunteer?msg=$msg&type=$type");
        exit(0);
    }

    header("location: addVolunteer?msg=$msg&type=$type");
    exit(1);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/favicon.ico">

    <title>Serve Global | Add New Volunteer</title>
    <link rel="shorcut icon" href="dist/img/favicon.ico"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../dist/css/material-bootstrap-wizard.css" rel="stylesheet" />
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!--        <link href="css/demo.css" rel="stylesheet" />-->
</head>

<body>
    <div class="image-container set-full-height">
        <!--   Creative Tim Branding   -->
        <a href="index">
            <div class="logo-container">
                <div class="logo">
                    <img src="../images/serve-global-164x1094.png">
                </div>
           </div>
        </a>
        <!--   Big container   -->
        <div class="container" style="margin-top: 0px; padding-top: 0px;">
            <div class="row">
                <div class="col-sm-12">
                    <!--      Wizard container        -->
                    <div class="wizard-container" style="margin-top: 2px; padding-top: 0px;">
                        <div class="card wizard-card" data-color="blue" id="wizardProfile">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                                <div class="wizard-header">
                                <?php
                            if ($msg != '' && strlen(trim($msg))>0) {
                                ?>
                                <div class="alert alert-<?php echo $type; ?>" role='alert'> 
                                    <button type='button' class='close' data-dismiss='alert'>
                                        <span aria-hidden='true'>&times;</span>
                                        <span class='sr-only'>Close</span>
                                    </button><?php echo $msg; ?>
                                </div>
                                <?php
                            }
                            ?>
                                    <h3 class="wizard-title">
                                        Add New Volunteer
                                    </h3>
                                    <h5>This information will let us know more about you.</h5>
                                </div>
                                <div class="wizard-navigation">
                                    <ul>
                                        <li><a href="#about" data-toggle="tab">About</a></li>
                                        <li><a href="#address" data-toggle="tab">Address</a></li>
                                        <li><a href="#support" data-toggle="tab">Support By</a></li>

                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane" id="about">
                                        <div class="row">
                                            <h4 class="info-text"> Let's start with the basic information</h4>
                                            <div class="col-sm-3">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        <img src="" class="picture-src" id="wizardPicturePreview" title="" />
                                                        <input type="file" id="wizard-picture" name="coverImage">
                                                    </div>
                                                    <h6>Choose Picture</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">First Name <small>(required)</small></label>
                                                        <input name="firstname" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="input-group ">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Father Name <small>(required)</small></label>
                                                        <input name="lastname" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Last Name <small>(optional)</small></label>
                                                        <input name="mname" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Email <small>(required)</small></label>
                                                        <input type="email" class="form-control" name="email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Phone Number <small> (required) </small></label>
                                                        <input type="text" class="form-control" name="phone">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-info-circle"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Sex <small>(required)</small></label>
                                                        <select name="sex" class="form-control">


                                                            <option disabled="" selected=""></option>

                                                            <option value="M" selected=""> Male </option>

                                                            <option value="F"> Female </option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar-check-o"></i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Birth Date</label>
                                                        <?php

                                                        $defaultYear = (int) date("Y") - 25;
                                                        $defaultDate = "01" . "/" . "01/" . $defaultYear;

                                                        ?>
                                                        <input type="text" class="form-control" value="<?php echo $defaultDate; ?>" name="birth_date" id="inputBirthDate">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row">

                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Country </label>
                                                    <select name="country" class="form-control" id="inputCountry">
                                                        <option disabled="" selected=""></option>
                                                        <?php
                                                        for ($index = 0; $index < count($countries); $index++) {
                                                            $value = $countries[$index];
                                                            if ($value == "Ethiopia") {
                                                        ?>
                                                                <option value="<?php echo $value; ?>" selected="true"><?php echo $value; ?></option>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="" id="customAdd">
                                                <div class="col-sm-5 col-sm-offset-1">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Region</label>
                                                        <select name="region" class="form-control" id="inputRegion">
                                                            <option disabled="" selected=""></option>
                                                            <?php
                                                            $regionObj = new Region();
                                                            $regions = $regionObj->getAllRegions();
                                                            while ($row1 = mysqli_fetch_array($regions)) {

                                                            ?>
                                                                <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                                                            <?php

                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">City</label>
                                                        <select name="city" class="form-control" id="inputCity">
                                                            <option disabled="" selected=""></option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-1">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Sub City/ Zone</label>
                                                        <select name="zone" class="form-control" id="inputZone">
                                                            <option disabled="" selected=""></option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Woreda</label>
                                                        <select name="woreda" class="form-control" id="inputWoreda">
                                                            <option disabled="" selected=""></option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="support">
                                        <h4 class="info-text"> How can you support us? </h4>
                                        <div class="row">
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <?php
                                                $categoryObj = new Category();
                                                $mandatories = $categoryObj->getMandatotyCategories();
                                                while ($mainCategory = mysqli_fetch_array($mandatories)) {
                                                    $categories = $categoryObj->getCategoryNameByCategory($mainCategory['id']);
                                                ?>
                                                    <div class="col-sm-6">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?php echo $mainCategory['name']; ?></label>
                                                            <select name="support[]" class="form-control select2" multiple="multiple" id="choice<?php echo $mainCategory['id']; ?>" style="width: 100%;" data-placeholder="<?php echo $mainCategory['name']; ?>" title="<?php echo $mainCategory['name']; ?>">
                                                                <option disabled=""></option>
                                                                <?php
                                                                while ($cateRow = mysqli_fetch_array($categories)) {

                                                                ?>
                                                                    <option value="<?php echo $cateRow['id']; ?>"><?php echo $cateRow['name']; ?></option>

                                                                <?php

                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                <?php
                                                }
                                                ?>


                                            </div>
                                        </div>
                                        <h5 class="info-text"> Additional volunteer activities </h5>
                                        <div class="row">
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <?php
                                                $optinalCategories = $categoryObj->getOptionalCategories();
                                                while ($optionalCategory = mysqli_fetch_array($optinalCategories)) {
                                                    $otherCategories = $categoryObj->getCategoryNameByCategory($optionalCategory['id']);
                                                ?>
                                                    <div class="col-sm-6">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label"><?php echo $optionalCategory['name']; ?></label>
                                                            <select name="support[]" class="form-control select2" multiple="multiple" id="choice<?php echo $optionalCategory['id']; ?>" style="width: 100%;" data-placeholder="<?php echo $optionalCategory['name']; ?>" title="<?php echo $optionalCategory['name']; ?>">
                                                                <option disabled=""></option>
                                                                <?php
                                                                while ($optinalRow = mysqli_fetch_array($otherCategories)) {

                                                                ?>
                                                                    <option value="<?php echo $optinalRow['id']; ?>"><?php echo $optinalRow['name']; ?></option>

                                                                <?php

                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                <?php
                                                }
                                                ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-footer">
                                    <div class="pull-right">
                                        <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Next' />
                                        <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Finish' />
                                    </div>

                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- wizard container -->
                </div>
            </div><!-- end row -->
        </div> <!--  big container -->

        <div class="footer">
            <div class="container text-center">
                System Developed by <i class="fa fa-globe text-yellow"></i> <a href="http://www.vintechplc.com" target="_blank"> Vintage Technologies Plc</a>.

            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../dist/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/jquery.bootstrap.js" type="text/javascript"></script>

    <!--  Plugin for the Wizard -->
    <script src="../dist/js/material-bootstrap-wizard.js"></script>
    <script src="../dist/js/jquery.validate.min.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Select2 -->
    <script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
    <script>
        $(function() {
            $('#inputBirthDate').datepicker({
                autoclose: true
            });
            $('[data-toggle="tooltip"]').tooltip();
            //Initialize Select2 Elements
            $('.select2').select2();

            $('#inputCountry').change(function() {

                var selection = $(this).val();
                if (selection !== "Ethiopia") {

                    $('#inputRegion').val("");
                    $('#inputCity').val("");
                    $('#inputZone').val("");
                    $('#inputWoreda').val("");
                    $('#customAdd').fadeOut(2000);
                } else {
                    $('#customAdd').fadeIn(2000);
                }
            });

            // Load Cities and subcities when Region changes
            $('#inputRegion').change(function() {
                //alert($(this).val());
                var selection = $(this).val();
                var selectedCountry = $('#inputCountry').val();
                if (selectedCountry === "Ethiopia" && (selection.trim()).length > 0) {
                    $.ajax({
                        url: "../include/getJsonCityByRegion.php",
                        type: "GET",
                        dataType: "json",
                        data: {
                            "region": selection
                        },
                        success: function(data, textStatus, jqXHR) {

                            $('#inputCity').html('');
                            $('#inputCity').append('<option disabled="" selected=""></option>');
                            for (var i in data) {
                                $('#inputCity').append('<option  value="' + data[i].id + '">' + data[i].name + '</option>');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                        }
                    });
                    //Get zones by region
                    $.ajax({
                        url: "../include/getJsonZoneByRegion.php",
                        type: "GET",
                        dataType: "json",
                        data: {
                            "region": selection
                        },
                        success: function(data, textStatus, jqXHR) {

                            $('#inputZone').html('');
                            $('#inputZone').append('<option disabled="" selected=""></option>');
                            $('#inputWoreda').html('');
                            $('#inputWoreda').append('<option disabled="" selected=""></option>');
                            for (var i in data) {
                                $('#inputZone').append('<option  value="' + data[i].id + '">' + data[i].name + '</option>');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                        }
                    });
                }
            });
            // Load Woredas when zone changes
            $('#inputZone').change(function() {
                //alert($(this).val());
                var selection = $(this).val();
                var selectedCountry = $('#inputCountry').val();
                if (selectedCountry === "Ethiopia" && (selection.trim()).length > 0) {
                    $.ajax({
                        url: "../include/getJsonWoredaByZone.php",
                        type: "GET",
                        dataType: "json",
                        data: {
                            "zone": selection
                        },
                        success: function(data, textStatus, jqXHR) {

                            $('#inputWoreda').html('');
                            $('#inputWoreda').append('<option disabled="" selected=""></option>');
                            for (var i in data) {
                                $('#inputWoreda').append('<option  value="' + data[i].id + '">' + data[i].name + '</option>');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {

                        }
                    });

                }
            });
        });
    </script>
</body>

</html>