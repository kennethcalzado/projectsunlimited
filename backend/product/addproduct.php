<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the file that establishes the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productName = $_POST["productName"];
    $brand_id = $_POST["productBrand"];
    $description = $_POST["productDescription"];
    $categoryID = $_POST["productCategory"];

    // Handle image upload
    $imagePath = "../../assets/products/";
    $imageName = $_FILES["productImage"]["name"];
    $imageTemp = $_FILES["productImage"]["tmp_name"];
    $imageUrl = $imagePath . $imageName; // Store only the filename

    // Verify directory existence
    if (!is_dir($imagePath)) {
        echo json_encode(["error" => "Directory does not exist"]);
        exit;
    }

    // Attempt to move the uploaded file
    if (move_uploaded_file($imageTemp, $imageUrl)) {
        // Sanitize inputs to prevent SQL injection
        $productName = mysqli_real_escape_string($conn, $productName);
        $description = mysqli_real_escape_string($conn, $description);
        $imageName = mysqli_real_escape_string($conn, $imageName);

        // Construct the SQL query
        $sql = "INSERT INTO product (ProductName, brand_id, Description, image_urls, CategoryID, created_at) 
        VALUES ('$productName', '$brand_id', '$description', '$imageName', '$categoryID', NOW())";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // Return success response
            echo json_encode(["success" => true]);
        } else {
            // Return error response if query fails
            echo json_encode(["error" => "Error executing SQL query: " . mysqli_error($conn)]);
        }
    } else {
        // Return error response if file upload fails
        echo json_encode(["error" => "Error uploading file"]);
    }
} else {
    // Return error response for invalid request
    echo json_encode(["error" => "Invalid request"]);
}
?>
