<?php
include '../../backend/conn.php'; // Include the database connection script

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (isset ($_POST['userId'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['role'])) {
        // Retrieve the form data
        $userId = $_POST['userId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $roleName = $_POST['role'];

        // Perform validation
        $errors = [];

        // Check if any required field is empty
        if (empty ($firstName)) {
            $errors['firstName'] = 'First Name is required.';
        }

        if (empty ($lastName)) {
            $errors['lastName'] = 'Last Name is required.';
        }

        if (empty ($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Valid Email is required.';
        } else {
            // Check if email is already registered
            $sql_check_email = "SELECT COUNT(*) AS count FROM users WHERE email = '$email' AND user_id != '$userId'";
            $result_check_email = $conn->query($sql_check_email);
            $row_check_email = $result_check_email->fetch_assoc();
            if ($row_check_email['count'] > 0) {
                $errors['email'] = 'Email is already registered.';
            }
        }

        if (empty ($roleName)) {
            $errors['role'] = 'Role is required.';
        }

        // If there are validation errors, return the error messages
        if (!empty ($errors)) {
            echo json_encode(['success' => false, 'message' => $errors]);
            exit;
        }

        // Retrieve role ID based on role name
        $sql_get_role_id = "SELECT role_id FROM roles WHERE role_name = '$roleName'";
        $result_get_role_id = $conn->query($sql_get_role_id);

        if ($result_get_role_id->num_rows > 0) {
            $row = $result_get_role_id->fetch_assoc();
            $roleId = $row['role_id'];

            // Perform the update query including the role ID and updated_at
            $sql = "UPDATE users SET fname = ?, lname = ?, email = ?, role_id = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE user_id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Bind parameters and execute the statement
                $stmt->bind_param("sssii", $firstName, $lastName, $email, $roleId, $userId);
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