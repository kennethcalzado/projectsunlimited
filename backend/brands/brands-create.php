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
            echo json_encode(['success' => false, 'message' => $errors]);
            exit;
        }

        // Prepare the insertion query
        $sql = "INSERT INTO brands (brand_name, description, type, status, updated_at, created_at) 
                VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $brandName, $description, $type, $status);

        if ($stmt->execute()) {
            // Get the inserted brand ID
            $brandId = $stmt->insert_id;

            // Fetch the inserted brand data from the database
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
            echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Required fields are missing
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    }
} else {
    // If the request method is not POST, return an error message
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
