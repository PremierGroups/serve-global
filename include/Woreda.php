<?php

require_once "Db.php";

class Woreda {

    private $db;

    public function __construct() {
        if (!isset($this->db) || $this->db == null) {
            $this->db = new Db();
        }
    }

    public function addWoreda($name, $zoneId, $regionId) {
        $msg = '';
        $newName = filter_var($name, FILTER_SANITIZE_STRING);
        $regionId = strip_tags($regionId);
        $zoneId = strip_tags($zoneId);
        if (!empty($newName) && filter_var($zoneId, FILTER_VALIDATE_INT) ) {
            $newName = mysqli_real_escape_string($this->db->conn, $newName);
            $regionId = mysqli_real_escape_string($this->db->conn, $regionId);
            $zoneId = mysqli_real_escape_string($this->db->conn, $zoneId);
            //Check if Region exist
            if ($this->checkIfExist($newName) == 0) {
                $query = "INSERT INTO woreda(`name`, `region_id`,`sub_city`) VALUES ('$newName', '$regionId', '$zoneId')";
                if (mysqli_query($this->db->conn, $query)) {
                    $msg = "Woreda has been added Successfully";
                } else {
                    $msg = "Woreda has not been Successfully added please try again!";
                }
            } else {
                $msg = "Woreda already added before!!!";
            }
        } else {
            $msg = "Woreda name is not valide";
        }
        return $msg;
    }

    public function checkIfExist($name) {
        $query = "select count(*)as total from woreda where name='$name'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getWoredaNameById($id) {
        $id = strip_tags($id);
        $id = mysqli_real_escape_string($this->db->conn, $id);
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $query = "select name from woreda where id='$id'";
            $result = mysqli_query($this->db->conn, $query);
            $row = mysqli_fetch_row($result);
            return $row[0];
        }
        return null;
    }
  public function getAllWoredas() {
        $query = "select woreda.*, subcity.name as zoneName from subcity, woreda where sub_city=subcity.id";
        return mysqli_query($this->db->conn, $query);
    }
   
public function getAllWoredasByZone($zoneId) {
    $zoneId= strip_tags($zoneId);
    $zoneId = mysqli_real_escape_string($this->db->conn, $zoneId);
        $query = "select * from woreda where sub_city='$zoneId'";
        return mysqli_query($this->db->conn, $query);
    }
    public function getTotalWoredas() {
        $query = "select count(*) as total from woreda";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function removeWoreda($id) {
        $id = strip_tags($id);
        $id = mysqli_real_escape_string($this->db->conn, $id);
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $query = "delete from woreda where id='$id'";
            return mysqli_query($this->db->conn, $query);
        }

        return false;
    }
 public function getWordasHavingMostVolunters($limit) {
        $query = "select woreda.*, count(user.id) as volunteerCount from woreda, user where woreda.id=user.woreda group by user.woreda order by volunteerCount desc limit $limit";
        return mysqli_query($this->db->conn, $query);
    }
    public function updateWoreda($id, $regionId, $zoneId, $name) {
        $id = strip_tags($id);
        $regionId = strip_tags($regionId);
        $zoneId = strip_tags($zoneId);
        $id = mysqli_real_escape_string($this->db->conn, $id);
        $zoneId = mysqli_real_escape_string($this->db->conn, $zoneId);
        $regionId = mysqli_real_escape_string($this->db->conn, $regionId);
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $name = mysqli_real_escape_string($this->db->conn, $name);
        if (filter_var($zoneId, FILTER_VALIDATE_INT) && filter_var($id, FILTER_VALIDATE_INT)) {
            $query = "update woreda set sub_city='$zoneId', region_id='$regionId', name='$name' where id='$id'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

}
