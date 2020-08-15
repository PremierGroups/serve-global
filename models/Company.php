<?php
include_once '../db/Db.php';
include_once 'Company.php';
class Company
{
    private $db;
    public function __construct()
    {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }

    public function updateOrganization($address, $email, $phone, $fb, $insta,$telegram)
    {
        $query = "update company set address='$address',email='$email',phone='$phone',facebook='$fb',instagram='$insta',telegram='$telegram' where id='12345678'";
        return mysqli_query($this->db->conn, $query);
    }
    public function getOrganization()
    {
        $query = "select * from company where id='12345678'";
        return mysqli_query($this->db->conn, $query);
    }


}
