<?php
session_start();
include '../../backend/conn.php';

// Define all possible availability statuses
$allStatuses = ['Available', 'Low Stocks', 'Unavailable'];

// Fetch distinct availability options from the database
$query = "SELECT DISTINCT availability FROM product_variation";
$result = mysqli_query($conn, $query);

$options = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $options[] = $row['availability'];
    }
}

// Merge fetched availability options with all possible statuses
$options = array_merge($allStatuses, $options);

// Remove duplicates
$options = array_unique($options);

// Return JSON response
echo json_encode($options);
?>
