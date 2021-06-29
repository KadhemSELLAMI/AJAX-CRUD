<?php
    //Require headers (allow-origin | Type | allow-method | max-age | allow-headers)
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //Includes
    include_once '../config/database.php';
    include_once '../objects/product.php';

    //Instatiations
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    //Get posted data
    $data = json_decode(file_get_contents("php://input"));

    //Create product
    if (
        !empty($data->name) &&
        !empty($data->desc) &&
        !empty($data->price) &&
        !empty($data->cate_id)
    ) {
        $product->name = $data->name;
        $product->desc = $data->desc;
        $product->price = $data->price;
        $product->cate_id = $data->cate_id;

        if ($product->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Product was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create product!"));
        }
    }