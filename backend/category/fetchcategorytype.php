<?php
include '../../backend/conn.php';

// Fetch data from the productcategory table
$query = "SELECT type FROM productcategory";
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    $categories = array();
    // Loop through the results to fetch data
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    // Return data as JSON
    echo json_encode($categories);
} else {
    // Handle query error
    echo "Error: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
