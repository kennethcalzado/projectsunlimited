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
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : ''; // Add search query parameter

// Build SQL query with filters and search condition
$sql = "SELECT CategoryID, CategoryName, type, status FROM productcategory WHERE 1 ";

// Add search condition
if (!empty($searchQuery)) {
    $searchQuery = $conn->real_escape_string($searchQuery); // Prevent SQL injection
    $sql .= "AND (CategoryName LIKE '%$searchQuery%' OR type LIKE '%$searchQuery%' OR status LIKE '%$searchQuery%') ";
}

if ($typeFilter != 'typereset') {
    $sql .= "AND type = '$typeFilter' ";
}

if ($statusFilter != 'statusreset') {
    $sql .= "AND status = '$statusFilter' ";
}

// Modify the default sorting to order 'inactive' categories last
$sql .= "ORDER BY CASE WHEN status = 'inactive' THEN 1 ELSE 0 END, created_at";

if ($sortFilter == 'newest') {
    $sql .= " DESC";
} elseif ($sortFilter == 'oldest') {
    $sql .= " ASC";
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
    $mainCategoriesSql = "SELECT DISTINCT pc.CategoryID, pc.CategoryName, pc.type, pc.status 
    FROM productcategory pc 
    LEFT JOIN productcategory pcp ON pc.CategoryID = pcp.ParentCategoryID 
    WHERE (pcp.CategoryID IS NOT NULL OR (pc.imagecover IS NOT NULL AND pc.imageheader IS NOT NULL))";

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
