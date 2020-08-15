<?php
include_once 'User.php';
header('Content-Type:Application/json');
$user = new User();
$statics = $user->getWorldWideUsers();
$data = array();
foreach ($statics as $value) {
    $data[] = $value;
}
$jsonData = json_encode($data);
echo "$jsonData";



