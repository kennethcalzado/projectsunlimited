<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include your database connection
include '../../backend/conn.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productId = $_POST['productId'];
    $editedProductName = $_POST['editedProductName'];
    $editedProductDescription = $_POST['editedProductDescription'];
    $editedProductBrand = $_POST['editedProductBrand'];
    $editedProductCategory = $_POST['editedProductCategory'];
    $editedVariations = $_POST['editedVariations']; // This will be an array of variations

    // Update product details
    $stmt = $conn->prepare("UPDATE product SET ProductName = ?, Description = ?, brand_id = ?, CategoryID = ? WHERE ProductID = ?");
    $stmt->bind_param("sssii", $editedProductName, $editedProductDescription, $editedProductBrand, $editedProductCategory, $productId);
    $resultProduct = $stmt->execute();

    // Handle product image upload
    if ($_FILES['editedProductImage']['error'] == UPLOAD_ERR_OK) {
        $productImageTmpName = $_FILES['editedProductImage']['tmp_name'];
        $productImageName = $_FILES['editedProductImage']['name'];
        $productImagePath = "../../../assets/products/" . $productImageName;
        move_uploaded_file($productImageTmpName, $productImagePath);
    }

    // Handle variation image uploads
    foreach ($editedVariations as $index => $variation) {
        if ($_FILES["editedVariationImage$index"]['error'] == UPLOAD_ERR_OK) {
            $variationImageTmpName = $_FILES["editedVariationImage$index"]['tmp_name'];
            $variationImageName = $_FILES["editedVariationImage$index"]['name'];
            $variationImagePath = "../../../assets/variations/" . $variationImageName;
            move_uploaded_file($variationImageTmpName, $variationImagePath);
        }
    }

    if ($resultProduct) {
        // Return success response to the client
        $response = array('success' => true, 'message' => 'Product details updated successfully.');
        echo json_encode($response);
    } else {
        // Return error response if updating product details fails
        $response = array('success' => false, 'message' => 'Error updating product details.');
        echo json_encode($response);
    }
} else {
    // If request method is not POST, return an error response
    $response = array('success' => false, 'message' => 'Invalid request method.');
    echo json_encode($response);
}
?>