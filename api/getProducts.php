<?php


    header("Content-Type: application/json");
    include '../classes/CRUD.php';
    
    $crud = new CRUD();
    
    $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
    
    if ($id) {
        $result = $crud->read(
            'products',
            ['column' => 'id', 'value'  => $id],
            1
        );
        if (is_array($result) && count($result) > 0) {
            echo json_encode($result[0]);
        } else {
            http_response_code(404);
            echo json_encode([
                'status'  => 'error',
                'message' => 'Product not found'
            ]);
        }
    } else {
        // Fetch all products
        $result = $crud->read('products');
        echo json_encode($result);
    }
    