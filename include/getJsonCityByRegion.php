<?php

header('Content-Type:Application/json');
include_once './City.php';
if (isset($_GET['region']) && !empty($_GET['region'])) {
    $cityObj = new City();
    $cities = $cityObj->getAllCitiesByRegion($_GET['region']);
    $data = array();
    foreach ($cities as $value) {
        $data[] = $value;
    }
    $jsonData = json_encode($data);
    echo $jsonData;
}

