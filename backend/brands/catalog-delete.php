<?php
include '../../backend/conn.php'; 

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if catalogId is set in the POST data
    if (isset($_POST['catalogId'])) {
        // Sanitize the catalogId to prevent SQL injection
        $catalogId = intval($_POST['catalogId']);

        // Prepare SQL statement to select the catalog path
        $sql_select_path = "SELECT catalog_path FROM catalogs WHERE catalog_id = ?";
        $stmt_select_path = $conn->prepare($sql_select_path);

        if ($stmt_select_path) {
            // Bind the catalogId parameter and execute the statement
            $stmt_select_path->bind_param("i", $catalogId);
            if ($stmt_select_path->execute()) {
                // Fetch the catalog path
                $stmt_select_path->bind_result($catalogPath);
                $stmt_select_path->fetch();
                $stmt_select_path->close();

                // Delete the catalog file from the directory
                if (unlink($catalogPath)) {
                    // Prepare SQL statement to delete the catalog from the database
                    $sql_delete_catalog = "DELETE FROM catalogs WHERE catalog_id = ?";
                    $stmt_delete_catalog = $conn->prepare($sql_delete_catalog);

                    if ($stmt_delete_catalog) {
                        // Bind the catalogId parameter and execute the statement
                        $stmt_delete_catalog->bind_param("i", $catalogId);
                        if ($stmt_delete_catalog->execute()) {
                            // Catalog deletion successful
                            echo json_encode(['success' => true]);
                            exit;
                        } else {
                            // Catalog deletion from database failed
                            http_response_code(500); // Set HTTP response code to indicate internal server error
                            echo json_encode(['success' => false, 'message' => 'Failed to delete catalog from the database.']);
                            exit;
                        }
                    } else {
                        // Statement preparation failed
                        http_response_code(500); // Set HTTP response code to indicate internal server error
                        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for deleting catalog from the database.']);
                        exit;
                    }
                } else {
                    // Failed to delete the catalog file from the directory
                    http_response_code(500); // Set HTTP response code to indicate internal server error
                    echo json_encode(['success' => false, 'message' => 'Failed to delete catalog file from the directory.']);
                    exit;
                }
            } else {
                // Failed to execute the statement to fetch catalog path
                http_response_code(500); // Set HTTP response code to indicate internal server error
                echo json_encode(['success' => false, 'message' => 'Failed to fetch catalog path from the database.']);
                exit;
            }
        } else {
            // Statement preparation failed
            http_response_code(500); // Set HTTP response code to indicate internal server error
            echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for fetching catalog path from the database.']);
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
