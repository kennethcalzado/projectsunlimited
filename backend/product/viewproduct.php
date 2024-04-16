<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include your database connection
include '../../backend/conn.php';

// Check if productId is provided
if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // Prepare and execute the query to fetch product details
    $stmt = $conn->prepare("
        SELECT p.*, b.brand_name, c.CategoryName
        FROM product p
        LEFT JOIN brands b ON p.brand_id = b.brand_id
        LEFT JOIN productcategory c ON p.CategoryID = c.CategoryID
        WHERE p.ProductID = ?
    ");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch product details
        $productDetails = $result->fetch_assoc();

        // Construct full image URL for product
        $productDetails['imageUrl'] = '../../../assets/products/' . $productDetails['image_urls'];

        // Initialize array to hold variations
        $variations = array();

        // Prepare and execute the query to fetch all variations for the specified product
        $stmt2 = $conn->prepare("
            SELECT VariationID, VariationName, image_url
            FROM product_variation
            WHERE ProductID = ?
        ");
        $stmt2->bind_param("i", $productId);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        // Check if variations are found
        if ($result2->num_rows > 0) {
            // Iterate through the result set to fetch all variations
            while ($row = $result2->fetch_assoc()) {
                // Add variation details to variations array
                $variation = array(
                    'VariationID' => $row['VariationID'],
                    'VariationName' => $row['VariationName'],
                    'image_url' => '../../../assets/variations/' . $row['image_url']
                );
                $variations[] = $variation;
            }
        }

        // Add variations array to the product details array
        $productDetails['variations'] = $variations;

        // Encode product details as JSON and return
        echo json_encode($productDetails);
    } else {
        // Product not found
        echo json_encode(array('error' => 'Product not found'));
    }
} else {
    // Product ID not provided
    echo json_encode(array('error' => 'Product ID not provided'));
}
?>