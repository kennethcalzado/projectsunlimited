<?php
include '../../backend/conn.php'; // Include the database connection script

try {
    // Your SQL query to fetch brands data
    $sql = "SELECT * FROM brands";

    // Execute the query
    $result = $conn->query($sql);

    // Prepare an array to hold the data
    $brands = array();

    // Fetch data and add to the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $brands[] = $row;
        }
    }

    // Send the JSON response
    echo json_encode($brands);
} catch (Exception $e) {
    // Handle database connection errors
    echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
}
?>
