<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include '../../backend/conn.php';
include "../../backend/auditlog.php";

// Function to fetch total number of variations with optional filters
function getTotalVariations($conn, $statusFilter = null, $availabilityFilter = null, $searchQuery = null)
{
    // Initialize the base query
    $query = "SELECT COUNT(*) as totalVariations FROM product_variation WHERE 1=1";

    // Add status filter if provided
    if ($statusFilter) {
        $query .= " AND status = '$statusFilter'";
    }

    // Add availability filter if provided
    if ($availabilityFilter) {
        $query .= " AND availability = '$availabilityFilter'";
    }

    // Add search filter if provided
    if ($searchQuery) {
        $query .= " AND (VariationName LIKE '%$searchQuery%' OR availability LIKE '%$searchQuery%' OR status LIKE '%$searchQuery%')";
    }

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if ($result) {
        // Fetch the total number of variations
        $row = mysqli_fetch_assoc($result);
        return $row['totalVariations'];
    } else {
        return 0;
    }
}

// Function to fetch variation data with pagination and optional filters
function fetchVariationData($conn, $page, $itemsPerPage, $statusFilter = null, $availabilityFilter = null, $searchQuery = null)
{
    // Calculate the offset based on the page number and items per page
    $offset = ($page - 1) * $itemsPerPage;

    // Query to fetch variations with pagination and filters
    $query = "SELECT * FROM product_variation WHERE 1=1";

    // Add status filter if provided
    if ($statusFilter) {
        $query .= " AND status = '$statusFilter'";
    }

    // Add availability filter if provided
    if ($availabilityFilter) {
        $query .= " AND availability = '$availabilityFilter'";
    }

    // Add search filter if provided
    if ($searchQuery) {
        $query .= " AND (VariationName LIKE '%$searchQuery%' OR availability LIKE '%$searchQuery%' OR status LIKE '%$searchQuery%')";
    }

    // Order by status and VariationID, and apply pagination
    $query .= " ORDER BY CASE WHEN status = 'inactive' THEN 1 ELSE 0 END, VariationID DESC LIMIT $offset, $itemsPerPage";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $variations = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $variations[] = $row;
        }
        // Get total variations count with filters
        $totalVariations = getTotalVariations($conn, $statusFilter, $availabilityFilter, $searchQuery);
        // Return variation data, total number of pages, and total number of items
        echo json_encode(array('status' => 'success', 'data' => $variations, 'totalPages' => ceil($totalVariations / $itemsPerPage), 'totalItems' => $totalVariations));
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
    // Get pagination, filter, and search parameters
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $itemsPerPage = isset($_GET['itemsPerPage']) ? $_GET['itemsPerPage'] : 10;
    $statusFilter = isset($_GET['status']) && $_GET['status'] !== 'statusreset' ? $_GET['status'] : null;
    $availabilityFilter = isset($_GET['availability']) && $_GET['availability'] !== 'availreset' ? $_GET['availability'] : null;
    $searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : null;

    // Fetch variation data with pagination, filters, and search
    fetchVariationData($conn, $page, $itemsPerPage, $statusFilter, $availabilityFilter, $searchQuery);
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