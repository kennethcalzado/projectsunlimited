<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("../../backend/conn.php");

// Check if blog ID is provided
if (isset($_POST['blogId'])) {
    $blogId = $_POST['blogId'];

    // Prepare and execute SQL query to delete the blog
    $sql = "DELETE FROM locations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blogId);

    if ($stmt->execute()) {
        // Blog deleted successfully
        echo "success";
        exit();
    } else {
        // Failed to delete blog
        echo "error";
        exit();
    }
} else {
    // Blog ID not provided
    echo "error";
    exit();
}
