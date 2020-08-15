<?php

header('Content-Type:Application/json');
include_once './Zone.php';
if (isset($_GET['region']) && !empty($_GET['region'])) {
    $zoneObj = new Zone();
    $zones = $zoneObj->getAllZonesByRegion($_GET['region']);
    $data = array();
    foreach ($zones as $value) {
        $data[] = $value;
    }
    $jsonData = json_encode($data);
    echo $jsonData;
}

