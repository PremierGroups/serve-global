<?php
include_once 'Db.php';

class Testimonial
{
    private $db;
    public function __construct() {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }
public function getTestimonialByOffset($limit=6,$offset=0) {
        $query = "select * from testimonial order by dateCreated desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function addTestimonial($name, $content, $email, $respo, $image="", $provider="") {

        $content=strip_tags($content);
        $name=strip_tags($name);
        $image=strip_tags($image);
        $image=mysqli_real_escape_string($this->db->conn, $image);
        $content=mysqli_real_escape_string($this->db->conn, $content);
        $name=mysqli_real_escape_string($this->db->conn,$name);
         $respo= strip_tags(trim($respo));
         $respo=mysqli_real_escape_string($this->db->conn, $respo);
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        $query = "INSERT INTO testimonial(`name`, `content`, `email`, `respo`, `image`,`provider`) VALUES ('$name','$content','$email','$respo', '$image','$provider')";
        return mysqli_query($this->db->conn, $query);
        }
        return false;

    }
    public function getAllTestimonial($limit = 15, $offset = 0){
        $query="select * from testimonial order by dateCreated desc limit $offset, $limit";
        return mysqli_query($this->db->conn,$query);
    }
    public function getTestimonial($offset=0) {
        $query = "select * from testimonial order by dateCreated desc limit 6 offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function getTotalTestimonials() {
        $query = "select count(*) as totalTestimonial from testimonial";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getToDayTestimonial() {
        $toDay = date("Y-m-d");
        $query = "select * from testimonial where date_format(dateCreated,'%Y-%m-%d')='$toDay' order by dateCreated desc";
        return mysqli_query($this->db->conn, $query);
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