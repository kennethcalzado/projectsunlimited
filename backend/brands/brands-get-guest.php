<?php
include '../../backend/conn.php'; // Include the database connection script

try {
    // Your SQL query to fetch brands data with associated catalogs
    $sql = "SELECT b.brand_name, b.logo_url, b.description, b.type, c.catalog_title, c.catalog_path 
            FROM brands AS b 
            LEFT JOIN catalogs AS c ON b.brand_id = c.brand_id 
            WHERE b.status = 'active'";

    // Execute the query
    $result = $conn->query($sql);

    // Prepare an array to hold the data
    $brands = array();

    // Fetch data and add to the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $brand_name = $row['brand_name'];
            // Check if the brand is already in the array
            if (!isset($brands[$brand_name])) {
                // If not, add it to the array
                $brands[$brand_name] = array(
                    'brand_name' => $brand_name,
                    'logo_url' => $row['logo_url'],
                    'description' => $row['description'],
                    'type' => $row['type'],
                    'catalogs' => array()
                );
            }
            // Add catalog details to the brand's catalogs array
            if (!is_null($row['catalog_title']) && !is_null($row['catalog_path'])) {
                $brands[$brand_name]['catalogs'][] = array(
                    'catalog_title' => $row['catalog_title'],
                    'catalog_path' => $row['catalog_path']
                );
            }
        }
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode(array_values($brands)); // Convert associative array to indexed array
} catch (Exception $e) {
    // Handle database connection errors
    echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
}
?>
