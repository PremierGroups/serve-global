<?php
/**
 * Created by PhpStorm.
 * User: Aemiro-PC
 * Date: 1/26/2019
 * Time: 5:51 PM
 */
include_once "Db.php";
class Gallery
{
    private $db;

    public function __construct() {
        if(!isset($this->db)){
            $this->db = new Db();
        }
    }

    public function addGallery($caption, $coverImage) {
        $caption=strip_tags($caption);
        
        $caption=mysqli_real_escape_string($this->db->conn,$caption);
        $query = "INSERT INTO gallery(`caption`, `path`)"
            . " VALUES ('$caption','$coverImage')";
        if(mysqli_query($this->db->conn, $query)){
            return "Gallery added to the system";
        }else{
            return "Gallery Not Added";
            //return $query;
        }
    }
    public function getAllGalleries() {
        $query = "select * from gallery order by dateCreated DESC";
        return mysqli_query($this->db->conn, $query);
    }
    public function getAllGalleriesByOffset($limit=8,$offset=0) {
        $query = "select * from gallery  order by dateCreated desc limit $limit offset $offset";
        return mysqli_query($this->db->conn, $query);
    }

    public function updateGallery($galleryId, $caption, $coverImage) {
        $caption=strip_tags($caption);
        
        $caption=mysqli_real_escape_string($this->db->conn,$caption);
        if(filter_var($galleryId, FILTER_VALIDATE_INT)){
            $query = "update gallery set caption='$caption', path='$coverImage' where id='$galleryId'";
            if(mysqli_query($this->db->conn, $query)){
                return "Gallery Update Successfully!";
            }else{
                return "Gallery Not Updated!";
            }
        }else{
            return "Gallery Not Updated!";
        }
    }
    public function getGalleryById($galleryId) {
       $galleryId = filter_var($galleryId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($galleryId, FILTER_VALIDATE_INT)) {
            $query = "select * from gallery where id='$galleryId'";
            return mysqli_query($this->db->conn, $query);
        }
        return null;
    }

    public function deleteGallery($galleryId) {
        $galleryId = filter_var($galleryId, FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($galleryId, FILTER_VALIDATE_INT)) {
            $query = "delete from gallery where id='$galleryId'";
            return mysqli_query($this->db->conn, $query);
        }
        return false;
    }
    public function getTotalGallery() {
        $query = "select count(*) as total from gallery";
        $result = mysqli_query($this->db->conn, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
       
    }


}