<?php
ob_start();
session_start();
session_regenerate_id();
include_once 'include/User.php';
include_once 'include/Region.php';
include_once 'include/City.php';
include_once 'include/Zone.php';
include_once 'include/Woreda.php';
include_once 'include/countries.php';
include_once "include/Category.php";
if (!isset($_SESSION['username'])) {
    header('location:login?msg=Please login before try to access this page&type=danger');
    die(1);
}
$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
$userObj = new User();
$userId = $userObj->getUserIdByUsername($_SESSION['username']);
$profile = $userObj->getUser($userId);
$row = mysqli_fetch_array($profile);
$fname = $row['fname'];
$mname = $row['mname'];
$fullname = $fname . " " . $mname;
$lname = $row['lname'];
$phone = $row['phone'];
$email = $row['email'];
$userImage = $row["profile_image"];
$userSex = $row['sex'];
$userCity = $row['city'];
$userRegion = $row['region'];
$userSubCity = $row['zone'];
$userCountry = $row['country'];
$userWoreda = $row['woreda'];
$provider = $row['provider'];
$userCareer = $row['career'];
$birthDate = "";
if (isset($row['birth_date']) && !empty(trim($row['birth_date']))) {
    $toFormat = new DateTime(trim($row['birth_date']));
    $birthDate = $toFormat->format("d/m/Y");
}
//echo $birthDate;
//exit(1);
$userSupport = $row['support_by'];
$userSupportArray = explode(',', $userSupport);


if (isset($userImage) && filter_var($userImage, FILTER_VALIDATE_URL)) {
    
} elseif (!file_exists("images/" . $userImage) || empty($userImage)) {
    $userImage = ($userSex == "M") ? "images/avatar.png" : "images/avatar2.png";
} else {
    $userImage = "images/" . $userImage;
}

if (isset($_POST['finish'])) {
    $fname = strip_tags($_POST['firstname']);
    $mname = strip_tags($_POST['lastname']);
    $lname = strip_tags($_POST['lname']);
    $tel = strip_tags($_POST['phone']);
    $email = strip_tags($_POST['email']);
    $city = "";
    $region = "";
    $zone = "";
    $woreda = "";
    $birth_date = "";
    if (isset($_POST['region'])) {
        $region = $_POST['region'];
    }
    if (isset($_POST['city'])) {
        $city = strip_tags(trim($_POST['city']));
    }
    if (isset($_POST['zone'])) {
        $subCity = strip_tags(trim($_POST['zone']));
    }
    if (isset($_POST['woreda'])) {
        $woreda = strip_tags(trim($_POST['woreda']));
    }
    if (isset($_POST['birth_date'])) {
        $birth_date = $_POST['birth_date'];
        $toFormat = new DateTime($birth_date);
        $birth_date = $toFormat->format("Y-m-d");
    }
    if (isset($_POST['sex'])) {
        $sex = $_POST['sex'];
    }

    $nationality = strip_tags(trim($_POST['country']));
    //  $career = strip_tags(trim($_POST['career']));
    $supportBy = "";
    $support = "";
    if (isset($_POST['support'])) {
        if (count($supportBy) > 0) {
            $supportBy = $_POST['support'];
            $support = implode(',', $supportBy);
        }
    }
    //New
    //File Upload
    $target_dir = "images/";
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
        $coverImage = $userImage;
        $msg .= " User Profile was not Updated.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["coverImage"]["tmp_name"], $target_dir . $target_file)) {
            $coverImage = $target_file;
        } else {
            $coverImage = $userImage;
            $msg .= "Sorry, there was an error while updat the cover image.";
        }
    }
    $msg = "Your Profile has been updated.";
    //$userId, $fname, $mname, $phoneNo, $email, $sex, $country, $lname="", $region="", $city="", $zone="", $woreda="", $userImage="", $supportBy="", $birth_date=""
    if ($userObj->updateUser($userId, $fname, $mname, $tel, $email, $sex, $nationality, $lname, $region, $city, $zone, $woreda, $coverImage, $support, $birth_date)) {
        $msg = "User Profile has been Updated Successfully!";
    } else {
        $msg = "Your Profile has not been Updated!";
    }
    header("location: profile?msg=$msg");
    exit(1);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title><?php echo $fullname; ?> - Profile</title>
        <link rel="shorcut icon" href="dist/img/favicon.ico"/>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- CSS Files -->
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="dist/css/material-bootstrap-wizard.css" rel="stylesheet" />
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

        <!-- CSS Just for demo purpose, don't include it in your project -->
        <!--        <link href="css/demo.css" rel="stylesheet" />-->
    </head>

    <body>
        <div class="image-container set-full-height">
            <!--   Creative Tim Branding   -->
            <a href="index">
                <div class="logo-container">
                    <div class="logo">
                          <img src="dist/img/logo.png">
                    </div>
                   
                </div>
            </a>

            <!--   Big container   -->
            <div class="container">
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
                                            Build Your Profile
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

                                                            <img src="<?php echo $userImage; ?>" class="picture-src" id="wizardPicturePreview" title=""/>
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
                                                            <input name="firstname" type="text" class="form-control" value="<?php echo $fname; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="input-group ">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Father Name <small>(required)</small></label>
                                                            <input name="lastname" type="text" class="form-control" value="<?php echo $mname; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Last Name <small>(optional)</small></label>
                                                            <input name="lname" type="text" class="form-control" value="<?php echo $lname; ?>">
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
                                                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
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
                                                            <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
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

                                                                <?php
                                                                if (empty($userSex)) {
                                                                    ?>
                                                                    <option disabled="" selected=""></option>
                                                                    <?php
                                                                }
                                                                if ($userSex == "M") {
                                                                    ?>
                                                                    <option value="M" selected=""> Male </option>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <option value="M"> Male </option>
                                                                    <?php
                                                                }
                                                                if ($userSex == "F") {
                                                                    ?>
                                                                    <option value="F" selected=""> Female </option>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <option value="F"> Female </option>
                                                                    <?php
                                                                }
                                                                ?>

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
                                                            if (empty($birthDate)) {
                                                                $defaultYear = (int) date("Y") - 25;
                                                                $defaultDate = "01" . "/" . "01/" . $defaultYear;
                                                            } else {
                                                                $defaultDate = $birthDate;
                                                            }
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
                                                                if ($value == $userCountry) {
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
                                                                    if ($row1['id'] == $userRegion) {
                                                                        ?>
                                                                        <option value="<?php echo $row1['id']; ?>" selected=""><?php echo $row1['name']; ?></option>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <option value="<?php echo $row1['id']; ?>" ><?php echo $row1['name']; ?></option>
                                                                        <?php
                                                                    }
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
                                                                <?php
                                                                $cityObj = new City();
                                                                $cities = $cityObj->getAllCitiesByRegion($userRegion);
                                                                while ($row2 = mysqli_fetch_array($cities)) {
                                                                    if ($row2['id'] == $userCity) {
                                                                        echo "<option value='$row2[id]' selected='true'>$row2[name]</option>";
                                                                    } else {
                                                                        echo "<option value='$row2[id]'>$row2[name]</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5 col-sm-offset-1">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Sub City/ Zone</label>
                                                            <select name="zone" class="form-control" id="inputZone">
                                                                <option disabled="" selected=""></option>
                                                                <?php
                                                                if (isset($userRegion) && !empty($userRegion)) {
                                                                    $zoneObj = new Zone();
                                                                    $zones = $zoneObj->getAllZonesByRegion($userRegion);
                                                                    while ($row3 = mysqli_fetch_array($zones)) {
                                                                        if ($row3['id'] == $userSubCity) {
                                                                            ?>
                                                                            <option value="<?php echo $row3['id']; ?>" selected=""><?php echo $row3['name']; ?></option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $row3['id']; ?>"><?php echo $row3['name']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Woreda</label>
                                                            <select name="woreda" class="form-control" id="inputWoreda">
                                                                <option disabled="" selected=""></option>
                                                                <?php
                                                                if (isset($userSubCity) && !empty(trim($userSubCity))) {
                                                                    $woredaObj = new Woreda();
                                                                    $woredas = $woredaObj->getAllWoredasByZone($userSubCity);
                                                                    while ($row4 = mysqli_fetch_array($woredas)) {
                                                                        if ($row4['id'] == $userWoreda) {
                                                                            ?>
                                                                            <option value="<?php echo $row4['id']; ?>" selected=""><?php echo $row4['name']; ?></option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $row4['id']; ?>"><?php echo $row4['name']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
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
                                                                        if (in_array($cateRow['id'], $userSupportArray)) {
                                                                            ?>
                                                                            <option value="<?php echo $cateRow['id']; ?>" selected=""><?php echo $cateRow['name']; ?></option>

                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $cateRow['id']; ?>"><?php echo $cateRow['name']; ?></option>

                                                                            <?php
                                                                        }
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
                                                                        if (in_array($optinalRow['id'], $userSupportArray)) {
                                                                            ?>
                                                                            <option value="<?php echo $optinalRow['id']; ?>" selected=""><?php echo $optinalRow['name']; ?></option>

                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $optinalRow['id']; ?>"><?php echo $optinalRow['name']; ?></option>

                                                                            <?php
                                                                        }
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
        <script src="dist/js/jquery-2.2.4.min.js" type="text/javascript"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="dist/js/jquery.bootstrap.js" type="text/javascript"></script>

        <!--  Plugin for the Wizard -->
        <script src="dist/js/material-bootstrap-wizard.js"></script>
        <script src="dist/js/jquery.validate.min.js"></script>
        <!-- bootstrap datepicker -->
        <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
        <!-- Select2 -->
        <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
        <script>
            $(function () {
                $('#inputBirthDate').datepicker({
                    autoclose: true
                });
                $('[data-toggle="tooltip"]').tooltip();
                //Initialize Select2 Elements
                $('.select2').select2();
                var country = "<?php echo $userCountry; ?>";
                if (country !== "Ethiopia") {
                    $('#inputRegion').val("");
                    $('#inputCity').val("");
                    $('#customAdd').fadeOut(2000);
                }
                $('#inputCountry').change(function () {

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
                $('#inputRegion').change(function () {
                    //alert($(this).val());
                    var selection = $(this).val();
                    var selectedCountry = $('#inputCountry').val();
                    if (selectedCountry === "Ethiopia" && (selection.trim()).length > 0) {
                        $.ajax({
                            url: "include/getJsonCityByRegion.php",
                            type: "GET",
                            dataType: "json",
                            data: {"region": selection},
                            success: function (data, textStatus, jqXHR) {

                                $('#inputCity').html('');
                                $('#inputCity').append('<option disabled="" selected=""></option>');
                                for (var i in data) {
                                    $('#inputCity').append('<option  value="' + data[i].id + '">' + data[i].name + '</option>');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                            }
                        });
                        //Get zones by region
                        $.ajax({
                            url: "include/getJsonZoneByRegion.php",
                            type: "GET",
                            dataType: "json",
                            data: {"region": selection},
                            success: function (data, textStatus, jqXHR) {

                                $('#inputZone').html('');
                                $('#inputZone').append('<option disabled="" selected=""></option>');
                                $('#inputWoreda').html('');
                                $('#inputWoreda').append('<option disabled="" selected=""></option>');
                                for (var i in data) {
                                    $('#inputZone').append('<option  value="' + data[i].id + '">' + data[i].name + '</option>');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                            }
                        });
                    }
                });
                // Load Woredas when zone changes
                $('#inputZone').change(function () {
                    //alert($(this).val());
                    var selection = $(this).val();
                    var selectedCountry = $('#inputCountry').val();
                    if (selectedCountry === "Ethiopia" && (selection.trim()).length > 0) {
                        $.ajax({
                            url: "include/getJsonWoredaByZone.php",
                            type: "GET",
                            dataType: "json",
                            data: {"zone": selection},
                            success: function (data, textStatus, jqXHR) {

                                $('#inputWoreda').html('');
                                $('#inputWoreda').append('<option disabled="" selected=""></option>');
                                for (var i in data) {
                                    $('#inputWoreda').append('<option  value="' + data[i].id + '">' + data[i].name + '</option>');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                            }
                        });

                    }
                });
            });
        </script>
    </body>
</html>
