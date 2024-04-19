<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories from the database
$sql = "SELECT CategoryID, CategoryName, type, status FROM productcategory";
$result = $conn->query($sql);

// Check if any categories are fetched
if ($result->num_rows > 0) {
    // Store categories in an array
    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    
    // Return categories as JSON
    header('Content-Type: application/json');
    echo json_encode($categories);
} else {
    // Return an empty array if no categories found
    header('Content-Type: application/json');
    echo json_encode(array());
}

// Close database connection
$conn->close();
?>