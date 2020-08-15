<?php
ob_start();
session_start();
session_regenerate_id();
header('Content-Type:Application/json');
include_once "./Category.php";
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
//Add Main Category 
$type = "info";
$data = array();
if (isset($_POST['mainCategoryId']) && !empty($_POST['mainCategoryId'])) {
    $mainCategoryId = $_POST['mainCategoryId'];
    $categoryObj = new Category();
    if ($categoryObj->removeMainCategory($mainCategoryId)) {
        $data['status'] = "success";
        $data['msg'] = "Main Category has been deleted successfully";
        echo json_encode($data);
        exit(1);
    } else {
        $data['status'] = "error";
        $data['msg'] = "Main Category has not been deleted successfully";
        echo json_encode($data);
        exit(1);
    }
} else {
    $data['status'] = "error";
    $data['msg'] = "Main Category name can not be empty!";
    echo json_encode($data);
    exit(1);
}

