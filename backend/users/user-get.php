<?php
include '../../backend/conn.php'; // Include the database connection script

// Initialize variables for filters (if provided)
$roleFilter = $_GET['roleFilter'] ?? null;
$statusFilter = $_GET['statusFilter'] ?? null;
$searchTerm = $_GET['searchTerm'] ?? null;
$page = $_GET['page'] ?? 1; // Default to page 1 if not provided
$limit = $_GET['limit'] ?? 5; // Default limit to 5 if not provided

// Calculate offset for pagination
$offset = ($page - 1) * $limit;

// Base SQL query
$sql = "SELECT u.user_id, u.username, u.fname, u.lname, u.email, u.status, r.role_name, u.created_at, u.updated_at
        FROM users u 
        INNER JOIN roles r ON u.role_id = r.role_id";

// Array to store parameters for prepared statement
$params = array();

// Append WHERE clause for role filter (if provided)
if ($roleFilter !== null && $roleFilter !== '') {
    $sql .= " WHERE r.role_name = ?";
    $params[] = $roleFilter;
}

// Append WHERE clause for status filter (if provided)
if ($statusFilter !== null && $statusFilter !== '') {
    $sql .= ($roleFilter !== null ? " AND" : " WHERE") . " u.status = ?";
    $params[] = $statusFilter;
}

// Append WHERE clause for search term (if provided)
if ($searchTerm !== null && $searchTerm !== '') {
    $sql .= ($roleFilter !== null || $statusFilter !== null && $statusFilter !== '') ? " AND" : " WHERE";
    $sql .= " (u.fname LIKE ? OR u.lname LIKE ? OR u.username LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
}

// Append LIMIT and OFFSET for pagination
$sql .= " LIMIT ? OFFSET ?";

// Add limit and offset parameters
$params[] = $limit;
$params[] = $offset;

// Log the SQL query
$queryLog = date('Y-m-d H:i:s') . " - SQL: $sql - Parameters: " . json_encode($params) . PHP_EOL;
file_put_contents('query_log.txt', $queryLog, FILE_APPEND);

// Prepare statement
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind parameters dynamically
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // Generate type string dynamically (all parameters are strings)
        $stmt->bind_param($types, ...$params);
    }

    // Execute the statement
    if ($stmt->execute()) {
        // Fetch results
        $result = $stmt->get_result();

        // Fetch user data
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        // Log the number of rows returned
        $rowsReturned = count($users);
        $logMessage = "Query executed successfully. Rows returned: $rowsReturned" . PHP_EOL;
        file_put_contents('query_log.txt', $logMessage, FILE_APPEND);

        // Return JSON response with user data
        if (empty($users)) {
            echo json_encode(["message" => "No users found."]);
        } else {
            header('Content-Type: application/json');
            echo json_encode($users);
        }
    } else {
        // Error executing the statement
        $errorMessage = "Error executing statement: " . $stmt->error . PHP_EOL;
        file_put_contents('query_log.txt', $errorMessage, FILE_APPEND);
        http_response_code(500); // Set HTTP response code to indicate internal server error
        echo json_encode(["error" => $errorMessage]);
    }

    // Close statement
    $stmt->close();
} else {
    // Error preparing statement
    $errorMessage = "Error preparing statement: " . $conn->error . PHP_EOL;
    file_put_contents('query_log.txt', $errorMessage, FILE_APPEND);
    http_response_code(500); // Set HTTP response code to indicate internal server error
    echo json_encode(["error" => $errorMessage]);
}

// Close connection
$conn->close();
?>