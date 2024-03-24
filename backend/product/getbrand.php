<?php
include '../../backend/conn.php';

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
    // Fetch brands data
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row; // Changed $brand to $brands
    }
}

// Return JSON response with brands data
header('Content-Type: application/json');
echo json_encode($brands);
?>