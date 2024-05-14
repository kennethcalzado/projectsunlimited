<?php
include '../../backend/conn.php'; // Include the database connection script

// Function to generate a password
function generatePassword($fname, $lname, $roleId)
{
    // Ensure the first letters are uppercase
    $firstLetterFname = strtoupper(substr($fname, 0, 1));
    $firstLetterLname = strtoupper(substr($lname, 0, 1));

    // Ensure the second letters are lowercase
    $secondLetterFname = strtolower(substr($fname, 1, 1));
    $secondLetterLname = strtolower(substr($lname, 1, 1));

    // Concatenate the components
    $password = $firstLetterFname . $secondLetterFname . '.' . $firstLetterLname . $secondLetterLname . '.00' . $roleId;

    return $password;
}

// Default response
$response = ['success' => false, 'message' => 'An unexpected error occurred'];

try {
    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if all required fields are present
        if (isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['role'])) {
            // Retrieve the form data
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $roleName = $_POST['role'];

            // Perform validation
            $errors = array();

            // Check if any required field is empty
            if (empty($firstName)) {
                $errors['firstName'] = 'First Name is required.';
            }

            if (empty($lastName)) {
                $errors['lastName'] = 'Last Name is required.';
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Valid Email is required.';
            } else {
                // Check if email is already registered
                $sql_check_email = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
                $stmt_check_email = $conn->prepare($sql_check_email);
                $stmt_check_email->bind_param("s", $email);
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
            }

            // If there are validation errors, return the error messages
            if (!empty($errors)) {
                $response = ['success' => false, 'message' => $errors];
            } else {
                // Retrieve role ID based on role name
                $sql_get_role_id = "SELECT role_id FROM roles WHERE role_name = ?";
                $stmt_get_role_id = $conn->prepare($sql_get_role_id);
                $stmt_get_role_id->bind_param("s", $roleName);
                $stmt_get_role_id->execute();
                $result_get_role_id = $stmt_get_role_id->get_result();

                if ($result_get_role_id->num_rows > 0) {
                    $row = $result_get_role_id->fetch_assoc();
                    $roleId = $row['role_id'];
                    $stmt_get_role_id->close();

                    // Generate random password
                    $password = generatePassword($firstName, $lastName, $roleId);
                    // var_dump($password);
                    // exit();
                    
                    // Prepare the insertion query
                    $sql_insert_user = "INSERT INTO users (fname, lname, email, role_id, password_hash, updated_at, created_at) 
                            VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

                    // Use prepared statements to prevent SQL injection
                    $stmt_insert_user = $conn->prepare($sql_insert_user);
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt_insert_user->bind_param("sssis", $firstName, $lastName, $email, $roleId, $hashedPassword);

                    // Execute the query
                    if ($stmt_insert_user->execute()) {
                        // Successfully inserted the user
                        $response = ['success' => true, 'message' => 'User created successfully', 'password' => $password];
                    } else {
                        // Handle error
                        $response = ['success' => false, 'message' => 'Error: ' . $stmt_insert_user->error];
                    }
                    $stmt_insert_user->close();
                } else {
                    $response = ['success' => false, 'message' => 'Role not found'];
                    $stmt_get_role_id->close();
                }
            }
        } else {
            // Required fields are missing
            $response = ["success" => false, "message" => "Missing parameters"];
            http_response_code(400); // Set HTTP response code to indicate bad request
        }
    } else {
        // If the request method is not POST, return an error message
        $response = ['success' => false, 'message' => 'Invalid request method'];
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Exception: ' . $e->getMessage()];
} finally {
    // Close the database connection
    $conn->close();
    // Output the response in JSON format
    echo json_encode($response);
}
?>