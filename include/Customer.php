<?php

/**
 * @author Aemiro Mekete <aemiromekete12@gmail.com at http://vintechplc.com>
 */
include_once 'Db.php';

class Customer {

    private $db;

    public function __construct() {
        if (!isset($this->db)) {
            $this->db = new Db();
        }
    }

    public function addCustomer($customer_id, $name, $email, $country="Ethiopia") {
        $name = mysqli_real_escape_string($this->db->conn, trim($name));
        $email = mysqli_real_escape_string($this->db->conn, trim($email));
        $country = mysqli_real_escape_string($this->db->conn, trim($country));
        $customer_id = mysqli_real_escape_string($this->db->conn, trim($customer_id));
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = "INSERT INTO customer(`customer_id`, `name`, `email`,`country`) "
                    . "VALUES ('$customer_id','$name', '$email', '$country')";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function checkIfEmailExists($email) {
        $email= filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = mysqli_real_escape_string($this->db->conn, trim($email));
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT count(*) FROM customer  where email='$email'";
            $result = mysqli_query($this->db->conn, $sql);
            $count = mysqli_fetch_array($result);
            return $count[0];
        }
        return 0;
    }

    public function checkIfCustomerIdExists($customer_id) {
        $customer_id= filter_var($customer_id, FILTER_SANITIZE_STRING);
        $customer_id = $name = mysqli_real_escape_string($this->db->conn, trim($customer_id));
        $sql = "SELECT count(*) FROM customer  where customer_id='$customer_id' ";
        $result = mysqli_query($this->db->conn, $sql);
        $count = mysqli_fetch_array($result);
        return $count[0];
    }

}
