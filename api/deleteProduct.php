<?php


header("Content-Type: application/json");
include '../classes/CRUD.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'DELETE' && $method !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
    exit;
}

// Read JSON payload
$input = json_decode(file_get_contents('php://input'), true);

// Validate ID
if (empty($input['id']) || !is_numeric($input['id'])) {
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Missing or invalid product ID'
    ]);
    exit;
}

$id   = (int) $input['id'];
$crud = new CRUD();

// Perform delete (limit to 1 row)
$result = $crud->delete(
    'products',
    ['column' => 'id', 'value' => $id],
    1
);

if ($result === true) {
    echo json_encode([
        'status'  => 'success',
        'message' => 'Product deleted successfully'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => $result
    ]);
}
