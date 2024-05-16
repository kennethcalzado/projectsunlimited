<?php
header('Content-Type: application/json');

// Include your database connection
include '../../backend/conn.php';

// Fetch distinct status from the productcategory table
$sql = "SELECT DISTINCT status FROM product_variation";
$result = $conn->query($sql);

// Store statuses in an array
$statuses = array();

// Check if any statuses are fetched
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statuses[] = $row['status'];
    }
}

// Add any additional statuses if they are not already in the array
$additional_statuses = array('active', 'inactive'); // Add your desired statuses here
foreach ($additional_statuses as $status) {
    if (!in_array($status, $statuses)) {
        $statuses[] = $status;
    }
}

// Return statuses as JSON
echo json_encode($statuses);

// Close database connection
$conn->close();
?>
