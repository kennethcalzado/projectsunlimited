<?php

include '../../backend/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_GET['categoryId'])) {

        $categoryId = $_GET['categoryId'];

        $categoryName = $_POST['editCategoryName'];
        $categoryType = $_POST['editCategoryType'];

        echo "Category ID: $categoryId\n";
        echo "Category Type: $categoryType\n";

        // Additional fields related to category type
        $pagePath = isset($_POST['editPagePath']) ? $_POST['editPagePath'] : null;
        $imageCover = isset($_FILES['editMainCategoryImageInput']['name']) ? $_FILES['editMainCategoryImageInput']['name'] : null;
        $imageHeader = isset($_FILES['editMainCategoryCoverInput']['name']) ? $_FILES['editMainCategoryCoverInput']['name'] : null;
        $parentCategoryId = isset($_POST['editParentCategoryID']) ? $_POST['editParentCategoryID'] : null;

        // Update query based on category type
        if ($categoryType === "sub") {
            // Reset page path, imagecover, imageheader, and parent category ID
            $sql = "UPDATE productcategory SET CategoryName = '$categoryName', type = '$categoryType', page_path = NULL, imagecover = NULL, imageheader = NULL, ParentCategoryID = NULL WHERE CategoryID = $categoryId";
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

            // Save page content to file
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

            // Save page content to file
            $filePath = '../../pages/' . $categoryName . '.php';

            // Create the page/file
            file_put_contents($filePath, $pageContent);

            // Update page path, imagecover, imageheader, and parent category ID
            $sql = "UPDATE productcategory SET CategoryName = '$categoryName', type = '$categoryType', page_path = '/" . urlencode($categoryName) . ".php', imagecover = '$imageCoverPath', imageheader = '$imageHeaderPath'";
            if ($parentCategoryId) {
                $sql .= ", ParentCategoryID = '$parentCategoryId'";
            } else {
                $sql .= ", ParentCategoryID = NULL";
            }
            $sql .= " WHERE CategoryID = $categoryId";
        }

        if (mysqli_query($conn, $sql)) {
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
