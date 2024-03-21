<?php
include '../../backend/conn.php'; // Include the database connection script

// Check if user ID is provided via POST method
if (isset ($_POST['userId'])) {
    $userId = $_POST['userId'];

    // SQL to update user status to inactive and set updated_at
    $sql = "UPDATE users 
    SET status = CASE 
        WHEN status = 'active' THEN 'inactive'
        ELSE 'active'
    END,
    updated_at = CURRENT_TIMESTAMP 
    WHERE user_id = ?;
    ";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("i", $userId);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // User status updated successfully
            echo json_encode(array("success" => true, "message" => "User status updated to inactive."));
        } else {
            // Error updating user status
            echo json_encode(array("success" => false, "message" => "Error updating user status."));
        }
    } else {
        // Error preparing statement
        echo json_encode(array("success" => false, "message" => "Error preparing statement."));
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // User ID not provided
    echo json_encode(array("success" => false, "message" => "User ID not provided."));
}
?>