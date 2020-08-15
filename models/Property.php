<?php
include_once '../db/Db.php';
class Property
{
    private $db;
    public function __construct()
    {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }

    public function addProperty($title, $description, $images,$phoneOne,$phoneTwo=null)
    {
        $query = "INSERT INTO property(`title`,`description`,`images`,`phone_one`,`phone_two`) VALUES ('$title','$description','$images','$phoneOne','$phoneTwo')";
        if(mysqli_query($this->db->conn, $query)){
            return "Property is added Successfully.";
        }else{
            return "Property not added. Please try again.";
        }  
    }

    public function updateProperty($id,$title, $description,$phoneOne,$phoneTwo)
    {
        $query = "update property set title='$title',description='$description',phone_one='$phoneOne',phone_two='$phoneTwo' where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
    public function getPropertyById($id)
    {
        $query = "select * from property where id='$id'";
        $property = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($property);
        return $row[0];
    }

    public function getSinglePropertyById($id) {
        $query = "select * from property where id='$id'";
        $property=mysqli_query($this->db->conn, $query);
        return $property;
       
    }
   
    public function deleteProperty($id)
    {
        $msg = "Error";
        $deleteSql = "delete from property where id='$id'";
        $deleteQuery = mysqli_query($this->db->conn, $deleteSql);
        if ($deleteQuery) {
            $msg = 'Property is deleted successfully!';
        } else {
            $msg = 'Property is not deleted';
        }
        return $msg;
    }

    public function getPropertiesByLimit($limit=6,$offset=0) {
        $query = "select * from property order by dateCreated desc limit $limit offset $offset";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getAllProperties(){
        $query = "select * from property";
        $organization = mysqli_query($this->db->conn, $query);
        return $organization;
    }
    public function getTotalProperties(){
        $query = "select count(*) as total from property";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }

}
