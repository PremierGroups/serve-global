<?php
ob_start();
session_start();
session_regenerate_id();
header('Content-Type:Application/json');
include_once "Event.php";
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
if (isset($_POST['eventId']) && !empty($_POST['eventId'])) {
    $eventId = $_POST['eventId'];
    $eventObj = new Event();
    if ($eventObj->deleteEvent($eventId)) {
        $data['status'] = "success";
        $data['msg'] = "Event has been deleted successfully";
        echo json_encode($data);
        exit(1);
    } else {
        $data['status'] = "error";
        $data['msg'] = "Event has not been deleted successfully";
        echo json_encode($data);
        exit(1);
    }
} else {
    $data['status'] = "error";
    $data['msg'] = "Event can not be empty!";
    echo json_encode($data);
    exit(1);
}

