<?php
include '../../backend/conn.php';

// Check if categoryId and action are set and not empty
if (isset($_POST['categoryId'], $_POST['action']) && !empty($_POST['categoryId']) && !empty($_POST['action'])) {
    // Sanitize the input to prevent SQL injection
    $categoryId = intval($_POST['categoryId']);
    $action = $_POST['action'];

    // Define the new status based on the action
    $newStatus = ($action === 'inactivate') ? 'inactive' : 'active';

    // Prepare and execute the SQL query to update the category status
    $sql = "UPDATE productcategory SET status = ? WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newStatus, $categoryId);

    if ($stmt->execute()) {
        // Query executed successfully, send a success response
        echo json_encode(array("status" => "success", "message" => "Category status set to $newStatus successfully."));
    } else {
        // Error occurred during execution, send an error response
        echo json_encode(array("status" => "error", "message" => "Failed to update category status."));
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Category ID or action is not set or empty, send an error response
    echo json_encode(array("status" => "error", "message" => "Category ID or action not provided."));
}
?>
