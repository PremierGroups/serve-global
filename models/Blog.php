<?php
include_once '../db/Db.php';
class Blog
{
    private $db;
    public function __construct()
    {
        if(!isset($this->db)){
            $this->db = new Db();
        }

    }

    public function addBlog($title,$description,$coverImage)
    {
        $query = "INSERT INTO blog(`title`,`description`,`coverImage`)VALUES ('$title','$description','$coverImage')";
        if(mysqli_query($this->db->conn, $query)){
            return "Blog is Created Successfully.";
        }else{
            return "Blog not created. Please try again.";
        }  
    }

    public function updateBlog($id,$title,$description,$coverImage)
    {
        $query = "update blog set title='$title',description='$description',coverImage='$coverImage' where id='$id'";
        return mysqli_query($this->db->conn, $query);
    }
    public function getBlogById($id)
    {
        $query = "select * from blog where id='$id'";
        $blog = mysqli_query($this->db->conn, $query);
        return $blog;
    }
    public function deleteBlog($id)
    {
        $msg = "Error";
        $deleteSql = "delete from blog where id='$id'";
        $deleteQuery = mysqli_query($this->db->conn, $deleteSql);
        if ($deleteQuery) {
            $msg = 'Blog is deleted successfully!';
        } else {
            $msg = 'Blog is not deleted';
        }
        return $msg;
    }
    public function getAllBlogs() {
        $query = "select * from blog";
        $blogs = mysqli_query($this->db->conn, $query);
        return $blogs;
    }
    public function getBlogsByLimit($limit=9,$offset=0) {
        $query = "select * from blog order by dateCreated desc limit $limit offset $offset";
        $result = mysqli_query($this->db->conn, $query);
        return $result;
    }

    public function getTotalBlogs(){
        $query = "select count(*) as total from blog";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        $totalCount = $row[0];
        return $totalCount;
    }

}
