<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $categoryName = $_POST['productName'];
    $pageType = $_POST['pageType']; // Assuming this corresponds to the 'type' column
    $categoryType = $_POST['categoryType'];
    $status = 'active'; // Assuming default status is 'active'
    $imageCover = ''; // Placeholder for image path
    $imageHeader = ''; // Placeholder for image path
    $parentCategoryID = NULL;

    // Check if main category or subcategory
    if ($categoryType == 'main') {
        // Main category
        // Handle image upload if provided
        if (!empty($_FILES['mainCategoryImageInput']['tmp_name'])) {
            $imageFilename = $_FILES['mainCategoryImageInput']['name']; // Get the filename
            $imageCover = $imageFilename; // Full path of the image
            move_uploaded_file($_FILES['mainCategoryImageInput']['tmp_name'], '../../' . $imageCover); // Move uploaded image to desired directory
        }
        if (!empty($_FILES['mainCategoryCoverInput']['tmp_name'])) {
            $imageFilename = $_FILES['mainCategoryCoverInput']['name']; // Get the filename
            $imageHeader = $imageFilename; // Full path of the image
            move_uploaded_file($_FILES['mainCategoryCoverInput']['tmp_name'], '../../' . $imageHeader); // Move uploaded image to desired directory
        }
    } else if ($categoryType == 'sub') {
        // Subcategory
        $parentCategoryID = $_POST['mainCategory']; // Assuming the main category ID is passed from the frontend
    }

    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO productcategory (CategoryName, ParentCategoryID, type, status, imagecover, imageheader, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sissss", $categoryName, $parentCategoryID, $pageType, $status, $imageCover, $imageHeader);

    // Execute the statement
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Category added successfully";
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Send JSON response back to frontend
    echo json_encode($response);
} else {
    // If form data is not submitted via POST method, return error
    $response['success'] = false;
    $response['message'] = "Form data not submitted";
    echo json_encode($response);
}
?>