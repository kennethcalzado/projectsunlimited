<?php
session_start();
include 'conn.php';

// Check if form is submitted
if (isset($_SERVER['REQUEST_METHOD'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email'], $_POST['password'])) {
            // Retrieve username and password from the form
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Perform validation
            $errors = [];

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email is required.';
            }

            if (empty($password)) {
                $errors['password'] = 'Password is required.';
            }

            // If there are validation errors, return the error messages
            if (!empty($errors)) {
                echo json_encode(['success' => false, 'message' => $errors]);
                exit;
            }

            // Query to check if the user exists
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result === false) {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'message' => 'Database error']);
                exit;
            }

            if ($result->num_rows > 0) {
                // User found, check password
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password_hash'])) {
                    // Password is correct, login successful
                     
                    // Store user data in session variables
                    $_SESSION['user_id'] = $user['user_id'];

                    // Retrieve user's role from the roles table based on role_id
                    $sql = "SELECT role_name FROM roles WHERE role_id = '" . $user['role_id'] . "'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $roleData = $result->fetch_assoc();
                        $_SESSION['user_role'] = $roleData['role_name'];
                    }

                    if (isset($_POST['remember'])) {
                        // Generate a unique token
                        $token = generate_token();
                
                        // Store the token in a cookie with a long expiration time
                        setcookie('remember_token', $token, time() + (60 * 60 * 24 * 30), '/');
                    }

                    // Redirect based on user's role
                    if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'marketing') {
                        echo json_encode(['success' => true, 'role' => $_SESSION['user_role']]);
                    }

                    exit;
                } else {
                    // Password is incorrect
                    $errors['password'] = 'Incorrect password';

                    // http_response_code(401); // Unauthorized
                    echo json_encode(['success' => false, 'message' => $errors]);
                    exit;
                }
            } else {
                // User not found
                http_response_code(404); // Not Found
                echo json_encode(['success' => false, 'message' => 'User not found']);
                exit;
            }
        }
    }
}

function generate_token() {
    // Generate a unique token using a secure method
    return bin2hex(random_bytes(32));
}
?>