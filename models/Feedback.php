<?php

include_once '../db/Db.php';

class Feedback {

    private $name;
    private $email;
    private $content;
    private $db;

    public function __construct() {
        if(!isset($this->db)){
            $this->db = new Db();
        }
    }

    public function addFeedback($name, $email, $content) {
        $senderName=strip_tags($name);
        $senderEmail=strip_tags($email);
        $content=strip_tags($content);
        $query = "INSERT INTO feedback(`sender`, `email`, `content`) VALUES ('$senderName','$senderEmail','$content')";
        return mysqli_query($this->db->conn, $query);
    }

    public function getFeedbacks($offset) {
        $query = "select * from feedback order by dateCreated desc limit 12 offset $offset";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getAllFeedbacks() {
        $query = "select * from feedback order by dateCreated desc";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }
    
    public function removeFeedback($id) {
        $query = "delete from feedback where id='$id'";
        return mysqli_query($this->db->conn, $query);
         
    }
    public function totalFeedback() {
        $query = "select count(*) as totalFeedback from feedback";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }
    public function unReadMessage() {
        $query = "select count(*) as totalFeedback from feedback where seen=0";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }

    public function feedbackSeen() {
        $query = "update feedback set seen='1' where seen='0'";
        return mysqli_query($this->db->conn, $query);
        
    }
}
