<?php
include '../../backend/conn.php';

// Check if the connection is established successfully
if ($conn) {
    // Fetching data from the database
    $query = "SELECT * FROM product";
    $result = mysqli_query($conn, $query);

    // Check if the query was executed successfully
    if ($result) {
        // Check if there are any rows returned from the query
        if (mysqli_num_rows($result) > 0) {
            // Looping through the results and returning them as an array
            $product = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row;
            }
            // Output JSON content only
            echo json_encode($product);
        } else {
            // If no rows are returned, return an empty array
            echo json_encode([]);
        }
    } else {
        // If the query failed to execute, return an error message
        echo json_encode(["error" => "Failed to execute query: " . mysqli_error($conn)]);
    }
} else {
    // Return an error message if connection fails
    echo json_encode(["error" => "Failed to connect to the database"]);
}
?>
