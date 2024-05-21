<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection script
include '../../backend/conn.php';
// Include the auditlog.php file
include "../../backend/auditlog.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (isset($_POST['userId'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['role'])) {
        // Retrieve the form data
        $userId = $_POST['userId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $roleName = $_POST['role'];

        // Perform validation
        $errors = [];

        // Check if any required field is empty
        if (empty($firstName)) {
            $errors['firstName'] = 'First Name is required.';
        } elseif (preg_match("/<[^>]*>/", $firstName)) { // Check if HTML tags are present
            $errors['firstName'] = 'First Name cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $firstName)) { // Check for SQL injection
            $errors['firstName'] = 'First Name cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $firstName)) { // Check for PHP tags
            $errors['firstName'] = 'First Name cannot contain PHP tags.';
        }

        if (empty($lastName)) {
            $errors['lastName'] = 'Last Name is required.';
        } elseif (preg_match("/<[^>]*>/", $lastName)) { // Check if HTML tags are present
            $errors['lastName'] = 'Last Name cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $lastName)) { // Check for SQL injection
            $errors['lastName'] = 'Last Name cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $lastName)) { // Check for PHP tags
            $errors['lastName'] = 'Last Name cannot contain PHP tags.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Valid Email is required.';
        } elseif (preg_match("/<[^>]*>/", $email)) { // Check if HTML tags are present
            $errors['email'] = 'Email cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $email)) { // Check for SQL injection
            $errors['email'] = 'Email cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $email)) { // Check for PHP tags
            $errors['email'] = 'Email cannot contain PHP tags.';
        } else {
            // Check if email is already registered
            $sql_check_email = "SELECT COUNT(*) AS count FROM users WHERE email = ? AND user_id != ?";
            $stmt_check_email = $conn->prepare($sql_check_email);
            $stmt_check_email->bind_param("si", $email, $user_id);
            $stmt_check_email->execute();
            $result_check_email = $stmt_check_email->get_result();
            $row_check_email = $result_check_email->fetch_assoc();
            if ($row_check_email['count'] > 0) {
                $errors['email'] = 'Email is already registered.';
            }
            $stmt_check_email->close();
        }

        if (empty($roleName)) {
            $errors['role'] = 'Role is required.';
        } elseif (preg_match("/<[^>]*>/", $roleName)) { // Check if HTML tags are present
            $errors['role'] = 'Role cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $roleName)) { // Check for SQL injection
            $errors['role'] = 'Role cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $roleName)) { // Check for PHP tags
            $errors['role'] = 'Role cannot contain PHP tags.';
        }

        // If there are validation errors, return the error messages
        if (!empty($errors)) {
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
                    // Fetch user information from session or database
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];

                        // Fetch user details from the database using user_id
                        $sqlUser = "SELECT fname, lname, role_id FROM users WHERE user_id = ?";
                        $stmtUser = $conn->prepare($sqlUser);
                        $stmtUser->bind_param("i", $user_id);
                        $stmtUser->execute();
                        $result = $stmtUser->get_result();

                        if ($row = $result->fetch_assoc()) {
                            $fname = $row['fname'];
                            $lname = $row['lname'];
                            $role_id = $row['role_id'];

                            // Log the action with user details
                            logAudit($user_id, $fname, $lname, $role_id, "User updated: '$firstName $lastName'");
                        }
                        $stmtUser->close();
                    }
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