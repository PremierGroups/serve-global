<?php
ob_start();
session_start();
session_regenerate_id();
require_once 'gl-config.php';
include_once './include/User.php';
if (isset($_SESSION['access_token'])) {
    $gClient->setAccessToken($_SESSION['access_token']);
} else if (isset($_GET['code'])) {
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;
} else {
    header('location: index');
    exit(1);
}
try {
    $gender = "";
    $google_oauth = new Google_Service_Oauth2($gClient);
    $userData = $google_oauth->userinfo->get();
    if (isset($userData->id) && !empty($userData->id)) {
        $userId = $userData->id;
        $email = $userData->email;
        $picture = $userData->picture;
        $fname = $userData->given_name;
        $mname = $userData->family_name;
        if (isset($userData->gender) && !empty($userData->gender)) {
            $gender = $userData->gender;
        }
        //$userId, $fname, $lname, $email, $userSex="", $picture=""
        $userObj = new User();
                if ($userObj->checkIfEmailExists($email) > 0) {
//                    $msg = "You have Registered successfully. Please complete your profile";
//                    $type = 'success';
                    $_SESSION['username'] = $email;
                    $_SESSION['role'] = 'volunteer';
                    $_SESSION['name'] = $name;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['oauth_id'] = $userId;
                    $_SESSION['email'] = $email;
                    $_SESSION['picture'] = $picture;
                    $_SESSION['provider']='google';
                    header("location:index");
                    exit(0);
                } else {
                    $msg = "User does not exist! Please register before try to login";
                    $type = 'danger';
                    header("location:login?msg=$msg&type=$type");
                    exit(0);
                }
           
    } 
   
} catch (Google_Service_Exception $ex) {
   header("location:login?msg=Unexpected error. Please try again& type=danger");
    exit(1);
}

header('location: index');
exit(1);
