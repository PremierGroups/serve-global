<?php
/**
 * @author Aemiro Mekete <aemiromekete12@gmail.com at http://vintechplc.com>
 */
include_once 'Db.php';

class Donate {

    private $db;

    public function __construct() {
        if (!isset($this->db)) {
            $this->db = new Db();
        }
    }

    public function getDonation($limit = 30, $offset = 0) {
        $sql = "select donation.*, name, email, country from customer, donation where customer.customer_id=donation.customer_id ORDER BY date_created DESC limit $offset, $limit";
        return mysqli_query($this->db->conn, $sql);
    }
     public function getPublicDonation($limit = 30, $offset = 0) {
        $sql = "select donation.*, name, email, country from donation,customer where customer.customer_id=donation.customer_id and anonymous=0 ORDER BY donation.date_created DESC limit $offset, $limit";
        return mysqli_query($this->db->conn, $sql);
    }
    public function getDonationByCustomer($customer_id, $limit = 30, $offset = 0) {
        $sql = "select * from donation where customer_id='$customer_id' ORDER BY date_created DESC limit $offset, $limit";
        return mysqli_query($this->db->conn, $sql);
    }
    public function addDonation($customer_id, $amount, $status="pending", $description="", $anonymous=0) {
        $customer_id = mysqli_real_escape_string($this->db->conn, $customer_id);
        $description = mysqli_real_escape_string($this->db->conn, $description);
        $amount = mysqli_real_escape_string($this->db->conn, $amount);
        $query = "INSERT INTO donation(`customer_id`, `description`, `amount`, `status`, `anonymous`) "
                . "VALUES ('$customer_id', '$description','$amount', '$status', '$anonymous')";
        return mysqli_query($this->db->conn, $query);
          
    }

    public function getTotalUserDonationByCustomer($customer_id) {
        $query = "select count(*) as total from donation where customer_id='$customer_id'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
    public function getTotalUserDonation() {
        $query = "select count(*) as total from donation";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
}
