<?php
include '../../backend/conn.php'; // Include the database connection script

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (isset($_POST['userId'], $_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['roleId'])) {
        $userId = $_POST['userId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $roleId = $_POST['roleId'];

        // Perform the update query including the role ID and updated_at
        $sql = "UPDATE users SET fname = ?, lname = ?, username = ?, email = ?, role_id = ?, updated_at = CURRENT_TIMESTAMP WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ssssii", $firstName, $lastName, $username, $email, $roleId, $userId);
            if ($stmt->execute()) {
                // Update successful
                $response = ["success" => true, "message" => "User updated successfully"];
                http_response_code(200); // Set HTTP response code to indicate success
            } else {
                // Update failed
                $response = ["success" => false, "message" => "Failed to update user"];
                http_response_code(500); // Set HTTP response code to indicate internal server error
            }
            $stmt->close();
        } else {
            // Statement preparation failed
            $response = ["success" => false, "message" => "Database error"];
            http_response_code(500); // Set HTTP response code to indicate internal server error
        }
    } else {
        // Required fields are missing
        $response = ["success" => false, "message" => "Missing parameters"];
        http_response_code(400); // Set HTTP response code to indicate bad request
    }
} else {
    // Invalid request method
    $response = ["success" => false, "message" => "Invalid request method"];
    http_response_code(405); // Set HTTP response code to indicate method not allowed
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>