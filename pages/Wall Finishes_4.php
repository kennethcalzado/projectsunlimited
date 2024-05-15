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
                width: 20px;
                height: 20px;
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

            .container {
                display: flex;
                justify-content: space-between;
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
                <div class="modal-body">
                    <div class="modal-left">
                        <img id="modalImage" src="" class="w-full h-auto object-cover mb-2">
                        <div class="container">
                            <div id="variationName" class="variation-name font-bold"></div>
                            <div id="variationAvail" class="variation-avail font-bold"></div>
                        </div>
                        <div id="variations" class="variations"></div>
                    </div>
                    <div class="modal-right">
                        <p id="modalDescription" class="text-sm text-gray-800 mb-2"></p>
                        <p id="modalAvailability" class="text-sm text-gray-800 mb-2"></p>
                        <p id="modalBrand" class="text-sm text-gray-800 mb-2"></p>
                        <p id="modalCategory" class="text-sm text-gray-800 mb-2"></p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function openModal(product) {
                document.getElementById('modalProductName').innerText = product.ProductName;
                document.getElementById('modalImage').src = "../../assets/products/" + product.image_urls;
                document.getElementById('modalDescription').innerHTML = "<strong>Description:</strong><br> " + product.Description;
                document.getElementById('modalAvailability').innerHTML = "<strong>Availability: </strong><br>" + product.availability;
                document.getElementById('modalBrand').innerHTML = "<strong>Brand: </strong><br>" + (product.brand_name || "N/A");
                document.getElementById('modalCategory').innerHTML = "<strong>Category: </strong><br>" + (product.ProdCategoryName || "N/A");
                document.getElementById('productModal').classList.add('modal-fixed');

                const variations = product.variations || [];
                const variationsContainer = document.getElementById('variations');
                variationsContainer.innerHTML = "";

                const variationsLabel = document.createElement('h6');
                variationsLabel.innerHTML = "Variations:<br>";
                variationsLabel.style.fontWeight = "bold";
                variationsLabel.className = "text-sm";
                variationsContainer.appendChild(variationsLabel);

                variations.forEach(variation => {
                    const variationElement = document.createElement('img');
                    variationElement.src = "../../assets/variations/" + variation.image_url;
                    variationElement.className = "w-20 h-20 object-cover cursor-pointer variation-item";
                    variationElement.onclick = () => {
                        document.getElementById('variationName').innerText = variation.VariationName;
                        document.getElementById('variationAvail').innerText = variation.availability;
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