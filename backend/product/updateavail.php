<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';
// Include the auditlog.php file
include("../../backend/auditlog.php");

// Check if the connection is established successfully
if ($conn) {
    // Check if ProductID and availability are provided in the POST request
    if (isset($_POST['ProductID'], $_POST['availability'])) {
        $productId = $_POST['ProductID'];
        $availability = $_POST['availability'];

        // Construct SQL query to update the availability of the product
        $sql = "UPDATE product SET availability = '$availability' WHERE ProductID = '$productId'";


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
                logAudit($user_id, $fname, $lname, $role_id, "Updated product availability of '$productId' to $availability");
            }
        }

        // Execute the SQL query
        $result = mysqli_query($conn, $sql);

        // Check if the query was executed successfully
        if ($result) {
            // Output success message as JSON
            header('Content-Type: application/json');
            echo json_encode(array("success" => "Availability updated successfully."));
        } else {
            // If the query failed to execute, log an error message
            error_log("Failed to execute query: " . mysqli_error($conn));
            // Output an error message as JSON
            header('Content-Type: application/json');
            echo json_encode(array("error" => "Failed to update availability."));
        }
    } else {
        // Output an error message if ProductID or availability is not provided
        header('Content-Type: application/json');
        echo json_encode(array("error" => "ProductID or availability not provided."));
    }
} else {
    // Output an error message if connection is not established
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Database connection failed."));
}
