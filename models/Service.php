<?php

include_once '../db/Db.php';

class Service {

    private $db;

    public function __construct() {
        $this->db = new Db();
    }

    public function getServiceById($id) {
        $query = "select * from service where id='$id'";
        $service=mysqli_query($this->db->conn, $query);
        return $service;
       
    }
    public function getAllServices() {
        $query = "select * from service order by dateCreated desc";
        $service = mysqli_query($this->db->conn, $query);
        return $service;
    }

    public function getServicesByCountry($country) {
        $query = "select * from service where id='$country'";
        $service = mysqli_query($this->db->conn, $query);
        return $service;
    }

    public function removeService($id) {
        $query = "delete from service where id='$id'";
        return mysqli_query($this->db->conn, $query);
       
    }

    public function updateService($id,$name,$description,$image=null,$country) {
        $query = "update service set name='$name', description='$description', coverImage='$image', country='$country' where id='$id'";
        return mysqli_query($this->db->conn, $query);
        
    }

    public function addService($name,$description,$image=null,$country)
    {
      $sql = "INSERT INTO service(`name`, `description`, `coverImage`, `country`)VALUES ('$name', '$description', '$image','$country')";
        if(mysqli_query($this->db->conn, $sql)){
            return "Service is Created Successfully.";
        }else{
            return "Service not created. Please try again.";
        }  
    }

    public function getServiceByLimit($limit=6,$offset=0) {
        $query = "select * from service order by dateCreated desc limit $limit offset $offset";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getTotalService() {
        $query = "select count(*) as totalServices from service";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }
   

}
