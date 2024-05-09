<?php
require '../../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;

// Include the database connection script
include '../../backend/conn.php';

// Function to validate email address
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to generate random password
function generatePassword($length = 8)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['upload_user'])) {
        $xlsxFile = $_FILES['upload_user']['tmp_name'];

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

            $email = $rowData[2];
            if (!validateEmail($email)) {
                $errors[] = "Invalid email address: " . $email;
                $errorCount++;
                continue;
            }

            // Check if role name exists
            $roleName = $rowData[3];
            $sql_get_role_id = "SELECT role_id FROM roles WHERE role_name = ?";
            $stmt_role_id = $conn->prepare($sql_get_role_id);
            $stmt_role_id->bind_param("s", $roleName);
            $stmt_role_id->execute();
            $result_get_role_id = $stmt_role_id->get_result();

            if ($result_get_role_id->num_rows == 0) {
                $errors[] = "Role name '$roleName' does not exist.";
                $errorCount++;
                continue;
            }

            $row = $result_get_role_id->fetch_assoc();
            $roleId = $row['role_id'];

            // Generate random password
            $password = generatePassword();

            // Insert user into database
            $sql_insert_user = "INSERT INTO users (fname, lname, password_hash, email, role_id, created_at, updated_at, status) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), 'active')";
            $stmt_insert_user = $conn->prepare($sql_insert_user);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt_insert_user->bind_param("ssssi", $rowData[0], $rowData[1], $passwordHash, $rowData[2], $roleId);

            if ($stmt_insert_user->execute()) {
                $successCount++;
            } else {
                $errors[] = "Error inserting user: " . $conn->error;
                $errorCount++;
            }
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