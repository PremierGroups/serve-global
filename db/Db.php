<?php

class Db {

    public $conn;

    function __construct() {
        if(!isset($this->conn)){
            $this->conn = mysqli_connect('localhost', 'root', 'root', 'premier_eth');
        }
    }

}
