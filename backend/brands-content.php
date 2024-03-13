<?php
include 'conn.php'; // Include the database connection script

// Check if brand_id is provided in the request
if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];

    // Query to retrieve brand information and its products
    $sql = "SELECT * FROM Brands WHERE brand_id = $brand_id";
    $result = $conn->query($sql);

    if ($result === false) {
        // Print error message and query causing the error
        echo "Error: " . $conn->error . "\n";
        echo "Query: " . $sql . "\n";
        die(); // Stop script execution
    }

    if ($result->num_rows > 0) {
        $brand_data = $result->fetch_assoc();

        // Query to retrieve products associated with the brand
        $sql_products = "SELECT * FROM Products WHERE brand_id = $brand_id";
        $result_products = $conn->query($sql_products);

        if ($result_products === false) {
            // Print error message and query causing the error
            echo "Error: " . $conn->error . "\n";
            echo "Query: " . $sql_products . "\n";
            die(); // Stop script execution
        }

        $products = array();
        if ($result_products->num_rows > 0) {
            while ($row = $result_products->fetch_assoc()) {
                $products[] = $row;
            }
        }

        // Combine brand data with product data
        $brand_data['products'] = $products;

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($brand_data);
    } else {
        echo "Brand not found";
    }
} else {
    echo "Brand ID is required";
}
?>