<?php
include_once 'User.php';
header('Content-Type:Application/json');
$user = new User();
$statics = $user->groupVolunteersByRegion();
$data = array();
foreach ($statics as $value) {
    $numberOfMales=(int)$user->getTotalMaleUsersInARegion($value['regionId']);
    $totalVolunteers=(int)$value['totalVolunteers'];
    $numberOfFemales=$totalVolunteers-$numberOfMales;
    $regionName=$value['regionName'];
    $regionData=array('name'=>$regionName, 'male'=>$numberOfMales, 'female'=>$numberOfFemales,'totalVolunteers'=>$totalVolunteers);
    $data[] = $regionData;
}
$jsonData = json_encode($data);
echo "$jsonData";



