<?php

include_once '../db/Db.php';

class Project {

    private $db;

    public function __construct() {
        $this->db = new Db();
    }

    public function getProjectById($id) {
        $query = "select * from project where id='$id'";
        $project=mysqli_query($this->db->conn, $query);
        return $project;
       
    }
    public function getAllProjects() {
        $query = "select * from project";
        $project = mysqli_query($this->db->conn, $query);
        return $project;
    }

    public function getProjectsByService($service) {
        $query = "select * from project where id='$service'";
        $project = mysqli_query($this->db->conn, $query);
        return $project;
    }

    public function removeProject($id) {
        $query = "delete from project where id='$id'";
        return mysqli_query($this->db->conn, $query);
       
    }

    public function updateProject($id,$title,$service,$image=null,$description) {
        $query = "update project set title='$title', description='$description', coverImage='$image', service='$service' where id='$id'";
        return mysqli_query($this->db->conn, $query);
        
    }

    public function addProject($title,$service,$image=null,$description)
    {
      $sql = "INSERT INTO project(`title`, `description`, `coverImage`, `service`)VALUES ('$title', '$description', '$image','$service')";
        if(mysqli_query($this->db->conn, $sql)){
            return "Project is Created Successfully.";
        }else{
            return "Project not created. Please try again.";
        }  
    }
   
    public function getProjectsByLimit($limit=8,$offset=0) {
        $query = "select * from project order by dateCreated desc limit $limit offset $offset";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getTotalProject() {
        $query = "select count(*) as totalProjects from project";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }
}
