<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection script
include '../../backend/conn.php';
// Include the auditlog.php file
include "../../backend/auditlog.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user ID is provided via POST method
    if (isset($_POST['userId'])) {
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
                $user_id = $_SESSION['user_id'];

                // Fetch deactivate/active user details from the database using user_id
                $sql = "SELECT fname, lname, status FROM users WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $status = $row['status'];

                    // Fetch admin user details from the database using user_id
                    $sql = "SELECT fname, lname, role_id, status FROM users WHERE user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($row = $result->fetch_assoc()) {
                        $adminfname = $row['fname'];
                        $adminlname = $row['lname'];
                        $adminrole_id = $row['role_id'];

                        // Log the action with user details
                        logAudit($user_id, $adminfname, $adminlname, $adminrole_id, "User $fname $lname status changed to: $status");
                    }
                }
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
} else {
    // Invalid request method
    $response = ["success" => false, "message" => "Invalid request method"];
    http_response_code(405); // Set HTTP response code to indicate method not allowed
}
?>