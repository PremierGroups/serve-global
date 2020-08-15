<?php
ob_start();
session_start();
session_regenerate_id();
header('Content-Type:Application/json');
include_once "Partner.php";
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
//Add Partner 
$type = "info";
$data = array();
if (isset($_POST['partnerId']) && !empty($_POST['partnerId'])) {
    $partnerId = $_POST['partnerId'];
    $partnerObj = new Partner();
    if ($partnerObj->activatePartner($partnerId)) {
        $data['status'] = "success";
        $data['msg'] = "Partner has been Activated successfully!";
        echo json_encode($data);
        exit(1);
    } else {
        $data['status'] = "error";
        $data['msg'] = "Partner has not been activated successfully!";
        echo json_encode($data);
        exit(1);
    }
} else {
    $data['status'] = "error";
    $data['msg'] = "Partner can not be empty!";
    echo json_encode($data);
    exit(1);
}

