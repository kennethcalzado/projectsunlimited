<?php
include("../../backend/conn.php");

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $sortOption = $_POST['sortOption'];
    $searchTerm = isset($_POST['query']) ? $_POST['query'] : '';


    // Start building the SQL query
    $sql = "SELECT * FROM blogs";

    // Append conditions based on the selected category
    if ($category !== "") {
        $sql .= " WHERE type = '$category'";
    }

    // Append conditions based on the search term
    if ($searchTerm !== "") {
        $sql .= ($category === "") ? " WHERE" : " AND";
        $sql .= " (title LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%')";
    }


    // Adjust the SQL query based on the selected sorting option
    if ($sortOption === 'new') {
        $sql .= " ORDER BY date DESC";
    } elseif ($sortOption === 'old') {
        $sql .= " ORDER BY date ASC";
    }

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);
    $data = array();
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        mysqli_free_result($result);
    }

    // Return the fetched data as JSON
    echo json_encode($data);
}
