<?php
include_once '../db/Db.php';

class Testimonial
{
    private $db;
    public function __construct() {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }

    public function addTestimonial($name, $content, $respo) {

        $content=strip_tags($content);
        $name=strip_tags($name);
        $content=mysqli_real_escape_string($this->db->conn, $content);
        $name=mysqli_real_escape_string($this->db->conn,$name);
        $respo= strip_tags(trim($respo));
        $respo=mysqli_real_escape_string($this->db->conn, $respo);
        $query = "INSERT INTO testimonial(`name`, `content`, `respo`) VALUES ('$name','$content','$respo')";
        return mysqli_query($this->db->conn, $query);
       
        return false;

    }
    public function getAllTestimonial(){
        $query="select * from testimonial order by dateCreated desc";
        return mysqli_query($this->db->conn,$query);
    }
    public function getTestimonial($offset=0) {
        $query = "select * from testimonial order by dateCreated desc limit 6 offset $offset";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getTotalTestimonial() {
        $query = "select count(*) as totalTestimonial from testimonial";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }
    public function getToDayTestimonial() {
        $toDay = date("Y-m-d");
        $query = "select * from testimonial where date_format(dateCreated,'%Y-%m-%d')='$toDay' order by dateCreated desc";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function removeTestimonial($id) {
        $query = "delete from testimonial where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
    public  function getTestimonialById($id){
        $query = "select * from testimonial where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
    public function updateTestimonial($id, $name, $email, $content, $respo){
        $email= filter_var($email,FILTER_SANITIZE_EMAIL);
        $content= strip_tags(trim($content));
        $respo= strip_tags(trim($respo));
        $name= strip_tags(trim($name));
        $name= filter_var($name,FILTER_SANITIZE_STRING);
        $msg=true;
        try{
            if((filter_var($id,FILTER_VALIDATE_INT))&& (filter_var($email,FILTER_VALIDATE_EMAIL))){
                $name=mysqli_real_escape_string($this->db->conn,$name);
                $content=mysqli_real_escape_string($this->db->conn,$content);
                $query = "update testimonial set name='$name', content='$content', email='$email', respo='$respo' where id='$id'";
                $msg=mysqli_query($this->db->conn, $query);
                return $msg;
            }
        }catch (Exception $ex){
            return false;
        }
        return $msg;
    }
}