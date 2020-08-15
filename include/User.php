<?php

include_once 'Db.php';

class User {

    private $fname;
    private $phoneNo;
    private $password;
    private $role;
    private $email;
    private $db;

    public function __construct() {
        if (!isset($this->db)) {
            $this->db = new Db();
        }
    }

    public function getUserIdByUsername($username) {
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $query = "select id from user where username='$username'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getWorldWideUsers() {
        $query = "select country, count(id) as userCount from user where role='volunteer' and enabled=1 group by country";
        return mysqli_query($this->db->conn, $query);
    }

    public function getUserByUsername($username) {
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $query = "select * from user where username='$username'";
        return mysqli_query($this->db->conn, $query);
    }

    public function getUserByEmail($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = "select * from user where email='$email'";
            return mysqli_query($this->db->conn, $query);
        }
        return "";
    }

    public function getVolunteersBySex($fromDate, $toDate, $sex = "") {
        $sex=filter_var($sex, FILTER_SANITIZE_STRING);
        $sex = mysqli_real_escape_string($this->db->conn, $sex);
        if (empty(trim($sex))) {
            $query = "select * from user where date_format(date_created,'%Y-%m-%d')>='$fromDate' and date_format(date_created,'%Y-%m-%d')<='$toDate' and role='volunteer' and enabled=1";
        } else {
            $query = "select * from user where date_format(date_created,'%Y-%m-%d')>='$fromDate' and date_format(date_created,'%Y-%m-%d')<='$toDate' and role='volunteer' and enabled=1 and sex='$sex'";
        }
        return mysqli_query($this->db->conn, $query);
    }

    public function getVolunteersByCountry($country = "", $sex = "") {
       
        $country = strip_tags($country);
        $country=stripcslashes($country);
        //$country = mysqli_($this->db->conn, $country);
        $sex = filter_var($sex, FILTER_SANITIZE_STRING);
        $sex = mysqli_real_escape_string($this->db->conn, $sex);
        if (empty(trim($sex)) && empty(trim($country))) {
            $query = "select * from user where role='volunteer' and enabled=1";
        } elseif (empty(trim($sex)) && !empty(trim($country))) {
            $query = "select * from user where country in ('$country') and  role='volunteer' and enabled='1'";
        } elseif (!empty(trim($sex)) && empty(trim($country))) {
            $query = "select * from user where sex='$sex' and  role='volunteer' and enabled='1'";
        } else {
            $query = "select * from user where country in('$country') and  role='volunteer' and enabled='1' and sex='$sex'";
        }
        return mysqli_query($this->db->conn, $query);
    }

    public function groupVolunteersBySex() {
        $query = "select sex, count(id) as volunteerCount from user where role='volunteer' and enabled='1' group by sex";
        return mysqli_query($this->db->conn, $query);
    }

    public function getVolunteersByAge($minAge="", $maxAge = "", $sex = "") {
        $minAge=filter_var($minAge, FILTER_SANITIZE_STRING);
        $maxAge=filter_var($maxAge, FILTER_SANITIZE_STRING);
        $sex=filter_var($sex, FILTER_SANITIZE_STRING);
        $sex = mysqli_real_escape_string($this->db->conn, $sex);
        $maxAge = mysqli_real_escape_string($this->db->conn, $maxAge);
        $minAge = mysqli_real_escape_string($this->db->conn, $minAge);
        $curYear=date("Y");
        $query="select * from user where role='volunteer' and enabled='1' ";
        if(!empty(trim($minAge)) && is_numeric($minAge)){
            $query.="and $curYear-date_format(birth_date, '%Y')>='$minAge' ";
        }
        if(!empty(trim($maxAge)) && is_numeric($maxAge)){
            $query.="and $curYear-date_format(birth_date, '%Y')<='$maxAge' ";
        }
        if(!empty(trim($sex))){
            $query.="and sex='$sex' ";
        }
        
      //  $query="select * from user where $curYear-date_format(birth_date, '%Y')>='$minAge' and $curYear-date_format(birth_date, '%Y')<='$maxAge' and sex='$sex' ";
      // echo $query;
        
        return mysqli_query($this->db->conn, $query);
//        if (empty(trim($age))) {
//            $query = "select * from user where date_format(date_created,'%Y-%m-%d')>='$fromDate' and date_format(date_created,'%Y-%m-%d')<='$toDate' and role='volunteer' and enabled=1";
//        } else {
//            $query = "select * from user where date_format(date_created,'%Y-%m-%d')>='$fromDate' and date_format(date_created,'%Y-%m-%d')<='$toDate' and role='volunteer' and enabled=1 and sex='$sex'";
//        }
    }

    public function getUserById($userId) {
        $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($userId, FILTER_VALIDATE_INT)) {
            $sql = "select * from user where id ='$userId'";
            return mysqli_query($this->db->conn, $sql);
        }
        return null;
    }

    public function getUserStatics() {
        $query = "select fname, count(userId) as blogCount from blog, user where user.id=userId group by userId";
        return mysqli_query($this->db->conn, $query);
    }

    public function getTotalVolunteers() {
        $query = "select count(*) as total from user where role='volunteer' and enabled=1";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getTotalForeignVolunteers() {
        $query = "select count(*) as total from user where country !='Ethiopia' and role='volunteer' and enabled=1";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getActiveVolunteers($limit = 6, $offset = 0) {
        $query = "select * from user where role='volunteer' and enabled='1' order by date_created desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function getUserImageById($userId) {
        $sql = "select userImage from user where id='$userId'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        return $row[0];
    }

    public function getUserCountryById($userId) {
        $sql = "select country from address where userId='$userId'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        $userCountry = $row[0];
        return $userCountry;
    }

//$userId, $fname, $tel, $email,$coverImage
    public function updateUser($userId, $fname, $mname, $phoneNo, $email, $sex, $country, $lname = "", $region = "", $city = "", $zone = "", $woreda = "", $userImage = "", $supportBy = "", $birth_date = "") {
       $userId=filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
       if(filter_var($userId, FILTER_VALIDATE_INT)){
        $fname = mysqli_real_escape_string($this->db->conn, $fname);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $phoneNo = mysqli_real_escape_string($this->db->conn, $phoneNo);
        $mname = mysqli_real_escape_string($this->db->conn, $mname);
        $sex = mysqli_real_escape_string($this->db->conn, $sex);
        $country = mysqli_real_escape_string($this->db->conn, $country);
        //
        $lname = mysqli_real_escape_string($this->db->conn, $lname);
        $region = mysqli_real_escape_string($this->db->conn, $region);
        $city = mysqli_real_escape_string($this->db->conn, $city);
        $zone = mysqli_real_escape_string($this->db->conn, $zone);
        $woreda = mysqli_real_escape_string($this->db->conn, $woreda);
        $userImage = mysqli_real_escape_string($this->db->conn, $userImage);
        $supportBy = mysqli_real_escape_string($this->db->conn, $supportBy);
        $birth_date = mysqli_real_escape_string($this->db->conn, $birth_date);  
       
        $sql = "UPDATE user SET `fname`='$fname',`mname`='$mname',`lname`='$lname',`email`='$email',`phone`='$phoneNo',`profile_image`='$userImage',`sex`='$sex',`birth_date`='$birth_date', `country`='$country',`region`='$region',`zone`='$zone',`woreda`='$woreda',`city`='$city',`career`='',`support_by`='$supportBy' WHERE id='$userId'";
        return mysqli_query($this->db->conn, $sql);
       }
       return false;
        
    }
    public function addVolunteer($fname, $mname, $phoneNo, $email, $username, $password, $sex, $country, $lname = "", $region = "", $city = "", $zone = "", $woreda = "", $userImage = "", $supportBy = "", $birth_date = "") {
        $email=filter_var($email, FILTER_SANITIZE_EMAIL);
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
         $fname = mysqli_real_escape_string($this->db->conn, $fname);
         $email = mysqli_real_escape_string($this->db->conn, $email);
         $phoneNo = mysqli_real_escape_string($this->db->conn, $phoneNo);
         $mname = mysqli_real_escape_string($this->db->conn, $mname);
         $sex = mysqli_real_escape_string($this->db->conn, $sex);
         $country = mysqli_real_escape_string($this->db->conn, $country);
         //
         $lname = mysqli_real_escape_string($this->db->conn, $lname);
         $region = mysqli_real_escape_string($this->db->conn, $region);
         $city = mysqli_real_escape_string($this->db->conn, $city);
         $zone = mysqli_real_escape_string($this->db->conn, $zone);
         $woreda = mysqli_real_escape_string($this->db->conn, $woreda);
         $userImage = mysqli_real_escape_string($this->db->conn, $userImage);
         $supportBy = mysqli_real_escape_string($this->db->conn, $supportBy);
         $birth_date = mysqli_real_escape_string($this->db->conn, $birth_date);  
         $tmpPass = password_hash($password, PASSWORD_BCRYPT, array('cost' => 13));
         $username = mysqli_real_escape_string($this->db->conn, $username);
         $query="INSERT INTO user(`fname`, `mname`, `lname`, `username`, `email`, `phone`, `profile_image`, `sex`, `birth_date`, `password`, `country`, `region`, `zone`, `woreda`, `city`, `support_by`)"
         ." VALUES ('$fname', '$mname', '$lname', '$username','$email', '$phoneNo','$userImage','$sex','$birth_date','$tmpPass','$country','$region','$zone','$woreda','$city','$supportBy')";
        // echo $query;
        // exit(1); 
         return mysqli_query($this->db->conn, $query);
        }
        return false;
         
     }
    public function getFullnameById($uid) {
        $sql = "select fname from user where id='$uid'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        return $row[0];
    }

    public function getUserEmailById($uid) {
        $uid = mysqli_real_escape_string($this->db->conn, $uid);
        $sql = "select email from user where id='$uid'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        return $row[0];
    }

    public function getUserSexById($userId) {
        $userId = mysqli_real_escape_string($this->db->conn, $userId);
        $sql = "select sex from user where id='$userId'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        return $row[0];
    }

    public function getDateCreatedByEmail($email) {
        $sql = "select * from user where email ='$email'";
        $dateC = mysqli_query($this->db->conn, $sql);
        $dateCr = mysqli_fetch_array($dateC);
        return $dateCr['dateCreated'];
    }

    public function getAcceptedUsers() {
        $sql = "select * from user where role='admin' and enabled='1'";
        return mysqli_query($this->db->conn, $sql);
    }

    public function getBlockedUsers() {
        $sql = "select * from user where role='admin' and enabled='0'";
        return mysqli_query($this->db->conn, $sql);
    }

    public function getUsers($limit = 15, $offset = 0) {
        $sql = "select * from user where role='instructor' limit $offset, $limit";
        return mysqli_query($this->db->conn, $sql);
    }

    public function getTotalUsers() {
        $query = "select count(*) as total from user";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function addUser($fname, $mname, $email, $phoneNo, $role = 'volunteer') {
        $fname = filter_var($fname, FILTER_SANITIZE_STRING);
        $fname = mysqli_real_escape_string($this->db->conn, trim($fname));
        $mname = filter_var($mname, FILTER_SANITIZE_STRING);
        $mname = mysqli_real_escape_string($this->db->conn, trim($mname));
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = mysqli_real_escape_string($this->db->conn, trim($email));
        $phoneNo = filter_var($phoneNo, FILTER_SANITIZE_STRING);
        $phoneNo = mysqli_real_escape_string($this->db->conn, trim($phoneNo));
        $password = $this->getPassword();
        $tmpPass = password_hash($password, PASSWORD_BCRYPT, array('cost' => 13));
        $query = "INSERT INTO user(`fname`, `mname`, `username`, `password`, `role`, `email`, `phone`)"
                . " VALUES ('$fname','$mname','$email', '$tmpPass','$role','$email','$phoneNo')";
        if ($this->checkIfEmailExists($email) == 0) {
            if (mysqli_query($this->db->conn, $query)) {
                return "Account created successfully.<br/>Please use this account to login into the system. Username: $email and Password: $password <br/>";
            } else {
                return "Account does not created due to Unknown Error!. Please try again.";
            }
        } else {
            return "This Email is used by other person! Please try another Email";
        }
    }

    public function createPartnerAdmin($fname, $mname, $email, $phoneNo, $password) {
        $fname = filter_var($fname, FILTER_SANITIZE_STRING);
        $fname = mysqli_real_escape_string($this->db->conn, trim($fname));
        $mname = filter_var($mname, FILTER_SANITIZE_STRING);
        $mname = mysqli_real_escape_string($this->db->conn, trim($mname));
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = mysqli_real_escape_string($this->db->conn, trim($email));
        $phoneNo = filter_var($phoneNo, FILTER_SANITIZE_STRING);
        $phoneNo = mysqli_real_escape_string($this->db->conn, trim($phoneNo));
        $tmpPass = password_hash($password, PASSWORD_BCRYPT, array('cost' => 13));
        $query = "INSERT INTO user(`fname`, `mname`, `username`, `password`, `role`, `email`, `phone`)"
                . " VALUES ('$fname','$mname','$email', '$tmpPass','partner','$email','$phoneNo')";
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function getUsersByRole($role) {
        $this->role = $role;
        $query = "select * from user where role='$this->role'";
        return mysqli_query($this->db->conn, $query);
    }

    public function getPassword() {
        $length = 12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$*|\/%&()';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function deleteUser($userId) {
        $deleteSql = "delete from user where id='$userId'";
        return  mysqli_query($this->db->conn, $deleteSql);
    }

    public function editUser($username) {
        $editSql = "select * from user where username='$username'";
        return mysqli_query($this->db->conn, $editSql);
    }

    public function getUser($id) {
        $editSql = "select * from user where id='$id'";
        return mysqli_query($this->db->conn, $editSql);
    }

    public function getUserIdByEmail($email) {
        $sql = "select * from user where email='$email'";
        $user = mysqli_query($this->db->conn, $sql);
        $row = mysqli_fetch_row($user);
        return $row[0];
    }

    public function changeUserPassword($username, $cPassword, $nPassword) {       
        $nPassword = password_hash($nPassword, PASSWORD_BCRYPT, array('cost' => 13));
        $query = "update user set password='$nPassword' where username='$username'";
        return mysqli_query($this->db->conn, $query);
    }
    public function checkPassword($username, $cPassword) {
        $query = "select password from user where username='$username'";
        $queryResult = mysqli_query($this->db->conn, $query);
        $count = mysqli_num_rows($queryResult);
        $row = mysqli_fetch_row($queryResult);
        if ($count == 1) {
            if (password_verify($cPassword, $row[0])) {
                $count = 1;
            } else {
                $count = 0;
            }
        } else {
            $count = 0;
        }

        return $count;
    }

    public function register($fname, $lname, $username, $password, $userSex, $phone, $email = "") {
        $tmpPass = password_hash($password, PASSWORD_BCRYPT, array('cost' => 13));
        $query = "INSERT INTO user(`fname`, `mname`, `username`, `email`, `phone`, `role`, `sex`, `password`, `enabled`) "
                . "VALUES ('$fname','$lname','$username','$email','$phone','volunteer','$userSex','$tmpPass','1')";
        return mysqli_query($this->db->conn, $query);
    }

    public function registerWithGoogle($userId, $fname, $lname, $email, $userSex = "", $picture = "") {
        $query = "INSERT INTO user(`fname`, `mname`, `username`, `email`, `role`, `sex`, `oauth_id`, `provider`, `profile_image`) "
                . "VALUES ('$fname','$lname','$email','$email','volunteer','$userSex', '$userId', 'google', '$picture')";
        return mysqli_query($this->db->conn, $query);
    }

    public function registerWithFacebook($userId, $fname, $mname, $link, $email = "", $userSex = "", $picture = "", $lname = "", $birthDate = "") {
        $query = "INSERT INTO user(`fname`, `mname`, `lname`, `username`, `email`, `role`, `sex`, `oauth_id`, `provider`, `profile_image`,`birth_date`) "
                . "VALUES ('$fname','$mname','$lname','$userId','$email','volunteer','$userSex', '$userId', 'facebook', '$picture','$birthDate')";
        return mysqli_query($this->db->conn, $query);
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

    public function getTotalUsersInRegion($region) {
        $query = "select count(*) as total from user where region='$region' and role='volunteer'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getTotalVolunteersInCity($cityId) {
        $query = "select count(*) as total from user where city='$cityId' and role='volunteer'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getTotalVolunteersInZone($zoneId) {
        $query = "select count(*) as total from user where zone='$zoneId' and role='volunteer'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getTotalVolunteersInWoreda($woredaId) {
        $query = "select count(*) as total from user where woreda='$woredaId' and role='volunteer'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function checkIfEmailExists($email) {
        $sql = "SELECT count(*) FROM user  where email='$email' ";
        $result = mysqli_query($this->db->conn, $sql);
        $count = mysqli_fetch_array($result);
        return $count[0];
    }

    public function checkIfUsernameExists($username) {
        $sql = "SELECT count(*) FROM user  where username='$username' ";
        $result = mysqli_query($this->db->conn, $sql);
        $count = mysqli_fetch_array($result);
        return $count[0];
    }

    public function getVolunteersByRegion($region = "", $sex = "") {

        $region = strip_tags($region);
        $region = stripcslashes($region);
        //$country = mysqli_($this->db->conn, $country);
        $sex = filter_var($sex, FILTER_SANITIZE_STRING);
        $sex = mysqli_real_escape_string($this->db->conn, $sex);
        if (empty(trim($sex)) && empty(trim($region))) {
            $query = "select * from user where role='volunteer' and enabled=1";
        } elseif (empty(trim($sex)) && !empty(trim($region))) {
            $query = "select * from user where region in ('$region') and  role='volunteer' and enabled='1'";
        } elseif (!empty(trim($sex)) && empty(trim($region))) {
            $query = "select * from user where sex='$sex' and  role='volunteer' and enabled='1'";
        } else {
            $query = "select * from user where region in('$region') and  role='volunteer' and enabled='1' and sex='$sex'";
        }
        return mysqli_query($this->db->conn, $query);
    }

    public function getVolunteersByCity($city = "", $sex = "") {

        $city = strip_tags($city);
        $city = stripcslashes($city);
        //$country = mysqli_($this->db->conn, $country);
        $sex = filter_var($sex, FILTER_SANITIZE_STRING);
        $sex = mysqli_real_escape_string($this->db->conn, $sex);
        if (empty(trim($sex)) && empty(trim($city))) {
            $query = "select * from user where role='volunteer' and enabled=1";
        } elseif (empty(trim($sex)) && !empty(trim($city))) {
            $query = "select * from user where city in ('$city') and  role='volunteer' and enabled='1'";
        } elseif (!empty(trim($sex)) && empty(trim($city))) {
            $query = "select * from user where sex='$sex' and  role='volunteer' and enabled='1'";
        } else {
            $query = "select * from user where city in('$city') and  role='volunteer' and enabled='1' and sex='$sex'";
        }
        return mysqli_query($this->db->conn, $query);
    }

    public function getVolunteersBySubCity($subCity = "", $sex = "") {

        $subCity = strip_tags($subCity);
        $subCity = stripcslashes($subCity);
        //$country = mysqli_($this->db->conn, $country);
        $sex = filter_var($sex, FILTER_SANITIZE_STRING);
        $sex = mysqli_real_escape_string($this->db->conn, $sex);
        if (empty(trim($sex)) && empty(trim($subCity))) {
            $query = "select * from user where role='volunteer' and enabled=1";
        } elseif (empty(trim($sex)) && !empty(trim($subCity))) {
            $query = "select * from user where zone in ('$subCity') and  role='volunteer' and enabled='1'";
        } elseif (!empty(trim($sex)) && empty(trim($subCity))) {
            $query = "select * from user where sex='$sex' and  role='volunteer' and enabled='1'";
        } else {
            $query = "select * from user where zone in('$subCity') and  role='volunteer' and enabled='1' and sex='$sex'";
        }
        return mysqli_query($this->db->conn, $query);
    }

    public function getVolunteersByWoreda($woreda = "", $sex = "") {

        $woreda = strip_tags($woreda);
        $woreda = stripcslashes($woreda);
        //$country = mysqli_($this->db->conn, $country);
        $sex = filter_var($sex, FILTER_SANITIZE_STRING);
        $sex = mysqli_real_escape_string($this->db->conn, $sex);
        if (empty(trim($sex)) && empty(trim($woreda))) {
            $query = "select * from user where role='volunteer' and enabled=1";
        } elseif (empty(trim($sex)) && !empty(trim($woreda))) {
            $query = "select * from user where woreda in ('$woreda') and  role='volunteer' and enabled='1'";
        } elseif (!empty(trim($sex)) && empty(trim($woreda))) {
            $query = "select * from user where sex='$sex' and  role='volunteer' and enabled='1'";
        } else {
            $query = "select * from user where woreda in('$woreda') and  role='volunteer' and enabled='1' and sex='$sex'";
        }
        return mysqli_query($this->db->conn, $query);
    }
    public function groupVolunteersByRegion() {
        $query = "select user.region as regionId, region.name as regionName, count(user.id) as totalVolunteers from user, region where region.id=user.region and role='volunteer' group by regionId";
        return mysqli_query($this->db->conn, $query);
    }
    public function getTotalMaleUsersInARegion($regionId="") {
        $query = "select count(*) as total from user where region='$regionId' and role='volunteer' and enabled=1 and sex='M'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }


}
