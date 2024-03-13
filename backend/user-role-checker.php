<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_role'])) {
    // Redirect the user to the login page or display an error message
    // For example:
    header("Location:../public\login.php");
    exit;
}

// Validate and sanitize the user role
$userRole = filter_var($_SESSION['user_role'], FILTER_SANITIZE_STRING);

// Define a list of valid roles
$validRoles = ['guest', '1', '2'];

// Check if the user role is valid
if (!in_array($userRole, $validRoles)) {
    // Handle invalid user roles (e.g., log the incident, redirect to an error page)
    // For example:
    header("Location: /error.php");
    exit;
}

// Include appropriate navigation component based on user role
if ($userRole == "guest") {
    include __DIR__ . "/include/navbar.php";
} elseif ($userRole == '1' || $userRole == '2') {
    include __DIR__ . "/include/sidebar.php";
}
?>
