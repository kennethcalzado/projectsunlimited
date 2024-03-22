<?php
include '../../backend/conn.php'; // Include the database connection script

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $roleName = $_POST['role']; // Assuming role name is passed from the form

    // Perform validation
    $errors = [];

    // Check if any required field is empty
    if (empty ($firstName)) {
        $errors['firstName'] = 'First Name is required.';
    }

    if (empty ($lastName)) {
        $errors['lastName'] = 'Last Name is required.';
    }

    if (empty ($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid Email is required.';
    } else {
        // Check if email is already registered
        $sql_check_email = "SELECT COUNT(*) AS count FROM users WHERE email = '$email'";
        $result_check_email = $conn->query($sql_check_email);
        $row_check_email = $result_check_email->fetch_assoc();
        if ($row_check_email['count'] > 0) {
            $errors['email'] = 'Email is already registered.';
        }
    }

    if (empty ($roleName)) {
        $errors['role'] = 'Role is required.';
    }

    // If there are validation errors, return the error messages
    if (!empty ($errors)) {
        echo json_encode(['success' => false, 'message' => $errors]);
        exit;
    }

    // Retrieve role ID based on role name
    $sql_get_role_id = "SELECT role_id FROM roles WHERE role_name = '$roleName'";
    $result_get_role_id = $conn->query($sql_get_role_id);

    if ($result_get_role_id->num_rows > 0) {
        $row = $result_get_role_id->fetch_assoc();
        $roleId = $row['role_id'];

        // Prepare the insertion query
        $sql = "INSERT INTO users (fname, lname, email, role_id, updated_at, created_at) 
                VALUES ('$firstName', '$lastName', '$email', '$roleId', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'User created successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Role not found']);
    }

    // Close the database connection
    $conn->close();
} else {
    // If the request method is not POST, return an error message
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>