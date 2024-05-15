<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include '../../backend/conn.php';
include "../../backend/auditlog.php";

// Check if variationId and status are set in POST request
if(isset($_POST['variationId'], $_POST['status'])) {
    // Sanitize input to prevent SQL injection
    $variationId = mysqli_real_escape_string($conn, $_POST['variationId']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the status of the variation in the database
    $sql = "UPDATE product_variation SET status = '$status' WHERE VariationID = '$variationId'";
    if(mysqli_query($conn, $sql)) {
        // If update successful, send success response
        $response = array('status' => 'success');
        echo json_encode($response);
    } else {
        // If update failed, send error response
        $response = array('status' => 'error');
        echo json_encode($response);
    }
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
            logAudit($user_id, $fname, $lname, $role_id, "Status Updated for Variation: '$variationId'");
        }
    }
} else {
    // If variationId and status are not set, send error response
    $response = array('status' => 'error', 'message' => 'Invalid request');
    echo json_encode($response);
}
?>
