<?php
    //Require headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    //Includes
    include_once '../config/database.php';
    include_once '../objects/product.php';

    //Instantiations
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    //Get number of rows
    $stmt = $product->read();
    $num = $stmt->rowCount();

    //Output product records
    if ($num>0) {
        $product_arr = array();
        $product_arr["records"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $product_item = array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price,
                "category_id" => $category_id,
                "category_name" => $category_name
            );
            array_push($product_arr['records'], $product_item);
        }
        http_response_code(200);
        echo json_encode($product_arr);
    } else {
        http_response_code(200);
        echo json_encode(404);
    }