<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the file that establishes the database connection
// Include the auditlog.php file
include("../../backend/auditlog.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data for the main product
    $productName = $_POST["productName"];
    $description = $_POST["productDescription"];

    // Handle optional form fields
    $brand_id = isset($_POST["productBrand"]) ? $_POST["productBrand"] : null;
    $categoryID = isset($_POST["productCategory"]) ? $_POST["productCategory"] : null;

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
        $sql = "INSERT INTO product (ProductName, brand_id, Description, image_urls, CategoryID) 
        VALUES ('$productName',";

        // If $brand_id is not set, insert NULL, otherwise, insert the value
        $sql .= isset($brand_id) ? "'$brand_id'" : "NULL";

        $sql .= ", '$description', '$mainImageName',";

        // If $categoryID is not set, insert NULL, otherwise, insert the value
        $sql .= isset($categoryID) ? "'$categoryID')" : "NULL)";



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
                    logAudit($user_id, $fname, $lname, $role_id, "Added product: '$productName'");
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
