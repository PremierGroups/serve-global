<?php
ob_start();
session_start();
session_regenerate_id();
include_once './include/Testimonial.php';
require 'vendor/autoload.php';
$clientId = "641815381795-2hq61ine5pir5culd2388an9q6edun21.apps.googleusercontent.com";
$clientSecret = "fsRnZiKxCoYHHkTWIFPyokf-";
$gClient = new Google_Client();
$redirectUri = "http://localhost/community/g-callback";
$email = '';
//Creating Client Request

$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setApplicationName("Serve Global");
$gClient->setRedirectUri($redirectUri);
$gClient->addScope('email');
$gClient->addScope('profile');
if(isset($_SESSION['access_token'])){
    $gClient->setAccessToken($_SESSION['access_token']);
}
else if (isset($_GET['code'])) {
	$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
	$_SESSION['access_token'] = $token;
}else{
    header('location: writeReview');
    exit(1);
}
$google_oauth = new Google_Service_Oauth2($gClient);
$userData = $google_oauth->userinfo->get();
$email = $userData->email;
$name = $userData->name;
$picture = $userData->picture;
$fname=$userData->given_name;
$mname=$userData->family_name;
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['picture'] = $picture;
header('location: writeReview');
exit(1);
