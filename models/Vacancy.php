<?php
include_once '../db/Db.php';
class Vacancy
{
    private $db;
    public function __construct()
    {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }

    public function addVacancy($title, $description,$location)
    {
        $query = "INSERT INTO vacancy(`title`,`description`,`location`) VALUES ('$title','$description','$location')";
       if(mysqli_query($this->db->conn, $query)){
            return "Vacancy is added Successfully.";
        }else{
            return "Vacancy is not added. Please try again.";
        }  
    }

    public function updateVacancy($id, $title, $description,$location)
    {
        $query = "update vacancy set title='$title',description='$description',location='$location' where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }

    public function getVacancyById($id)
    {
        $query = "select * from vacancy where enabled='1' and id='$id'";
        $vacancy = mysqli_query($this->db->conn, $query);
        return $vacancy;
    }

    
    public function deleteVacancy($id)
    {
        $msg = "Error";
        $deleteSql = "update vacancy set enabled='0' where id='$id'";
        $deleteQuery = mysqli_query($this->db->conn, $deleteSql);
        if ($deleteQuery) {
            $msg = 'Vacancy is deleted successfully!';
        } else {
            $msg = 'Vacancy is not deleted';
        }
        return $msg;
    }
    public function getAllVacancies(){
        $query = "select * from vacancy where enabled='1'";
        $organization = mysqli_query($this->db->conn, $query);
        return $organization;
    }

    public function getVacancyByLimit($limit=6,$offset=0) {
        $query = "select * from vacancy order by dateCreated desc limit $limit offset $offset where enabled='1'";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getTotalVacancies(){
        $query = "select count(*) as total from vacancy where enabled='1'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }

    public function getApplicantByVacancy($id){
        $query = "select * from vacancy where id='$id'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }

   

}
