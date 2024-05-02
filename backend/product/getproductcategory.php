<?php
include '../../backend/conn.php';

$sql = "SELECT * FROM productcategory";
$result = $conn->query($sql);

if ($result === false) {
    // Error handling if the query fails
    $error = ["error" => $conn->error];
    http_response_code(500); // Set HTTP response code to indicate internal server error
    echo json_encode($error);
    exit();
}

$productCategories = [
    "Main Category" => [], // Initialize array for main categories
    "Sub Category" => []   // Initialize array for sub categories
];

if ($result->num_rows > 0) {
    // Fetch productCategory data
    while ($row = $result->fetch_assoc()) {
        // Check if the category is a Main Category or Sub Category
        if ($row['ParentCategoryID'] === null) {
            // Group as Main Category
            $productCategories["Main Category"][] = $row;
        } else {
            // Group as Sub Category
            $productCategories["Sub Category"][] = $row;
        }
    }
}

// Return JSON response with grouped productCategory data
header('Content-Type: application/json');
echo json_encode($productCategories);
?>
