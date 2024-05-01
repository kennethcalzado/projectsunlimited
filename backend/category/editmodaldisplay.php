<?php
include '../../backend/conn.php';

// Check if categoryId is set and not empty
if(isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {
    // Sanitize the input
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    // Query to fetch category details
    $query = "SELECT pc.CategoryName, pc.type, 
                     CONCAT('../../../assets/category/', pc.imagecover) AS imagecover,
                     CONCAT('../../../assets/catheader/', pc.imageheader) AS imageheader, 
                     mc.CategoryName AS MainCategoryName,
                     mc.CategoryID AS MainCategoryID
              FROM productcategory pc
              LEFT JOIN productcategory mc ON pc.ParentCategoryID = mc.CategoryID
              WHERE pc.CategoryID = $categoryId";

    // Perform the query
    $result = mysqli_query($conn, $query);

    if($result) {
        if(mysqli_num_rows($result) > 0) {
            $category = mysqli_fetch_assoc($result);

            // Check if the category has both imagecover and imageheader
            $isMainCategory = !empty($category['imagecover']) && !empty($category['imageheader']);

            // Fetch subcategories if it's a main category
            if($isMainCategory) {
                $subcategoriesQuery = "SELECT CategoryID, CategoryName FROM productcategory WHERE ParentCategoryID = $categoryId";
                $subcategoriesResult = mysqli_query($conn, $subcategoriesQuery);

                if($subcategoriesResult) {
                    $subcategories = array();
                    while($subcategory = mysqli_fetch_assoc($subcategoriesResult)) {
                        $subcategories[] = $subcategory['CategoryName'];
                    }
                    mysqli_free_result($subcategoriesResult);
                } else {
                    $subcategories = array("No Subcategories");
                }
            }

            mysqli_free_result($result);

            echo json_encode(array(
                'success' => true,
                'category' => $category,
                'isMainCategory' => $isMainCategory,
                'subcategories' => isset($subcategories) ? $subcategories : null
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