<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the database connection script
// Include the auditlog.php file
include ("../../backend/auditlog.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (isset($_POST['brandId'], $_POST['brandName'], $_POST['description'], $_POST['type'], $_POST['status'])) {
        // Retrieve the form data
        $brandId = $_POST['brandId'];
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

        if (empty($description)) {
            $errors['description'] = 'Description is required.';
        } elseif (preg_match("/<[^>]*>/", $description)) { // Check if HTML tags are present
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

        if (empty($status)) {
            $errors['status'] = 'Status is required.';
        } elseif (preg_match("/<[^>]*>/", $status)) { // Check if HTML tags are present
            $errors['status'] = 'Status cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $status)) { // Check for SQL injection
            $errors['status'] = 'Status cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $status)) { // Check for PHP tags
            $errors['status'] = 'Status cannot contain PHP tags.';
        }

        // If there are validation errors, return the error messages
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'message' => $errors]);
            exit;
        }

        // Handle brand logo upload
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
            if (in_array($fileExtension, $allowedExtensions)) {
                // Move the uploaded file to the desired location
                $uploadDir = '../../assets/brands/';
                $fileName = basename($fileName);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                    // Update the brand logo path in the database
                    $sqlUpdateLogo = "UPDATE brands SET logo_url = ? WHERE brand_id = ?";
                    $stmtUpdateLogo = $conn->prepare($sqlUpdateLogo);
                    if ($stmtUpdateLogo) {
                        $stmtUpdateLogo->bind_param("si", $uploadPath, $brandId);
                        if ($stmtUpdateLogo->execute()) {
                            // Logo update successful
                        } else {
                            // Logo update failed
                            $response = ["success" => false, "message" => "Failed to update brand logo"];
                            http_response_code(500); // Set HTTP response code to indicate internal server error
                        }
                        $stmtUpdateLogo->close();
                    }
                } else {
                    // Failed to move the uploaded file
                    $response = ["success" => false, "message" => "Failed to move uploaded file"];
                    http_response_code(500); // Set HTTP response code to indicate internal server error
                }
            } else {
                // Invalid file extension
                $response = ["success" => false, "message" => "Invalid file extension. Only JPG, JPEG, and PNG files are allowed."];
                http_response_code(400); // Set HTTP response code to indicate bad request
            }
        }

        // Handle brand catalogs
        if (isset($_FILES['brandCatalogs'])) {
            // Loop through each uploaded catalog file and handle it
            foreach ($_FILES['brandCatalogs']['tmp_name'] as $key => $tmp_name) {
                // Check if a file was uploaded
                if (!empty($_FILES['brandCatalogs']['name'][$key])) {
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
                        // Validate file extension
                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        if ($fileExtension !== 'pdf') {
                            $errors['brandCatalogs'] = $fileName . ' is not a PDF file.';
                            continue;
                        }

                        // Validate file size (in bytes)
                        $maxSize = 30 * 1024 * 1024; // 30 MB
                        if ($fileSize > $maxSize) {
                            $errors['brandCatalogs'] = $fileName . ' exceeds the maximum size limit (30 MB).';
                            continue;
                        }

                        // Move the uploaded file to the desired location
                        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                            // Insert the catalog information into the database
                            $sqlInsertCatalog = "INSERT INTO catalogs (brand_id, catalog_title, catalog_path) VALUES (?, ?, ?)";
                            $stmtInsertCatalog = $conn->prepare($sqlInsertCatalog);
                            if ($stmtInsertCatalog) {
                                $stmtInsertCatalog->bind_param("iss", $brandId, $fileName, $uploadPath);
                                if (!$stmtInsertCatalog->execute()) {
                                    // Catalog insert failed
                                    $response = ["success" => false, "message" => "Failed to insert catalog"];
                                    http_response_code(500); // Set HTTP response code to indicate internal server error
                                    echo json_encode($response);
                                    exit;
                                }
                                $stmtInsertCatalog->close();
                            }
                        } else {
                            // Failed to move the uploaded file
                            $response = ["success" => false, "message" => "Failed to move uploaded file"];
                            http_response_code(500); // Set HTTP response code to indicate internal server error
                            echo json_encode($response);
                            exit;
                        }
                    } else {
                        // Handle file upload errors
                        $response = ["success" => false, "message" => "File upload error: $fileError"];
                        http_response_code(400); // Set HTTP response code to indicate bad request
                        echo json_encode($response);
                        exit;
                    }
                }
            }

            // Check for invalid files and display error message
            if (!empty($invalidFiles)) {
                $response = ["success" => false, "message" => "Invalid files:<br>" . implode("<br>", $invalidFiles)];
                http_response_code(400); // Set HTTP response code to indicate bad request
                echo json_encode($response);
                exit;
            }
        }


        // Perform the update query including the updated_at
        $sql = "UPDATE brands SET brand_name = ?, description = ?, type = ?, status = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE brand_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ssssi", $brandName, $description, $type, $status, $brandId);
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
                        logAudit($user_id, $fname, $lname, $role_id, "Updated brand: '$brandName'");
                    }
                }
                // Update successful

                // Fetch the updated brand data from the database
                $sql_select_brand = "SELECT * FROM brands WHERE brand_id = ?";
                $stmt_select_brand = $conn->prepare($sql_select_brand);

                if ($stmt_select_brand) {
                    // Bind parameters and execute the statement
                    $stmt_select_brand->bind_param("i", $brandId);
                    if ($stmt_select_brand->execute()) {
                        // Fetch the result
                        $result = $stmt_select_brand->get_result();

                        // Check if any rows were returned
                        if ($result->num_rows > 0) {
                            // Fetch the brand data
                            $updatedBrandData = $result->fetch_assoc();
                            // Return the updated brand data as a JSON response

                            http_response_code(200);
                            header('Content-Type: application/json');
                            echo json_encode($updatedBrandData);
                        } else {
                            // Handle the case where no rows were returned (brand not found)
                            http_response_code(404);
                            echo json_encode(['error' => 'Brand not found']);
                        }
                    } else {
                        // Handle query execution error
                        http_response_code(500);
                        echo json_encode(['error' => 'Failed to execute query']);
                    }
                    // Close the statement
                    $stmt_select_brand->close();
                } else {
                    // Handle statement preparation error
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to prepare statement']);
                }
            } else {
                // Update failed
                $response = ["success" => false, "message" => "Failed to update brand"];
                http_response_code(500);
                echo json_encode($response);
            }
            // Close the statement
            $stmt->close();
        } else {
            // Statement preparation failed
            $response = ["success" => false, "message" => "Database error"];
            http_response_code(500);
            echo json_encode($response);
        }
    } else {
        // Required fields are missing
        $response = ["success" => false, "message" => "Missing parameters"];
        http_response_code(400); // Set HTTP response code to indicate bad request
    }
} else {
    // Invalid request method
    $response = ["success" => false, "message" => "Invalid request method"];
    http_response_code(405); // Set HTTP response code to indicate method not allowed
}

function sanitizeFileName($fileName)
{
    // Remove any characters that are not alphanumeric, underscores, hyphens, or periods
    $fileName = preg_replace("/[^a-zA-Z0-9_\-.]/", "", $fileName);
    return $fileName;
}
