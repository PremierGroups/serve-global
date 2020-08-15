<?php

/**
 * Description of Subscriber
 *
 * @author Aemiro Mekete <aemiromekete12@gmail.com at http://vintechplc.com>
 */
include_once "Db.php";

class Subscriber {

    private $db;

    public function __construct() {
        if (!isset($this->db)) {
            $this->db = new Db();
        }
    }

    public function addSubscriber($email) {

        $email = strip_tags($email);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
            if ($this->checkIfEmailExists($email) == 0) {
                $query = "INSERT INTO subscriber(`email`)"
                        . " VALUES ('$email')";
                if (mysqli_query($this->db->conn, $query)) {
                    return "Thank You For Your Subscription";
                } else {
                    return "Not Subscribed!";
                    //return $query;
                }
            } else {
                return "You have already Subscribed Before!";
            }
        } else {
            return "Please Enter Correct Email Format!";
        }
    }

    public function getAllSubscribers() {
        $query = "select * from subscriber where status='active' order by dateCreated DESC ";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getAllSubscribersByOffset($limit = 8, $offset = 0) {
        $query = "select * from subscriber  order by dateCreated desc limit $limit offset $offset";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getSubscriberById($subscriberId) {
        $query = "select * from subscriber where id='$subscriberId'";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function unsubscribe($email) {
        $email = strip_tags($email);
        $email = mysqli_real_escape_string($this->db->conn,$email);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)==true) {
            $query = "delete from subscriber where email='$email'";
            mysqli_query($this->db->conn, $query);
            if (mysqli_query($this->db->conn, $query)) {
                return "You have been Successfully Unsubscibed!";
            } else {
                return "This Operation Failed due to unknown errors!";
            }
        } else {
            return "This Operation Failed due to unknown errorss!";
        }
    }

    public function getTotalSubscriber() {
        $query = "select count(*) as total from subscriber where status='active'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getTodayTotalSubscriber() {
        $toDay = date("Y-m-d");
        $query = "select count(*) as total from subscriber where date_format(dateCreated,'%Y-%m-%d')='$toDay'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getTodayTotalUnSubscriber() {
        $toDay = date("Y-m-d");
        $query = "select count(*) as total from subscriber where date_format(lastUpdated,'%Y-%m-%d')='$toDay' and status='disabled'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
    public function checkIfEmailExists($email) {
        $sql = "SELECT count(*) FROM subscriber  where email='$email' ";
        $result = mysqli_query($this->db->conn, $sql);
        $count = mysqli_fetch_array($result);
        return $count[0];
    }

}
