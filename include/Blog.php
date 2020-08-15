<?php

include_once 'Db.php';

class Blog {

    private $db;

    public function __construct() {
        if (!isset($this->db)) {
            $this->db = new Db();
        }
    }

    public function addBlog($title, $content, $target_file, $slug, $category = "", $partnerId = "") {
        $partnerId = strip_tags($partnerId);
        $category = strip_tags($category);

        $partnerId = mysqli_real_escape_string($this->db->conn, $partnerId);
        $content = mysqli_real_escape_string($this->db->conn, $content);
        $title = mysqli_real_escape_string($this->db->conn, $title);
        $categoryId = mysqli_real_escape_string($this->db->conn, $category);
        $query = '';

        $query = "INSERT INTO blog(`partner_id`, `title`, `description`, `coverImage`, `category_id`, `slug`) "
                . "VALUES ('$partnerId','$title','$content','$target_file','$categoryId','$slug')";
        return mysqli_query($this->db->conn, $query);
    }

    public function addBlogView($blogId) {
        $blogId = mysqli_real_escape_string($this->db->conn, $blogId);
        $query = "update blog set views=views+1 where id='$blogId'";
        return mysqli_query($this->db->conn, $query);
    }

    public function getBlogs($limit = 6, $offset = 0) {
        $query = "select * from blog order by lastUpdated desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function getPouplarBlogs($limit = 5) {
        $query = "select * from blog order by views desc limit $limit";
        return mysqli_query($this->db->conn, $query);
    }

    public function getBlogsByCategory($categoryId, $limit = 12, $offset = 0) {
        $query = "select * from blog where category_id='$categoryId' order by dateCreated desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function getBlogsNotIn($blogs, $limit = 5, $offset = 0) {
        $query = "select * from blog where id not in('$blogs')order by dateCreated desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function getTotalBlogs() {
        $query = "select count(*) as totalBlog from blog";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getTotalUndisplayedBlogs($blogs) {
        $query = "select count(*) as totalBlog from blog where id not in('$blogs')";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getTotalBlogsByCategory($categoryId) {
        $query = "select count(*) as totalBlog from blog where category_id='$categoryId'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getToDayBlog() {
        $toDay = date("Y-m-d");
        $query = "select * from blog where date_format(dateCreated,'%Y-%m-%d')='$toDay' order by dateCreated desc";
        return mysqli_query($this->db->conn, $query);
    }

    public function removeBlog($id) {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $id = mysqli_real_escape_string($this->db->conn, $id);
            $query = "delete from blog where id='$id'";
            return mysqli_query($this->db->conn, $query);
        }
        return null;
    }

    public function getBlogById($blogId) {
         $id = filter_var($blogId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $query = "select * from blog where id='$id'";
            return mysqli_query($this->db->conn, $query);
        }
       return null;
    }

    public function getBlogBySlug($slug) {
        $slug= filter_var($slug, FILTER_SANITIZE_STRING);
        $slug = mysqli_real_escape_string($this->db->conn, $slug);
        $query = "select * from blog where slug='$slug'";
        return mysqli_query($this->db->conn, $query);
    }

    public function updateBlog($blogId, $title, $target_file, $description, $category, $partnerId=0) {

        if (filter_var($blogId, FILTER_VALIDATE_INT)) {
            $title = mysqli_real_escape_string($this->db->conn, $title);
            $description = mysqli_real_escape_string($this->db->conn, $description);
            $query = "update blog set title='$title', description='$description', coverImage='$target_file', partner_id='$partnerId', category_id='$category' where id='$blogId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function searchBlog($keyword, $limit = 8, $offset = 0) {
        $keyword= filter_var($keyword, FILTER_SANITIZE_STRING);
        $keyword = mysqli_real_escape_string($this->db->conn, $keyword);
        $query = "select * from blog where title like '%" . $keyword . "%' order by dateCreated desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function addBlogComment($blogId, $name, $email, $comment, $parentId = 0) {
        $blogId = filter_var($blogId, FILTER_SANITIZE_NUMBER_INT);
        $name = strip_tags($name);
        $email = strip_tags($email);
        $comment = strip_tags($comment);
        $name = stripcslashes($name);
        $email = stripcslashes($email);
        $comment = stripcslashes($comment);
        $name = mysqli_real_escape_string($this->db->conn, $name);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $comment = mysqli_real_escape_string($this->db->conn, $comment);
        if (!empty($blogId) && is_numeric($blogId)) {
            $query = "INSERT INTO blog_comment(`blogId`, `name`, `email`, `parentId`, `comment`) VALUES ('$blogId','$name','$email','$parentId','$comment')";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function replyBlogComment($blogId, $name, $email, $comment, $parentId = 0) {

        $blogId = filter_var($blogId, FILTER_SANITIZE_NUMBER_INT);
        $name = strip_tags($name);
        $email = strip_tags($email);
        $comment = strip_tags($comment);
        $name = stripcslashes($name);
        $email = stripcslashes($email);
        $comment = stripcslashes($comment);
        $name = mysqli_real_escape_string($this->db->conn, $name);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $comment = mysqli_real_escape_string($this->db->conn, $comment);
        if (!empty($blogId) && is_numeric($blogId)) {
            $query = "INSERT INTO blog_comment(`blogId`, `name`, `email`, `parentId`, `comment`) VALUES ('$blogId','$name','$email','$parentId','$comment')";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }

    public function getBlogComment($blogId) {
        $query = "select * from blog_comment where blogId='$blogId' and parentId=0";
        return mysqli_query($this->db->conn, $query);
    }

    public function getBlogCommentReply($commentId) {
        $query = "select * from blog_comment where parentId='$commentId'";
        return mysqli_query($this->db->conn, $query);
    }

    public function getCommentCountForBlog($blogId) {
        $query = "select count(*) as totalBlogComment from blog_comment where blogId='$blogId'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
     public function getBlogView($blogId) {
        $query = "select views as totalView from blog where id='$blogId'";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function getCategoriesHavingMostBlogs($limit) {
        $query = "select category.*, count(category_id) as categoryCount from category, blog where category.id=category_id group by category_id order by categoryCount desc limit $limit";
        return mysqli_query($this->db->conn, $query);
    }

    public function getAllCategoriesHavingMostBlogs() {
        $query = "select category.*, count(category_id) as categoryCount from category, blog where category.id=category_id group by category_id order by categoryCount desc";
        return mysqli_query($this->db->conn, $query);
    }

    public function checkIfSlugExist($slugName) {
        $query = "select count(*)as total from blog where slug='$slugName'";
        $slugCount = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($slugCount);
        return $row[0];
    }

}
