<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include your database connection code
include '../../backend/conn.php';

// Check if productId and status are provided via POST request
if (isset($_POST['productId']) && isset($_POST['status'])) {
    // Sanitize input to prevent SQL injection
    $productId = $_POST['productId'];
    $status = $_POST['status'];

    // Prepare and execute SQL query to update product status
    $query = "UPDATE product SET status = ? WHERE ProductID = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param('si', $status, $productId);

    // Execute the statement
    if ($statement->execute()) {
        // Return success response
        echo json_encode(["success" => true]);
    } else {
        // Return error response
        echo json_encode(["success" => false, "message" => "Error updating product status"]);
    }
} else {
    // Return error response if productId or status are not provided
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
}
?>
