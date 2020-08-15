<?php
header('Content-Type:Application/json');
include_once './Woreda.php';
if (isset($_GET['zone']) && !empty($_GET['zone'])) {
    $woredaObj = new Woreda();
    $woredas = $woredaObj->getAllWoredasByZone($_GET['zone']);
    $data = array();
    foreach ($woredas as $value) {
        $data[] = $value;
    }
    $jsonData = json_encode($data);
    echo $jsonData;
}

