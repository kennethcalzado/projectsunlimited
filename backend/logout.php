<?php
session_start();

// Include necessary files
include 'auditlog.php';
include 'conn.php';

// Log the logout action
logAudit($user_id, $fname, $lname, $role_id, "Logout");

// Destroy session data
session_destroy();

// Redirect to the login page after logout
header("Location: ../public/login.php");
exit;
