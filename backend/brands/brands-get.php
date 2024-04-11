<?php
include '../../backend/conn.php'; // Include the database connection script

try {
    // Fetch pages from the database
    $stmt = $conn->prepare("SELECT pages.page_id, pages.title, pages.description, pages.page_url, brands.logo_url, brands.brand_name AS brand_name FROM pages INNER JOIN brands ON pages.brand_id = brands.brand_id");
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the rows from the result set as an associative array
    $pages = [];
    while ($row = $result->fetch_assoc()) {
        $pages[] = $row;
    }

    // Return the pages data in JSON format
    header('Content-Type: application/json');
    echo json_encode($pages);
} catch (Exception $e) {
    // Handle database connection errors
    echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
}
?>