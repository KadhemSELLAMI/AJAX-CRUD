<?php
    //Require headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //Includes
    include_once '../config/database.php';
    include_once '../objects/product.php';

    //Instantiations
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    //Get data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID property
    $product->id = $data->id;

    //Set product prperties
    $product->name = $data->name;
    $product->desc = $data->desc;
    $product->price = $data->price;
    $product->cate_id = $data->cate_id;

    //Update product
    if ($product->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Product updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update product!"));
    }