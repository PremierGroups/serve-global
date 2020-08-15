<?php
include_once './Category.php';

if(isset($_POST['categoryId'])){
    $categoryId=$_POST['categoryId'];
    $category=new Category();
    echo $category->removeCategory($categoryId);
    echo "Category deleted successfully";
}

