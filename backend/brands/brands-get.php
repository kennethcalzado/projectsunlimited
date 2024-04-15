<?php
include '../../backend/conn.php'; // Include the database connection script

try {
    // Fetch pages from the database
    $stmt = $conn->prepare("SELECT * FROM brands");
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the rows from the result set as an associative array
    $brands = array();
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row;
    }

    // Return the pages data in JSON format
    header('Content-Type: application/json');
    echo json_encode($brands);
} catch (Exception $e) {
    // Handle database connection errors
    echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
}
?>