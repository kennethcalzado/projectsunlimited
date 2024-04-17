<?php
include '../../backend/conn.php';

// Check if productId is set in the request
if(isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // Prepare and execute SQL query to fetch product details
    $sql = "SELECT p.ProductID, p.ProductName, p.Description, p.image_urls, p.CategoryID, p.availability, p.brand_id, b.brand_name, pc.CategoryName 
            FROM product p
            LEFT JOIN brands b ON p.brand_id = b.brand_id
            LEFT JOIN productcategory pc ON p.CategoryID = pc.CategoryID
            WHERE p.ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if product details are fetched successfully
    if($result->num_rows > 0) {
        $productData = $result->fetch_assoc();

        // Prepare and execute SQL query to fetch variations for the product
        $variationSql = "SELECT VariationName, CONCAT('../../assets/variations/', image_url) AS image_url FROM product_variation WHERE ProductID = ?";
        $variationStmt = $conn->prepare($variationSql);
        $variationStmt->bind_param("i", $productId);
        $variationStmt->execute();
        $variationResult = $variationStmt->get_result();

        // Fetch variations if available
        $variations = [];
        if($variationResult->num_rows > 0) {
            while($row = $variationResult->fetch_assoc()) {
                $variations[] = $row;
            }
        }

        // Add variations data to product data
        $productData['variations'] = $variations;

        // Construct the path to the product image
        $productData['product_image'] = "../../assets/products/" . $productData['image_urls'];

        // Return product data as JSON
        echo json_encode($productData);
    } else {
        // Product not found
        echo json_encode(array("error" => "Product not found"));
    }

    // Close database connection
    $stmt->close();
    $variationStmt->close();
    $conn->close();
} else {
    // Product ID not provided in the request
    echo json_encode(array("error" => "Product ID not provided"));
}
?>
