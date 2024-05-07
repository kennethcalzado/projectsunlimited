<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Check if the connection is established successfully
if ($conn) {
    // Construct the basic SQL query
    $sql = "SELECT p.ProductID, p.ProductName, b.brand_name, p.availability, p.image_urls, pc.CategoryName, DATE_FORMAT(p.created_at, '%b %d, %Y') AS created_date, TIME_FORMAT(p.created_at, '%h:%i %p') AS created_time, p.status
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

    if (isset($_GET['status']) && $_GET['status'] !== '') {
        // Add brand filter to the SQL query
        $status = mysqli_real_escape_string($conn, $_GET['status']);
        if ($status !== 'statusreset') {
            $sql .= " AND p.status = '$status'";
        }
    }


    // Check if search term is provided
    if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
        // Sanitize and escape the search term to prevent SQL injection
        $searchTerm = mysqli_real_escape_string($conn, $_GET['searchQuery']);
        // Add search filter to the SQL query
        $sql .= " AND (p.ProductName LIKE '%$searchTerm%' 
                   OR b.brand_name LIKE '%$searchTerm%' 
                   OR p.availability LIKE '%$searchTerm%' 
                   OR pc.CategoryName LIKE '%$searchTerm%'
                   OR p.created_at LIKE '%$searchTerm%'
                   OR p.status LIKE '%$searchTerm%')";
    }

    // Check if a sorting option is provided
    if (isset($_GET['sortValue'])) {
        $sortValue = $_GET['sortValue'];
        // Add sorting based on creation date
        if ($sortValue == 'newest') {
            $sql .= " ORDER BY CASE WHEN p.status = 'inactive' THEN 1 ELSE 0 END, p.created_at DESC";
        } elseif ($sortValue == 'oldest') {
            $sql .= " ORDER BY CASE WHEN p.status = 'inactive' THEN 1 ELSE 0 END, p.created_at ASC";
        }
    } else {
        // Default sorting by newest to oldest
        $sql .= " ORDER BY CASE WHEN p.status = 'inactive' THEN 1 ELSE 0 END, p.created_at DESC";
    }

    // Execute the SQL query to get total count of items
    $resultCount = mysqli_query($conn, "SELECT COUNT(*) AS totalRows FROM ($sql) AS subquery");
    $totalRows = mysqli_fetch_assoc($resultCount)['totalRows'];

    // Initialize $limit and $page variables
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    // Calculate offset for pagination
    $offset = ($page - 1) * $limit;

    // Add LIMIT and OFFSET to SQL query for pagination
    $sqlPagination = $sql . " LIMIT $limit OFFSET $offset";

    // Execute the SQL query for pagination
    $result = mysqli_query($conn, $sqlPagination);

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
                $row['availability'] = $row['availability'] ?: '-';
                $row['CategoryName'] = $row['CategoryName'] ?: '-';

                // Add the row to the products array with the image URLs
                $row['image_urls'] = $imageUrls;
                $products[] = $row;
            }

            // Calculate the total number of pages
            $totalPages = ceil($totalRows / $limit);

            // Output the products array as JSON with the totalPages and totalRows properties
            echo json_encode(array('products' => $products, 'totalPages' => $totalPages, 'totalRows' => $totalRows));
        } else {
            // Output an empty array as JSON
            echo json_encode(array('products' => [], 'totalPages' => 0, 'totalRows' => 0));

        }
    } else {
        // Output the SQL error as JSON
        echo json_encode(array('error' => mysqli_error($conn)));
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
