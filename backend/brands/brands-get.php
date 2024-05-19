<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the database connection script

$errorLogPath = __DIR__ . '\error.log';
ini_set('error_log', $errorLogPath);

try {
    // Your SQL query to fetch brands data along with catalogs and images
    $sql = "SELECT brands.*, 
                   GROUP_CONCAT(catalogs.catalog_id) AS catalog_ids, 
                   GROUP_CONCAT(catalogs.catalog_path) AS catalog_paths,
                   brands.images
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
            // Convert catalog paths and ids to arrays
            $catalogIds = ($row['catalog_ids'] !== null) ? explode(',', $row['catalog_ids']) : array();
            $catalogPaths = ($row['catalog_paths'] !== null) ? explode(',', $row['catalog_paths']) : array();
            
            // Combine catalog ids and paths into an array of arrays
            $catalogs = array();
            foreach ($catalogIds as $index => $catalogId) {
                $catalogs[] = array(
                    'catalogId' => $catalogId,
                    'path' => $catalogPaths[$index],
                    'size' => filesize('../../assets/catalogs/' . basename($catalogPaths[$index])) // Get file size
                );
            }

            // Convert images JSON to array
            $images = json_decode($row['images'], true);

            // Remove redundant columns from the row
            unset($row['catalog_ids'], $row['catalog_paths'], $row['images']);

            // Add the catalogs array and images array to the row
            $row['catalogs'] = $catalogs;
            $row['images'] = $images;

            // Add the modified row to the brands array
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
