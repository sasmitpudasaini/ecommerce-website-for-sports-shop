<?php
session_start();
include 'db.php'; // Include your database connection file

// Enable error reporting (for debugging, remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    // Check if JSON data is valid
    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON data received.']);
        exit;
    }

    // Check if the action parameter is set
    if (!isset($data['action'])) {
        echo json_encode(['success' => false, 'message' => 'Missing action parameter.']);
        exit;
    }

    $action = $data['action'];

    // Handle the insert action
    if ($action == 'insert' && isset($data['products'])) {
        $products = $data['products'];

        // Insert each product into the database
        foreach ($products as $product) {
            try {
                $sql = "INSERT INTO products (id, image, image_price, company, item_name) 
                        VALUES (:id, :image, :image_price, :company, :item_name)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':id' => $product['id'],
                    ':image' => $product['image'],
                    ':image_price' => $product['image_price'],
                    ':company' => $product['company'],
                    ':item_name' => $product['item_name']
                ]);
                echo json_encode(['success' => true, 'message' => 'Products inserted successfully.']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Failed to insert products: ' . $e->getMessage()]);
                exit;
            }
        }
        exit;
    }

    // If no valid action is found
    echo json_encode(['success' => false, 'message' => 'Invalid action or missing data.']);
    exit;
}

// If the request method is not POST
echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
exit;
?>