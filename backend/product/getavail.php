<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Define all possible availability options
$allAvailabilityOptions = array('AVAILABLE', 'LOW', 'UNAVAILABLE');

// Initialize an array to store availability options
$availabilityOptions = array();

// Check if the connection is established successfully
if ($conn) {
    // Get the ProductID from the GET request, if it exists
    $ProductID = isset($_GET['ProductID']) ? $_GET['ProductID'] : '';

    // Construct SQL query to fetch all distinct availability options
    $sql = "SELECT DISTINCT availability FROM product";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if the query was executed successfully
    if ($result) {
        // Loop through the results and fetch each availability option
        while ($row = mysqli_fetch_assoc($result)) {
            // Add availability option to the array
            $availabilityOptions[] = $row['availability'];
        }
    } else {
        // If the query failed to execute, log an error message
        error_log("Failed to execute query: " . mysqli_error($conn));
    }
}

// Merge all possible availability options with the options fetched from the database
$availabilityOptions = array_merge($allAvailabilityOptions, $availabilityOptions);

// Remove duplicates and preserve order
$availabilityOptions = array_unique($availabilityOptions);

// Output the availability options array as JSON
header('Content-Type: application/json');
echo json_encode($availabilityOptions);
?>
