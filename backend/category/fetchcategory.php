<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store filter values
$typeFilter = isset($_GET['type']) ? $_GET['type'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sortFilter = isset($_GET['sort']) ? $_GET['sort'] : '';

// Build SQL query with filters
$sql = "SELECT CategoryID, CategoryName, type, status FROM productcategory WHERE 1 ";

if ($typeFilter != 'typereset') {
    $sql .= "AND type = '$typeFilter' ";
}

if ($statusFilter != 'statusreset') {
    $sql .= "AND status = '$statusFilter' ";
}

if ($sortFilter == 'newest') {
    $sql .= "ORDER BY created_at DESC";
} elseif ($sortFilter == 'oldest') {
    $sql .= "ORDER BY created_at ASC";
}

// Execute SQL query
$result = $conn->query($sql);

// Check if any categories are fetched
if ($result->num_rows > 0) {
    // Store categories in an array
    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    // Fetch main categories
    $mainCategoriesSql = "SELECT CategoryID, CategoryName FROM productcategory";
    $mainCategoriesResult = $conn->query($mainCategoriesSql);
    $mainCategories = array();
    while ($row = $mainCategoriesResult->fetch_assoc()) {
        $mainCategories[] = $row;
    }

    // Combine main categories and categories for the table
    $data = array(
        'mainCategories' => $mainCategories,
        'categories' => $categories
    );

    // Return categories as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Return an empty array if no categories found
    header('Content-Type: application/json');
    echo json_encode(array());
}

// Close database connection
$conn->close();
?>