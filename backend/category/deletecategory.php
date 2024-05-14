<?php
include '../../backend/conn.php';
// Include the auditlog.php file
include("../../backend/auditlog.php");

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

        // Fetch user information from session or database
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Fetch user details from the database using user_id
            $sql = "SELECT fname, lname, role_id FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $fname = $row['fname'];
                $lname = $row['lname'];
                $role_id = $row['role_id'];

                // Log the action with user details
                logAudit($user_id, $fname, $lname, $role_id, "Deleted category: '$categoryId'");
            }
        }

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
