<?php
include '../../backend/conn.php'; // Include the database connection script

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
        }

        if (empty($type)) {
            $errors['type'] = 'Type is required.';
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
                http_response_code(400); // Set HTTP response code to indicate bad request
                echo json_encode(["success" => false, "message" => "Invalid file extension. Only JPG, JPEG, and PNG files are allowed."]);
                exit;
            }

            // Move the uploaded file to the desired location
            $uploadDir = '../../assets/brands/';
            $fileName = basename($fileName);
            $uploadPath = $uploadDir. $fileName;

            if (!move_uploaded_file($fileTmpPath, $uploadPath)) {
                http_response_code(500); // Set HTTP response code to indicate internal server error
                echo json_encode(["success" => false, "message" => "Failed to move uploaded file"]);
                exit;
            }
        }

        // Prepare the insertion query
        $sql = "INSERT INTO brands (brand_name, description, type, status, logo_url, updated_at, created_at) 
                VALUES (?,?,?,?,?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $brandName, $description, $type, $status, $uploadPath);

        if ($stmt->execute()) {
            // Get the inserted brand ID
            $brandId = $stmt->insert_id;

            // Fetch the inserted brand data from the database
            $sql_select_brand = "SELECT * FROM brands WHERE brand_id =?";
            $stmt_select_brand = $conn->prepare($sql_select_brand);
            $stmt_select_brand->bind_param("i", $brandId);
            $stmt_select_brand->execute();
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
            echo json_encode(['success' => false, 'message' => 'Error: '. $sql. '<br>'. $conn->error]);
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