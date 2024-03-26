<?php
include '../../backend/conn.php';
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract form data
    $productName = $_POST['productName'];
    $productBrand = $_POST['productBrand'];
    $productDescription = $_POST['productDescription'];
    $productCategory = $_POST['productCategory'];

    // File upload
    $uploadDir = 'uploads/';
    $uploadedFile = $uploadDir . basename($_FILES['productImage']['name']);

    if (move_uploaded_file($_FILES['productImage']['tmp_name'], $uploadedFile)) {
        // File uploaded successfully
        echo "Product image uploaded successfully.";

        // Get current timestamp
        $dateAdded = date('Y-m-d H:i:s');

        // Now you can save other form data, including the timestamp, and image path to the database
        // Replace this with your database saving logic
        // For example, using PDO or mysqli to insert data into the database
    } else {
        // File upload failed
        echo "Failed to upload product image.";
    }
}
?>
