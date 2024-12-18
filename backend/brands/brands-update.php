<?php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php'; // Include the database connection script
include '../../backend/auditlog.php'; // Include the auditlog.php file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['brandId'], $_POST['brandName'], $_POST['description'], $_POST['type'], $_POST['status'])) {
        $brandId = $_POST['brandId'];
        $brandName = $_POST['brandName'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $status = $_POST['status'];

        $errors = [];
        if (empty($brandName)) {
            $errors['brandName'] = 'Brand Name is required.';
        } elseif (preg_match("/<[^>]*>/", $brandName)) {
            $errors['brandName'] = 'Brand Name cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $brandName)) {
            $errors['brandName'] = 'Brand Name cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $brandName)) {
            $errors['brandName'] = 'Brand Name cannot contain PHP tags.';
        }

        if (empty($description)) {
            $errors['description'] = 'Description is required.';
        } elseif (preg_match("/<[^>]*>/", $description)) {
            $errors['description'] = 'Description cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $description)) {
            $errors['description'] = 'Description cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $description)) {
            $errors['description'] = 'Description cannot contain PHP tags.';
        }

        if (empty($type)) {
            $errors['type'] = 'Type is required.';
        } elseif (preg_match("/<[^>]*>/", $type)) {
            $errors['type'] = 'Type cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $type)) {
            $errors['type'] = 'Type cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $type)) {
            $errors['type'] = 'Type cannot contain PHP tags.';
        }

        if (empty($status)) {
            $errors['status'] = 'Status is required.';
        } elseif (preg_match("/<[^>]*>/", $status)) {
            $errors['status'] = 'Status cannot contain HTML elements.';
        } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $status)) {
            $errors['status'] = 'Status cannot contain SQL injection.';
        } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $status)) {
            $errors['status'] = 'Status cannot contain PHP tags.';
        }

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
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadDir = '../../assets/brands/';
                $fileName = basename($fileName);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                    $sqlUpdateLogo = "UPDATE brands SET logo_url = ? WHERE brand_id = ?";
                    $stmtUpdateLogo = $conn->prepare($sqlUpdateLogo);
                    if ($stmtUpdateLogo) {
                        $stmtUpdateLogo->bind_param("si", $uploadPath, $brandId);
                        if (!$stmtUpdateLogo->execute()) {
                            $errors['uploadingBrandlogo'] = "Failed to update logo URL in the database.";
                            log_error("Database error: " . $stmtUpdateLogo->error);
                        }
                        $stmtUpdateLogo->close();
                    } else {
                        $errors['uploadingBrandlogo'] = "Failed to prepare logo update statement.";
                        log_error("Database error: " . $conn->error);
                    }
                } else {
                    $errors['uploadingBrandlogo'] = "Failed to move uploaded file: $fileName";
                    log_error("File move error: " . error_get_last()['message']);
                }
            } else {
                $errors['uploadingBrandlogo'] = "Invalid file extension. Only JPG, JPEG, and PNG files are allowed: $fileName";
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
                $allowedExtensions = ['jpg', 'jpeg', 'png'];

                if (!in_array($fileExtension, $allowedExtensions)) {
                    $errors['uploadingBrandImages'] = "Invalid file extension for $fileName. Only JPG, JPEG, and PNG files are allowed.";
                    log_error("Invalid file extension: $fileExtension for file: $fileName");
                    continue;
                }

                $uploadDir = '../../assets/brands_images/';
                $uploadImagePath = $uploadDir . basename($fileName);

                if (move_uploaded_file($fileTmpPath, $uploadImagePath)) {
                    $uploadImagePaths[] = $uploadImagePath;
                } else {
                     $errors['uploadingBrandImages'] = "Failed to move uploaded file: $fileName";
                    // Add detailed logging
                    $lastError = error_get_last();
                    $errorMessage = isset($lastError['message']) ? $lastError['message'] : 'No error message';
                    log_error("File move error for image: $fileName - $errorMessage");
                }
            }

            // Fetch existing images from the database
            $stmtSelect = $conn->prepare("SELECT images FROM brands WHERE brand_id = ?");
            $stmtSelect->bind_param("i", $brandId);
            $stmtSelect->execute();
            $result = $stmtSelect->get_result();
            $existingImages = [];
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $existingImages = json_decode($row['images'], true) ?: [];
            }
            $stmtSelect->close();

            // Merge existing images with new uploads
            $allImages = array_merge($existingImages, $uploadImagePaths);
            $encodedImagePaths = json_encode($allImages);

            // Update brand images in a separate query
            $sqlUpdateImages = "UPDATE brands SET images = ? WHERE brand_id = ?";
            $stmtUpdateImages = $conn->prepare($sqlUpdateImages);
            if ($stmtUpdateImages) {
                $stmtUpdateImages->bind_param("si", $encodedImagePaths, $brandId);
                if (!$stmtUpdateImages->execute()) {
                    $errors['updatingBrandImages'] = "Failed to update images in the database.";
                    log_error("Database error: " . $stmtUpdateImages->error);
                }
                $stmtUpdateImages->close();
            } else {
                $errors['updatingBrandImages'] = "Failed to prepare image update statement.";
                log_error("Database error: " . $conn->error);
            }
        }

        // Update the brand data excluding images
        $sql = "UPDATE brands SET brand_name = ?, description = ?, type = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE brand_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssi", $brandName, $description, $type, $status, $brandId);
            if ($stmt->execute()) {
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $sql = "SELECT fname, lname, role_id FROM users WHERE user_id = ?";
                    $stmtUser = $conn->prepare($sql);
                    $stmtUser->bind_param("i", $user_id);
                    $stmtUser->execute();
                    $resultUser = $stmtUser->get_result();
                    if ($row = $resultUser->fetch_assoc()) {
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $role_id = $row['role_id'];
                        logAudit($user_id, $fname, $lname, $role_id, "Updated brand: '$brandName'");
                    }
                    $stmtUser->close();
                }

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
                        $uploadDir = '../../assets/catalogs/';
                        $uploadPath = $uploadDir . $fileName;

                        // Check for errors
                        if ($fileError === UPLOAD_ERR_OK) {
                            // Move the uploaded file to the desired location
                            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                                // Check if the catalog already exists in the database
                                $sqlCheckCatalog = "SELECT COUNT(*) as count FROM catalogs WHERE brand_id = ? AND catalog_title = ?";
                                $stmtCheckCatalog = $conn->prepare($sqlCheckCatalog);
                                if ($stmtCheckCatalog) {
                                    $stmtCheckCatalog->bind_param("is", $brandId, $fileName);
                                    $stmtCheckCatalog->execute();
                                    $resultCheckCatalog = $stmtCheckCatalog->get_result();
                                    $row = $resultCheckCatalog->fetch_assoc();
                                    if ($row['count'] == 0) {
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
                                        // Catalog already exists
                                        $errors['brandCatalogs'] = "Catalog already exists: $fileName";
                                    }
                                    $stmtCheckCatalog->close();
                                }
                            } else {
                                // Handle file upload errors
                                $errors['brandCatalogs'] = "File upload error for catalog: $fileName - Error code: $fileError";
                            }
                        }
                    }
                }

				// if (!empty($errors)) {
				// 	// Uncomment one of the lines below to print the error array for debugging
				// 	 print_r($errors);
				// 	 var_dump($errors);

				// 	// Send error response
				// 	//echo json_encode(['success' => false, 'message' => $errors]);
				// 	exit;
				// }

                $sql_select_brand = "SELECT * FROM brands WHERE brand_id = ?";
                $stmt_select_brand = $conn->prepare($sql_select_brand);
                if ($stmt_select_brand) {
                    $stmt_select_brand->bind_param("i", $brandId);
                    if ($stmt_select_brand->execute()) {
                        $result = $stmt_select_brand->get_result();
                        if ($result->num_rows > 0) {
                            $updatedBrandData = $result->fetch_assoc();
                            http_response_code(200);
                            header('Content-Type: application/json');
                            echo json_encode($updatedBrandData);
                        } else {
                            http_response_code(404);
                            echo json_encode(['error' => 'Brand not found']);
                        }
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Failed to execute query']);
                    }
                    $stmt_select_brand->close();
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to prepare statement']);
                }
            } else {
                $response = ["success" => false, "message" => "Failed to update brand"];
                http_response_code(500);
                echo json_encode($response);
            }
            $stmt->close();
        } else {
            $response = ["success" => false, "message" => "Database error"];
            http_response_code(500);
            echo json_encode($response);
        }
    } else {
        $response = ["success" => false, "message" => "Missing parameters"];
        http_response_code(400);
    }
} else {
    $response = ["success" => false, "message" => "Invalid request method"];
    http_response_code(405);
}

function log_error($message) {
    $logFile = __DIR__ . '/error.log'; // Ensure the log file path is correct
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>
