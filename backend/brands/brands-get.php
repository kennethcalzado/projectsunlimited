<?php
include '../../backend/conn.php'; // Include the database connection script

try {
    // Your SQL query to fetch brands data along with catalogs
    $sql = "SELECT brands.*, GROUP_CONCAT(catalogs.catalog_path) AS catalog_paths 
            FROM brands 
            LEFT JOIN catalogs ON brands.brand_id = catalogs.brand_id 
            GROUP BY brands.brand_id";

    // Execute the query
    $result = $conn->query($sql);

    // Prepare an array to hold the data
    $brands = array();

    // Fetch data and add to the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert catalog paths to an array if not null
            $catalogPaths = ($row['catalog_paths'] !== null) ? explode(',', $row['catalog_paths']) : array();
            $row['catalogs'] = $catalogPaths;
            unset($row['catalog_paths']); // Remove catalog paths from the row
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
