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
    
    // Check if a file was uploaded
    if(isset($_FILES['editedProductImage'])) {
        $file = $_FILES['editedProductImage'];
        
        // Check for errors in file upload
        if($file['error'] === UPLOAD_ERR_OK) {
            // Move the uploaded file to the desired location
            $uploadDir = '../../assets/products/';
            $fileName = basename($file['name']);
            $uploadPath = $uploadDir . $fileName;
            
            if(move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // File uploaded successfully, update product image URL in the database
                $imageURL = $fileName; // Assuming the file name is stored in the database
                // Update product details including the image URL
                $stmt = $conn->prepare("UPDATE product SET ProductName = ?, Description = ?, brand_id = ?, CategoryID = ?, image_urls = ? WHERE ProductID = ?");
                $stmt->bind_param("sssisi", $editedProductName, $editedProductDescription, $editedProductBrand, $editedProductCategory, $imageURL, $productId);
                $resultProduct = $stmt->execute();
                
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
                // Error moving uploaded file
                $response = array('success' => false, 'message' => 'Error moving uploaded file.');
                echo json_encode($response);
            }
        } else {
            // Error in file upload
            $response = array('success' => false, 'message' => 'Error in file upload: ' . $file['error']);
            echo json_encode($response);
        }
    } else {
        // No file uploaded, update product details excluding the image URL
        $stmt = $conn->prepare("UPDATE product SET ProductName = ?, Description = ?, brand_id = ?, CategoryID = ? WHERE ProductID = ?");
        $stmt->bind_param("sssii", $editedProductName, $editedProductDescription, $editedProductBrand, $editedProductCategory, $productId);
        $resultProduct = $stmt->execute();
        
        if ($resultProduct) {
            // Return success response to the client
            $response = array('success' => true, 'message' => 'Product details updated successfully.');
            echo json_encode($response);
        } else {
            // Return error response if updating product details fails
            $response = array('success' => false, 'message' => 'Error updating product details.');
            echo json_encode($response);
        }
    }
} else {
    // If request method is not POST, return an error response
    $response = array('success' => false, 'message' => 'Invalid request method.');
    echo json_encode($response);
}
?>
