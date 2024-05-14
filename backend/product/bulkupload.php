<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the file that establishes the database connection
// Include the auditlog.php file
include("../../backend/auditlog.php");

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
                        logAudit($user_id, $fname, $lname, $role_id, "Added multiple products");
                    }
                }
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
