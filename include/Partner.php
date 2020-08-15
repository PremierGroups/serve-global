<?php

/**
 * Description of Partner
 *
 * @author Aemiro Mekete <aemiromekete12@gmail.com at http://vintechplc.com>
 */
require_once 'Db.php';

class Partner {

    private $db;

    public function __construct() {
        if (!isset($this->db) || $this->db == null) {
            $this->db = new Db();
        }
    }

    public function checkIfSlugExist($slugName) {
        $query = "select count(*)as total from partner where slug='$slugName'";
        $slugCount = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($slugCount);
        return $row[0];
    }

    public function generateSlug() {
        $length = 16;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString . "-" . date('h-i-s');
    }

    public function addPartner($name, $slug, $email, $phone1, $country, $website = "", $parent_id = "", $region = "", $city = "", $can_create = 0) {
        $msg = '';
        $newName = filter_var($name, FILTER_SANITIZE_STRING);
        $newName = mysqli_real_escape_string($this->db->conn, $newName);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $phone1 = filter_var($phone1, FILTER_SANITIZE_STRING);
        $phone1 = mysqli_real_escape_string($this->db->conn, $phone1);
        $country = filter_var($country, FILTER_SANITIZE_STRING);
        $country = mysqli_real_escape_string($this->db->conn, $country);
        $city = filter_var($city, FILTER_SANITIZE_STRING);
        $city = mysqli_real_escape_string($this->db->conn, $city);
        $website = filter_var($website, FILTER_SANITIZE_URL);
        $website = mysqli_real_escape_string($this->db->conn, $website);
        //Check if Partner exist
        if ($this->checkIfExist($newName) == 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = "INSERT INTO partner(`name`, `slug`, `email`, `phone1`, `website`, `parent_id`, `city`, `country`,`region`,`can_create`)"
                    . " VALUES ('$newName','$slug','$email','$phone1','$website','$parent_id','$city','$country','$region', '$can_create')";
            if (mysqli_query($this->db->conn, $query)) {
                $msg = "Partner has been added Successfully";
            } else {
                $msg = "Partner has not been Successfully added please try again!";
            }
        } else {
            $msg = "Partner already added before!!!";
        }

        return $msg;
    }

    public function checkIfExist($name) {
        $query = "select count(*)as total from partner where name='$$name'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function updatePartner($id, $name, $email, $phone1, $country, $website = "", $parent_id = "", $region = "", $city = "", $can_create = 0) {
        $msg = '';
        $partnerId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($partnerId, FILTER_VALIDATE_INT)) {
            $newName = filter_var($name, FILTER_SANITIZE_STRING);
            $newName = mysqli_real_escape_string($this->db->conn, $newName);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = mysqli_real_escape_string($this->db->conn, $email);
            $phone1 = filter_var($phone1, FILTER_SANITIZE_STRING);
            $phone1 = mysqli_real_escape_string($this->db->conn, $phone1);
            $country = filter_var($country, FILTER_SANITIZE_STRING);
            $country = mysqli_real_escape_string($this->db->conn, $country);
            $city = filter_var($city, FILTER_SANITIZE_STRING);
            $city = mysqli_real_escape_string($this->db->conn, $city);
            $website = filter_var($website, FILTER_SANITIZE_URL);
            $website = mysqli_real_escape_string($this->db->conn, $website);
            //Check if Partner exist
            if ($this->checkIfExist($newName) == 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $query="UPDATE `partner` SET `name`='$name',`email`='$email',`phone1`='$phone1', `website`='$website',`parent_id`='$parent_id',`city`='$city',`region`='$region',`country`='$country',`can_create`='$can_create' WHERE id='$partnerId'";
                if (mysqli_query($this->db->conn, $query)) {
                    $msg = "Partner has been updated Successfully";
                } else {
                    $msg = "Partner has not been updated please try again!";
                }
            } else {
                $msg = "Partner name already taken before!!!";
            }
        } else {
            $msg = "Invalide Parameter. Please try agai !";
        }

        return $msg;
    }

    public function getAllPartners($limit = 10, $offset = 0) {
        $query = "select * from partner order by date_created desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function deletePartner($id) {
        $partnerId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($partnerId, FILTER_VALIDATE_INT)) {
            $query = "delete from partner where id='$partnerId'";
            return mysqli_query($this->db->conn, $query);
        }

        return false;
    }

    public function getChildPartners($parentId) {
        $partnerId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($partnerId, FILTER_VALIDATE_INT)) {
            $query = "select * from partner where parent_id='$partnerId'";
            return mysqli_query($this->db->conn, $query);
        }
        return null;
    }

    public function getPartnerById($id) {
        $partnerId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($partnerId, FILTER_VALIDATE_INT)) {
            $query = "select * from partner where id='$partnerId'";
            return mysqli_query($this->db->conn, $query);
        }
        return null;
    }

    public function getPartnerBySlug($slug) {
        
    }

    public function getPartnerByAdmin($userId) {
        
    }

    public function getPartnerAdmin($id) {
        
    }

    public function activatePartner($partnerId) {
        $partnerId = filter_var($partnerId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($partnerId, FILTER_VALIDATE_INT)) {
            $query = "update partner set enabled=1 where id='$partnerId' or parent_id='$partnerId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function deactivatePartner($partnerId) {
        $partnerId = filter_var($partnerId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($partnerId, FILTER_VALIDATE_INT)) {
            $query = "update partner set enabled=0 where id='$partnerId' or parent_id='$partnerId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function getTotalChildsInApartner($partnerId) {
        $partnerId = filter_var($partnerId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($partnerId, FILTER_VALIDATE_INT)) {
            $query = "select count(*) as total from partner where parent_id='$partnerId'";
            $result = mysqli_query($this->db->conn, $query);
            $row = mysqli_fetch_row($result);
            return $row[0];
        }
        return 0;
    }

}
