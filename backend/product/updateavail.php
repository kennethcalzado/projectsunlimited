<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// include '../../backend/conn.php';

// // Check if the connection is established successfully
// if ($conn) {
//     // Get the ProductID and availability from the POST request
//     $ProductID = $_POST['ProductID'];
//     $availability = $_POST['availability'];

//     // Construct SQL query to update the availability for the specified product
//     $sql = "UPDATE product SET availability = '$availability' WHERE ProductID = $ProductID";

//     // Execute the SQL query
//     $result = mysqli_query($conn, $sql);

//     // Check if the query was executed successfully
//     if ($result) {
//         // Output the updated availability as JSON
//         header('Content-Type: application/json');
//         echo json_encode($availability);
//     } else {
//         // If the query failed to execute, return an error message as JSON
//         header('Content-Type: application/json');
//         echo json_encode(array("error" => "Failed to execute query: " . mysqli_error($conn)));
//     }
// } else {
//     // Return an error message as JSON if connection fails
//     header('Content-Type: application/json');
//     echo json_encode(array("error" => "Failed to connect to the database"));
// }
?>