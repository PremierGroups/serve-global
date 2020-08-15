<?php 
ob_start();
session_start();
session_regenerate_id();
require 'vendor/autoload.php';
$appSecret="0b3aaacd098393ff8b45323c97d6fa42";
$appId="572683610112599";

$fb = new Facebook\Facebook([

 'app_id' => $appId,

 'app_secret' => $appSecret,

 'default_graph_version' => 'v2.10',

]);

$helper = $fb->getRedirectLoginHelper();
