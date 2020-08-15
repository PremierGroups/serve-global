<?php
ob_start();
session_start();
session_regenerate_id();
header('Content-Type:Application/json');
include_once "../include/Region.php";
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
if (isset($_POST['regionId']) && !empty($_POST['regionId'])) {
    $regionId = $_POST['regionId'];
    $regionObj = new Region();
    if ($regionObj->removeRegion($regionId)) {
        $data['status'] = "success";
        $data['msg'] = "Region has been deleted successfully";
        echo json_encode($data);
        exit(1);
    } else {
        $data['status'] = "error";
        $data['msg'] = "Region has not been deleted successfully";
        echo json_encode($data);
        exit(1);
    }
} else {
    $data['status'] = "error";
    $data['msg'] = "Region can not be empty!";
    echo json_encode($data);
    exit(1);
}

