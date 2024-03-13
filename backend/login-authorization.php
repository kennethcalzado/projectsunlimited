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
            $_SESSION['user_role'] = $user['level_id']; // Assuming 'level_id' contains the user's role

            // Redirect based on user's role
            if ($_SESSION['user_role'] === '1') {
                // Admin dashboard
                header('Location: ../public/admin/admin-dashboard.php');
                exit;
            } elseif ($_SESSION['user_role'] === '2') {
                // Marketing dashboard
                header('Location: ../public/marketing/marketing-dashboard.php');
                exit();
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
?>