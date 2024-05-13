<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
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
        $pageContent = <<<'PHP'
<?php
$is_public_page = true;
$pageTitle = 'Products - Projects Unlimited';
ob_start();
include("../backend/conn.php");

// Extract the category ID from the filename
$pagePath = basename(__FILE__); // Get the current filename
$parts = explode('_', $pagePath);
$categoryID = (int) end($parts); // Extract the numeric value before the file extension

// Retrieve category data based on its ID
$sql = "SELECT * FROM productcategory WHERE CategoryID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $categoryID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $categoryData = $result->fetch_assoc();
    $categoryName = $categoryData['CategoryName'];
    $imageHeader = $categoryData['imageheader'];
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
            <img src="../../assets/catheader/<?php echo $imageHeader; ?>" class="w-full h-96 object-cover object-top">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 flex items-center justify-center text-center">
                <p class="text-white font-extrabold text-4xl"><?php echo strtoupper($categoryName); ?><br></p>
            </div>
        </div>
        <header class="bg-[#F6E381]">
        </header>
    </div>
<?php
} else {
    echo "Category not found.";
}
$content = ob_get_clean();
include("../public/master.php");
?>
PHP;

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

        // Execute the statement
        $stmt = $conn->prepare("INSERT INTO productcategory (CategoryName, ParentCategoryID, type, status, imagecover, imageheader, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sissss", $categoryName, $parentCategoryID, $pageType, $status, $imageCover, $imageHeader);
        if ($stmt->execute()) {
            // Get the ID of the newly inserted category
            $category_id = $stmt->insert_id;

            // Construct the page path with the category ID
            $pagePath = "../../pages/{$categoryName}_{$category_id}.php";

            // Update the database with the relative page path
            $pagePathRelativeToRoot = "/{$categoryName}_{$category_id}.php";

            // Create the page/file
            file_put_contents($pagePath, $pageContent);

            // Update the database with the specific page path
            $updatePathStmt = $conn->prepare("UPDATE productcategory SET page_path = ? WHERE CategoryID = ?");
            $updatePathStmt->bind_param("si", $pagePathRelativeToRoot, $category_id);
            $updatePathStmt->execute();
            $updatePathStmt->close();

            $response['success'] = true;
            $response['message'] = "Category added successfully";
            $response['categoryID'] = $category_id; // Send the newly inserted category ID back to frontend
        } else {
            $response['success'] = false;
            $response['message'] = "Error: " . $conn->error;
        }
        $stmt->close();
    } else if ($categoryType == 'sub') {
        // Subcategory
        $parentCategoryID = $_POST['mainCategory']; // Assuming the main category ID is passed from the frontend
        // Set imageCover and imageHeader to NULL for subcategories
        $imageCover = NULL;
        $imageHeader = NULL;
        $pagePathRelativeToRoot = NULL; // For subcategories, page path may not be applicable or different logic may apply
    }

    // Send JSON response back to frontend
    echo json_encode($response);
} else {
    // If form data is not submitted via POST method, return error
    $response['success'] = false;
    $response['message'] = "Form data not submitted";
    echo json_encode($response);
}
?>