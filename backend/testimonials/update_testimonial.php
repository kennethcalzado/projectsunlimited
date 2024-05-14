<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("../../backend/conn.php");
// Include the auditlog.php file
include("../../backend/auditlog.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $blogId = $_POST['blogIdToUpdate'];
    $message = $_POST['message'];
    $name = $_POST['name'];
    $company = $_POST['company'];

    // Update data in the database
    $sql = "UPDATE testimonials SET message = ?, cname = ?, company = ?";
    $param_types = "sss";
    $param_values = array($message, $name, $company);

    $sql .= " WHERE id = ?";
    $param_types .= "i";
    $param_values[] = $blogId;

    // Prepare and bind parameters for the update query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($param_types, ...$param_values);

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
                logAudit($user_id, $fname, $lname, $role_id, "Updated testimonial from: '$company'");
            }
        }

        // Redirect back to the page with success message
        $_SESSION['success'] = "Blog updated successfully!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Redirect back to the page with error message
        $_SESSION['error'] = "Failed to update blog. Please try again.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
