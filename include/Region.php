<?php

require_once "Db.php";

class Region {

    private $db;

    public function __construct() {
        if (!isset($this->db) || $this->db == null) {
            $this->db = new Db();
        }
    }

    public function addRegion($name) {
        $msg = '';
        $name = strip_tags($name);
        $newName = filter_var($name, FILTER_SANITIZE_STRING);
        $newName = mysqli_real_escape_string($this->db->conn, $newName);
        //Check if Region exist
        if ($this->checkIfExist($newName) == 0) {
            $query = "INSERT INTO region(`name`) VALUES ('$newName')";
            if (mysqli_query($this->db->conn, $query)) {
                $msg = "Region has been added Successfully";
            } else {
                $msg = "Region has not been Successfully added please try again!";
            }
        } else {
            $msg = "Region already added before!!!";
        }

        return $msg;
    }

    public function checkIfExist($regionName) {
        $query = "select count(*)as total from region where name='$regionName'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getRegionNameById($regionId) {
        $regionId = strip_tags($regionId);
        if (filter_var($regionId, FILTER_VALIDATE_INT)) {
            $query = "select name from region where id='$regionId'";
            $result = mysqli_query($this->db->conn, $query);
            $row = mysqli_fetch_row($result);
            return $row[0];
        }
        return null;
    }

    public function getAllRegions() {
        $query = "select * from region";
        return mysqli_query($this->db->conn, $query);
    }

    public function getTotalRegions() {
        $query = "select count(*) as totalRegions from region";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function removeRegion($regionId) {
        $regionId = strip_tags($regionId);
        if (filter_var($regionId, FILTER_VALIDATE_INT)) {
            $query = "delete from region where id='$regionId'";
            return mysqli_query($this->db->conn, $query);
        }

        return false;
    }

    public function updateRegion($regionId, $regionName) {
        $regionId = strip_tags($regionId);
        $regionName = filter_var($regionName, FILTER_SANITIZE_STRING);
        if (filter_var($regionId, FILTER_VALIDATE_INT)) {
            $query = "update region set name='$regionName' where id='$regionId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

}
