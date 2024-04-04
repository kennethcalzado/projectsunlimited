<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Check if the connection is established successfully
if ($conn) {
    // Construct the basic SQL query
    $sql = "SELECT p.ProductName, b.brand_name, p.Description, p.image_urls, pc.CategoryName, DATE_FORMAT(p.created_at, '%b %d, %Y') AS created_at
    FROM product p 
    LEFT JOIN brands b ON p.brand_id = b.brand_id 
    LEFT JOIN productcategory pc ON p.CategoryID = pc.CategoryID
    WHERE p.image_urls IS NOT NULL AND p.image_urls != ''";

    // Check if any filter parameters are provided
    if (isset($_GET['categoryId']) && $_GET['categoryId'] !== '') {
        // Add category filter to the SQL query
        $categoryId = mysqli_real_escape_string($conn, $_GET['categoryId']);
        if ($categoryId !== 'categoryreset') {
            $sql .= " AND p.CategoryID = '$categoryId'";
        }
    }

    if (isset($_GET['brandId']) && $_GET['brandId'] !== '') {
        // Add brand filter to the SQL query
        $brandId = mysqli_real_escape_string($conn, $_GET['brandId']);
        if ($brandId !== 'brandsreset') {
            $sql .= " AND p.brand_id = '$brandId'";
        }
    }

    // Check if search term is provided
    if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
        // Sanitize and escape the search term to prevent SQL injection
        $searchTerm = mysqli_real_escape_string($conn, $_GET['searchQuery']);
        // Add search filter to the SQL query
        $sql .= " AND (p.ProductName LIKE '%$searchTerm%' 
               OR b.brand_name LIKE '%$searchTerm%' 
               OR p.Description LIKE '%$searchTerm%' 
               OR pc.CategoryName LIKE '%$searchTerm%'
               OR p.created_at LIKE '%$searchTerm%')";
    }

    // Check if a sorting option is provided
    if (isset($_GET['sortValue'])) {
        $sortValue = $_GET['sortValue'];
        // Add sorting based on creation date
        if ($sortValue == 'newest') {
            $sql .= " ORDER BY p.created_at DESC";
        } elseif ($sortValue == 'oldest') {
            $sql .= " ORDER BY p.created_at ASC";
        }
    } else {
        // Default sorting by newest to oldest
        $sql .= " ORDER BY p.created_at DESC";
    }

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if the query was executed successfully
    if ($result) {
        // Initialize an array to store the products
        $products = [];

        // Check if there are any rows returned from the query
        if (mysqli_num_rows($result) > 0) {
            // Loop through the results and fetch each row as an associative array
            while ($row = mysqli_fetch_assoc($result)) {
                // Convert image URLs string to an array
                $imageUrls = explode(',', $row['image_urls']);

                // Remove empty elements from the image URLs array
                $imageUrls = array_filter($imageUrls);

                // Replace null or empty values with a dash (-)
                $row['ProductName'] = $row['ProductName'] ?: '-';
                $row['brand_name'] = $row['brand_name'] ?: '-';
                $row['Description'] = $row['Description'] ?: '-';
                $row['CategoryName'] = $row['CategoryName'] ?: '-';

                // Add the row to the products array with the image URLs
                $row['image_urls'] = $imageUrls;
                $products[] = $row;
            }

            // Output the products array as JSON
            echo json_encode($products);
        } else {
            // If no rows are returned, return an empty array
            echo json_encode([]);
        }
    } else {
        // If the query failed to execute, return an error message
        echo json_encode(["error" => "Failed to execute query: " . mysqli_error($conn)]);
    }
} else {
    // Return an error message if connection fails
    echo json_encode(["error" => "Failed to connect to the database"]);
}
?>
