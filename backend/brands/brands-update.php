<?php
include '../../backend/conn.php'; // Include the database connection script

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
        }

        if (empty($description)) {
            $errors['description'] = 'Description is required.';
        }

        if (empty($type)) {
            $errors['type'] = 'Type is required.';
        }

        if (empty($status)) {
            $errors['status'] = 'Status is required.';
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

        // Perform the update query including the updated_at
        $sql = "UPDATE brands SET brand_name = ?, description = ?, type = ?, status = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE brand_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ssssi", $brandName, $description, $type, $status, $brandId);
            if ($stmt->execute()) {
                // Update successful

                // Fetch the updated brand data from the database
                $sql_select_brand = "SELECT * FROM your_table_name WHERE brand_id = ?";
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
                            $updatedBrandData['brandId'] = $brandId;
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

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>