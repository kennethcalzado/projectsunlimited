<?php
include '../../backend/conn.php';

// Check if the catalogId is provided as a query parameter
if(isset($_GET['catalogId'])) {
    // Sanitize the catalogId to prevent SQL injection
    $catalogId = intval($_GET['catalogId']);

    // Retrieve the catalog path from the database using the provided catalogId
    $sql = "SELECT catalog_path FROM catalogs WHERE catalog_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the catalogId parameter and execute the statement
        $stmt->bind_param("i", $catalogId);
        if ($stmt->execute()) {
            // Bind the result variable
            $stmt->bind_result($catalogPath);

            // Fetch the result
            $stmt->fetch();

            // Close the statement
            $stmt->close();

            // Check if the catalog path is valid
            if (!empty($catalogPath) && is_readable($catalogPath)) {
                // Set headers for force download
                header("Content-Type: application/pdf");
                header("Content-Disposition: attachment; filename=" . basename($catalogPath));
                header("Content-Length: " . filesize($catalogPath));

                // Output the file content
                readfile($catalogPath);
                exit;
            } else {
                // Catalog path is empty or not readable
                http_response_code(404); // Set HTTP response code to indicate not found
                echo "File not found or inaccessible.";
                exit;
            }
        }
    }
}

// If catalogId is not provided or the retrieval from the database fails, return an error message
http_response_code(400); // Set HTTP response code to indicate bad request
echo "Invalid catalogId parameter or failed to retrieve catalog path.";
?>
