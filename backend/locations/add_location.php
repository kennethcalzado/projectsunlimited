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
    $name = $_POST['name'];
    $address = $_POST['address'];
    $time = $_POST['time'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $map = $_POST['map'];

    // Insert data into the database
    $sql = "INSERT INTO locations (name, address, time, phone, email, map) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $address, $time, $phone, $email, $map);

    if ($stmt->execute()) {
        // Redirect back to the page with success message
        $_SESSION['success'] = "Location added successfully!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Redirect back to the page with error message
        $_SESSION['error'] = "Failed to add location. Please try again.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
