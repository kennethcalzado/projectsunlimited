<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $categoryName = $_POST['categoryName'];
    $pageType = $_POST['pageType']; // Assuming this corresponds to the 'type' column
    $categoryType = $_POST['categoryType'];
    $status = 'active'; // Assuming default status is 'active'
    $imageCover = ''; // Placeholder for image path
    $imageHeader = ''; // Placeholder for image path
    $parentCategoryID = NULL;

    // Check if main category or subcategory
    if ($categoryType == 'main') {
        // Main category
        // Handle image upload if provided
        if (!empty($_FILES['mainCategoryImageInput']['tmp_name'])) {
            $imageFilename = $_FILES['mainCategoryImageInput']['name']; // Get the filename
            $imageCover = $imageFilename; // Only save the filename
            move_uploaded_file($_FILES['mainCategoryImageInput']['tmp_name'], '../../assets/category/' . $imageCover); // Move uploaded image to desired directory
        }
        if (!empty($_FILES['mainCategoryCoverInput']['tmp_name'])) {
            $imageFilename = $_FILES['mainCategoryCoverInput']['name']; // Get the filename
            $imageHeader = $imageFilename; // Only save the filename
            move_uploaded_file($_FILES['mainCategoryCoverInput']['tmp_name'], '../../assets/catheader/' . $imageHeader); // Move uploaded image to desired directory
        }

        // Create page/file for the main category
        $pagePath = '../../pages/' . $categoryName . '.php'; // Relative path of the page
        $pageContent = '<?php
$pageTitle = "Products - ' . $categoryName . '";
ob_start();
?>
<style>
    #productModal {
        width: 100%;
        height: 100%;
        z-index: 1000;
    }
    .modal-content {
        width: 90%;
        max-width: 800px;
    }
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999i;
    }
    body.modal-open {
        overflow: hidden;
    }
</style>
<div class="content">
    <div class="relative">
        <img src="../assets/catheader/' . $imageHeader . '" class="w-full h-96 object-cover object-top">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-center text-center">
            <p class="text-white font-extrabold text-4xl">' . strtoupper($categoryName) . '<br></p>
        </div>
    </div>
    <header class="bg-[#F6E381]">
    </header>
</div>
<?php
$content = ob_get_clean();
include ("../public/master.php");
?>';

        // Create directories if they don't exist
        if (!file_exists('../../assets/category')) {
            mkdir('../../assets/category', 0777, true); // recursively create the directory
        }
        if (!file_exists('../../assets/catheader')) {
            mkdir('../../assets/catheader', 0777, true); // recursively create the directory
        }
        if (!file_exists('../../pages')) {
            mkdir('../../pages', 0777, true); // recursively create the directory
        }

        // Create the page/file
        file_put_contents($pagePath, $pageContent);

        // Update the database with the relative page path
        $pagePathRelativeToRoot = '/' . $categoryName . '.php'; // Relative to the root of your website
    } else if ($categoryType == 'sub') {
        // Subcategory
        $parentCategoryID = $_POST['mainCategory']; // Assuming the main category ID is passed from the frontend
        // Set imageCover and imageHeader to NULL for subcategories
        $imageCover = NULL;
        $imageHeader = NULL;
        $pagePathRelativeToRoot = NULL; // For subcategories, page path may not be applicable or different logic may apply
    }


    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO productcategory (CategoryName, ParentCategoryID, type, status, imagecover, imageheader, page_path, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sisssss", $categoryName, $parentCategoryID, $pageType, $status, $imageCover, $imageHeader, $pagePathRelativeToRoot);

    // Execute the statement
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Category added successfully";
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Send JSON response back to frontend
    echo json_encode($response);
} else {
    // If form data is not submitted via POST method, return error
    $response['success'] = false;
    $response['message'] = "Form data not submitted";
    echo json_encode($response);
}
?>
