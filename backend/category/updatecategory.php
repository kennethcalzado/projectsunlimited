<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../../backend/auditlog.php';
include '../../backend/conn.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if categoryId, editCategoryName, editCategoryType, and editCategoryCat are set
    if (isset($_GET['categoryId'], $_POST['editCategoryName'], $_POST['editCategoryType'], $_POST['editCategoryCat'])) {

        $categoryId = $_GET['categoryId'];
        $categoryName = $_POST['editCategoryName'];
        $categoryType = $_POST['editCategoryType'];
        $editCategoryCat = $_POST['editCategoryCat']; // Added line to retrieve editCategoryCat value

        // Additional fields related to category type
        $pagePath = isset($_POST['editPagePath']) ? $_POST['editPagePath'] : null;
        $imageCover = isset($_FILES['editMainCategoryImageInput']['name']) ? $_FILES['editMainCategoryImageInput']['name'] : null;
        $imageHeader = isset($_FILES['editMainCategoryCoverInput']['name']) ? $_FILES['editMainCategoryCoverInput']['name'] : null;
        $parentCategoryId = isset($_POST['editParentCategoryID']) ? $_POST['editParentCategoryID'] : null;

        // Verify if the provided ParentCategoryID exists
        if (!empty($parentCategoryId)) {
            $checkParentCategoryQuery = "SELECT * FROM productcategory WHERE CategoryID = $parentCategoryId";
            $parentCategoryResult = mysqli_query($conn, $checkParentCategoryQuery);
            if (!$parentCategoryResult || mysqli_num_rows($parentCategoryResult) == 0) {
                echo json_encode(array("success" => false, "message" => "Parent Category ID does not exist"));
                exit(); // Stop execution if Parent Category ID does not exist
            }
        }

        // Retrieve the current parent category ID
        $currentParentCategoryIdQuery = mysqli_query($conn, "SELECT ParentCategoryID FROM productcategory WHERE CategoryID = $categoryId");
        $currentParentCategoryId = mysqli_fetch_assoc($currentParentCategoryIdQuery)['ParentCategoryID'];

        // Update query based on category type and category change
        if ($editCategoryCat === "sub") {
            // Ensure that a parent category is selected for subcategories
            if (empty($parentCategoryId)) {
                echo json_encode(array("success" => false, "message" => "Please select a Parent Category for subcategories"));
                exit();
            }


            // Reset page path, imagecover, imageheader, and parent category ID
            $sql = "UPDATE productcategory SET CategoryName = '$categoryName', type = '$categoryType', imagecover = NULL, imageheader = NULL, ParentCategoryID = $parentCategoryId WHERE CategoryID = $categoryId";
        } else {
            // Save image paths
            $imageCoverPath = '';
            $imageHeaderPath = '';

            // Handle image uploads
            if (!empty($_FILES['editMainCategoryImageInput']['tmp_name'])) {
                $imageCoverFilename = $_FILES['editMainCategoryImageInput']['name'];
                $imageCoverPath = '../../assets/category/' . $imageCoverFilename;
                move_uploaded_file($_FILES['editMainCategoryImageInput']['tmp_name'], $imageCoverPath);
                $imageCoverPath = $imageCoverFilename; // Save only the file name
            }

            if (!empty($_FILES['editMainCategoryCoverInput']['tmp_name'])) {
                $imageHeaderFilename = $_FILES['editMainCategoryCoverInput']['name'];
                $imageHeaderPath = '../../assets/catheader/' . $imageHeaderFilename;
                move_uploaded_file($_FILES['editMainCategoryCoverInput']['tmp_name'], $imageHeaderPath);
                $imageHeaderPath = $imageHeaderFilename; // Save only the file name
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
            // Check if page already exists for the category
            $existingPagePathQuery = mysqli_query($conn, "SELECT page_path FROM productcategory WHERE CategoryID = $categoryId");
            $existingPagePath = mysqli_fetch_assoc($existingPagePathQuery)['page_path'];

            // If page path exists and it's not empty, update page content, else create a new page
            if (!empty($existingPagePath)) {
                // Update existing page content
                $filePath = '../../pages/' . $existingPagePath;
                file_put_contents($filePath, $pageContent); // Update the content
                $pagePath = "{$existingPagePath}"; // Keep the existing page path
            } else {
                // Save page content to file
                $filePath = "../../pages/{$categoryName}_{$categoryId}.php";
                file_put_contents($filePath, $pageContent);
                $pagePath = "/{$categoryName}_{$categoryId}.php";
            }

            // Update page path, imagecover, imageheader, and parent category ID
            $sql = "UPDATE productcategory SET CategoryName = '$categoryName', type = '$categoryType'";
            // Update page path
            if (!empty($pagePath)) {
                $sql .= ", page_path = '$pagePath'";
            }
            // Update imagecover if provided
            if (!empty($imageCover)) {
                $sql .= ", imagecover = '$imageCoverPath'";
            }
            // Update imageheader if provided
            if (!empty($imageHeader)) {
                $sql .= ", imageheader = '$imageHeaderPath'";
            }
           // Update parent category ID if provided
           if (!empty($parentCategoryId)) {
            $sql .= ", ParentCategoryID = '$parentCategoryId'";
        } else {
            // Set ParentCategoryID to NULL for main categories
            $sql .= ", ParentCategoryID = NULL";
        }
        $sql .= " WHERE CategoryID = $categoryId";
    }

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("success" => true, "message" => "Category updated successfully"));

            // Fetch user information from session or database
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];

                // Fetch user details from the database using user_id
                $sql = "SELECT fname, lname, role_id FROM users WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $role_id = $row['role_id'];

                    // Log the action with user details
                    logAudit($user_id, $fname, $lname, $role_id, "Updated category: '$categoryName'");
                }
            }
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