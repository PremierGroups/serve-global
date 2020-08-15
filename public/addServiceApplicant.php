<?php
include_once '../models/ServiceRequest.php';
if(isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['service'])){
    $name=($_POST['name']);
    $email=($_POST['email']);
    $phone=($_POST['phone']);
    $address=($_POST['address']);
    $service=($_POST['service']);
    $message=($_POST['message']);
    $serviceApplicantObj = new ServiceRequest();
    $apply = $serviceApplicantObj->addServiceApplicant($name, $email, $phone, $address, $service, $message);
    return $apply;
                
   
}
