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
                // else {
                //     // Return error response if updating product details fails
                //     $response = array('success' => false, 'message' => 'Error updating product details.');
                //     echo json_encode($response);
                // }
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

    if (isset($_POST['variations'])) {
        $variations = $_POST['variations'];
        // Use print_r() to echo the array in a human-readable format
        // echo "Using print_r():<br>";
        // print_r($variations);

        // // Use var_dump() to echo the array with more detailed information
        // echo "<br><br>Using var_dump():<br>";
        // var_dump($variations);

        // Iterate through variations and update database accordingly
        // foreach ($variations as $variationID => $variation) {
        //     $variationName = $variation['variationName'];
        //     // $variationImage = $variation['variationImage'];
        //     echo $_FILES['variations'][$variationID]['variationImage'];

        //     // Check if variation image is set
        //     if (isset($_FILES['variations'][$variationID]['variationImage'])) {
        //         $file = $_FILES['variations'][$variationID]['variationImage'];
        //         $file_tmp_name = $file['tmp_name'][$variationID]['variationImage'];
        //         $file_name = $file['name'][$variationID]['variationImage'];

        //         echo $file;

        //         // Check for errors in file upload
        //         if ($file['error'] === UPLOAD_ERR_OK) {
        //             // Move the uploaded file to the desired location
        //             $uploadDir = '../../assets/variations/';
        //             $fileName = basename($file['name']);
        //             $uploadPath = $uploadDir . $fileName;

        //             echo $uploadPath;

        //             if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        //                 // File uploaded successfully, update variation image URL in the database
        //                 $imageURL = $fileName;
        //                 $stmt = $conn->prepare("UPDATE product_variation SET VariationName = ?, image_url = ? WHERE VariationID = ?");
        //                 $stmt->bind_param("ssi", $variationName, $imageURL, $variationID);
        //                 $resultVariation = $stmt->execute();

        //                 if (!$resultVariation) {
        //                     // Return error response if updating variation details fails
        //                     $response = array('success' => false, 'message' => 'Error updating variation details.');
        //                     echo json_encode($response);
        //                     exit(); // Terminate script execution
        //                 }
        //             } else {
        //                 // Error moving uploaded file
        //                 $response = array('success' => false, 'message' => 'Error moving uploaded file.');
        //                 echo json_encode($response);
        //                 exit(); // Terminate script execution
        //             }
        //         } else {
        //             // Error in file upload
        //             $response = array('success' => false, 'message' => 'Error in file upload: ' . $file['error']);
        //             echo json_encode($response);
        //             exit(); // Terminate script execution
        //         }
        //     } else {
        //         // Variation image not set, update only variation name
        //         $stmt = $conn->prepare("UPDATE product_variation SET VariationName = ? WHERE VariationID = ?");
        //         $stmt->bind_param("si", $variationName, $variationID);
        //         $resultVariation = $stmt->execute();

        //         if (!$resultVariation) {
        //             // Return error response if updating variation details fails
        //             $response = array('success' => false, 'message' => 'Error updating variation details.');
        //             echo json_encode($response);
        //             exit(); // Terminate script execution
        //         }
        //     }
        // }

        foreach ($variations as $variationID => $variation) {
            $variationName = $variation['variationName'];
        
            // Check if the file was uploaded for this variation
            if (isset($_FILES['variations']['tmp_name'][$variationID]['variationImage'])) {
                // Access the uploaded file for this variation
                $file_tmp_name = $_FILES['variations']['tmp_name'][$variationID]['variationImage'];
                $file_name = $_FILES['variations']['name'][$variationID]['variationImage'];
        
                // You can handle the file as needed, for example, move it to a permanent location
                // Move the uploaded file to the desired location
                $uploadDir = '../../assets/variations/';
                $uploadPath = $uploadDir . $file_name;
        
                if (move_uploaded_file($file_tmp_name, $uploadPath)) {
                    $imageURL = $file_name;
                    $stmt = $conn->prepare("UPDATE product_variation SET VariationName = ?, image_url = ? WHERE VariationID = ?");
                    $stmt->bind_param("ssi", $variationName, $imageURL, $variationID);
                    $resultVariation = $stmt->execute();

                    if (!$resultVariation) {
                        // Return error response if updating variation details fails
                        $response = array('success' => false, 'message' => 'Error updating variation details.');
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