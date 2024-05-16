<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../backend/conn.php';
include '../../backend/auditlog.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $categoryName = $_POST['categoryName'];
    $pageType = $_POST['pageType']; // Assuming this corresponds to the 'type' column
    $categoryType = $_POST['categoryType'];
    $status = 'active'; // Assuming default status is 'active'
    $imageCover = NULL; // Placeholder for image path, NULL by default
    $imageHeader = NULL; // Placeholder for image path, NULL by default
    $parentCategoryID = NULL; // NULL by default

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
                        position: relative;
                        z-index: 1;
        
                    }
        
                    .product-item:hover {
                        transform: scale(1.05);
                        background-color: #D1D5DB;
                        z-index: 2;
        
                    }
        
                    #dropdownMenu {
                        width: 150%;
                        z-index: 3;
                        font-size: 14px !important;
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
                    <div class="flex justify-center">
                        <div class="relative mb-1 mt-2 sm:mb-0 sm:mr-2 flex items-center">
                            <div class="relative">
                                <input
                                    class="border-2 border-gray-300 bg-white h-10 w-96 px-2 pr-10 rounded-lg text-[16px] focus:outline-none"
                                    type="text" name="search" placeholder="Search Product or Category" id="searchInput">
                                <button type="submit" class="absolute right-0 top-0 mt-2 mr-4">
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
                            <div class="ml-2 relative">
                                <div>
                                    <button onclick="toggleDropdown()" id="dropdownButton"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
                                        Filter by Category
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 14l6-6H4l6 6z" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="dropdownMenu"
                                    class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                                    <div class="py-1 px-4" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                        <?php
                                        // Retrieve main category and its subcategories
                                        $mainCategorySQL = "SELECT * FROM productcategory WHERE CategoryID = ?";
                                        $mainCategoryStmt = $conn->prepare($mainCategorySQL);
                                        $mainCategoryStmt->bind_param("i", $categoryID);
                                        $mainCategoryStmt->execute();
                                        $mainCategoryResult = $mainCategoryStmt->get_result();
                                        $mainCategory = $mainCategoryResult->fetch_assoc();
        
                                        // Display checkbox for main category
                                        ?>
                                        <label class="block text-sm leading-5 text-gray-700">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600"
                                                value="<?php echo $mainCategory['CategoryID']; ?>">
                                            <span class="ml-2"><?php echo $mainCategory['CategoryName']; ?></span>
                                        </label>
        
                                        <?php
                                        // Retrieve subcategories of the main category
                                        $subcategoriesSQL = "SELECT * FROM productcategory WHERE ParentCategoryID = ?";
                                        $subcategoriesStmt = $conn->prepare($subcategoriesSQL);
                                        $subcategoriesStmt->bind_param("i", $categoryID);
                                        $subcategoriesStmt->execute();
                                        $subcategoriesResult = $subcategoriesStmt->get_result();
        
                                        // Display checkboxes for each subcategory
                                        while ($subcategory = $subcategoriesResult->fetch_assoc()) {
                                            ?>
                                            <label class="block text-sm leading-5 text-gray-700">
                                                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600"
                                                    value="<?php echo $subcategory['CategoryID']; ?>">
                                                <span class="ml-2"><?php echo $subcategory['CategoryName']; ?></span>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
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
                                        data-category-id="<?php echo htmlspecialchars($product['CategoryID']); ?>"
                                        data-category-name="<?php echo htmlspecialchars($product['ProdCategoryName']); ?>"
                                        onclick='openModal(<?php echo htmlspecialchars(json_encode($product)); ?>)'>
                                        <img src="../../assets/products/<?php echo $product['image_urls']; ?>"
                                            alt="<?php echo htmlspecialchars($product['ProductName']); ?>"
                                            class="product-image object-cover object-center mb-2">
                                        <h3 class="text-lg font-bold text-center"><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                                        <h3 class="text-sm font-semibold text-gray-800 text-center">
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
                    function toggleDropdown() {
                        document.getElementById('dropdownMenu').classList.toggle('hidden');
                    }
        
                    function filterProducts() {
                        var grid, productItems, i;
                        grid = document.querySelector('.grid');
                        productItems = grid.querySelectorAll('.product-item');
        
                        // Get the selected categories
                        var selectedCategories = [];
                        var checkboxes = document.querySelectorAll('#dropdownMenu input[type="checkbox"]:checked');
                        checkboxes.forEach(function (checkbox) {
                            selectedCategories.push(checkbox.value);
                        });
        
                        console.log("Selected Categories:", selectedCategories);
        
                        // Filter products based on the selected categories
                        productItems.forEach(function (item) {
                            var categoryId = item.dataset.categoryId; // Assuming you have a data attribute for CategoryID
                            console.log("Product Category ID:", categoryId);
                            var display = selectedCategories.length === 0 || selectedCategories.includes(categoryId) ? 'block' : 'none';
                            item.style.display = display;
                        });
                    }
        
                    function searchProducts() {
                        var input, filter, grid, productItems, productName, categoryName, i, txtValue;
                        input = document.getElementById('searchInput');
                        filter = input.value.toUpperCase();
                        grid = document.querySelector('.grid');
                        productItems = grid.querySelectorAll('.product-item');
        
                        var matchedProducts = false; // Flag to check if any products were matched
        
                        // Iterate through all product items
                        productItems.forEach(function (item) {
                            productName = item.querySelector('h3').innerText.toUpperCase();
                            // Check if the product name matches the search filter
                            if (productName.indexOf(filter) > -1) {
                                item.style.display = ''; // Show the product
                                matchedProducts = true;
                            } else {
                                item.style.display = 'none'; // Hide the product
                            }
                        });
        
                        // If no products were matched, display the message; otherwise, hide it
                        var noMatchProductsElement = document.querySelector('.no-match-products');
                        if (!matchedProducts) {
                            if (!noMatchProductsElement) {
                                noMatchProductsElement = document.createElement('p');
                                noMatchProductsElement.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> No Match Products Found';
                                noMatchProductsElement.classList.add('no-match-products', 'text-center', 'my-8', 'font-bold', 'text-red-800', 'text-lg'); // Add specified classes
                                grid.parentNode.insertBefore(noMatchProductsElement, grid.nextSibling);
                            } else {
                                noMatchProductsElement.style.display = "block";
                            }
                        } else {
                            if (noMatchProductsElement) {
                                noMatchProductsElement.style.display = "none";
                            }
                        }
                    }
        
                    document.getElementById('searchInput').addEventListener('keyup', searchProducts);
        
        
                    document.querySelectorAll('#dropdownMenu input[type="checkbox"]').forEach(function (checkbox) {
                        checkbox.addEventListener('change', filterProducts);
                    });
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
                                            of our clients.<br> These may include the dimensions, colors, textures, and materials used in
                                            the
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
                                        <p class="font-semibold text-2xl p-4 px-8 mx-12">Ask about the product and set an official
                                            appointment
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
                                            and materials for your customized products and we’ll do it for you. The budget and timeline will
                                            be
                                            discussed as well.</p>
                                    </div>
                                    <div class="flex items-center p-2 px-8">
                                        <div
                                            class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                            3</div>
                                        <h3 class="text-gray-800 font-bold text-3xl">CREATE</h3>
                                    </div>
                                    <div class="flex items-centern">
                                        <p class="font-semibold text-2xl p-4 px-8 mx-12">Our team will proceed to create your desired
                                            products
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
                                        <p class=" text-right font-semibold text-2xl pb-2 px-8 pt-2 mx-12">Once the products are completed,
                                            we
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
                                    of our clients.<br> These may include the dimensions, colors, textures, and materials used in
                                    the
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
                                <p class="font-semibold text-2xl p-4 px-8 mx-12">Ask about the product and set an official
                                    appointment
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
                                    and materials for your customized products and we’ll do it for you. The budget and timeline will
                                    be
                                    discussed as well.</p>
                            </div>
                            <div class="flex items-center p-2 px-8">
                                <div
                                    class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">
                                    3</div>
                                <h3 class="text-gray-800 font-bold text-3xl">CREATE</h3>
                            </div>
                            <div class="flex items-centern">
                                <p class="font-semibold text-2xl p-4 px-8 mx-12">Our team will proceed to create your desired
                                    products
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
                                <p class=" text-right font-semibold text-2xl pb-2 px-8 pt-2 mx-12">Once the products are completed,
                                    we
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
        // Set imageCover, imageHeader, and pagePathRelativeToRoot to NULL for subcategories
        $imageCover = NULL;
        $imageHeader = NULL;
        $pagePathRelativeToRoot = NULL;

        // Insert the subcategory into the database
        $stmt = $conn->prepare("INSERT INTO productcategory (CategoryName, ParentCategoryID, type, status, imagecover, imageheader, page_path, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sisssss", $categoryName, $parentCategoryID, $pageType, $status, $imageCover, $imageHeader, $pagePathRelativeToRoot);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Subcategory added successfully";
        } else {
            $response['success'] = false;
            $response['message'] = "Error: " . $conn->error;
        }
        $stmt->close();

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
    }
    // Send JSON response back to frontend
    echo json_encode($response);
} else {
    // If form data is not submitted via POST method, return error
    $response['success'] = false;
    $response['message'] = "Form data not submitted";
    echo json_encode($response);
}
