<?php
include '../../backend/conn.php'; // Include the database connection script

// Query to retrieve user data with role information
$sql = "SELECT u.user_id, u.username, u.fname, u.lname, u.email, r.role_name AS role FROM users u INNER JOIN roles r ON u.role_id = r.role_id";
$result = $conn->query($sql);

if ($result === false) {
    // Error handling if the query fails
    $error = ["error" => $conn->error];
    http_response_code(500); // Set HTTP response code to indicate internal server error
    echo json_encode($error);
    exit();
}

$users = array();
if ($result->num_rows > 0) {
    // Fetch user data
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Return JSON response with user data
header('Content-Type: application/json');
echo json_encode($users);
?>