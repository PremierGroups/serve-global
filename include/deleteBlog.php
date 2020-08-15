<?php
ob_start();
session_start();
session_regenerate_id();
header('Content-Type:Application/json');
include_once "Blog.php";
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
if (isset($_POST['blogId']) && !empty($_POST['blogId'])) {
    $blogId = $_POST['blogId'];
    $blogObj = new Blog();
    if ($blogObj->removeBlog($blogId)) {
        $data['status'] = "success";
        $data['msg'] = "Blog has been deleted successfully";
        echo json_encode($data);
        exit(1);
    } else {
        $data['status'] = "error";
        $data['msg'] = "Blog has not been deleted successfully";
        echo json_encode($data);
        exit(1);
    }
} else {
    $data['status'] = "error";
    $data['msg'] = "Blog can not be empty!";
    echo json_encode($data);
    exit(1);
}

