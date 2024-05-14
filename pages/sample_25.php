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
        
            // Retrieve products under the category and its subcategories
            $sql = "
                SELECT p.*, b.brand_name, pc.CategoryName as ProdCategoryName FROM product p
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                JOIN productcategory pc ON p.CategoryID = pc.CategoryID
                WHERE (p.CategoryID = ? OR p.CategoryID IN (SELECT CategoryID FROM productcategory WHERE ParentCategoryID = ?))
                AND p.status = 'active'
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
                }
        
                .modal-content {
                    background-color: white;
                    padding: 20px;
                    border-radius: 5px;
                    display: flex;
                    max-width: 90%;
                    max-height: 90%;
                }
        
                .modal-left {
                    flex: 1;
                    padding-right: 20px;
                }
        
                .modal-right {
                    flex: 2;
                }
        
                .grid {
                    display: grid;
                    grid-template-columns: repeat(5, 1fr);
                    gap: 20px;
                }
        
                .product-item {
                    cursor: pointer;
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
                <h1 class="text-black font-extrabold text-center my-4 text-4xl">PRODUCTS<br></h1>
                <div class="prodcontent">
                    <?php if ($products->num_rows > 0): ?>
                        <div class="grid">
                            <?php while ($product = $products->fetch_assoc()): ?>
                                <div class="product-item border p-4" onclick='openModal(<?php echo htmlspecialchars(json_encode($product)); ?>)'>
                                    <img src="../../assets/products/<?php echo $product['image_urls']; ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" class="w-full h-48 object-cover mb-2">
                                    <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($product['Description']); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p>No products found in this category.</p>
                    <?php endif; ?>
                </div>
            </div>
        
            <div id="productModal" class="flex">
                <div class="modal-content">
                    <div class="modal-left">
                        <img id="modalImage" src="" class="w-full h-auto object-cover mb-2">
                        <div id="variations"></div>
                    </div>
                    <div class="modal-right">
                        <h3 id="modalProductName" class="text-lg font-semibold"></h3>
                        <p id="modalDescription" class="text-sm text-gray-600"></p>
                        <p id="modalBrand" class="text-sm text-gray-600"></p>
                        <p id="modalCategory" class="text-sm text-gray-600"></p>
                    </div>
                </div>
            </div>
        
            <script>
                function openModal(product) {
                    document.getElementById('modalImage').src = "../../assets/products/" + product.image_urls;
                    document.getElementById('modalProductName').innerText = product.ProductName;
                    document.getElementById('modalDescription').innerText = product.Description;
                    document.getElementById('modalBrand').innerText = "Brand: " + (product.brand_name || "N/A");
                    document.getElementById('modalCategory').innerText = "Category: " + (product.ProdCategoryName || "N/A");
        
                    // Assuming variations are stored in a field like product.variations
                    const variations = product.variations ? JSON.parse(product.variations) : [];
                    const variationsContainer = document.getElementById('variations');
                    variationsContainer.innerHTML = "";
                    variations.forEach(variation => {
                        const variationElement = document.createElement('img');
                        variationElement.src = "../../assets/products/" + variation.image;
                        variationElement.className = "w-20 h-20 object-cover cursor-pointer";
                        variationElement.onclick = () => document.getElementById('modalImage').src = variationElement.src;
                        variationsContainer.appendChild(variationElement);
                    });
        
                    document.getElementById('productModal').style.display = 'flex';
                    document.body.classList.add('modal-open');
                }
        
                document.getElementById('productModal').onclick = function(event) {
                    if (event.target === this) {
                        this.style.display = 'none';
                        document.body.classList.remove('modal-open');
                    }
                }
            </script>
        <?php
        } else {
            echo "Category not found.";
        }
        $content = ob_get_clean();
        include("../public/master.php");
        ?>        