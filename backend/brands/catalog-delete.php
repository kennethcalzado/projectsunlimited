<?php
include '../../backend/conn.php'; 

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if catalogId is set in the POST data
    if (isset($_POST['catalogId'])) {
        // Sanitize the catalogId to prevent SQL injection
        $catalogId = intval($_POST['catalogId']);

        // Prepare SQL statement to delete the catalog
        $sql = "DELETE FROM catalogs WHERE catalog_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the catalogId parameter and execute the statement
            $stmt->bind_param("i", $catalogId);
            if ($stmt->execute()) {
                // Catalog deletion successful
                echo json_encode(['success' => true]);
                exit;
            } else {
                // Catalog deletion failed
                http_response_code(500); // Set HTTP response code to indicate internal server error
                echo json_encode(['success' => false, 'message' => 'Failed to delete catalog.']);
                exit;
            }
        } else {
            // Statement preparation failed
            http_response_code(500); // Set HTTP response code to indicate internal server error
            echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
            exit;
        }
    } else {
        // Required parameter catalogId is missing
        http_response_code(400); // Set HTTP response code to indicate bad request
        echo json_encode(['success' => false, 'message' => 'Missing catalogId parameter.']);
        exit;
    }
} else {
    // Invalid request method
    http_response_code(405); // Set HTTP response code to indicate method not allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
?>
