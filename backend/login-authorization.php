<?php
include 'conn.php';

// Start session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error: " . $conn->error;
        die();
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
                $_SESSION['user_role'] = ucfirst($roleData['role_name']);
            } else {
                // Handle the case where the role is not found
                $_SESSION['user_role'] = 'guest'; // or any default role you prefer
            }

            // Redirect based on user's role
            if ($_SESSION['user_role'] === 'Admin' || $_SESSION['user_role'] === 'Marketing') {
                // Admin dashboard
                header('Location: ../public\users\admin\admin-dashboard.php');
                exit;
            } else {
                // Default dashboard for other roles or unauthorized users
                header('Location: ../public/home.php');
                exit();
            }
        } else {
            // Password is incorrect
            echo "Incorrect password";
        }
    } else {
        // User not found
        echo "User not found";
    }
}
