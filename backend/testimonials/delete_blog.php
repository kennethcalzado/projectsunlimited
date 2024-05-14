<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("../../backend/conn.php");
// Include the auditlog.php file
include("../../backend/auditlog.php");

// Check if blog ID is provided
if (isset($_POST['blogId'])) {
    $blogId = $_POST['blogId'];

    // Prepare and execute SQL query to delete the blog
    $sql = "DELETE FROM testimonials WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blogId);

    if ($stmt->execute()) {


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
                logAudit($user_id, $fname, $lname, $role_id, "Deleted testimonial: '$blogId'");
            }
        }

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
