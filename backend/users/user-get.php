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
$sql = "SELECT u.user_id, u.fname, u.lname, u.email, u.status, r.role_name, u.created_at, u.updated_at
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
    $sql .= " (u.fname LIKE ? OR u.lname LIKE ? OR u.email LIKE ?)";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
    $params[] = "%$searchTerm%";
}

// Prepare statement for counting total rows
$countSql = "SELECT COUNT(*) AS totalRows FROM ($sql) AS total";
$countStmt = $conn->prepare($countSql);
if ($countStmt) {
    // Bind parameters dynamically
    if (!empty ($params)) {
        $types = str_repeat('s', count($params)); // Generate type string dynamically (all parameters are strings)
        $countStmt->bind_param($types, ...$params);
    }

    // Execute the count statement
    if ($countStmt->execute()) {
        // Fetch total count
        $countResult = $countStmt->get_result();
        $totalCount = $countResult->fetch_assoc()['totalRows'];

        // Close count statement
        $countStmt->close();

        // Append LIMIT and OFFSET for pagination to the original query
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        // Prepare statement for fetching limited data
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Bind parameters dynamically
            if (!empty ($params)) {
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

                // Calculate total pages
                $totalPages = ceil($totalCount / $limit);

                // Construct pagination data
                $pagination = array(
                    "totalRows" => $totalCount,
                    "totalPages" => $totalPages,
                    "currentPage" => $page,
                    "perPage" => $limit,
                    "startItem" => $offset + 1, // Calculate startItem based on offset
                    "endItem" => min($offset + $limit, $totalCount) // Calculate endItem based on offset and limit
                );

                // Combine user data and pagination information
                $response = array(
                    "users" => $users,
                    "pagination" => $pagination
                );

                // Return JSON response with user data and pagination information
                if (empty ($users)) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode($response);
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
            // Error preparing statement for fetching limited data
            $errorMessage = "Error preparing statement: " . $conn->error . PHP_EOL;
            file_put_contents('query_log.txt', $errorMessage, FILE_APPEND);
            http_response_code(500); // Set HTTP response code to indicate internal server error
            echo json_encode(["error" => $errorMessage]);
        }
    } else {
        // Error executing the count statement
        $errorMessage = "Error executing statement: " . $countStmt->error . PHP_EOL;
        file_put_contents('query_log.txt', $errorMessage, FILE_APPEND);
        http_response_code(500); // Set HTTP response code to indicate internal server error
        echo json_encode(["error" => $errorMessage]);
    }
} else {
    // Error preparing statement for counting total rows
    $errorMessage = "Error preparing statement: " . $conn->error . PHP_EOL;
    file_put_contents('query_log.txt', $errorMessage, FILE_APPEND);
    http_response_code(500); // Set HTTP response code to indicate internal server error
    echo json_encode(["error" => $errorMessage]);
}

// Close connection
$conn->close();
?>