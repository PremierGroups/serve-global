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
if (isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];
    $categoryObj = new Category();
    if ($categoryObj->removeCategory($categoryId)) {
        $data['status'] = "success";
        $data['msg'] = "Category has been deleted successfully";
        echo json_encode($data);
        exit(1);
    } else {
        $data['status'] = "error";
        $data['msg'] = "Category has not been deleted successfully";
        echo json_encode($data);
        exit(1);
    }
} else {
    $data['status'] = "error";
    $data['msg'] = "Category name can not be empty!";
    echo json_encode($data);
    exit(1);
}

