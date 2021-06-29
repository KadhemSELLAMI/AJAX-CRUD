<?php
    //Require headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    //Includes
    include_once '../config/database.php';
    include_once '../objects/category.php';

    //Instantiations
    $database = new Database();
    $db = $database->getConnection();
    $category = new Category($db);

    //Get number of rows
    $stmt = $category->read();
    $num = $stmt->rowCount();

    //Output product records
    if ($num>0) {
        $category_arr = array();
        $category_arr["records"]=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $category_item = array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description)
            );
            array_push($category_arr['records'], $category_item);
        }
        http_response_code(200);
        echo json_encode($category_arr);
    } else {
        http_response_code(200);
        echo json_encode(404);
    }