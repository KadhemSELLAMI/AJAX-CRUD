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

    //Instentiations
    $database = new Database();
    $db = $database->getConnection();
    $product = new Product($db);

    //Get product ID
    $data = json_decode(file_get_contents("php://input"));

    //Set product ID to be deleted
    $product->id = $data->id;

    //Delete
    if ($product->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Product deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete product!"));
    }