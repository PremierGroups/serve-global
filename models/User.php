<?php

include_once '../db/Db.php';

class User {

    private $username;
    private $fname;
    private $phoneNo;
    private $lname;
    private $password;
    private $role;
    private $email;
    private $db;

    public function __construct() {
        if(!isset($this->db)){
            $this->db = new Db();
        }
    }

    public function getUserById($userId) {
        if (isset($userId) && $userId != NULL) {
            $sql = "select * from user where id ='$userId'";
            $userProfile = mysqli_query($this->db->conn, $sql);
            return $userProfile;
        }
        return null;
    }
    public function getUserImageById($userId){
        $sql = "select userImage from user where id='$userId'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        $userImage = $row[0];
        return $userImage;
    }
    public function getUserCountryById($userId){
        $sql = "select country from address where userId='$userId'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        $userCountry = $row[0];
        return $userCountry;
    }

    public function updateUser($userId, $fname, $lname, $phoneNo, $email,$userImage) {
        $msg=false;
        try {
            $fname=mysqli_real_escape_string($this->db->conn,$fname);
            $lname=mysqli_real_escape_string($this->db->conn,$lname);
            $email=mysqli_real_escape_string($this->db->conn,$email);
            $phoneNo=mysqli_real_escape_string($this->db->conn,$phoneNo);

            $query = "update user set fname='$fname', lname='$lname', phoneNo='$phoneNo',email='$email',userimage='$userImage' where id='$userId'";
            $msg=mysqli_query($this->db->conn, $query);
        } catch (Exception $ex) {

        }
        return $msg;
    }

    public function getFullnameById($uid) {
        $sql = "select fname,lname from user where id='$uid'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        $fullname = $row[0] . " " . $row[1];
        return $fullname;
    }
    public function getUserEmailById($uid) {
        $sql = "select email from user where id='$uid'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        return $row[0];
    }
   
    public function getFullnameByUsername($username) {
        $sql = "select fname,lname from user where username='$username'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        $fullname = $row[0] . " " . $row[1];
        return $fullname;
    }

    public function getDateCreatedByUsername($username) {
        $sql = "select * from user where username ='$username'";
        $dateC = mysqli_query($this->db->conn, $sql);
        $dateCr = mysqli_fetch_array($dateC);
        $dateCreated = $dateCr['dateCreated'];
        return $dateCreated;
    }

    public function getAcceptedUsers() {
        $sql = "select * from user where role!='admin' and enabled='1'";
        $users = mysqli_query($this->db->conn, $sql);
        return $users;
    }
    public function getBlockedUsers() {
        $sql = "select * from user where role!='admin' and enabled='0'";
        $users = mysqli_query($this->db->conn, $sql);
        return $users;
    }

    public function addUser($fname, $lname, $email, $phoneNo)
    {
        $this->fname=mysqli_real_escape_string($this->db->conn,trim($fname));
        $this->lname=mysqli_real_escape_string($this->db->conn,trim($lname));
        $this->email=mysqli_real_escape_string($this->db->conn,trim($email));
        $this->phoneNo=mysqli_real_escape_string($this->db->conn,trim($phoneNo));
        $role='member';
        $password=$this->getPassword();
        $tmpPass = md5($password);
        $username=$this->getUsername($this->phoneNo, $this->email);
        if($this->checkIfUsernameExists($username)==0){
            if($this->checkIfEmailExists($email)==0){
                $sql = "INSERT INTO user(`username`, `password`, `role`, `fname`, `lname`, `email`, `phoneNo`)VALUES ('$username', '$tmpPass', '$role', '$this->fname', '$this->lname', '$this->email', '$this->phoneNo')";
               if(mysqli_query($this->db->conn, $sql)){
                   return "User Created Successfully.<br/> Please use this login Information to login to the system.<br/> Username: $username<br/> Password: $password <br/>";
               }else{
                   return "User not Created due to Unknown Error!. Please try again.";
               }
            }else{
                return "This Email is used by other guy! Please try another Email";
            }
        }else{
            return "This username is used by other guy! Please try another Username";
        }
    }
    private function getUsername($phoneNo,$email){
        return substr($email,0,5).substr($phoneNo,4,6);
    }
    public function getUsersByRole($role) {
        $this->role = $role;
        $query = "select * from user where role='$this->role'";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    private function getPassword() {
        $length=10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%&()';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function deleteUser($userId) {
        $msg = "Error";
        $deleteSql = "delete from user where id='$userId'";
        $deleteQuery = mysqli_query($this->db->conn, $deleteSql);
        if ($deleteQuery) {
            $msg = 'user deleted!';
        } else {
            $msg = 'user not deleted';
        }
        return $msg;
    }

    public function editUser($username) {
        $editSql = "select * from user where username='$username'";
        $editQuery = mysqli_query($this->db->conn, $editSql);
        return $editQuery;
    }

    public function getUser($id) {
        $editSql = "select * from user where id='$id'";
        $editQuery = mysqli_query($this->db->conn, $editSql);
        return $editQuery;
    }

    public function getUserIdByUsername($username) {
        $sql = "select * from user where username='$username'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        $userId = $row[0];
        return $userId;
    }

    public function changeUserPassword($username, $cPassword, $nPassword) {
        $checkExist = $this->checkPassword($username, $cPassword);
        if ($checkExist) {
            $sPassword = password_hash($nPassword, PASSWORD_BCRYPT,array('cost'=>13));
            $query = "update user set password='$sPassword' where username='$username'";
                return mysqli_query($this->db->conn, $query);          
        }else{
            return false;
        }
    }

    private function checkPassword($username, $cPassword) {
       
        try {
            $query = "select * from user where username='$username'";
            $result = mysqli_query($this->db->conn, $query);
            $count = mysqli_num_rows($result);
            
            if($count>0){
                $row= mysqli_fetch_array($result);
                if(password_verify($cPassword, $row['password'])){
                    return true;
                }
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }
    public function blockUser($userId) {
        try {
            $query = "update user set enabled='0' where id='$userId'";
            mysqli_query($this->db->conn, $query);
        } catch (Exception $ex) {

        }
        return "User Blocked";
    }
    public function acceptUser($userId) {
        try {
            $query = "update user set enabled='1' where id='$userId'";
            mysqli_query($this->db->conn, $query);
        } catch (Exception $ex) {

        }
        return "User Accepted";
    }
    public function forgotPassword($email){

    }
    public function checkIfUsernameExists($username) {
        $sql = "SELECT count(*) FROM user  where username='$username' ";
        $result = mysqli_query($this->db->conn, $sql);
        $count=  mysqli_fetch_array($result);
        return $count[0];
    }
    public function checkIfEmailExists($email) {
        $sql = "SELECT count(*) FROM user  where email='$email' ";
        $result = mysqli_query($this->db->conn, $sql);
        $count=  mysqli_fetch_array($result);
        return $count[0];
    }
public function getTotalEmployees(){
        $query = "select count(*) as total from user where role='employee' and enabled='1'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }
}
