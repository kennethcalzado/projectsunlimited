<?php
session_start();
include 'conn.php';
include 'auditlog.php'; // Include the auditlog.php file

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
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

    // Query to check if the user exists and is active
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, check status
        $user = $result->fetch_assoc();
        if ($user['status'] === 'inactive') {
            // Account is inactive, return message
            echo json_encode(['success' => false, 'message' => 'Account deactivated. Please contact the company for further instructions.']);
            exit;
        }

        // User is active, check password
        if (password_verify($password, $user['password_hash'])) {
            // Password is correct, login successful

            // Store user data in session variables
            $_SESSION['user_id'] = $user['user_id'];

            // Retrieve user's role from the roles table based on role_id
            $sql = "SELECT role_name FROM roles WHERE role_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user['role_id']);
            $stmt->execute();
            $result = $stmt->get_result();

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

            // Log the login action
            logAudit($user['user_id'], $user['fname'], $user['lname'], $user['role_id'], "Login");

            // Redirect based on user's role
            if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'marketing') {
                echo json_encode(['success' => true, 'role' => $_SESSION['user_role']]);
            }

            exit;
        } else {
            // Password is incorrect
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
            exit;
        }
    } else {
        // User not found
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }
}

function generate_token()
{
    // Generate a unique token using a secure method
    return bin2hex(random_bytes(32));
}
?>