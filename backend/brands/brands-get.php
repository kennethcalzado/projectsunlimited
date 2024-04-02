<?php
include '../../backend/conn.php'; // Include the database connection script

// Query to retrieve all roles
$sql = "SELECT * FROM brands";
$result = $conn->query($sql);

if ($result === false) {
    // Error handling if the query fails
    $error = ["error" => $conn->error];
    http_response_code(500); // Set HTTP response code to indicate internal server error
    echo json_encode($error);
    exit();
}

$brands = array();
if ($result->num_rows > 0) {
    // Fetch roles data
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row;
    }
}

// Return JSON response with roles data
header('Content-Type: application/json');
echo json_encode($brands);
?>