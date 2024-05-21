<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include your database connection
include '../../backend/conn.php';
// Include the auditlog.php file
include("../../backend/auditlog.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productId = $_POST['productId'];
    $editedProductName = $_POST['editedProductName'];
    $editedProductDescription = $_POST['editedProductDescription'];
    $editedProductBrand = $_POST['editedProductBrand'];
    $editedProductCategory = $_POST['editedProductCategory'];

    // Fetch user information from session or database
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Fetch user details from the database using user_id
        $sql = "SELECT fname, lname, role_id FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $fname = $row['fname'];
            $lname = $row['lname'];
            $role_id = $row['role_id'];

            // Log the action with user details
            logAudit($user_id, $fname, $lname, $role_id, "Updated product: '$editedProductName'");
        }
    }

    // Check if a file was uploaded
    if (isset($_FILES['editedProductImage'])) {
        $file = $_FILES['editedProductImage'];

        // Check for errors in file upload
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Move the uploaded file to the desired location
            $uploadDir = '../../assets/products/';
            $fileName = basename($file['name']);
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // File uploaded successfully, update product image URL in the database
                $imageURL = $fileName; // Assuming the file name is stored in the database
                // Update product details including the image URL
                $stmt = $conn->prepare("UPDATE product SET ProductName = ?, Description = ?, brand_id = ?, CategoryID = ?, image_urls = ? WHERE ProductID = ?");
                $stmt->bind_param("sssisi", $editedProductName, $editedProductDescription, $editedProductBrand, $editedProductCategory, $imageURL, $productId);
                $resultProduct = $stmt->execute();

                if (!$resultProduct) {
                    // Return error response if updating product details fails
                    $response = array('success' => false, 'message' => 'Error updating product details.');
                    echo json_encode($response);
                    exit();
                }
            } else {
                // Error moving uploaded file
                $response = array('success' => false, 'message' => 'Error moving uploaded file.');
                echo json_encode($response);
                exit();
            }
        } else {
            // Error in file upload
            $response = array('success' => false, 'message' => 'Error in file upload: ' . $file['error']);
            echo json_encode($response);
            exit();
        }
    } else {
        // No file uploaded, update product details excluding the image URL
        $stmt = $conn->prepare("UPDATE product SET ProductName = ?, Description = ?, brand_id = ?, CategoryID = ? WHERE ProductID = ?");
        $stmt->bind_param("sssii", $editedProductName, $editedProductDescription, $editedProductBrand, $editedProductCategory, $productId);
        $resultProduct = $stmt->execute();

        if (!$resultProduct) {
            // Return error response if updating product details fails
            $response = array('success' => false, 'message' => 'Error updating product details.');
            echo json_encode($response);
            exit();
        }
    }

    // Check if new variations are set
    if (isset($_POST['newVariations'])) {
        $newVariations = $_POST['newVariations'];
        $newVariationImages = $_FILES['newVariationImages'];

        // Loop through each new variation
        foreach ($newVariations as $index => $newVariationName) {
            // Handle variation image upload
            $newVariationImage = $newVariationImages['tmp_name'][$index];
            $newVariationImageName = $newVariationImages['name'][$index];

            // Move the uploaded image to the desired location
            $uploadDir = '../../assets/variations/';
            $uploadPath = $uploadDir . $newVariationImageName;

            if (move_uploaded_file($newVariationImage, $uploadPath)) {
                // Insert new variation into the database
                $stmt = $conn->prepare("INSERT INTO product_variation (ProductID, VariationName, image_url) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $productId, $newVariationName, $newVariationImageName);
                $resultVariation = $stmt->execute();

                if (!$resultVariation) {
                    // Return error response if inserting variation fails
                    $response = array('success' => false, 'message' => 'Error inserting new variation.');
                    echo json_encode($response);
                    exit();
                }
            } else {
                // Error moving uploaded image
                $response = array('success' => false, 'message' => 'Error moving uploaded image for new variation.');
                echo json_encode($response);
                exit();
            }
        }
    }
    // Check if variations to delete are set
    if (isset($_POST['deletedVariations'])) {
        $deletedVariations = $_POST['deletedVariations'];
        foreach ($deletedVariations as $variationID) {
            // Update variation status to "Inactive" in the database
            $stmt = $conn->prepare("UPDATE product_variation SET status = 'inactive' WHERE VariationID = ?");
            $stmt->bind_param("i", $variationID);
            $result = $stmt->execute();
            // Check for success or failure and handle accordingly
        }
    }
    if (isset($_POST['variations'])) {
        $variations = $_POST['variations'];
        foreach ($variations as $variationID => $variation) {
            $variationName = $variation['variationName'];

            // Update the variation name in the database
            $stmt = $conn->prepare("UPDATE product_variation SET VariationName = ? WHERE VariationID = ?");
            $stmt->bind_param("si", $variationName, $variationID);
            $resultVariation = $stmt->execute();

            if (!$resultVariation) {
                // Return error response if updating variation details fails
                $response = array('success' => false, 'message' => 'Error updating variation name.');
                echo json_encode($response);
               
                exit(); // Terminate script execution
            }
            // Check if a file was uploaded for this variation
            if (isset($_FILES['variations']['tmp_name'][$variationID]['variationImage'])) {
                // Access the uploaded file for this variation
                $file_tmp_name = $_FILES['variations']['tmp_name'][$variationID]['variationImage'];
                $file_name = $_FILES['variations']['name'][$variationID]['variationImage'];

                // You can handle the file as needed, for example, move it to a permanent location
                $uploadDir = '../../assets/variations/';
                $uploadPath = $uploadDir . $file_name;

                if (move_uploaded_file($file_tmp_name, $uploadPath)) {
                    $imageURL = $file_name;
                    $stmt = $conn->prepare("UPDATE product_variation SET image_url = ? WHERE VariationID = ?");
                    $stmt->bind_param("si", $imageURL, $variationID);
                    $resultImageUpdate = $stmt->execute();

                    if (!$resultImageUpdate) {
                        // Return error response if updating variation image URL fails
                        $response = array('success' => false, 'message' => 'Error updating variation image.');
                        echo json_encode($response);
                        exit(); // Terminate script execution
                    }
                    // File uploaded successfully
                    echo "Image uploaded for Variation ID: $variationID, Variation Name: $variationName<br>";
                } else {
                    // Error moving uploaded file
                    echo "Error uploading image for Variation ID: $variationID, Variation Name: $variationName<br>";
                }
            } else {
                // No file uploaded for this variation
                echo "No image uploaded for Variation ID: $variationID, Variation Name: $variationName<br>";
            }
        }
    } else {
        // Error moving uploaded file
        $response = array('success' => false, 'message' => 'VARIATIONS NOT SET.');
        echo json_encode($response);
        exit(); // Terminate script execution
    }

    // Return success response if all updates were successful
    $response = array('success' => true, 'message' => 'Product and variation details updated successfully.');
    echo json_encode($response);
} else {
    // If request method is not POST, return an error response
    $response = array('success' => false, 'message' => 'Invalid request method.');
    echo json_encode($response);
}
?>
