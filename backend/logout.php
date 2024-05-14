<?php
session_start();

// Include necessary files
include 'auditlog.php';
include 'conn.php';

// Destroy session data
session_destroy();

// Fetch user information from session or database
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user details from the database using user_id
    $sql = "SELECT fname, lname, role_id FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $fname = $row['fname'];
        $lname = $row['lname'];
        $role_id = $row['role_id'];

        // Log the action with user details
        logAudit($user_id, $fname, $lname, $role_id, "Logout");
    }
}

// Redirect to the login page after logout
header("Location: ../public/login.php");
exit;
