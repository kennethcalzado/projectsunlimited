<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Include database connection
include '../../backend/conn.php';
// Include the auditlog.php file
include("../../backend/auditlog.php");

// Function to handle Excel file upload and brand insertion
function handleBrandUpload($file, $conn)
{
    $errors = []; // Array to store errors

    // Check if file is uploaded successfully
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'File upload error.';
        return $errors;
    }

    // Check file type
    $allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']; // Only allow XLSX files
    if (!in_array($file['type'], $allowedTypes)) {
        $errors[] = 'Invalid file type. Please upload an Excel file (.xlsx).';
        return $errors;
    }

    // Read file data
    $xlsxFile = $file['tmp_name'];

    try {
        // Load the Excel file
        $spreadsheet = IOFactory::load($xlsxFile);

        // Get the active sheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Loop through rows and insert brands
        foreach ($worksheet->getRowIterator() as $row) {
            // Skip the first row
            if ($row->getRowIndex() == 1) {
                continue;
            }

            $rowData = $row->getWorksheet()->rangeToArray('A' . $row->getRowIndex() . ':' . 'C' . $row->getRowIndex(), null, true, true, true);

            // Extract brand data
            $brandName = $rowData[$row->getRowIndex()]['A'];
            $type = $rowData[$row->getRowIndex()]['B'];
            $description = $rowData[$row->getRowIndex()]['C'];

            // Check if brand already exists
            $query = "SELECT COUNT(*) AS count FROM brands WHERE brand_name = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $brandName);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row['count'] > 0) {
                $errors[] = "Brand '$brandName' already exists.";
                continue; // Skip insertion for existing brand
            }

            // Insert brand into database
            $query = "INSERT INTO brands (brand_name, type, description, status) VALUES (?, ?, ?, 'inactive')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $brandName, $type, $description);
            if (!$stmt->execute()) {

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
                        logAudit($user_id, $fname, $lname, $role_id, "Uploaded brands: '$brandName'");
                    }
                }

                $errors[] = "Failed to insert brand '$brandName'.";
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        $errors[] = 'Error processing Excel file: ' . $e->getMessage();
    }

    return $errors;
}

// Main upload process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['upload_brand'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
        exit;
    }

    $file = $_FILES['upload_brand'];
    $uploadErrors = handleBrandUpload($file, $conn);

    if (!empty($uploadErrors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $uploadErrors]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Brands uploaded successfully.']);
    exit;
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
