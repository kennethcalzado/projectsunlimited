<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Check if the connection is established successfully
if ($conn) {
    // Construct SQL query to fetch availability options for all products
    $sql = "SELECT DISTINCT availability FROM product";
    
    // Execute the SQL query
    $result = mysqli_query($conn, $sql);
    
    // Check if the query was executed successfully
    if ($result) {
        // Initialize an array to store availability options
        $availabilityOptions = array();
        
        // Loop through the results and fetch each availability option
        while ($row = mysqli_fetch_assoc($result)) {
            // Add availability option to the array
            $availabilityOptions[] = $row['availability'];
        }
        
        // Output the availability options array as JSON
        echo json_encode($availabilityOptions);
    } else {
        // If the query failed to execute, return an error message
        echo json_encode(array("error" => "Failed to execute query: " . mysqli_error($conn)));
    }
} else {
    // Return an error message if connection fails
    echo json_encode(array("error" => "Failed to connect to the database"));
}
?>
