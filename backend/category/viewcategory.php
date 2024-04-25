<?php
// Include your database connection
include '../../backend/conn.php';

// Check if categoryId is set and not empty
if(isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {
    // Sanitize the input
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    // Query to fetch category details
    $query = "SELECT pc.CategoryName, pc.type, 
                     CONCAT('../../../assets/category/', pc.imagecover) AS imagecover,
                     CONCAT('../../../assets/catheader/', pc.imageheader) AS imageheader, 
                     mc.CategoryName AS MainCategoryName
              FROM productcategory pc
              LEFT JOIN productcategory mc ON pc.ParentCategoryID = mc.CategoryID
              WHERE pc.CategoryID = $categoryId";

    // Perform the query
    $result = mysqli_query($conn, $query);

    if($result) {
        if(mysqli_num_rows($result) > 0) {
            $category = mysqli_fetch_assoc($result);
            
            $isMainCategory = false;

            // Check if the category ID is used as a parent category ID for any other category
            $checkMainCategoryQuery = "SELECT COUNT(*) AS count FROM productcategory WHERE ParentCategoryID = $categoryId";
            $mainCategoryResult = mysqli_query($conn, $checkMainCategoryQuery);
            $mainCategoryData = mysqli_fetch_assoc($mainCategoryResult);
            if (!empty($category['imagecover']) && !empty($category['imageheader']) && $mainCategoryData['count'] > 0) {
                $isMainCategory = true;
            }

            mysqli_free_result($result);

            echo json_encode(array(
                'success' => true,
                'category' => $category,
                'isMainCategory' => $isMainCategory
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Category not found'
            ));
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => 'Error fetching category details: ' . mysqli_error($conn)
        ));
    }
} else {
    echo json_encode(array(
        'success' => false,
        'message' => 'Invalid categoryId parameter'
    ));
}
?>
