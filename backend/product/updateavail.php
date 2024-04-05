<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Check if the connection is established successfully
if ($conn) {
    // Check if productId and availability are received through POST request
    if (isset($_POST['productId'], $_POST['availability'])) {
        $productId = $_POST['productId'];
        $availability = $_POST['availability'];

        // Prepare SQL statement to update the availability for the given product
        $sql = "UPDATE product SET availability = ? WHERE product_id = ?";
        
        // Prepare and bind parameters
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $availability, $productId);
        
        // Execute the update statement
        if (mysqli_stmt_execute($stmt)) {
            // Return success response
            echo json_encode(array("success" => true));
        } else {
            // Return error response if update fails
            echo json_encode(array("success" => false, "error" => "Failed to update availability: " . mysqli_error($conn)));
        }
    } else {
        // Return error response if productId or availability is not received
        echo json_encode(array("success" => false, "error" => "Product ID or availability not provided"));
    }
} else {
    // Return error message if connection fails
    echo json_encode(array("success" => false, "error" => "Failed to connect to the database"));
}
?>
