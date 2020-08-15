<?php
include_once 'Blog.php';
if(isset($_POST['blogId']) ){
    $blogObj=new Blog();
    $blogId= strip_tags($_POST['blogId']);
    $msg=$blogObj->addBlogView($blogId);
    //echo $blogId;
}

