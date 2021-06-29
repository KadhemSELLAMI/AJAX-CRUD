<?php
    class Product {

        private $conn;
        private $tbl = "product";

        public $id;
        public $name;
        public $des;
        public $price;
        public $cate_id;
        public $cate_name;
        public $crea;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function create() {
            //SQL query
            $sql = '
                insert into ' . $this->tbl . '
                set
                    name=:name,
                    description=:desc,
                    price=:price,
                    category_id=:cate_id,
                    created=:crea
            ';

            //Prepare query
            $stmt = $this->conn->prepare($sql);

            //Sanitize
            $this->name = htmlspecialchars(strip_tags(($this->name)));
            $this->desc = htmlspecialchars(strip_tags(($this->desc)));
            $this->price = htmlspecialchars(strip_tags(($this->price)));
            $this->cate_id = htmlspecialchars(strip_tags(($this->cate_id)));
            $this->crea = htmlspecialchars(strip_tags(($this->crea)));

            //Bind parameters
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":desc", $this->desc);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":cate_id", $this->cate_id);
            $stmt->bindParam(":crea", $this->crea);

            //Execute
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

        }

        public function read() {
            //Query
            $sql = '
                select c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                from ' . $this->tbl . ' p
                left join category c on p.category_id = c.id
                order by p.created desc
            ';

            //Prepare stmt
            $stmt = $this->conn->prepare($sql);

            //Execute
            $stmt->execute();

            return $stmt;
        }

        public function readOne() {
            // Query
            $sql = '
                select
                    c.name as category_name,
                    p.id,
                    p.name,
                    p.description,
                    p.price,
                    p.category_id,
                    p.created
                from '.$this->tbl.' p
                left join category c
                on p.category_id = c.id
                where p.id = ?
                limit 0,1
            ';

            // Prepare
            $stmt = $this->conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(1, $this->id);

            // Execute
            $stmt->execute();

            // Get retrived row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Get rows numbers
            $num = $stmt->rowCount();

            // Set values to object properties
            if ($num>0) {
                $this->name = $row['name'];
                $this->price = $row['price'];
                $this->desc = $row['description'];
                $this->cate_id = $row['category_id'];
                $this->cate_name = $row['category_name'];
            } else {
                return null;
            }
        }

        public function update() {
            //Query
            $sql = '
                update ' . $this->tbl . '
                set
                    name=:name,
                    description=:desc,
                    price=:price,
                    category_id=:cate_id
                where id=:id;
            ';

            //Prepare stmt
            $stmt = $this->conn->prepare($sql);

            //Sanitize
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->desc = htmlspecialchars(strip_tags($this->desc));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->cate_id = htmlspecialchars(strip_tags($this->cate_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind parameters
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":desc", $this->desc);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":cate_id", $this->cate_id);
            $stmt->bindParam(":id", $this->id);

            //Execute
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function delete() {
            //Query
            $sql = '
                delete from ' . $this->tbl .' where id = ?
            ';

            //Prepare
            $stmt = $this->conn->prepare($sql);

            //Sanitize
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind parameter
            $stmt->bindParam(1, $this->id);

            //Execute
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

    }