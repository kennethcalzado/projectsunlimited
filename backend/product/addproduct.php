<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the file that establishes the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data for the main product
    $productName = $_POST["productName"];
    $brand_id = $_POST["productBrand"];
    $description = $_POST["productDescription"];
    $categoryID = $_POST["productCategory"];

    // Handle image upload for the main product
    $mainImagePath = "../../assets/products/";
    $mainImageName = $_FILES["productImage"]["name"];
    $mainImageTemp = $_FILES["productImage"]["tmp_name"];
    $mainImageUrl = $mainImagePath . $mainImageName; // Store only the filename

    // Verify directory existence for main product image
    if (!is_dir($mainImagePath)) {
        echo json_encode(["error" => "Directory does not exist"]);
        exit;
    }

    // Attempt to move the uploaded file for the main product
    if (move_uploaded_file($mainImageTemp, $mainImageUrl)) {
        // Sanitize inputs to prevent SQL injection for the main product
        $productName = mysqli_real_escape_string($conn, $productName);
        $description = mysqli_real_escape_string($conn, $description);
        $mainImageName = mysqli_real_escape_string($conn, $mainImageName);

        // Construct the SQL query for the main product
        $sql = "INSERT INTO product (ProductName, brand_id, Description, image_urls, CategoryID, created_at) 
        VALUES ('$productName', '$brand_id', '$description', '$mainImageName', '$categoryID', NOW())";

        // Execute the query for the main product
        if (mysqli_query($conn, $sql)) {
            // Get the ID of the inserted main product
            $productId = mysqli_insert_id($conn);

            // Loop through variations and handle insertion
            for ($i = 1; isset($_POST["variationName$i"]); $i++) {
                // Retrieve variation data
                $variationName = $_POST["variationName$i"];
                $variationImageName = $_FILES["variationImage$i"]["name"];
                $variationImageTemp = $_FILES["variationImage$i"]["tmp_name"];
                $variationImageUrl = "../../assets/variations/" . $variationImageName; // Variation image path

                // Verify directory existence for variation image
                if (!is_dir("../../assets/variations/")) {
                    mkdir("../../assets/variations/");
                }

                // Attempt to move the uploaded variation image
                if (move_uploaded_file($variationImageTemp, $variationImageUrl)) {
                    // Sanitize inputs to prevent SQL injection for variations
                    $variationName = mysqli_real_escape_string($conn, $variationName);
                    $variationImageName = mysqli_real_escape_string($conn, $variationImageName);

                    // Construct the SQL query for variation insertion
                    $variationSql = "INSERT INTO product_variation (ProductID, VariationName, image_url, availability, status) 
                    VALUES ('$productId', '$variationName', '$variationImageName', 'AVAILABLE', 'active')";

                    // Execute the query for variation insertion
                    mysqli_query($conn, $variationSql);
                }
            }

            // Return success response
            echo json_encode(["success" => true]);
        } else {
            // Return error response if query fails for the main product
            echo json_encode(["error" => "Error executing SQL query: " . mysqli_error($conn)]);
        }
    } else {
        // Return error response if file upload fails for the main product
        echo json_encode(["error" => "Error uploading file"]);
    }
} else {
    // Return error response for invalid request
    echo json_encode(["error" => "Invalid request"]);
}
?>
