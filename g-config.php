<?php
// Load Composer's autoloader
require 'vendor/autoload.php';
$clientId = "641815381795-2hq61ine5pir5culd2388an9q6edun21.apps.googleusercontent.com";
$clientSecret = "fsRnZiKxCoYHHkTWIFPyokf-";
$gClient = new Google_Client();
$redirectUri = "http://localhost/community/g-register";
$email = '';
//Creating Client Request

$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setApplicationName("Serve Global");
$gClient->setRedirectUri($redirectUri);
$gClient->addScope('email');
$gClient->addScope('profile');
?>