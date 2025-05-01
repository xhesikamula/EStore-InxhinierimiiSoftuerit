<?php


header("Content-Type: application/json");

include '../classes/CRUD.php';  // Ensure the correct path

// Get raw POST data
$inputData = json_decode(file_get_contents("php://input"), true);

// Check if data is valid
if (isset($inputData['name']) && isset($inputData['price'])) {
    $crud = new CRUD();
    $result = $crud->create('products', $inputData);  // Pass valid data

    // Return success message
    if ($result === true) {
        echo json_encode(['status' => 'success', 'message' => 'Product created successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $result]);
    }
} else {
    // Handle invalid input
    echo json_encode(['status' => 'error', 'message' => 'Invalid data provided']);
}

