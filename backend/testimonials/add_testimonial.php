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
    $message = $_POST['message'];
    $name = $_POST['name'];
    $company = $_POST['company'];

    // Insert data into the database
    $sql = "INSERT INTO testimonials (message, cname, company) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $message, $name, $company);

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
                logAudit($user_id, $fname, $lname, $role_id, "Added testimonial from: '$company'");
            }
        }

        // Redirect back to the page with success message
        $_SESSION['success'] = "Testimonial added successfully!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Redirect back to the page with error message
        $_SESSION['error'] = "Failed to add testimonial. Please try again.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
