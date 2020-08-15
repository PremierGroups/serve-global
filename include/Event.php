<?php

/**
 * Created by PhpStorm.
 * User: Aemiro
 * Date: 1/5/2019
 * Time: 10:53 PM
 */
include_once 'Db.php';

class Event {

    private $db;

    public function __construct() {
        if (!isset($this->db->conn)) {
            $this->db = new Db();
        }
    }
 public function getEventBySlug($slug) {
        $slug= filter_var($slug, FILTER_SANITIZE_STRING);
        $slug = mysqli_real_escape_string($this->db->conn, $slug);
        $query = "select * from events where slug='$slug'";
        return mysqli_query($this->db->conn, $query);
    }

    public function createEvent($title, $location, $description, $dueDate, $coverImage, $category, $slug) {
        $query = "INSERT INTO events(`title`,`location`,`description`,`coverImage`,`dueDate`,`category_id`,`slug`) "
                . "VALUES ('$title','$location','$description','$coverImage','$dueDate','$category', '$slug')";
        return mysqli_query($this->db->conn, $query);
    }

    public function updateEvent($id, $title, $location, $description, $dueDate, $coverImage, $category) {
        $query = "update events set title='$title',coverImage='$coverImage',location='$location',description='$description',dueDate='$dueDate',category_id='$category' WHERE id='$id'";
        return mysqli_query($this->db->conn, $query);
    }

    public function deleteEvent($id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (is_numeric($id)) {
            $eventId = (int) $id;
            $query = "delete from events where id='$eventId'";
            return mysqli_query($this->db->conn, $query);
        }

        return false;
    }

    public function getAllActiveEvents() {
        $query = "select * from events where dueDate>=NOW() ORDER BY dueDate DESC";
        return mysqli_query($this->db->conn, $query);
    }

    public function getAllCompletedEvents() {
        $query = "select * from events where dueDate<NOW() ORDER BY dueDate ASC";
        return mysqli_query($this->db->conn, $query);
    }

    public function getEventById($id) {
        if (isset($id)) {
            if (is_numeric($id)) {
                $eventId = (int) $id;
                $query = "select * from events where id='$eventId'";
                return mysqli_query($this->db->conn, $query);
            }
        }
        return null;
    }

    public function getTotalActiveEvents() {
        $query = "select count(*) as total from events where dueDate>=NOW()";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getTotalEvents() {
        $query = "select count(*) as total from events";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getEvents($limit = 15, $offset = 0) {
        $query = "select * from events ORDER BY dueDate ASC limit $offset, $limit";
        return mysqli_query($this->db->conn, $query);
    }

    public function getLatestEvents($limit = 5, $offset = 0) {
        $query = "select * from events where dueDate>=NOW() ORDER BY dueDate ASC limit $offset, $limit";
        return mysqli_query($this->db->conn, $query);
    }

    public function getLastActiveEvent() {
        $query = "select id,dueDate,title,dateCreated,coverImage from events where dueDate>=NOW() ORDER BY dueDate ASC limit 1";
        return mysqli_query($this->db->conn, $query);
    }

    public function searchEvents($keyword, $limit = 5, $offset = 0) {
        if (isset($keyword)) {
            $keyword = strip_tags($keyword);
            $keyword = mysqli_real_escape_string($this->db->conn, $keyword);
            $query = "select * from events where title like '%" . $keyword . "%' order by dateCreated desc limit $limit offset $offset";
            return mysqli_query($this->db->conn, $query);
        }
        return NULL;
    }

    public function addEventComment($eventId, $name, $email, $comment, $parentId = 0) {
        $eventId = filter_var($eventId, FILTER_SANITIZE_NUMBER_INT);
        $name = strip_tags($name);
        $email = strip_tags($email);
        $comment = strip_tags($comment);
        $name = stripcslashes($name);
        $email = stripcslashes($email);
        $comment = stripcslashes($comment);
        $name = mysqli_real_escape_string($this->db->conn, $name);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $comment = mysqli_real_escape_string($this->db->conn, $comment);
        if (!empty($eventId) && is_numeric($eventId)) {
            $query = "INSERT INTO event_comment(`eventId`, `name`, `email`, `parentId`, `comment`) VALUES ('$eventId','$name','$email','$parentId','$comment')";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function replyEventComment($eventId, $name, $email, $comment, $parentId = 0) {
        $eventId = filter_var($eventId, FILTER_SANITIZE_NUMBER_INT);
        $name = strip_tags($name);
        $email = strip_tags($email);
        $comment = strip_tags($comment);
        $name = stripcslashes($name);
        $email = stripcslashes($email);
        $comment = stripcslashes($comment);
        $name = mysqli_real_escape_string($this->db->conn, $name);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $comment = mysqli_real_escape_string($this->db->conn, $comment);
        if (!empty($eventId) && is_numeric($eventId)) {
            $query = "INSERT INTO event_comment(`eventId`, `name`, `email`, `parentId`, `comment`) VALUES ('$eventId','$name','$email','$parentId','$comment')";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function getEventComment($eventId) {
        $query = "select * from event_comment where eventId='$eventId' and parentId=0";
        return mysqli_query($this->db->conn, $query);
    }

    public function getEventCommentReply($commentId) {
        $query = "select * from event_comment where parentId='$commentId'";
        return mysqli_query($this->db->conn, $query);
    }

    public function getCommentCountForEvent($eventId) {
        $query = "select count(*) as totalEventComment from event_comment where eventId='$eventId'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getTotalEventsInApartner($partnerId) {
        $partnerId = filter_var($partnerId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($partnerId, FILTER_VALIDATE_INT)) {
            $query = "select count(*) as total from events where partner_id='$partnerId'";
            $result = mysqli_query($this->db->conn, $query);
            $row = mysqli_fetch_row($result);
            return $row[0];
        }
        return 0;
    }
     public function checkIfSlugExist($slugName) {
        $query = "select count(*)as total from events where slug='$slugName'";
        $slugCount = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($slugCount);
        return $row[0];
    }

}
