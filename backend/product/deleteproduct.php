<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include your database connection code
include '../../backend/conn.php';
// Include the auditlog.php file
include("../../backend/auditlog.php");

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
                logAudit($user_id, $fname, $lname, $role_id, "Deleted product: '$productId'");
            }
        }

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
