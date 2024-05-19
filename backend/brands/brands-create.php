<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the database connection script
// Include the auditlog.php file
include ("../../backend/auditlog.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if all required fields are present
    if (isset($_POST['brandName'], $_POST['description'], $_POST['type'], $_POST['status'])) {
        // Retrieve the form data
        $brandName = $_POST['brandName'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $status = $_POST['status'];

        // Perform validation
        $errors = [];

        // Check if any required field is empty
        if (empty($brandName)) {
            $errors['brandName'] = 'Brand Name is required.';
        } elseif (preg_match("/<[^>]*>/", $brandName)) { // Check if HTML tags are present
            $errors['brandName'] = 'Brand Name cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $brandName)) { // Check for SQL injection
            $errors['brandName'] = 'Brand Name cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $brandName)) { // Check for PHP tags
            $errors['brandName'] = 'Brand Name cannot contain PHP tags.';
        }

        if (preg_match("/<[^>]*>/", $description)) { // Check if HTML tags are present
            $errors['description'] = 'Description cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $description)) { // Check for SQL injection
            $errors['description'] = 'Description cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $description)) { // Check for PHP tags
            $errors['description'] = 'Description cannot contain PHP tags.';
        }

        if (empty($type)) {
            $errors['type'] = 'Type is required.';
        } elseif (preg_match("/<[^>]*>/", $type)) { // Check if HTML tags are present
            $errors['type'] = 'Type cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $type)) { // Check for SQL injection
            $errors['type'] = 'Type cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $type)) { // Check for PHP tags
            $errors['type'] = 'Type cannot contain PHP tags.';
        }

        if (preg_match("/<[^>]*>/", $status)) { // Check if HTML tags are present
            $errors['status'] = 'Status cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $status)) { // Check for SQL injection
            $errors['status'] = 'Status cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $status)) { // Check for PHP tags
            $errors['status'] = 'Status cannot contain PHP tags.';
        }

        // If there are validation errors, return the error messages
        if (!empty($errors)) {
            http_response_code(400); // Set HTTP response code to indicate bad request
            echo json_encode(['success' => false, 'message' => $errors]);
            exit;
        }

        // Handle brand logo upload
        $uploadPath = '';
        if (isset($_FILES['brandLogo']) && $_FILES['brandLogo']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['brandLogo']['tmp_name'];
            $fileName = $_FILES['brandLogo']['name'];
            $fileSize = $_FILES['brandLogo']['size'];
            $fileType = $_FILES['brandLogo']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Valid extensions
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            // Check file extension
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors['brandLogo'] = "Invalid file extension for logo: $fileName. Only JPG, JPEG, and PNG files are allowed.";
            }

            // Move the uploaded file to the desired location
            $uploadDir = '../../assets/brands/';
            $fileName = basename($fileName);
            $uploadPath = $uploadDir . $fileName;

            if (!move_uploaded_file($fileTmpPath, $uploadPath)) {
                $errors['brandLogo'] = "Failed to move uploaded logo file: $fileName";
            }
        }

        // Handle brand images upload
        $uploadImagePaths = [];
        if (!empty($_FILES['brandImages'])) {
            foreach ($_FILES['brandImages']['tmp_name'] as $key => $tmp_name) {
                $fileName = $_FILES['brandImages']['name'][$key];
                $fileTmpPath = $_FILES['brandImages']['tmp_name'][$key];
                $fileSize = $_FILES['brandImages']['size'][$key];
                $fileType = $_FILES['brandImages']['type'][$key];
                $fileError = $_FILES['brandImages']['error'][$key];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                // Valid extensions
                $allowedExtensions = ['jpg', 'jpeg', 'png'];

                // Check file extension
                if (!in_array($fileExtension, $allowedExtensions)) {
                    $errors[] = "Invalid file extension for $fileName. Only JPG, JPEG, and PNG files are allowed.";
                    continue; // Skip processing this file
                }

                // Move the uploaded file to the desired location
                $uploadDir = '../../assets/brands_images/';
                $uploadImagePath = $uploadDir . basename($fileName);

                if (!move_uploaded_file($fileTmpPath, $uploadImagePath)) {
                    $errors[] = "Failed to move uploaded file: $fileName";
                } else {
                    $uploadImagePaths[] = $uploadImagePath; // Append the path to the array
                }
            }
        }

        // Encode the upload image paths array to JSON
        $encodedImagePaths = json_encode($uploadImagePaths);

        // Prepare the insertion query with image paths
        $inser_brand_sql = "INSERT INTO brands (brand_name, description, type, status, logo_url, images, updated_at, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";

        // Prepare and execute the query
        $inser_brand_stmt = $conn->prepare($inser_brand_sql);
        $inser_brand_stmt->bind_param("ssssss", $brandName, $description, $type, $status, $uploadPath, $encodedImagePaths);

        if ($inser_brand_stmt->execute()) {
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
                    logAudit($user_id, $fname, $lname, $role_id, "Created brand: '$brandName'");
                }
            }
            // Get the inserted brand ID
            $brandId = $inser_brand_stmt->insert_id;

            // Handle brand catalogs
            if (!empty($_FILES['brandCatalogs']) && isset($_FILES['brandCatalogs'])) {
                // Loop through each uploaded catalog file and handle it
                foreach ($_FILES['brandCatalogs']['tmp_name'] as $key => $tmp_name) {
                    // Retrieve file information
                    $fileName = $_FILES['brandCatalogs']['name'][$key];
                    $fileSize = $_FILES['brandCatalogs']['size'][$key];
                    $fileType = $_FILES['brandCatalogs']['type'][$key];
                    $fileError = $_FILES['brandCatalogs']['error'][$key];
                    $fileTmpPath = $_FILES['brandCatalogs']['tmp_name'][$key];

                    // Perform further validation and sanitization of file name and path
                    $fileName = sanitizeFileName($fileName);
                    $uploadDir = '../../assets/catalogs/';
                    $uploadPath = $uploadDir . $fileName;

                    // Check for errors
                    if ($fileError === UPLOAD_ERR_OK) {
                        // Move the uploaded file to the desired location
                        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                            // Insert the catalog information into the database
                            $sqlInsertCatalog = "INSERT INTO catalogs (brand_id, catalog_title, catalog_path) VALUES (?, ?, ?)";
                            $stmtInsertCatalog = $conn->prepare($sqlInsertCatalog);
                            if ($stmtInsertCatalog) {
                                $stmtInsertCatalog->bind_param("iss", $brandId, $fileName, $uploadPath);
                                if (!$stmtInsertCatalog->execute()) {
                                    // Catalog insert failed
                                    $errors['brandCatalogs'] = "Failed to insert catalog: $fileName";
                                }
                                $stmtInsertCatalog->close();
                            }
                        } else {
                            // Handle file upload errors
                            $errors['brandCatalogs'] = "File upload error for catalog: $fileName - Error code: $fileError";
                        }
                    }
                }
            }

            // Fetch the inserted brand data from the database
            $sql_select_brand = "SELECT * FROM brands WHERE brand_id =?";
            $stmt_select_brand = $conn->prepare($sql_select_brand);
            $stmt_select_brand->bind_param("i", $brandId);
            $stmt_select_brand->execute();
            $result = $stmt_select_brand->get_result();

            if ($result->num_rows > 0) {
                $updatedBrandData = $result->fetch_assoc();
                $updatedBrandData['errors'] = $errors;
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($updatedBrandData);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Brand not found']);
            }
        } else {
            http_response_code(500);
            $errors[] = "Failed to insert brand: " . $inser_brand_stmt->error;
            echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        }

        // Close the statement and database connection
        $stmt->close();
        $stmt_select_brand->close();
        $conn->close();
    } else {
        http_response_code(400); // Set HTTP response code to indicate bad request
        echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
    }
}

function sanitizeFileName($fileName)
{
    // Remove any characters that are not alphanumeric, underscores, hyphens, or periods
    $fileName = preg_replace("/[^a-zA-Z0-9_\-.]/", "", $fileName);
    return $fileName;
}
