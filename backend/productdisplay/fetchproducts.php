<?php
include '../../backend/conn.php';

// Check if the connection is established successfully
if ($conn) {
    // Get the categories from the POST request
    $categories = json_decode($_POST['categories']);

    // Construct the SQL query to fetch products based on categories
    $categoryNames = [];
    foreach ($categories as $category) {
        $categoryNames[] = mysqli_real_escape_string($conn, $category);
    }
    $categoryNamesString = "'" . implode("','", $categoryNames) . "'";

    // Query to fetch products based on categories
    $sql = "SELECT p.*, pc.CategoryName FROM product p
            JOIN productcategory pc ON p.CategoryID = pc.CategoryID
            WHERE pc.CategoryName IN ($categoryNamesString)";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Construct the full image URLs
            $imageFileNames = explode(',', $row['image_urls']);
            $imageUrls = [];
            foreach ($imageFileNames as $fileName) {
                $imageUrls[] = '../../assets/products/' . $fileName;
            }
            // Add each product to the products array with full image URLs
            $row['image_urls'] = $imageUrls;
            $products[] = $row;
        }
        // Return products as JSON
        echo json_encode($products);
    } else {
        // Return error message as JSON
        echo json_encode(['error' => mysqli_error($conn)]);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Return connection error message as JSON
    echo json_encode(['error' => 'Database connection error']);
}
?>
