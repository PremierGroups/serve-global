<?php
include_once '../models/User.php';
if(isset($_POST['userId'])){
    $userId=strip_tags($_POST['userId']);
    if(filter_var($userId, FILTER_VALIDATE_INT)) {
        $user = new User();
        $blockUser = $user->blockUser($userId);
        echo "$blockUser";
    }
}
