<?php
session_start();
include '../../backend/conn.php'; // Include the database connection script

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    // Retrieve user id and password from the session and form
    $userId = $_SESSION['user_id'];
    $password = $_POST['password'];

    // Perform validation
    $errors = [];

    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    // If there are validation errors, return the error messages
    if (!empty($errors)) {
        echo 'invalid';
        exit;
    }

    // Query to check if the user exists and password matches
    $sql = "SELECT password_hash FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPasswordHash = $row['password_hash'];

        // Check if the provided password matches the stored password hash
        if (password_verify($password, $storedPasswordHash)) {
            // Password is correct
            echo 'valid';
        } else {
            // Password is incorrect
            echo 'invalid';
        }
    } else {
        // User not found
        echo 'invalid';
    }
} else {
    // Invalid request
    http_response_code(400); // Bad Request
    echo 'invalid';
}
?>
