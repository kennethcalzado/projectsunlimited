<?php

include '../../backend/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_GET['categoryId'])) {

        $categoryId = $_GET['categoryId'];

        // Fetch the existing category details
        $oldCategoryDetails = mysqli_fetch_assoc(mysqli_query($conn, "SELECT CategoryName, type FROM productcategory WHERE CategoryID = $categoryId"));
        $oldCategoryName = $oldCategoryDetails['CategoryName'];
        $oldCategoryType = $oldCategoryDetails['type'];

        $categoryName = $_POST['editCategoryName'];
        $categoryType = $_POST['editCategoryType']; // Add this line to fetch the new category type
        
        // Check if only CategoryName field is changed
        $isCategoryNameChanged = false;
        if ($oldCategoryName !== $categoryName) {
            $isCategoryNameChanged = true;
        }
        
        // Check if only CategoryType field is changed
        $isCategoryTypeChanged = false;
        if ($oldCategoryType !== $categoryType) {
            $isCategoryTypeChanged = true;
        }

        // Update query
        $sql = "UPDATE productcategory SET CategoryName = ?";
        $sqlParams = array("s", &$categoryName);

        // Additional fields related to category type
        if ($isCategoryNameChanged) {
            // Update other fields only if CategoryName is changed
            // Construct the page path
            $pagePath = $oldCategoryType === 'main' ? '../../pages/' . $categoryName . '.php' : null;

            // Update page path
            $sql .= ", page_path = ?";
            $sqlParams[0] .= "s";
            $sqlParams[] = &$pagePath;
        }
        
        // Add condition to handle CategoryType change
        if ($isCategoryTypeChanged) {
            $sql .= ", type = ?";
            $sqlParams[0] .= "s";
            $sqlParams[] = &$categoryType;
        }

        // Complete the SQL statement
        $sql .= " WHERE CategoryID = ?";
        $sqlParams[0] .= "i";
        $sqlParams[] = &$categoryId;

        // Prepare statement
        $stmt = mysqli_prepare($conn, $sql);

        // Check for errors
        if (!$stmt) {
            echo json_encode(array("success" => false, "message" => "Error preparing statement: " . mysqli_error($conn)));
            exit(); // Terminate the script
        }

        // Bind parameters
        call_user_func_array('mysqli_stmt_bind_param', array_merge(array($stmt), $sqlParams));

        // Execute query
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(array("success" => true, "message" => "Category updated successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error updating category: " . mysqli_error($conn)));
        }
        
    } else {
        echo json_encode(array("success" => false, "message" => "Category ID not provided"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Form not submitted"));
}
?>
