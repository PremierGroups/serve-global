<?php

include_once 'Db.php';

class Feedback
{

    private $senderName;
    private $senderEmail;
    private $dateCreated;
    private $content;
    private $db;

    public function __construct()
    {
        if (!isset($this->db)) {
            $this->db = new Db();
        }
    }

    public function addFeedback($senderName, $senderEmail, $content, $subject = "")
    {
        $senderName = mysqli_real_escape_string($this->db->conn, $senderName);
        $senderEmail = mysqli_real_escape_string($this->db->conn, $senderEmail);
        $content = mysqli_real_escape_string($this->db->conn, $content);
        $subject = mysqli_real_escape_string($this->db->conn, $subject);
        $query = "INSERT INTO feedback(`sender`, `email`, `subject`, `content`) VALUES ('$senderName','$senderEmail','$subject','$content')";
        return mysqli_query($this->db->conn, $query);
    }

    public function getFeedbacks($limit = 10, $offset = 0)
    {
        $query = "select * from feedback order by dateCreated desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }
    public function getFeedbackById($id)
    {
        $query = "select * from feedback where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
    public function addAnswer($feedbackId, $answer)
    {
        $id = filter_var($feedbackId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($id, FILTER_VALIDATE_INT) === 0 || !filter_var($id, FILTER_VALIDATE_INT) === false) {
            $ans = mysqli_real_escape_string($this->db->conn, $answer);
            $query = "update feedback set answer='$ans' where id='$id'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }
    public function getTotalFeedbacks()
    {
        $query = "select count(*) as totalFeedback from feedback";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getTotalFeedbacksHavingAns()
    {
        $query = "select count(*) as totalFeedback from feedback where answer !=''";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getFAQ($limit = 10, $offset = 0)
    {
        $query = "select * from feedback where answer !='' order by dateCreated desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function getSenderName()
    {
        return $this->senderName;
    }

    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }

    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
    }

    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getToDayFeedback()
    {
        $toDay = date("Y-m-d");
        $query = "select * from feedback where date_format(dateCreated,'%Y-%m-%d')='$toDay' order by dateCreated desc";
        return mysqli_query($this->db->conn, $query);
    }

    public function removeFeedback($id)
    {
        $query = "delete from feedback where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
}
