<?php
include '../../backend/conn.php'; // Include the database connection script

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $firstName = $_POST['createFirstName'];
    $lastName = $_POST['createLastName'];
    $username = $_POST['createUsername'];
    $email = $_POST['createEmail'];
    $role = $_POST['createRole'];

    // Perform validation
    $errors = [];

    // Check if any required field is empty
    if (empty ($firstName)) {
        $errors[] = 'First Name is required.';
    }
    if (empty ($lastName)) {
        $errors[] = 'Last Name is required.';
    }
    if (empty ($username)) {
        $errors[] = 'Username is required.';
    }
    if (empty ($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid Email is required.';
    }
    if (empty ($role)) {
        $errors[] = 'Role is required.';
    }

    // If there are validation errors, return the error messages
    if (!empty ($errors)) {
        echo json_encode(['success' => false, 'message' => implode("\n", $errors)]);
        exit;
    }

    // Prepare the insertion query
    $sql = "INSERT INTO users (fname, lname, username, email, role_id) 
            VALUES ('$firstName', '$lastName', '$username', '$email', '$role')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'User created successfully']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
    }

    // Close the database connection
    $conn->close();
} else {
    // If the request method is not POST, return an error message
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>