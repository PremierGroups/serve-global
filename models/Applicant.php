<?php
include_once '../db/Db.php';
class Applicant
{
    private $db;
    public function __construct()
    {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }

    public function addApplicant($vacancyId,$name, $email, $phone, $location, $scanned_cv)
    {
        $query = "INSERT INTO applicant(`name`,`email`,`phone`, `location`,`scanned_cv`,`vacancy_id`)VALUES ('$name','$email','$phone','$location','$scanned_cv','$vacancyId')";
        if(mysqli_query($this->db->conn, $query)){
            return true;
        }else{
            return false;
        }  
    }

    public function updateApplicant($id,$name, $email, $phone, $location, $scanned_id)
    {
        $query = "update applicant set name='$name',email='$email',phone='$phone',location='$location',scanned_id='$scanned_id' where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
    public function getApplicantById($id)
    {
        $query = "select * from applicant where id='$id'";
        $applicant = mysqli_query($this->db->conn, $query);
        return $applicant;
    }
    public function getApplicantByVacancy($vacancyId)
    {
        $query = "select * from applicant where vacancy_id='$vacancyId'";
        $applicants = mysqli_query($this->db->conn, $query);
        return $applicants;
    }
    
    public function deleteApplicant($id)
    {
        $msg = "Error";
        $deleteSql = "delete from applicant where id='$id'";
        $deleteQuery = mysqli_query($this->db->conn, $deleteSql);
        if ($deleteQuery) {
            $msg = 'Applicant is deleted successfully!';
        } else {
            $msg = 'Applicant is not deleted';
        }
        return $msg;
    }
    public function getAllApplicants(){
        $query = "select * from applicant";
        $organization = mysqli_query($this->db->conn, $query);
        return $organization;
    }
    public function getTotalApplicants(){
        $query = "select count(*) as total from applicant";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }

    public function applicantSeen($vacancyId) {
        $query = "update applicant set seen='1' where seen='0' and vacancy_id=$vacancyId";
        return mysqli_query($this->db->conn, $query);
        
    }

    public function getUnseenApplicant(){
        $query = "select count(*) as total from applicant where seen='0'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }

    public function getApplicantByVacancyUnSeen($vacancyId)
    {
        $query = "select count(*) as total from applicant where vacancy_id='$vacancyId' and seen='0'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }


}
