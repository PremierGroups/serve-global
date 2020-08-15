<?php

require_once "Db.php";

class City {

    private $db;

    public function __construct() {
        if (!isset($this->db) || $this->db == null) {
            $this->db = new Db();
        }
    }

    public function addCity($name, $regionId) {
        $msg = '';
        $name = strip_tags($name);
        $newName = filter_var($name, FILTER_SANITIZE_STRING);
        $regionId = strip_tags($regionId);
       // $regionId = filter_var($regionId, FILTER_SANITIZE_INT);
        if (!empty($newName) && filter_var($regionId, FILTER_VALIDATE_INT) ) {
            $newName = mysqli_real_escape_string($this->db->conn, $newName);
            $regionId = mysqli_real_escape_string($this->db->conn, $regionId);
            //Check if Region exist
            if ($this->checkIfExist($newName) == 0) {
                $query = "INSERT INTO city(`name`, `region_id`) VALUES ('$newName', '$regionId')";
                if (mysqli_query($this->db->conn, $query)) {
                    $msg = "City has been added Successfully";
                } else {
                    $msg = "City has not been Successfully added please try again!";
                }
            } else {
                $msg = "City already added before!!!";
            }
        } else {
            $msg = "City Name is not valide";
        }
        return $msg;
    }

    public function checkIfExist($cityName) {
        $query = "select count(*)as total from city where name='$cityName'";
        $region = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($region);
        return $row[0];
    }

    public function getCityNameById($cityId) {
        $cityId = filter_var($cityId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($cityId, FILTER_VALIDATE_INT)) {
            $query = "select name from city where id='$cityId'";
            $Region = mysqli_query($this->db->conn, $query);
            $row = mysqli_fetch_row($Region);
            return $row[0];
        }
        return null;
    }

    public function getAllCities() {
        $query = "select city.*, region.name as regionName from city, region where region_id=region.id";
        return mysqli_query($this->db->conn, $query);
    }
public function getAllCitiesByRegion($regionId) {
        $query = "select * from city where region_id='$regionId'";
        return mysqli_query($this->db->conn, $query);
    }
    public function getTotalCities() {
        $query = "select count(*) as totalCities from city";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function removeCity($cityId) {
        $cityId = strip_tags($cityId);
        if (filter_var($cityId, FILTER_VALIDATE_INT)) {
            $query = "delete from city where id='$cityId'";
            return mysqli_query($this->db->conn, $query);
        }

        return false;
    }
 public function getCitiesHavingMostVolunters($limit) {
        $query = "select city.*, count(user.id) as volunteerCount from city, user where city.id=user.city group by user.city order by volunteerCount desc limit $limit";
        return mysqli_query($this->db->conn, $query);
    }

    public function updateCity($id, $regionId, $cityName) {
        $id = strip_tags($id);
       // $id = filter_var($id, FILTER_SANITIZE_INT);
        $regionId = strip_tags($regionId);
        //$regionId = filter_var($regionId, FILTER_SANITIZE_INT);
        $cityName = strip_tags($cityName);
        $cityName = filter_var($cityName, FILTER_SANITIZE_STRING);
        if (filter_var($regionId, FILTER_VALIDATE_INT) && filter_var($id, FILTER_VALIDATE_INT)) {
            $query = "update city set name='$cityName', region_id='$regionId' where id='$id'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

}
