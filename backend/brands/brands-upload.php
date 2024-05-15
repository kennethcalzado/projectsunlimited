<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Include the database connection script
include '../../backend/conn.php';
// Include the auditlog.php file
include ("../../backend/auditlog.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['upload_brand'])) {
        $xlsxFile = $_FILES['upload_brand']['tmp_name'];

        // Load the Excel file
        $spreadsheet = IOFactory::load($xlsxFile);

        // Get the active sheet
        $worksheet = $spreadsheet->getActiveSheet();

        $successCount = 0;
        $errorCount = 0;
        $errors = array();

        foreach ($worksheet->getRowIterator() as $key => $row) {
            if ($key === 1) {
                continue;
            }

            $rowData = $worksheet->rangeToArray('A' . $key . ':' . $worksheet->getHighestColumn() . $key, null, true, false)[0];

            $brandName = isset($rowData[0]) ? trim($rowData[0]) : '';
            $type = isset($rowData[1]) ? trim($rowData[1]) : '';
            $description = isset($rowData[2]) ? trim($rowData[2]) : '';

            // Check for blank cells
            if (empty($brandName) || empty($type)) {
                $errors[] = "Row $key has blank cells. All fields are required.";
                $errorCount++;
                continue;
            }

            // Validate brand name
            if (preg_match("/<[^>]*>/", $brandName)) { // Check if HTML tags are present
                $errors[] = "Row $key: Brand Name '$brandName' cannot contain HTML elements.";
                $errorCount++;
                continue;
            } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $brandName)) { // Check for SQL injection
                $errors[] = "Row $key: Brand Name '$brandName' cannot contain SQL injection.";
                $errorCount++;
                continue;
            } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $brandName)) { // Check for PHP tags
                $errors[] = "Row $key: Brand Name '$brandName' cannot contain PHP tags.";
                $errorCount++;
                continue;
            }

            // Validate type
            if (preg_match("/<[^>]*>/", $type)) { // Check if HTML tags are present
                $errors[] = "Row $key: Type '$type' cannot contain HTML elements.";
                $errorCount++;
                continue;
            } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $type)) { // Check for SQL injection
                $errors[] = "Row $key: Type '$type' cannot contain SQL injection.";
                $errorCount++;
                continue;
            } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $type)) { // Check for PHP tags
                $errors[] = "Row $key: Type '$type' cannot contain PHP tags.";
                $errorCount++;
                continue;
            }

            // Validate description
            if (preg_match("/<[^>]*>/", $description)) { // Check if HTML tags are present
                $errors[] = "Row $key: Description '$description' cannot contain HTML elements.";
                $errorCount++;
                continue;
            } elseif (preg_match("/\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/i", $description)) { // Check for SQL injection
                $errors[] = "Row $key: Description '$description' cannot contain SQL injection.";
                $errorCount++;
                continue;
            } elseif (preg_match("/<\?(php)?[\s\S]*?\?>/i", $description)) { // Check for PHP tags
                $errors[] = "Row $key: Description '$description' cannot contain PHP tags.";
                $errorCount++;
                continue;
            }

            // Check if brand already exists
            $sql_check_brand = "SELECT COUNT(*) AS count FROM brands WHERE brand_name = ?";
            $stmt_check_brand = $conn->prepare($sql_check_brand);
            $stmt_check_brand->bind_param("s", $brandName);
            $stmt_check_brand->execute();
            $result_check_brand = $stmt_check_brand->get_result();
            $row_brand = $result_check_brand->fetch_assoc();

            if ($row_brand['count'] > 0) {
                $errors[] = "Row '$key': Brand '$brandName' already exists.";
                $errorCount++;
                continue;
            }

            // Insert brand into database
            $sql_insert_brand = "INSERT INTO brands (brand_name, type, description, status) VALUES (?, ?, ?, 'inactive')";
            $stmt_insert_brand = $conn->prepare($sql_insert_brand);
            $stmt_insert_brand->bind_param("sss", $brandName, $type, $description);

            if ($stmt_insert_brand->execute()) {
                $successCount++;

                // Fetch user information from session or database
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Fetch user details from the database using user_id
                    $sql_get_user = "SELECT fname, lname, role_id FROM users WHERE user_id = ?";
                    $stmt_get_user = $conn->prepare($sql_get_user);
                    $stmt_get_user->bind_param("i", $user_id);
                    $stmt_get_user->execute();
                    $result_get_user = $stmt_get_user->get_result();

                    if ($user = $result_get_user->fetch_assoc()) {
                        $fname = $user['fname'];
                        $lname = $user['lname'];
                        $role_id = $user['role_id'];

                        // Log the action with user details
                        logAudit($user_id, $fname, $lname, $role_id, "Uploaded brands: '$brandName'");
                    }
                    $stmt_get_user->close();
                }
            } else {
                $errors[] = "Error inserting brand '$brandName': " . $conn->error;
                $errorCount++;
            }
            $stmt_insert_brand->close();
        }

        // Close database connection
        $conn->close();

        // Prepare response
        $response = [
            "success" => true,
            "message" => "Processed Excel file.",
            "successCount" => $successCount,
            "errorCount" => $errorCount,
            "errors" => $errors
        ];
        echo json_encode($response);
    } else {
        // No file uploaded
        $response = ["success" => false, "message" => "Please select a file."];
        echo json_encode($response);
    }
} else {
    // Invalid request method
    $response = ["success" => false, "message" => "Invalid request method"];
    http_response_code(405); // Set HTTP response code to indicate method not allowed
    echo json_encode($response);
}
?>