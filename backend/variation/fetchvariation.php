<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include '../../backend/conn.php';
include "../../backend/auditlog.php";

// Function to fetch total number of variations
function getTotalVariations($conn)
{
    $query = "SELECT COUNT(*) as totalVariations FROM product_variation";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['totalVariations'];
    } else {
        return 0;
    }
}

// Function to fetch variation data with pagination
function fetchVariationData($conn, $page, $itemsPerPage)
{
    // Calculate the offset based on the page number and items per page
    $offset = ($page - 1) * $itemsPerPage;

    // Query to fetch variations with pagination
    $query = "SELECT * FROM product_variation ORDER BY CASE WHEN status = 'inactive' THEN 1 ELSE 0 END, VariationID DESC LIMIT $offset, $itemsPerPage";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $variations = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $variations[] = $row;
        }
        // Return variation data and total number of pages
        echo json_encode(array('status' => 'success', 'data' => $variations, 'totalPages' => ceil(getTotalVariations($conn) / $itemsPerPage)));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to fetch variation data'));
    }
}

// Function to update availability
function updateAvailability($conn, $variationId, $availability)
{
    $query = "UPDATE product_variation SET availability = '$availability' WHERE VariationID = '$variationId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to update availability'));
    }
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get pagination parameters
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $itemsPerPage = isset($_GET['itemsPerPage']) ? $_GET['itemsPerPage'] : 10;

    // Fetch variation data with pagination
    fetchVariationData($conn, $page, $itemsPerPage);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update availability
    $variationId = $_POST['variationId'];
    $availability = $_POST['availability'];
    updateAvailability($conn, $variationId, $availability);

    // Fetch user information from session or database
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Construct SQL query to select user details
        $select_sql = "SELECT fname, lname, role_id FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($select_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch user details from the result
        if ($row = $result->fetch_assoc()) {
            $fname = $row['fname'];
            $lname = $row['lname'];
            $role_id = $row['role_id'];

            // Log the action with user details
            logAudit($user_id, $fname, $lname, $role_id, "Updated variation availability of '$variationId' to $availability");
        }
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}

// Close database connection
mysqli_close($conn);
?>
