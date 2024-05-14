<?php
include("../backend/conn.php");

if (isset($_POST['sortOption'])) {
    $sortOption = $_POST['sortOption'];
    $searchTerm = isset($_POST['query']) ? $_POST['query'] : '';
    $page = isset($_POST['page']) ? $_POST['page'] : 1; // New: Get the current page

    $limit = 10; // Number of records per page
    $offset = ($page - 1) * $limit; // Calculate the offset

    $sql = 'SELECT auditlogs.*, roles.role_name
        FROM auditlogs
        LEFT JOIN roles ON auditlogs.role_id = roles.role_id';

    // Append conditions based on the search term
    if ($searchTerm !== "") {
        $sql .= " WHERE (fname LIKE '%$searchTerm%' OR lname LIKE '%$searchTerm%' OR action LIKE '%$searchTerm%')";
    }

    // Append sorting option
    if ($sortOption === 'new') {
        $sql .= " ORDER BY date DESC";
    } elseif ($sortOption === 'old') {
        $sql .= " ORDER BY date ASC";
    }

    // Execute the SQL query to get filtered records count
    $countSql = "SELECT COUNT(*) AS count FROM ($sql) AS filtered";
    $countResult = mysqli_query($conn, $countSql);
    $totalCount = 0;
    if ($countResult && $countRow = mysqli_fetch_assoc($countResult)) {
        $totalCount = $countRow['count'];
    }

    // Adjust the original SQL query with pagination
    $sql .= " LIMIT $limit OFFSET $offset";

    // Execute the SQL query to fetch data
    $result = mysqli_query($conn, $sql);
    $data = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_free_result($result);
    }

    // Return the fetched data as JSON along with total number of filtered records
    echo json_encode(array('data' => $data, 'total' => $totalCount));
}