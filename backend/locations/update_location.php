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
    $blogId = $_POST['blogIdToUpdate'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $map = $_POST['map'];

    // Update data in the database
    $sql = "UPDATE locations SET name = ?, address = ?, phone = ?, email = ?, map = ?";
    $param_types = "sssss";
    $param_values = array($name, $address, $phone, $email, $map);

    $sql .= " WHERE id = ?";
    $param_types .= "i";
    $param_values[] = $blogId;

    // Prepare and bind parameters for the update query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($param_types, ...$param_values);

    if ($stmt->execute()) {
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
