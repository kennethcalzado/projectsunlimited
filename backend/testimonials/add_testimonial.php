<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("../../backend/conn.php");

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
