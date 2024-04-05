<?php
include("../../backend/conn.php");

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $sortOption = $_POST['sortOption'];

    // Initialize response array
    $response = array();

    // Start building the SQL query
    $sql = "SELECT * FROM blogs";

    // Append conditions based on the selected category
    if ($category !== "") {
        $category = mysqli_real_escape_string($conn, $category); // Escape input to prevent SQL injection
        $sql .= " WHERE type = '$category'";
    }

    // Append sorting option
    if ($sortOption === 'new') {
        $sql .= " ORDER BY date DESC";
    } elseif ($sortOption === 'old') {
        $sql .= " ORDER BY date ASC";
    }

    // Execute the SQL query to fetch data
    $result = mysqli_query($conn, $sql);

    // Check for errors
    if (!$result) {
        $response['error'] = mysqli_error($conn);
    } else {
        // Fetch data if query was successful
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_free_result($result);

        // Add data to response
        $response['data'] = $data;
    }

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close database connection
    mysqli_close($conn);
}
