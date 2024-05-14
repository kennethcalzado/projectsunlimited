<?php
use PhpOffice\PhpSpreadsheet\IOFactory;

// Include the autoload file
require '../../vendor/autoload.php'; 
// Include the database connection script
include '../../backend/conn.php';

// Function to validate email address
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to generate random password
function generatePassword($fname, $lname, $roleId)
{
    // Ensure the first letters are uppercase
    $firstLetterFname = strtoupper(substr($fname, 0, 1));
    $firstLetterLname = strtoupper(substr($lname, 0, 1));

    // Ensure the second letters are lowercase
    $secondLetterFname = strtolower(substr($fname, 1, 1));
    $secondLetterLname = strtolower(substr($lname, 1, 1));

    // Concatenate the components
    $password = $firstLetterFname . $secondLetterFname . '.' . $firstLetterLname . $secondLetterLname . '.00' . $roleId;

    return $password;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['upload_user'])) {
        try {
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

                // Validate each column and perform necessary checks
                $fname = isset($rowData[0]) ? trim($rowData[0]) : '';
                $lname = isset($rowData[1]) ? trim($rowData[1]) : '';
                $email = isset($rowData[2]) ? trim($rowData[2]) : '';
                $roleName = isset($rowData[3]) ? trim($rowData[3]) : '';

                // Check for blank cells
                if (empty($fname) || empty($lname) || empty($email) || empty($roleName)) {
                    $errors[] = "Row $key has blank cells. All fields are required.";
                    $errorCount++;
                    continue;
                }

                // Validate email address
                if (!validateEmail($email)) {
                    $errors[] = "Row $key: Invalid email address: $email";
                    $errorCount++;
                    continue;
                }

                // Check if email already exists
                $sql_check_email = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
                $stmt_check_email = $conn->prepare($sql_check_email);
                $stmt_check_email->bind_param("s", $email);
                $stmt_check_email->execute();
                $result_check_email = $stmt_check_email->get_result();
                $row_email = $result_check_email->fetch_assoc();

                if ($row_email['count'] > 0) {
                    $errors[] = "Row $key: Email address '$email' already exists.";
                    $errorCount++;
                    continue;
                }

                // Check if role name exists
                $sql_get_role_id = "SELECT role_id FROM roles WHERE role_name = ?";
                $stmt_role_id = $conn->prepare($sql_get_role_id);
                $stmt_role_id->bind_param("s", $roleName);
                $stmt_role_id->execute();
                $result_get_role_id = $stmt_role_id->get_result();

                if ($result_get_role_id->num_rows == 0) {
                    $errors[] = "Row $key: Role name '$roleName' does not exist.";
                    $errorCount++;
                    continue;
                }

                $row = $result_get_role_id->fetch_assoc();
                $roleId = $row['role_id'];

                // Generate random password
                $password = generatePassword($fname, $lname, $roleId);

                // Insert user into database
                $sql_insert_user = "INSERT INTO users (fname, lname, password_hash, email, role_id, created_at, updated_at, status) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), 'active')";
                $stmt_insert_user = $conn->prepare($sql_insert_user);
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt_insert_user->bind_param("ssssi", $fname, $lname, $passwordHash, $email, $roleId);

                if ($stmt_insert_user->execute()) {
                    $successCount++;
                } else {
                    $errors[] = "Error inserting user in row $key: " . $conn->error;
                    $errorCount++;
                }            
            }

            // Prepare response
            $response = [
                "success" => true,
                "message" => "Processed Excel file.",
                "successCount" => $successCount,
                "errorCount" => $errorCount,
                "errors" => $errors
            ];
            echo json_encode($response);
        } catch (Exception $e) {
            // Handle any exceptions
            $response = ["success" => false, "message" => "An error occurred: " . $e->getMessage()];
            echo json_encode($response);
        } finally {
            // Close the insert statement
            if (isset($stmt_insert_user)) {
                $stmt_insert_user->close();
            }

            // Close database connection
            $conn->close();
        }
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
