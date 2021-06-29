<?php
    class Database {

        private $host = "localhost";
        private $db = "ajax_crud";
        private $username = "root";
        private $pass = "";

        public $conn;
    
        public function getConnection() {
    
            $this->conn = null;
    
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->username, $this->pass);
                $this->conn->exec("set names utf8");
            } catch(PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
    
            return $this->conn;
        }
        
    }