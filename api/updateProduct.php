<?php

header("Content-Type: application/json");
include '../classes/CRUD.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'PUT' && $method !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
    exit;
}

// Parse the incoming JSON
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

$id = (int) $input['id'];
unset($input['id']);

// Validate that there is at least one other field to update
if (empty($input) || !is_array($input)) {
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => 'No update data provided'
    ]);
    exit;
}

$crud   = new CRUD();
$result = $crud->update(
    'products',
    $input,
    ['column' => 'id', 'value' => $id]
);

if ($result === true) {
    echo json_encode([
        'status'  => 'success',
        'message' => 'Product updated successfully'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => $result
    ]);
}
