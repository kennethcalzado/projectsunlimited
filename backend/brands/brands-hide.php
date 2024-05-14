<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/conn.php';
// Include the auditlog.php file
include("../../backend/auditlog.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if brandId and status are set in the POST data
    if (isset($_POST['brandId']) && isset($_POST['status'])) {
        // Sanitize the brandId to prevent SQL injection
        $brandId = intval($_POST['brandId']);
        // Sanitize and validate the status to prevent SQL injection and ensure it's a valid value
        $status = $_POST['status'] === 'Hide' ? 'hidden' : ($_POST['status'] === 'Unhide' ? 'active' : '');

        if (!empty($status)) {
            // Update the brand status based on the received status
            $sqlUpdateBrandStatus = "UPDATE brands SET status = ?, updated_at = CURRENT_TIMESTAMP() WHERE brand_id = ?";
            $stmtUpdateBrandStatus = $conn->prepare($sqlUpdateBrandStatus);
            if ($stmtUpdateBrandStatus) {
                $stmtUpdateBrandStatus->bind_param("si", $status, $brandId);
                if ($stmtUpdateBrandStatus->execute()) {

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
                            logAudit($user_id, $fname, $lname, $role_id, "Hid brand: '$brandId'");
                        }
                    }

                    // Brand status updated successfully
                    $stmtUpdateBrandStatus->close();

                    // Update product availability based on the brand status
                    $availability = $status === 'hidden' ? 'Unavailable' : 'Available';
                    $sqlUpdateProductAvailability = "UPDATE product SET availability = ? WHERE brand_id = ?";
                    $stmtUpdateProductAvailability = $conn->prepare($sqlUpdateProductAvailability);
                    if ($stmtUpdateProductAvailability) {
                        $stmtUpdateProductAvailability->bind_param("si", $availability, $brandId);
                        $stmtUpdateProductAvailability->execute();
                        $stmtUpdateProductAvailability->close();
                    } else {
                        // Failed to prepare statement for updating product availability
                        http_response_code(500);
                        echo json_encode(['success' => false, 'message' => 'Failed to update product availability.']);
                        exit;
                    }

                    // Brand and product updates successful
                    echo json_encode(['success' => true]);
                    exit;
                } else {
                    // Failed to update brand status
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Failed to update brand status.']);
                    exit;
                }
            } else {
                // Failed to prepare statement for updating brand status
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to update brand status.']);
                exit;
            }
        } else {
            // Invalid status value
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid status value.']);
            exit;
        }
    } else {
        // Required parameters brandId or status are missing
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing brandId or status parameter.']);
        exit;
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
