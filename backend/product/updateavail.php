<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Check if the connection is established successfully
if ($conn) {
    // Check if ProductID and availability are provided in the POST request
    if (isset($_POST['ProductID'], $_POST['availability'])) {
        $productId = $_POST['ProductID'];
        $availability = $_POST['availability'];

        // Construct SQL query to update the availability of the product
        $sql = "UPDATE product SET availability = '$availability' WHERE ProductID = '$productId'";

        // Execute the SQL query
        $result = mysqli_query($conn, $sql);

        // Check if the query was executed successfully
        if ($result) {
            // Output success message as JSON
            header('Content-Type: application/json');
            echo json_encode(array("success" => "Availability updated successfully."));
        } else {
            // If the query failed to execute, log an error message
            error_log("Failed to execute query: " . mysqli_error($conn));
            // Output an error message as JSON
            header('Content-Type: application/json');
            echo json_encode(array("error" => "Failed to update availability."));
        }
    } else {
        // Output an error message if ProductID or availability is not provided
        header('Content-Type: application/json');
        echo json_encode(array("error" => "ProductID or availability not provided."));
    }
} else {
    // Output an error message if connection is not established
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Database connection failed."));
}
?>
