<?php
// Include the database connection file
include '../../backend/conn.php';

// Define the SQL query with the condition for active status
$sql = "SELECT * FROM productcategory WHERE ParentCategoryID IS NULL AND status = 'active'";

// Execute the SQL query
$result = mysqli_query($conn, $sql);
$categories = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

// Return categories as JSON
echo json_encode($categories);
?>
