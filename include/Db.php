<?php

class Db {

    public $conn;

    public function __construct() {
        if(!isset($this->conn) || $this->conn==null){
            $this->conn = mysqli_connect('localhost', 'root', 'root', 'serve_global');
        }
    }
}
