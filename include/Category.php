<?php
include_once 'Db.php';

class Category {

    private $db;

    public function __construct() {
        $this->db = new Db();
    }
    public function getCategoryNameBySlug($categorySlug) {
        $query = "select name from category where slug='$categorySlug'";
        $category = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($category);
        return $row[0];
    }

    public function addCategory($categoryName, $slug, $description = "",$maincategory="") {
        $categoryName = mysqli_real_escape_string($this->db->conn, $categoryName);
        $slug = mysqli_real_escape_string($this->db->conn, $slug);
        $description = mysqli_real_escape_string($this->db->conn, $description);
//        $coverImage = mysqli_real_escape_string($this->db->conn, $coverImage);
        $msg = '';
        //Check if category exist
        if ($this->checkIfExist($categoryName) == 0) {
            $query = "INSERT INTO category(`name`,`slug`,`description`,`parent_id`) VALUES ('$categoryName','$slug','$description', '$maincategory')";
            if (mysqli_query($this->db->conn, $query)) {
                $msg = "Category have been saved Successfully";
            } else {
                $msg = "Category have not Saved Successfully. Please try again!";
            }
        } else {
            $msg = "Category already added before!!!";
        }
        return $msg;
    }

    public function addMainCategory($categoryName, $is_mandatory=0) {
        $categoryName = mysqli_real_escape_string($this->db->conn, $categoryName);
        $msg = '';
        //Check if main category exist
        if ($this->checkIfMainCategoryExist($categoryName) == 0) {
            $query = "INSERT INTO main_category(`name`,`is_mandatory`) VALUES ('$categoryName','$is_mandatory')";
            if (mysqli_query($this->db->conn, $query)) {
                $msg = "Main Category have been saved Successfully";
            } else {
                $msg = "Main Category does not Saved Successfully. Please try again!";
            }
        } else {
            $msg = "Main Category already added before!!!";
        }
        return $msg;
    }

    public function getCategoryNameById($categoryId) {
        $categoryId= filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT);
        if(filter_var($categoryId, FILTER_VALIDATE_INT)){
             $query = "select name from category where id='$categoryId'";
        $category = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($category);
        return $row[0];
        }
       return null;
    }

    public function getAllCategories() {
        $query = "select category.*, main_category.id as categoryId, main_category.name as category_name from category, main_category where parent_id=main_category.id";
        return mysqli_query($this->db->conn, $query);
    }

    public function getAllMainCategories() {
        $query = "select * from main_category";
        return mysqli_query($this->db->conn, $query);
    }

    public function checkIfExist($categoryName) {
        $query = "select count(*)as total from category where name='$categoryName'";
        $category = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($category);
        return $row[0];
    }

    public function checkIfMainCategoryExist($categoryName) {
        $query = "select count(*)as total from main_category where name='$categoryName'";
        $category = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($category);
        return $row[0];
    }

    public function getTotalCategories() {
        $query = "select count(*) as totalCategories from category";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function removeCategory($id) {
        $categoryId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($categoryId, FILTER_VALIDATE_INT)) {
            $query = "delete from category where id='$categoryId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }
     public function removeMainCategory($id) {
        $categoryId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($categoryId, FILTER_VALIDATE_INT)) {
            $query = "delete from main_category where id='$categoryId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function updateCategory($id, $categoryName, $description, $mainCategory="") {
        $categoryId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($categoryId, FILTER_VALIDATE_INT)) {
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $categoryName = mysqli_real_escape_string($this->db->conn, $categoryName);
            $description = mysqli_real_escape_string($this->db->conn, $description);

            $query = "update category set name='$categoryName', description='$description', parent_id='$mainCategory' where id='$categoryId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function updateMainCategory($id, $categoryName, $is_mandatory=0) {
        $categoryId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($categoryId, FILTER_VALIDATE_INT)) {
            $categoryName = mysqli_real_escape_string($this->db->conn, $categoryName);
            $query = "update main_category set name='$categoryName', is_mandatory='$is_mandatory' where id='$categoryId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function getCategoryIdBySlug($slug) {
        if (isset($slug) && !empty($slug)) {
            $query = "select id from category where slug='$slug' ";
            $categoryId = mysqli_query($this->db->conn, $query);
            $row = mysqli_fetch_row($categoryId);
            return $row[0];
        }
        return '';
    }
    public function getMandatotyCategories(){
        $query="select * from main_category where is_mandatory=1";
        return mysqli_query($this->db->conn, $query);
        
    }
    public function getOptionalCategories(){
        $query="select * from main_category where is_mandatory=0";
        return mysqli_query($this->db->conn, $query);
        
    }
    public function getCategoryNameByCategory($categoryId) {
        $categoryId= filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT);
        if(filter_var($categoryId, FILTER_VALIDATE_INT)){
           $query="select * from category where parent_id='$categoryId'";
           return mysqli_query($this->db->conn, $query);
        }
        return null;
        
        
    }

}
