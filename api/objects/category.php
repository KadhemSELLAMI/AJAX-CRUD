<?php
    class Category {

        private $conn;
        private $tbl = "category";

        public $id;
        public $name;
        public $desc;
        public $crea;
        public $modi;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            //Query
            $query = '
                select id, name, description
                from ' . $this->tbl . '
                order by name
            ';

            //Prepare stmt
            $stmt = $this->conn->prepare($query);
            
            //Execute
            $stmt->execute();
            
            return $stmt;
        }

    }