<?php
include_once 'Db.php';
class Company
{
    private $db;
    public function __construct()
    {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }

    public function create($name, $phone1, $phone2, $email, $organLogo, $organWebsite,$organDescription, $type, $startDate, $endDate, $location)
    {
        $query = "INSERT INTO sponsor(`name`,`phone1`,`phone2`, `email`,`logo`, `website`,`about`,`type`, `startDate`,`endDate`,`location`) VALUES ('$name','$phone1','$phone2','$email','$organLogo','$organWebsite','$organDescription','$type','$startDate','$endDate','$location')";
        return mysqli_query($this->db->conn, $query);
    }

    public function updateOrganization($id, $name, $phone1, $phone2, $email, $organLogo, $organWebsite,$organDescription, $location)
    {
        $query = "update sponsor set name='$name',location='$location',phone1='$phone1',phone2='$phone2',email='$email',logo='$organLogo',website='$organWebsite',about='$organDescription'where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
    public function getOrganById($organId)
    {
        $sponsorId = filter_var($organId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sponsorId, FILTER_VALIDATE_INT)) {
            $query = "select * from sponsor where id='$sponsorId'";
        return mysqli_query($this->db->conn, $query);
        }
        return null;
    }

    public function getOrganNameById($organId)
    {
        $sponsorId = filter_var($organId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($sponsorId, FILTER_VALIDATE_INT)) {
            $query = "select name from sponsor where id='$sponsorId'";
            $organization = mysqli_query($this->db->conn, $query);
            $row = mysqli_fetch_row($organization);
            return $row[0];
        }
        return null;
       
    }
    public function getOrganLogoById($organId)
    {
        $query = "select logo from sponsor where id='$organId'";
        $organization = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($organization);
        return  $row[0];
    }
    public function deleteOrganization($id)
    {
       $sponsorId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
       if(filter_var($sponsorId, FILTER_VALIDATE_INT)){
            $deleteSql = "delete from sponsor where id='$sponsorId'";
            return mysqli_query($this->db->conn, $deleteSql);
       }
       return false;
       
    }
    public function getAllOrgan(){
        $query = "select * from sponsor";
        return  mysqli_query($this->db->conn, $query);
    }
       public function getSponsor($limit = 6, $offset = 0) {
        $query = "select name,website,dateCreated,type,about,logo from sponsor order by dateCreated desc limit $limit offset $offset";
        return  mysqli_query($this->db->conn, $query);
    }
    public function getTotalCompanies(){
        $query = "select count(*) as total from sponsor";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return  $row[0];
    }
    public function renewSponsor($sponsorId, $type, $startDate, $endDate){
        $query="UPDATE sponsor SET sponsor.type='$type',startDate='$startDate',endDate='$endDate' WHERE id='$sponsorId'";
        return mysqli_query($this->db->conn, $query);
    }
public function getRemainingDays($endDate){
    $curDate=date("Y-m-d");
    $query="SELECT DATEDIFF('$endDate', '$curDate')";
    $result= mysqli_query($this->db->conn, $query);
    $row=mysqli_fetch_row($result);
    return $row[0];
}
}
