<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../classes/CRUD.php");
$crud = new CRUD();

$method = $_SERVER['REQUEST_METHOD'];

// Parse input for PUT & DELETE
parse_str(file_get_contents("php://input"), $inputData);

switch ($method) {
    case 'GET':
        $products = $crud->read("products"); // Use your actual table name here
        echo json_encode(["status" => "success", "data" => $products]);
        break;

    case 'POST':
        $data = $_POST;
        $result = $crud->create("products", $data); 
        echo json_encode(["status" => $result ? "success" : "error"]);
        break;

    case 'PUT':
        if (!isset($inputData['id'])) {
            echo json_encode(["status" => "error", "message" => "Missing ID for update"]);
            exit;
        }
        $id = $inputData['id'];
        unset($inputData['id']);
        $result = $crud->update("products", $inputData, ['column' => 'id', 'value' => $id]);
        echo json_encode(["status" => $result ? "success" : "error"]);
        break;

    case 'DELETE':
        if (!isset($inputData['id'])) {
            echo json_encode(["status" => "error", "message" => "Missing ID for delete"]);
            exit;
        }
        $result = $crud->delete("products", ['column' => 'id', 'value' => $inputData['id']]);
        echo json_encode(["status" => $result ? "success" : "error"]);
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
