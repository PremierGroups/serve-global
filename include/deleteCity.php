<?php
ob_start();
session_start();
session_regenerate_id();
header('Content-Type:Application/json');
include_once "City.php";
if (!isset($_SESSION['username'])) {
    $data['status'] = 'error';
    $data['msg'] = "Please login before try to access this page";
    echo json_encode($data);
    exit(1);
}
if (!$_SESSION['role'] == 'admin') {
    $data['status'] = 'error';
    $data['msg'] = "You don\'t have permission to access this page";
    echo json_encode($data);
    exit(1);
}
//Add Region 
$type = "info";
$data = array();
if (isset($_POST['cityId']) && !empty($_POST['cityId'])) {
    $cityId = $_POST['cityId'];
    $cityObj = new City();
    if ($cityObj->removeCity($cityId)) {
        $data['status'] = "success";
        $data['msg'] = "City has been deleted successfully";
        echo json_encode($data);
        exit(1);
    } else {
        $data['status'] = "error";
        $data['msg'] = "City has not been deleted successfully";
        echo json_encode($data);
        exit(1);
    }
} else {
    $data['status'] = "error";
    $data['msg'] = "City name can not be empty!";
    echo json_encode($data);
    exit(1);
}

