<?php
include_once '../db/Db.php';
class Client
{
    private $db;
    public function __construct()
    {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }

    public function addClient($name, $email=null, $website=null, $location, $phone,$logo,$about=null)
    {
        $query = "INSERT INTO client(`name`,`email`,`website`, `location`,`phone`, `logo`,`about`) VALUES ('$name','$email','$website','$location','$phone','$logo','$about')";
        if( mysqli_query($this->db->conn, $query)){
            return "Client is added Successfully.";
        }else{
            return "Client is not added. Please try again.";
        }  
    }

    public function updateClient($id, $name, $email=null, $website=null, $location, $phone,$logo,$about=null)
    {
        $query = "update client set name='$name',email='$email',website='$website',location='$location',phone='$phone',logo='$logo',about='$about'where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
    public function getClientById($id)
    {
        $query = "select * from client where id='$id'";
        $organDetail = mysqli_query($this->db->conn, $query);
        return $organDetail;
    }

    public function getClientNameById($id)
    {
        $query = "select name from client where id='$id'";
        $organization = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($organization);
        $name = $row[0];
        return $name;
    }
    public function getClientLogoById($id)
    {
        $query = "select logo from client where id='$id'";
        $organization = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($organization);
        $logo = $row[0];
        return $logo;
    }
    public function deleteClient($id)
    {
        $msg = "Error";
        $deleteSql = "delete from client where id='$id'";
        $deleteQuery = mysqli_query($this->db->conn, $deleteSql);
        if ($deleteQuery) {
            $msg = 'Client is deleted successfully!';
        } else {
            $msg = 'Client is not deleted';
        }
        return $msg;
    }
    public function getAllClients(){
        $query = "select * from client";
        $organization = mysqli_query($this->db->conn, $query);
        return $organization;
    }
    public function getTotalClients(){
        $query = "select count(*) as total from client";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }

}
