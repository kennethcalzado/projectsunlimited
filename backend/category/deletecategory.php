<?php
include '../../backend/conn.php';

// Check if categoryId is set and not empty
if (isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {
    // Sanitize the input to prevent SQL injection
    $categoryId = intval($_POST['categoryId']);

    // Prepare and execute the SQL query to update the category status
    $sql = "UPDATE productcategory SET status = 'inactive' WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);

    if ($stmt->execute()) {
        // Query executed successfully, send a success response
        echo json_encode(array("status" => "success", "message" => "Category inactivated successfully."));
    } else {
        // Error occurred during execution, send an error response
        echo json_encode(array("status" => "error", "message" => "Failed to inactivate category."));
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Category ID is not set or empty, send an error response
    echo json_encode(array("status" => "error", "message" => "Category ID not provided."));
}
?>