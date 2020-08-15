<?php
require_once './f-config.php';
include_once './include/User.php';
try{
    $accessToken=$helper->getAccessToken();
    
} catch (\Facebook\Exceptions\FacebookResponseException $es) {
    header("location:register?msg=Unknown facebook Response Exception Error&type=danger");
    exit(1);
}catch (\Facebook\Exceptions\FacebookSDKException $ex){
   header("location:register?msg=Unknown Facebook SDK Exception& type=danger");
    exit(1);
}
if(!$accessToken){
    header("location: login");
    exit(1);
    
}
$oauth2Client=$fb->getOAuth2Client();
if(!$accessToken->isLongLived()){
    $accessToken=$oauth2Client->getLongLivedAccessToken($accessToken);
}
$response=$fb->get("/me?fields=id,first_name,middle_name, last_name, email, gender, birthday, link, picture", $accessToken);
$userData=$response->getGraphNode()->asArray();
$fname="";
$mname="";
$lname="";
$email="";
$birthDate="";
$gender="";
$picture="";
$link="";
if(isset($userData['id'])){
    $fname=$userData['first_name'];
    $mname=$userData['middle_name'];
    $link=$userData['link'];
    $username=$userData['id'];
    if(isset($userData['last_name']) && !empty($userData['last_name'])){
        $lname=$userData['last_name'];
    }
    if(isset($userData['email']) && !empty($userData['email'])){
        $email=$userData['email'];
    }
    if(isset($userData['gender']) && !empty($userData['gender'])){
        $gender=(string)$userData['gender'];
        $gender=($gender==="male")?"M":"F";
    }
    if(isset($userData['birthday']) && !empty($userData['birthday'])){
        $birthDateArry=(array)$userData['birthday'];
        $toFormat = new DateTime($birthDateArry['date']);
        $birthDate = $toFormat->format("Y-m-d");
    }
     if(isset($userData['picture']) && !empty($userData['picture'])){
        $picture=$userData['picture']['url'];
    }
    $userObj = new User();
    //$userId, $fname, $mname,$link, $email="", $userSex="", $picture="", $lname=""
        if (!empty($username) && $userObj->checkIfUsernameExists($username) == 0) {
            if ($userObj->registerWithFacebook($userData['id'], $fname, $mname,$link, $email="", $gender, $picture, $lname, $birthDate)) {
                if ($userObj->checkIfUsernameExists($username) > 0) {
                    $msg = "You have Registered successfully. Please complete your profile";
                    $type = 'success';
                    $_SESSION['username'] = $userData['id'];
                    $_SESSION['role'] = 'volunteer';
                    $_SESSION['name'] = $fname." ".$mname;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['oauth_id'] = $userData['id'];
                    $_SESSION['email'] = $email;
                    $_SESSION['picture'] = $picture;
                    $_SESSION['provider']='facebook';
                    header("location:profile?msg=$msg&type=$type&$first=true");
                    exit(0);
                } else {
                    $msg = "User Registration is failed! Please try again";
                    $type = 'danger';
                    header("location:register?msg=$msg&type=$type");
                    exit(0);
                }
            } else {
                $msg = "User Registration is failed! Please try again";
                $type = 'danger';
                header("location:register?msg=$msg&type=$type");
                exit(0);
            }
        } else {
            $msg = "You are already registered with this account. Please login.!";
            $type = 'danger';
            header("location:register?msg=$msg&type=$type");
            exit(0);
        }
    
}else{
    header("location: register?msg=User does not exist&type=danbger");
    exit(1);
}