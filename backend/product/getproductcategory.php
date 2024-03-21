<?php
include '../../backend/conn.php';

$sql = "SELECT * FROM productcategory";
$result = $conn->query($sql);

if ($result === false) {
    // Error handling if the query fails
    $error = ["error" => $conn->error];
    http_response_code(500); // Set HTTP response code to indicate internal server error
    echo json_encode($error);
    exit();
}

$productCategory = array();
if ($result->num_rows > 0) {
    // Fetch productCategory data
    while ($row = $result->fetch_assoc()) {
        $productCategory[] = $row;
    }
}

// Return JSON response with productCategory data
header('Content-Type: application/json');
echo json_encode($productCategory);
?>