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
            include ("../backend/conn.php");
            
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
                $categoryType = $categoryData['type'];
            
                if ($categoryType === 'product') {
                    // Retrieve products under the category and its subcategories
                    $sql = "
                   SELECT p.*, b.brand_name, pc.CategoryName as ProdCategoryName FROM product p
                   LEFT JOIN brands b ON p.brand_id = b.brand_id
                   JOIN productcategory pc ON p.CategoryID = pc.CategoryID
                   WHERE (p.CategoryID = ? OR p.CategoryID IN (SELECT CategoryID FROM productcategory WHERE ParentCategoryID = ?))
                   AND p.status = 'active'
                   AND (p.availability = 'available' OR p.availability = 'low stocks')    
                   ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $categoryID, $categoryID);
                    $stmt->execute();
                    $products = $stmt->get_result();
                    ?>
                    <style>
                        #productModal {
                            display: none;
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.5);
                            z-index: 1000;
                            justify-content: center;
                            align-items: center;
                            opacity: 0;
                            transition: opacity 0.5s ease-in-out;
                        }
            
                        #productModal.show {
                            display: flex;
                            opacity: 1;
                        }
            
                        #productModal.hide {
                            opacity: 0;
                        }
            
                        .modal-content {
                            background-color: white;
                            padding: 20px;
                            border-radius: 5px;
                            display: flex;
                            flex-direction: column;
                            max-width: 100%;
                            max-height: 100%;
                            overflow-y: auto;
                        }
            
                        .modal-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            width: 100%;
                        }
            
                        .modal-header button {
                            background: none;
                            border: none;
                            font-size: 1.5rem;
                            cursor: pointer;
                        }
            
                        .modal-body {
                            display: flex;
                            width: 100%;
                        }
            
                        .modal-left {
                            flex: 1;
                            padding-right: 20px;
                            display: flex;
                            flex-direction: column;
                        }
            
                        .modal-left img#modalImage {
                            width: 500px;
                            height: 250px;
                        }
            
                        .modal-right {
                            flex: 2;
                        }
            
                        .variations {
                            display: flex;
                            flex-wrap: wrap;
                            margin-top: 5px;
                            gap: 2px;
                        }
            
                        .variation-item {
                            width: 35px;
                            height: 35px;
                        }
            
                        .grid {
                            display: grid;
                            grid-template-columns: repeat(5, 1fr);
                            gap: 20px;
                        }
            
                        .product-item {
                            cursor: pointer;
                            transition: transform 0.3s ease-in-out;
                        }
            
                        .product-item:hover {
                            transform: scale(1.05);
                            background-color: #D1D5DB;
                        }
            
                        .product-item:hover h3 {
                            color: #A16207;
                        }
            
                        .product-image {
                            width: 100%;
                            height: 250px;
                        }
            
                        #productModal.modal-fixed {
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
                        <h1 class="text-black font-extrabold text-center my-4 text-4xl"><?php echo strtoupper($categoryName); ?>
                            PRODUCTS<br></h1>
                        <div class="flex justify-center"> <!-- Added flex and justify-center -->
                            <div class="relative mb-1 mt-2 sm:mb-0 sm:mr-2 flex items-center">
                                <!-- Search input -->
                                <div class="relative">
                                    <input
                                        class="border-2 border-gray-300 bg-white h-10 w-96 px-2 pr-10 rounded-lg text-[16px] focus:outline-none"
                                        type="text" name="search" placeholder="Search Product or Category" id="searchInput">
                                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-4"> <!-- Adjusted margin-top -->
                                        <svg class="text-gray-600 h-5 w-5 fill-current hover:text-gray-500 "
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                            id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966"
                                            style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px"
                                            height="512px">
                                            <path
                                                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="prodcontent">
                            <?php if ($products->num_rows > 0): ?>
                                <div class="grid m-4">
                                    <?php while ($product = $products->fetch_assoc()): ?>
                                        <?php
                                        $productID = $product['ProductID'];
                                        $sql = "SELECT * FROM product_variation WHERE ProductID = ? AND status = 'active'";
                                        $variationStmt = $conn->prepare($sql);
                                        $variationStmt->bind_param("i", $productID);
                                        $variationStmt->execute();
                                        $variations = $variationStmt->get_result();
                                        $product['variations'] = $variations->fetch_all(MYSQLI_ASSOC);
                                        ?>
                                        <div class="product-item border p-4"
                                            onclick='openModal(<?php echo htmlspecialchars(json_encode($product)); ?>)'>
                                            <img src="../../assets/products/<?php echo $product['image_urls']; ?>"
                                                alt="<?php echo htmlspecialchars($product['ProductName']); ?>"
                                                class="product-image object-cover object-center mb-2">
                                            <h3 class="text-lg font-bold text-center"><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                                            <h3 class="text-sm font-semibold text-gray-800 text-center">Category:
                                                <?php echo htmlspecialchars($product['ProdCategoryName']); ?>
                                            </h3>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-lg font-bold text-red-800">No products found in this category.</p>
                            <?php endif; ?>
                        </div>
                    </div>
            
                    <div id="productModal" class="flex">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 id="modalProductName" class="text-lg font-semibold"></h3>
                                <button id="closeModalButton">&times;</button>
                            </div>
                            <div class="border-b border-gray-800 flex-grow border my-2 mb-3"></div>
                            <div class="modal-body">
                                <div class="modal-left">
                                    <img id="modalImage" src="" class="w-full h-auto object-cover mb-2">
                                    <div id="variationName" class="mr-2"></div>
                                    <div id="variationAvailability" class="mr-2"></div>
                                </div>
                                <div class="modal-right">
                                    <p id="modalDescription" class="text-sm text-gray-800 mb-2"></p>
                                    <p id="modalAvailability" class="text-sm text-gray-800 mb-2"></p>
                                    <p id="modalBrand" class="text-sm text-gray-800 mb-2"></p>
                                    <p id="modalCategory" class="text-sm text-gray-800 mb-2"></p>
                                    <p id="modalVariation" class="text-sm text-gray-800 mb-2"></p>
                                    <div id="variations" class="variations"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function openModal(product) {
                            document.getElementById('modalProductName').innerText = "Product:" + " " + product.ProductName;
            
                            document.getElementById('modalImage').src = "../../assets/products/" + product.image_urls;
                            document.getElementById('modalDescription').innerHTML = "<strong>Description:</strong><br> " + product.Description;
                            document.getElementById('modalAvailability').innerHTML = "<strong>Availability: </strong><br>" + product.availability;
                            document.getElementById('modalBrand').innerHTML = "<strong>Brand: </strong><br>" + (product.brand_name || "N/A");
                            document.getElementById('modalCategory').innerHTML = "<strong>Category: </strong><br>" + (product.ProdCategoryName || "N/A");
                            document.getElementById('modalVariation').innerHTML = "<strong>Variation: </strong>";
            
                            const variations = product.variations || [];
                            const variationsContainer = document.getElementById('variations');
                            variationsContainer.innerHTML = "";
            
                            // const variationsLabel = document.createElement('h6');
                            // variationsLabel.innerHTML = "Variations:";
                            // variationsLabel.style.fontWeight = "bold";
                            // variationsLabel.className = "text-sm";
                            // variationsContainer.appendChild(variationsLabel);
            
                            variations.forEach(variation => {
                                const variationElement = document.createElement('img');
                                variationElement.src = "../../assets/variations/" + variation.image_url;
                                variationElement.className = "w-20 h-20 object-cover cursor-pointer variation-item";
                                variationElement.onclick = () => {
                                    document.getElementById('variationName').innerHTML = "<strong>Variation Name:</strong><br>" + " " + variation.VariationName;
                                    document.getElementById('variationAvailability').innerHTML = "<strong>Availability:</strong><br>" + " " + variation.availability;
                                    document.getElementById('modalImage').src = variationElement.src;
                                };
                                variationsContainer.appendChild(variationElement);
                            });
            
                            const modal = document.getElementById('productModal');
                            modal.style.display = 'flex';
                            requestAnimationFrame(() => {
                                modal.classList.add('show');
                            });
                            document.body.classList.add('modal-open');
                        }
            
                        function closeModal() {
                            const modal = document.getElementById('productModal');
                            modal.classList.remove('show');
                            modal.classList.add('hide');
                            document.body.classList.remove('modal-open');
                            document.getElementById('productModal').classList.remove('modal-fixed');
            
                            modal.addEventListener('transitionend', () => {
                                modal.style.display = 'none';
                                modal.classList.remove('hide');
                            }, { once: true });
                        }
            
                        document.getElementById('productModal').onclick = function (event) {
                            if (event.target === this) {
                                closeModal();
                            }
                        };
            
                        document.getElementById('closeModalButton').onclick = function () {
                            closeModal();
                        };
                        function searchProducts() {
                            var input, filter, grid, productItems, productName, categoryName, i, txtValue;
                            input = document.getElementById('searchInput');
                            filter = input.value.toUpperCase();
                            grid = document.getElementsByClassName('grid')[0];
                            productItems = grid.getElementsByClassName('product-item');
            
                            var matchedProducts = false; // Flag to check if any products were matched
            
                            for (i = 0; i < productItems.length; i++) {
                                productName = productItems[i].getElementsByTagName('h3')[0];
                                categoryName = productItems[i].getElementsByTagName('h3')[1]; // Add category name selection
                                if (productName && categoryName) {
                                    var productText = productName.textContent || productName.innerText;
                                    var categoryText = categoryName.textContent || categoryName.innerText;
                                    var combinedText = productText + " " + categoryText; // Combine product and category names for search
            
                                    if (combinedText.toUpperCase().indexOf(filter) > -1) {
                                        productItems[i].style.display = "";
                                        matchedProducts = true; // Set flag to true if any product is matched
                                    } else {
                                        productItems[i].style.display = "none";
                                    }
                                }
                            }
            
                            // If no products were matched, display the message; otherwise, hide it
                            var noMatchProductsElement = document.querySelector('.no-match-products');
                            if (!matchedProducts) {
                                if (!noMatchProductsElement) {
                                    // Create the message if it doesn't exist
                                    noMatchProductsElement = document.createElement('p');
                                    noMatchProductsElement.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> No Match Products Found';
                                    noMatchProductsElement.classList.add('no-match-products', 'text-center', 'mt-8', 'font-bold', 'text-red-800', 'text-lg'); // Add specified classes
                                    // Append the message below the search input
                                    input.parentNode.appendChild(noMatchProductsElement);
                                } else {
                                    // If message already exists, ensure it's visible
                                    noMatchProductsElement.style.display = "block";
                                }
                            } else {
                                // If there were matched products, hide the message if it exists
                                if (noMatchProductsElement) {
                                    noMatchProductsElement.style.display = "none";
                                }
                            }
                        }
                        // Bind keyup event to search input
                        document.getElementById('searchInput').addEventListener('keyup', searchProducts);
            
                    </script>
                    <?php
            
                    // Check if there are subcategories of type 'customizable'
                    $sql = "SELECT * FROM productcategory WHERE ParentCategoryID = ? AND type = 'customizable'";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $categoryID);
                    $stmt->execute();
                    $customizableCategories = $stmt->get_result();
            
                    if ($customizableCategories->num_rows > 0) {
                        // Display customizable content for each subcategory
                        while ($customizableCategory = $customizableCategories->fetch_assoc()) {
                            // Display customizable content for each subcategory
                            ?>
                            <div class="content">
                                <div class="relative">
                                    <img src="../../assets/catheader/<?php echo $imageHeader; ?>" class="w-full h-96 object-cover">
                                    <div class="absolute inset-0 bg-black opacity-50"></div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <p class="text-[#F6E381] font-extrabold text-4xl text-center">
                                            CUSTOMIZE:<?php echo strtoupper($categoryName); ?><br>
                                            <span class="text-white text-2xl font-semibold">Many of our products can be customized to the
                                                requirements
                                                of our clients.<br> These may include the dimensions, colors, textures, and materials used in the
                                                item.</span><br>
                                            <span class="text-white text-2xl font-semibold block mt-12">Send us an email at:
                                                <a href="mailto:info@projectsunlimited.com.ph" class="text-2xl hover:underline">
                                                    <i class="fa-solid fa-envelope"></i> info@projectsunlimited.com.ph
                                                </a>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div id="customcontainer">
                                    <div class="p-8">
                                        <div class="flex items-center p-2 px-8">
                                            <div
                                                class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                                1</div>
                                            <h3 class="text-gray-800 font-bold text-3xl ">INQUIRE</h3>
                                        </div>
                                        <div class="flex items-center">
                                            <p class="font-semibold text-2xl p-4 px-8 mx-12">Ask about the product and set an official appointment
                                                with
                                                Projects Unlimited. We are willing to get in touch with you directly and know your ideas.</p>
                                        </div>
                                        <div class="flex items-center justify-end p-2 px-8">
                                            <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">PLAN</h3>
                                            <div
                                                class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                                2</div>
                                        </div>
                                        <div class="flex items-centern">
                                            <p class="text-right font-semibold text-2xl p-4 px-8 mx-12">Discuss your desired dimension, color,
                                                texture,
                                                and materials for your customized products and we’ll do it for you. The budget and timeline will be
                                                discussed as well.</p>
                                        </div>
                                        <div class="flex items-center p-2 px-8">
                                            <div
                                                class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                                3</div>
                                            <h3 class="text-gray-800 font-bold text-3xl">CREATE</h3>
                                        </div>
                                        <div class="flex items-centern">
                                            <p class="font-semibold text-2xl p-4 px-8 mx-12">Our team will proceed to create your desired products
                                                and
                                                we’ll give you an estimated time of completion and we’ll keep you updated at all time.</p>
                                        </div>
                                        <div class="flex items-center justify-end p-2 px-8">
                                            <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">DELIVER & INSTALL</h3>
                                            <div
                                                class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                                4</div>
                                        </div>
                                        <div class="flex items-center justify-endn">
                                            <p class=" text-right font-semibold text-2xl pb-2 px-8 pt-2 mx-12">Once the products are completed, we
                                                will
                                                proceed to delivering and installing the products to your place.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } elseif ($categoryType === 'customizable') {
                    ?>
                    <div class="content">
                        <div class="relative">
                            <img src="../../assets/catheader/<?php echo $imageHeader; ?>" class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-black opacity-50"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <p class="text-[#F6E381] font-extrabold text-4xl text-center">
                                    CUSTOMIZE:<?php echo strtoupper($categoryName); ?><br>
                                    <span class="text-white text-2xl font-semibold">Many of our products can be customized to the
                                        requirements
                                        of our clients.<br> These may include the dimensions, colors, textures, and materials used in the
                                        item.</span><br>
                                    <span class="text-white text-2xl font-semibold block mt-12">Send us an email at:
                                        <a href="mailto:info@projectsunlimited.com.ph" class="text-2xl hover:underline">
                                            <i class="fa-solid fa-envelope"></i> info@projectsunlimited.com.ph
                                        </a>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div id="customcontainer">
                            <div class="p-8">
                                <div class="flex items-center p-2 px-8">
                                    <div
                                        class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                        1</div>
                                    <h3 class="text-gray-800 font-bold text-3xl ">INQUIRE</h3>
                                </div>
                                <div class="flex items-center">
                                    <p class="font-semibold text-2xl p-4 px-8 mx-12">Ask about the product and set an official appointment
                                        with
                                        Projects Unlimited. We are willing to get in touch with you directly and know your ideas.</p>
                                </div>
                                <div class="flex items-center justify-end p-2 px-8">
                                    <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">PLAN</h3>
                                    <div
                                        class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                        2</div>
                                </div>
                                <div class="flex items-centern">
                                    <p class="text-right font-semibold text-2xl p-4 px-8 mx-12">Discuss your desired dimension, color,
                                        texture,
                                        and materials for your customized products and we’ll do it for you. The budget and timeline will be
                                        discussed as well.</p>
                                </div>
                                <div class="flex items-center p-2 px-8">
                                    <div
                                        class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                        3</div>
                                    <h3 class="text-gray-800 font-bold text-3xl">CREATE</h3>
                                </div>
                                <div class="flex items-centern">
                                    <p class="font-semibold text-2xl p-4 px-8 mx-12">Our team will proceed to create your desired products
                                        and
                                        we’ll give you an estimated time of completion and we’ll keep you updated at all time.</p>
                                </div>
                                <div class="flex items-center justify-end p-2 px-8">
                                    <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">DELIVER & INSTALL</h3>
                                    <div
                                        class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                        4</div>
                                </div>
                                <div class="flex items-center justify-endn">
                                    <p class=" text-right font-semibold text-2xl pb-2 px-8 pt-2 mx-12">Once the products are completed, we
                                        will
                                        proceed to delivering and installing the products to your place.</p>
                                </div>
                            </div>
                        </div>
                        <?php
                } else {
                    echo "Unknown category type.";
                }
            } else {
                echo "Category not found.";
            }
            $content = ob_get_clean();
            include ("../public/master.php");
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
