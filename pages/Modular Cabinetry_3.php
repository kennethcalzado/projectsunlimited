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