<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the file that establishes the database connection

// Check if files were uploaded
if (isset($_FILES['images'])) {
    // Check file types
    $allowed_types = array('image/jpeg', 'image/png');
    foreach ($_FILES['images']['type'] as $type) {
        if (!in_array($type, $allowed_types)) {
            echo "Error: Only JPEG and PNG file types are allowed.";
            exit;
        }
    }

    // Prepare SQL statement for inserting images
    $stmt = $conn->prepare("INSERT INTO product (image_urls, created_at) VALUES (?, NOW())");
    $targetDirectory = "../../assets/products/"; // Absolute path to the directory where images will be stored

    // Loop through each uploaded file
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['images']['name'][$key];
        $file_tmp = $_FILES['images']['tmp_name'][$key];

        // Verify directory existence
        if (!is_dir($targetDirectory)) {
            echo json_encode(["error" => "Directory does not exist"]);
            exit;
        }

        // Move uploaded file to the destination directory
        $image_url = $targetDirectory . $file_name;
        if (move_uploaded_file($file_tmp, $image_url)) {
            // File uploaded successfully, execute SQL statement to save image filename in the database
            $filename_only = $file_name; // Extract filename without path
            $stmt->bind_param("s", $filename_only);
            if ($stmt->execute()) {
                // Insertion successful
                echo "Image uploaded and inserted into database: " . $filename_only . "\n";
            } else {
                // Error inserting into database
                echo "Error inserting image into database: " . $filename_only . "\n";
            }
        } else {
            // Error uploading file
            echo "Error uploading file: " . $file_name . "\n";
        }
    }

    // Close prepared statement
    $stmt->close();
} else {
    // No files uploaded
    echo "No files uploaded\n";
}
// Close database connection
$conn->close();
?>
