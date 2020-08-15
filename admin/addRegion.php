<?php
ob_start();
session_start();
session_regenerate_id();
header('Content-Type:Application/json');
include_once "../include/Region.php";
if (!isset($_SESSION['username'])) {
    $data['type'] = 'error';
    $data['msg'] = "Please login before try to access this page";
    echo json_encode($data);
    exit(1);
}
if (!$_SESSION['role'] == 'admin') {
    $data['type'] = 'error';
    $data['msg'] = "You don\'t have permission to access this page";
    echo json_encode($data);
    exit(1);
}
//Add Region 
$type = "info";
$data = array();
if (isset($_POST['name']) && !empty($_POST['name'])) {
    $regionObj = new Region();
    $msg = $regionObj->addRegion($_POST['name']);
    $data['type'] = 'success';
    $data['msg'] = $msg;
    echo json_encode($data);
    exit(1);
} else {
    $data['type'] = 'error';
    $data['msg'] = "Please Enter region name";
    echo json_encode($data);
    exit(1);
}
