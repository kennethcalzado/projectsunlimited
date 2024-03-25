<?php
include '../../backend/conn.php';

// Check if the connection is established successfully
if ($conn) {
    // Fetching data from the database
    $sql = "SELECT p.ProductName, b.brand_name, p.image_urls, pc.CategoryName, DATE_FORMAT(p.created_at, '%m-%d-%Y') AS created_at
    FROM product p 
    INNER JOIN brands b ON p.brand_id = b.brand_id 
    INNER JOIN productcategory pc ON p.CategoryID = pc.CategoryID";

    $result = mysqli_query($conn, $sql);

    // Check if the query was executed successfully
    if ($result) {
        // Initialize an array to store the products
        $products = [];

        // Check if there are any rows returned from the query
        if (mysqli_num_rows($result) > 0) {
            // Loop through the results and fetch each row as an associative array
            while ($row = mysqli_fetch_assoc($result)) {
                // Convert image URLs string to an array
                $imageUrls = explode(',', $row['image_urls']);

                // Add the row to the products array with the image URLs
                $row['image_urls'] = $imageUrls;
                $products[] = $row;
            }

            // Output the products array as JSON
            echo json_encode($products);
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
