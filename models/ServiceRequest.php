<?php

include_once '../db/Db.php';

class ServiceRequest {

    private $db;

    public function __construct() {
        $this->db = new Db();
    }

    public function addServiceApplicant($name,$email,$phone,$address,$service,$message=null)
    {
       
        $sql = "INSERT INTO serviceapplicant(`name`, `email`, `phone`, `address`, `service`, `message`)VALUES ('$name', '$email', '$phone','$address','$service','$message')";
        if(mysqli_query($this->db->conn, $sql)){
            return true;
        }else{
            return false;
        }  
    }

    public function getRequestById($id) {
        $query = "select * from serviceapplicant where id='$id'";
        $service=mysqli_query($this->db->conn, $query);
        return $service;
       
    }

    public function getAllRequests() {
        $query = "select * from serviceapplicant order by dateCreated desc";
        $service = mysqli_query($this->db->conn, $query);
        return $service;
    }

   public function removeRequest($id) {
        $query = "delete from serviceapplicant where id='$id'";
        return mysqli_query($this->db->conn, $query);
       
    }
    public function requestSeen() {
        $query = "update serviceapplicant set seen='1' where seen='0'";
        return mysqli_query($this->db->conn, $query);
        
    }

    public function unReadRequests() {
        $query = "select count(*) as totalRequests from serviceapplicant where seen=0";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }


}
