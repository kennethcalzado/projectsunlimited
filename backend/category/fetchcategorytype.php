<?php
header('Content-Type: application/json');

// Include your database connection
include '../../backend/conn.php';

// Fetch distinct types from the productcategory table
$sql = "SELECT DISTINCT type FROM productcategory";
$result = $conn->query($sql);

// Store types in an array
$types = array();

// Check if any types are fetched
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $types[] = $row['type'];
    }
}

// Add "product" and "customizable" options if they are not already in the array
if (!in_array("product", $types)) {
    $types[] = "product";
}
if (!in_array("customizable", $types)) {
    $types[] = "customizable";
}

// Return types as JSON
echo json_encode($types);

// Close database connection
$conn->close();
?>
