<?php

require_once "Db.php";

class Zone {

    private $db;

    public function __construct() {
        if (!isset($this->db) || $this->db == null) {
            $this->db = new Db();
        }
    }

    public function addZone($name, $regionId) {
        $msg = '';
        $newName = filter_var($name, FILTER_SANITIZE_STRING);
        $regionId = strip_tags($regionId);
        //$regionId = filter_var($regionId, FILTER_SANITIZE_INT);
        if (!empty($newName) && filter_var($regionId, FILTER_VALIDATE_INT)) {
            $newName = mysqli_real_escape_string($this->db->conn, $newName);
            $regionId = mysqli_real_escape_string($this->db->conn, $regionId);
            //Check if Region exist
            if ($this->checkIfExist($newName) == 0) {
                $query = "INSERT INTO subcity(`name`, `region_id`) VALUES ('$newName', '$regionId')";
                if (mysqli_query($this->db->conn, $query)) {
                    $msg = "Subcity has been added Successfully";
                } else {
                    $msg = "Subcity has not been Successfully added please try again!";
                }
            } else {
                $msg = "Subcity already added before!!!";
            }
        } else {
            $msg = "Subcity Name is not valide";
        }
        return $msg;
    }

    public function checkIfExist($zoneName) {

        $query = "select count(*)as total from subcity where name='$zoneName'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getZonesHavingMostVolunters($limit) {
        $query = "select subcity.*, count(user.id) as volunteerCount from subcity, user where subcity.id=user.zone group by user.zone order by volunteerCount desc limit $limit";
        return mysqli_query($this->db->conn, $query);
    }

    public function getZoneNameById($zoneId) {
        $zoneId = strip_tags($zoneId);
        $zoneId = mysqli_real_escape_string($this->db->conn, $zoneId);
        if (filter_var($zoneId, FILTER_VALIDATE_INT)) {
            $query = "select name from subcity where id='$zoneId'";
            $result = mysqli_query($this->db->conn, $query);
            $row = mysqli_fetch_row($result);
            return $row[0];
        }
        return null;
    }

    public function getAllZones() {
        $query = "select subcity.*, region.name as regionName from subcity, region where region_id=region.id";
        return mysqli_query($this->db->conn, $query);
    }

    public function getAllZonesByRegion($regionId) {
        $regionId = strip_tags($regionId);
        $regionId = mysqli_real_escape_string($this->db->conn, $regionId);
        $query = "select * from subcity where region_id='$regionId'";
        return mysqli_query($this->db->conn, $query);
    }

    public function getTotalZones() {
        $query = "select count(*) as totalZones from subcity";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function removeZone($zoneId) {
        $zoneId = strip_tags($zoneId);
        $zoneId = mysqli_real_escape_string($this->db->conn, $zoneId);
        //   $zoneId = filter_var($zoneId, FILTER_SANITIZE_INT);
        if (filter_var($zoneId, FILTER_VALIDATE_INT)) {
            $query = "delete from subcity where id='$zoneId'";
            return mysqli_query($this->db->conn, $query);
        }

        return false;
    }

    public function updateZone($id, $regionId, $zoneName) {
        $id = strip_tags($id);
        $regionId = strip_tags($regionId);
        $cityName = filter_var($cityName, FILTER_SANITIZE_STRING);
        $cityName = mysqli_real_escape_string($this->db->conn, $cityName);
        $regionId = mysqli_real_escape_string($this->db->conn, $regionId);
        $id = mysqli_real_escape_string($this->db->conn, $id);
        if (filter_var($regionId, FILTER_VALIDATE_INT) && filter_var($id, FILTER_VALIDATE_INT)) {
            $query = "update subcity set name='$zoneName', region_id='$regionId' where id='$id'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

}
