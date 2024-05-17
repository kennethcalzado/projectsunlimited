<?php
session_start();
$pageTitle = "Products";
ob_start();
?>

<head>
    <link rel="stylesheet" href="../../../assets/input.css">
    <style>
        .btn {
            font-size: 14px;
            vertical-align: center;
            padding: 4px, 16px;
        }

        .btn-pagination {
            padding: 4px 16px;
            margin: 0 2px;
            border-radius: 5px;
        }

        .btn-pagination:hover {
            text-decoration: underline;
        }

        .active {
            background-color: #F6E17A;
            color: black;
            border: none;
            padding: 4px 16px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: underline;
        }

        .item-count {
            margin-right: auto;
        }

        .btn-reactivate {
            background-color: #10B981;
            color: black;
            border: none;
            padding: 5px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">Products</h1>
        <div class="flex justify-end">
            <button id="uploadImage" class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Upload Image </button>
            <button id="addProduct" class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Product </button>
        </div>
    </div>
    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div>
    <div class="flex flex-col sm:flex-row items-center justify-center">
        <div class="flex flex-col sm:flex-row justify-between mb-4 sm:mb-0">
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="brandFilter" class="mr-2">Brands</label>
                <select id="brandFilter" class="border rounded-md px-2 py-1">
                    <option value="brandsreset">All Brand</option>
                    <!-- Add your brand options here -->
                </select>
            </div>
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="categoryFilter" class="mr-2">Category</label>
                <select id="categoryFilter" class="border rounded-md px-2 py-1">
                    <option value="categoryreset">All Category</option>
                    <!-- Add your category options here -->
                </select>
            </div>
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="statusFilter" class="mr-2">Status</label>
                <select id="statusFilter" class="border rounded-md px-2 py-1">
                    <option value="statusreset">Status</option>
                    <!-- Add your status options here -->
                </select>
            </div>
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="sortFilter" class="mr-2">Sort</label>
                <select id="sortFilter" class="border rounded-md px-2 py-1">
                    <option value="newest">Newest to Oldest</option>
                    <option value="oldest">Oldest to Newest</option>
                </select>
            </div>
            <div class="flex justify-between">
                <div class="relative mb-1 mt-2 sm:mb-0 sm:mr-2">
                    <!-- Search input -->
                    <div class="relative">
                        <input class="border-2 border-gray-300 bg-white h-10 w-64 px-2 pr-10 mt-4 sm:!mt-0 rounded-lg text-[16px] focus:outline-none" type="text" name="search" placeholder="Search" id="searchInput">
                        <button type="submit" class="absolute right-0 top-0 mt-7 mr-4 sm:mt-3">
                            <svg class="text-gray-600 h-5 w-5 fill-current hover:text-gray-500 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto mb-1 rounded-lg mt-4">
        <table class="display !w-full  ">
            <thead class="">
                <tr>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Brand
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Availability
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Date Added
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody id="productlisting">
                <!-- Content will be loaded dynamically using JavaScript -->
            </tbody>
        </table>
        <div id="pagination" class="flex justify-end mt-4"></div>
    </div>
</div>

<!-- MODALS -->
<!-- Upload Image Modal -->
<div id="uploadImageModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md w-full sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-bold">Upload Images</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <!-- Add instruction -->
        <p class="text-black justify-center mb-4 text-lg"><b class="mr-2">Instruction:</b>To upload multiple or bulk
            images into the table, select all product images. Once everything is uploaded, you may insert the product
            details such as name, brand, category, and description via the edit button under the action column</p>
        <form id="uploadImageForm" enctype="multipart/form-data" class="mt-2">
            <div class="flex flex-col">
                <label for="images" class="text-sm font-medium text-gray-700 mb-1">Select Images</label>
                <input type="file" id="images" name="images[]" multiple accept=".jpg, .jpeg, .png" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <span id="errorMessages" class="text-red-500 text-sm"></span>
            <div class="flex justify-end">
                <button type="submit" id="uploadImagesBtn" class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Upload
                    Images</button>
                <button type="button" id="closeUploadModal" class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md max-w-3xl w-full h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Add Product</h2>
            <button id="closeAddModal" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <form id="addProductForm" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-4 flex flex-col">
                <label for="addproductName" class="text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" id="addproductName" name="productName" placeholder="Enter Product Name" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                <div id="productNameError" class="text-red-500 text-sm hidden">Please enter a product name.</div>
            </div>
            <div class="mb-4 flex flex-col">
                <label for="addproductImage" class="text-sm font-medium text-gray-700 mb-1">Please Insert a Product
                    Image</label>
                <input type="file" id="addproductImage" name="productImage" accept=".jpg, .jpeg, .png" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" onchange="previewImage(event)">
                <div id="imagePreview"></div>
                <div id="productImageError" class="text-red-500 text-sm hidden">Please select a product image.</div>
            </div>
            <div class="mb-4 flex flex-col">
                <label for="addproductDescription" class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="addproductDescription" name="productDescription" rows="4" placeholder="Enter Product Description" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
                <div id="productDescriptionError" class="text-red-500 text-sm hidden">Please enter a product
                    description.</div>
            </div>
            <div class="flex mb-4 justify-center">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="addproductBrand" class="text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <select id="addproductBrand" name="productBrand" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="addproductCategory" class="text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="addproductCategory" name="productCategory" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
            </div>
            <!-- Variation Section -->
            <div id="variationsSection" class="mb-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Add Variations</h3>
                <div id="variationInputs"></div>
                <button type="button" onclick="addVariation()" class="flex items-center text-blue-500 hover:text-blue-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Variation
                </button>
            </div>
            <!-- End of Variation Section -->
            <div class="flex justify-end">
                <button type="submit" id="addProductbtn" class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Add
                    Product</button>
                <button type="button" id="closeModal" class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
            </div>
        </form>
    </div>
</div>
<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md max-w-3xl w-full h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Edit Product</h2>
            <button id="closeEditModalButton" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <form id="editProductForm" enctype="multipart/form-data" class="mt-4">
            <!-- Product Name -->
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input id="editProductName" type="text" class="border rounded-md px-3 py-2 text-sm">
                <span id="editProductNameError" class="text-red-500 text-sm hidden">Please enter a product name.</span>
            </div>
            <!-- Product Image -->
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Product Image</label>
                <input type="file" id="editProductImage" name="editedProductImage" accept=".jpg, .jpeg, .png">
                <img id="previewProductImage" class="border rounded-md mt-2" src="#" alt="Product Image" style="max-width: 100px; max-height: 100px; display: none;">
                <span id="editProductImageError" class="text-red-500 text-sm hidden">Please Insert a Product
                    Image</span>
            </div>

            <!-- Description -->
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="editProductDescription" class="border rounded-md px-3 py-2 text-sm"></textarea>
                <span id="editProductDescriptionError" class="text-red-500 text-sm hidden">Please enter a product
                    description.</span>
            </div>
            <!-- Brand and Category -->
            <div class="flex mb-4 justify-center">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label class="text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <select id="editProductBrand" class="border rounded-md px-3 py-2 text-sm">
                        <!-- Options will be dynamically added here -->
                    </select>
                    <span id="editProductBrandError" class="text-red-500 text-sm hidden">Please select a Brand</span>
                </div>
                <div class="flex flex-col" style="flex: 1;">
                    <label class="text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="editProductCategory" class="border rounded-md px-3 py-2 text-sm">
                        <!-- Options will be dynamically added here -->
                    </select>
                    <span id="editProductCategoryError" class="text-red-500 text-sm hidden">Please select a
                        Category</span>
                </div>
            </div>
            <!-- Variation Section -->
            <div class="border-b border-grey-800 flex-grow border-1.5 mt-2 mb-2"></div>
            <label class="text-sm font-medium text-gray-700 mb-1">Variations</label>
            <div class="mb-4 flex flex-col" id="editVariations">
                <!-- Variation fields will be dynamically added here -->
            </div>
            <div id="editVariationInputs"></div>
            <button type="button" onclick="addEditVariation()" class="flex items-center text-blue-500 hover:text-blue-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Variation
            </button>
            <!-- End of Variation Section -->
            <!-- Save Changes and Close Buttons -->
            <div class="flex justify-end">
                <button id="saveChangesButton" type="submit" class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Save
                    Changes</button>
                <button id="closeEditModalButton" class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center ml-2">Close</button>
            </div>
        </form>
    </div>
</div>

<!-- View Product Modal -->
<div id="viewProductModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md max-w-3xl w-full h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Product Details</h2>
            <button id="closeViewModalButton" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <div class="mt-4">
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <p id="viewProductName" class="border rounded-md px-3 py-2 text-sm"></p>
            </div>
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Product Image</label>
                <img id="viewProductImage" class="border rounded-md" src="#" alt="Product Image" style="max-width: 100px; max-height: 100px;">
            </div>
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <p id="viewProductDescription" class="border rounded-md px-3 py-2 text-sm"></p>
            </div>
            <div class="flex mb-4 justify-center">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label class="text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <p id="viewProductBrand" class="border rounded-md px-3 py-2 text-sm"></p>
                </div>
                <div class="flex flex-col" style="flex: 1;">
                    <label class="text-sm font-medium text-gray-700 mb-1">Category</label>
                    <p id="viewProductCategory" class="border rounded-md px-3 py-2 text-sm"></p>
                </div>
            </div>
            <!-- Variation Section -->
            <div class="mb-4 flex flex-col">
                <div class="border-b border-grey-800 flex-grow border-1.5 mt-2 mb-2"></div>
                <label class="text-sm font-medium text-gray-700 mb-1">Variations</label>
                <div id="viewVariations">
                    <!-- Variation fields will be dynamically added here -->
                </div>
            </div>

            <!-- End of Variation Section -->
        </div>
        <div class="flex justify-end">
            <button id="closeViewModal" class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Close</button>
        </div>
    </div>
</div>
<?php $content = ob_get_clean();
ob_start();
?>

<!-- JAVASCRIPT -->
<script>
    $(document).ready(function() {
        // Fetch products and populate the table
        function fetchProducts(page, limit) {
            $.ajax({
                url: "../../../backend/product/productdisplay.php",
                type: "GET",
                dataType: "json",
                data: {
                    page: page,
                    limit: limit,
                    categoryId: $("#categoryFilter").val() || "",
                    brandId: $("#brandFilter").val() || "",
                    sortValue: $("#sortFilter").val() || "",
                    searchQuery: $("#searchInput").val() || "",
                    statusFilter: $('#statusFilter').val() || ""
                },
                success: function(data) {
                    console.log("Total rows: " + data.products.length);
                    populateProductTable(data.products);
                    console.log('data.totalRows');

                    console.log(data.totalRows);
                    generatePagination(data.totalPages, data.totalRows, page);
                },
                error: function(xhr, status, error) {
                    handleFetchError();
                }
            });
        }

        function generatePagination(totalPages, totalRows, currentPage, categoryId, brandId, sortValue, searchQuery, statusFilter) {
            const paginationBar = $('#pagination');

            // Clear existing pagination bar
            paginationBar.empty();

            // Get the total number of products and the number of products per page
            const totalProducts = totalPages * 10;
            const productsPerPage = 10;

            // Calculate the starting and ending index of the current page
            const startIndex = ((currentPage - 1) * productsPerPage) + 1;
            const endIndex = Math.min(startIndex + productsPerPage - 1, totalRows);

            // Display the item count
            const itemCountElement = $('<div class="text-[16px] text-gray-500 item-count">').text(`Showing ${startIndex} - ${endIndex} of ${totalRows} items`);
            paginationBar.append(itemCountElement);

            // Add numbered pages
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationBar.append(`<button class="btn btn-primary btn-pagination mr-2">${i}</button>`);
                } else {
                    paginationBar.append(`<button class="btn btn-secondary btn-pagination mr-2">${i}</button>`);
                }
            }

            // Add click event to pagination buttons
            paginationBar.find('.btn-pagination').click(function() {
                const pageNumber = $(this).text();
                console.log("Clicked page number: " + pageNumber); // Debug statement
                fetchFilteredProducts(pageNumber, 10, categoryId, brandId, sortValue, searchQuery, statusFilter); // Include filter values in request data
            });

            // Add active class to current page button
            paginationBar.find(`.btn-pagination:contains(${currentPage})`).addClass('active');

            // Style the pagination bar using CSS Flexbox
            paginationBar.addClass('flex justify-end');
        }

        // Fetch products on page load
        fetchProducts(1, 10);

        // Handle category filter change
        $('#categoryFilter').change(function() {
            fetchFilteredProducts(1, 10, true);
        });

        // Handle brand filter change
        $('#brandFilter').change(function() {
            fetchFilteredProducts(1, 10, true);
        });

        // Handle sort filter change
        $('#sortFilter').change(function() {
            sortValue = $(this).val();
            fetchFilteredProducts(1, 10, true);
        });

        // Handle search input change
        $('#statusFilter').on('input', function() {
            fetchFilteredProducts(1, 10, true);
        });

        // Handle search input change
        $('#searchInput').on('input', function() {
            fetchFilteredProducts(1, 10, true);
        });

        function fetchFilteredProducts(page, limit, categoryId, brandId, sortValue, searchQuery, statusFilter) {
            // Get selected values
            categoryId = $('#categoryFilter').val();
            brandId = $('#brandFilter').val();
            sortValue = $('#sortFilter').val();
            statusFilter = $('#statusFilter').val();
            searchQuery = $('#searchInput').val();

            // Check if 'All Category' is selected
            if (categoryId === 'categoriesreset') {
                categoryId = '';
            }

            // Check if 'All Brand' is selected
            if (brandId === 'brandsreset') {
                brandId = '';
            }

            // Check if 'Status' is selected
            if (status === 'statusreset') {
                status = '';
            }
            // Fetch filtered products
            $.ajax({
                url: "../../../backend/product/productdisplay.php",
                type: "GET",
                dataType: "json",
                data: {
                    page: page,
                    limit: limit,
                    categoryId: categoryId,
                    brandId: brandId,
                    sortValue: sortValue,
                    status: statusFilter,
                    searchQuery: searchQuery
                },
                success: function(data) {
                    populateProductTable(data.products);
                    generatePagination(data.totalPages, data.totalRows, page, categoryId, brandId, sortValue, statusFilter, searchQuery);

                },
                error: function(xhr, status, error) {
                    handleFetchError();
                }
            });
        }

        function populateProductTable(data) {
            const productListing = $("#productlisting");
            productListing.empty(); // Clear existing table rows

            if (data.length > 0) {
                // Iterate through the data array
                data.forEach(function(product) {
                    // Create table row for each product
                    const tr = $("<tr>").addClass("hover:bg-zinc-100 border-b bg-white-200");

                    // Create select element for availability
                    const availabilitySelect = $("<select>").addClass("availability-dropdown");

                    // Set a placeholder option while availability options are being fetched
                    availabilitySelect.append($("<option>").attr("value", "").text("-"));

                    // Fetch availability options for the current product
                    fetchAvailabilityOptions(product.ProductID, function(availabilityOptions) {
                        // Add options based on fetched availability options
                        availabilityOptions.forEach(function(option) {
                            const optionElement = $("<option>").attr("value", option).text(option);
                            availabilitySelect.append(optionElement);
                        });

                        // Set selected option based on product's availability
                        availabilitySelect.val(product.availability);
                    });
                    tr.html(`
                        <td>${product.ProductName}</td>
                        <td><img class="centered-image" src="../../../assets/products/${product.image_urls[0]}" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
                        <td>${product.brand_name}</td>
                        <td></td> <!-- This will be replaced by the availability dropdown -->
                        <td>${product.CategoryName}</td>
                        <td>${product.status}</td>
                        <td>
                            <div>
                                <span>${product.created_date}</span><br>
                                <span class="text-sm text-gray-500">${product.created_time}</span>
                            </div>
                        </td>
                        <td>
                            <div class="flex justify-center">
                                <button type="button" class="btn btn-view rounded-md text-center sm:mt-4!px-4 text-sm flex items-center mr-2 viewProduct" data-productid="${product.ProductID}"><i class="fas fa-eye mr-2 fa-sm"></i><span class="hover:underline">View</span></button>
                                <button type="button" class="btn btn-primary rounded-md text-center sm:mt-4!px-4 text-sm flex items-center mr-2 editProduct" data-productid="${product.ProductID}"><i class="fas fa-edit mr-2 fa-sm"></i><span class="hover:underline">Edit</span></button>
                                ${product.status === 'active' ?
                            `<button type="button" class="btn btn-danger rounded-md text-center sm:mt-4!px-4 text-sm flex items-center mr-2 deleteProduct" data-productid="${product.ProductID}" id="deleteButton"><i class="fa-solid fa-eye-slash mr-2"></i><span class="hover:underline">Inactivate</span></button>` :
                            `<button type="button" class="btn btn-reactivate rounded-md text-center sm:mt-4!px-4 text-sm flex items-center mr-2 reactivateProduct hover:bg-emerald-400" data-productid="${product.ProductID}" id="reactivateButton"><i class="fa-solid fa-check-circle mr-2"></i><span class="hover:underline">Reactivate</span></button>`}
                            </div>
                        </td>

                    `);



                    // Append availability dropdown to table cell
                    tr.find("td:eq(3)").append(availabilitySelect);

                    // Append table row to productListing
                    productListing.append(tr);
                });

                // Add event listener for availability dropdown change
                $(".availability-dropdown").on("change", function() {
                    const productId = $(this).closest("tr").find(".editProduct").data("productid");
                    const newAvailability = $(this).val();

                    // Call function to update availability in the backend
                    updateProductAvailability(productId, newAvailability);
                });

                // Click event handler for inactivate button
                $(".deleteProduct").on("click", function() {
                    const productId = $(this).data("productid");
                    const tr = $(this).closest("tr");

                    // Show Swal confirmation alert
                    Swal.fire({
                        title: 'Inactivate Product',
                        text: 'Are you sure you want to inactivate this product?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Call function to update product status to "inactive" in the backend
                            updateProductStatus(productId, "inactive", function() {
                                // Hide the corresponding row in the frontend table
                                tr.hide();
                            });
                            // Show success Swal alert
                            Swal.fire({
                                title: 'Inactivated!',
                                text: 'Product status has been set to inactive',
                                icon: 'success'
                            });
                        }
                    });
                });

                // Click event handler for reactivate button
                $(".reactivateProduct").on("click", function() {
                    const productId = $(this).data("productid");
                    const tr = $(this).closest("tr");

                    // Show Swal confirmation alert
                    Swal.fire({
                        title: 'Reactivate Product',
                        text: 'Are you sure you want to reactivate this product?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Call function to update product status to "active" in the backend
                            updateProductStatus(productId, "active", function() {
                                // Hide the corresponding row in the frontend table
                                tr.hide();
                            });
                            // Show success Swal alert
                            Swal.fire({
                                title: 'Reactivated!',
                                text: 'Product status has been set to active',
                                icon: 'success'
                            });
                        }
                    });
                });

            } else {
                productListing.html("<tr><td colspan='7' class='text-center font-bold text-red-800'>No products available</td></tr>");
            }
        }

        // Function to update product status to "inactive" or "active" in the backend
        function updateProductStatus(productId, status, callback) {
            $.ajax({
                url: "../../../backend/product/deleteproduct.php",
                type: "POST",
                data: {
                    productId: productId,
                    status: status
                },
                success: function(response) {
                    const message = status === "inactive" ? "Product has been inactivated successfully!" : "Product has been reactivated successfully!";
                    // Show success Swal alert
                    Swal.fire({
                        title: 'Success!',
                        text: message,
                        icon: 'success'
                    }).then(() => {
                        // Reload page after update
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error updating product status:", error);
                    // Show error Swal alert
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update product status. Please try again later.',
                        icon: 'error'
                    });
                }
            });
        }


        // Function to update product availability in the backend
        function updateProductAvailability(productId, availability) {
            // Ask the user for confirmation
            Swal.fire({
                title: 'Confirm Update',
                text: "Do you want to update the product availability?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with the update
                    $.ajax({
                        url: "../../../backend/product/updateavail.php",
                        type: "POST",
                        data: {
                            ProductID: productId,
                            availability: availability
                        },
                        dataType: "json",
                        success: function(response) {
                            // Handle success with Swal alert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Availability updated successfully!',
                                timer: 1000,
                                showConfirmButton: false
                            });
                            console.log("Availability updated successfully:", response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error with Swal alert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error updating availability: ' + error,
                                timer: 1000,
                                showConfirmButton: false
                            });
                            console.error("Error updating availability:", error);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // If user cancels, log it or handle the cancellation as needed
                    console.log("Update cancelled by the user.");
                }
            });
        }

        // Function to fetch availability options
        function fetchAvailabilityOptions(productId, callback) {
            $.ajax({
                url: "../../../backend/product/getavail.php",
                type: "GET",
                data: {
                    ProductID: productId
                },
                dataType: "json",
                success: function(response) {
                    const availabilityOptions = response;

                    // If callback function is provided, invoke it with availability options
                    if (callback) {
                        callback(availabilityOptions);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching availability options:", error);
                }
            });
        }

        // Function to handle fetch error
        function handleFetchError() {
            console.error("Error fetching data:", error);
            const productListing = $("#productlisting");
            productListing.html("<tr><td colspan='7' class='text-center justify-center font-bold text-red-800'>Failed to fetch products</td></tr>");
        }
    });

    // Open modal when Add Product button is clicked
    $("#addProduct").click(function() {
        $("#addProductModal").removeClass("hidden");
    });

    // Close modal when Close button or "x" button is clicked
    $("#closeModal, #closeAddModal").click(function() {
        $("#addProductModal").addClass("hidden");
    });

    // Close modal when clicking outside the modal
    $("#addProductModal").click(function(event) {
        if (event.target === this) {
            $(this).addClass("hidden");
        }
    });

    // Preview image function
    function previewImage(event) {
        const preview = $('#imagePreview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            const img = $('<img>').attr('src', reader.result).addClass('previewproductimage');
            preview.empty().append(img);
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.empty();
        }
    }

    //BULK UPLOAD SCRIPT
    // Open upload image modal
    $("#uploadImage").click(function() {
        $("#uploadImageModal").removeClass("hidden");
    });

    // Close upload image modal
    $("#closeUploadModal").click(function() {
        $("#uploadImageModal").addClass("hidden");
        $("#images").val("");
        $("#images").removeClass("border-red-500");
        $("#errorMessages").empty();
    });

    // Handle change event for file input (images)
    $("#images").change(function() {
        // Remove red border and error message when an image is inserted
        $("#images").removeClass("border-red-500");
        $("#errorMessages").empty();
    });

    // Handle form submission to upload images
    $("#uploadImageForm").submit(function(event) {
        event.preventDefault();

        // Reset previous error messages
        $("#errorMessages").empty();

        // Validate form inputs
        var isValid = true;
        if ($("#images").get(0).files.length === 0) {
            $("#images").addClass("border-red-500");
            $("#errorMessages").append("<p class='text-sm'>Please insert an image</p>");
            isValid = false;
        } else {
            $("#images").removeClass("border-red-500");
        }

        // Check for HTML and SQL injection
        var formData = new FormData(this);
        formData.forEach(function(value, key) {
            if (/\<(.*?)\>/g.test(value)) {
                $("#" + key.replace(/([!"#$%&'()*+,./:;<=>?@[\]^`{|}~])/g, '\\$1')).addClass("border-red-500");
                $("#errorMessages").append("<p class='text-sm'>Invalid input in " + key + " field.</p>");
                isValid = false;
            } else {
                $("#" + key.replace(/([!"#$%&'()*+,./:;<=>?@[\]^`{|}~])/g, '\\$1')).removeClass("border-red-500");
            }
        });

        if (!isValid) {
            return false;
        }


        // Proceed with form submission if all validations pass
        $.ajax({
            url: "../../../backend/product/bulkupload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log("Images uploaded successfully:", response);
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Images successfully added!',
                    showConfirmButton: false,
                    timer: 1000
                }).then(function() {
                    $("#successPopup").removeClass("hidden");
                    $("#successMessage").text("Images Successfully Added!");
                    $("#successBulkPopup").removeClass("hidden");
                    setTimeout(function() {
                        $("#successBulkPopup").addClass("hidden"); // Hide success modal after 0.5 seconds
                        setTimeout(function() {
                            location.reload(); // Refresh the page after 1 second
                        }, 500); // 1 second
                    }, 500); // 0.5 seconds
                });
            },
            error: function(xhr, status, error) {
                console.error("Error uploading images:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to upload images. Please try again.'
                });
            }
        });
    });


    // Fetch and populate dropdowns for brand and category
    $.ajax({
        url: '../../../backend/product/getproductcategory.php',
        type: 'GET',
        dataType: 'json',
        success: function(categories) {
            const categoryForm = $('#addproductCategory');
            const categoryFilter = $('#categoryFilter');
            const categoryDropdown = $('#editProductCategory');

            // Clear existing options
            categoryForm.empty();
            categoryFilter.empty();
            categoryDropdown.empty();

            // Append initial options
            categoryForm.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Category'));
            categoryFilter.append($('<option>').val('categoryreset').text('All Category')); // Add 'All Category' option
            categoryDropdown.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Category'));

            // Append main categories
            const mainCategoryOptgroup = $('<optgroup label="Main Category">');
            $.each(categories["Main Category"], function(index, mainCategory) {
                mainCategoryOptgroup.append($('<option>').val(mainCategory.CategoryID).text(mainCategory.CategoryName));
            });
            categoryForm.append(mainCategoryOptgroup.clone());
            categoryFilter.append(mainCategoryOptgroup.clone());
            categoryDropdown.append(mainCategoryOptgroup.clone());

            // Append sub categories
            const subCategoryOptgroup = $('<optgroup label="Sub Category">');
            $.each(categories["Sub Category"], function(index, subCategory) {
                subCategoryOptgroup.append($('<option>').val(subCategory.CategoryID).text(subCategory.CategoryName));
            });
            categoryForm.append(subCategoryOptgroup.clone());
            categoryFilter.append(subCategoryOptgroup.clone());
            categoryDropdown.append(subCategoryOptgroup.clone());
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });


    $.ajax({
        url: '../../../backend/product/getbrand.php',
        type: 'GET',
        dataType: 'json',
        success: function(brands) {
            const brandForm = $('#addproductBrand');
            brandForm.empty();
            brandForm.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Brand'));
            $.each(brands, function(index, brand) {
                brandForm.append($('<option>').val(brand.brand_id).text(brand.brand_name));
            });
            const brandFilter = $('#brandFilter');
            brandFilter.empty();
            brandFilter.append($('<option>').val('brandsreset').text('All Brand')); // Add 'All Brand' option
            $.each(brands, function(index, brand) {
                brandFilter.append($('<option>').val(brand.brand_id).text(brand.brand_name));
            });
            const brandDropdown = $("#editProductBrand");
            brandDropdown.empty();
            brandDropdown.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Brand'));
            $.each(brands, function(index, brand) {
                brandDropdown.append($('<option>').val(brand.brand_id).text(brand.brand_name));
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching brands:', error);
        }
    });

    function validateFields() {
        let isValid = true;

        const productName = document.getElementById('addproductName');
        const productImage = document.getElementById('addproductImage');
        const productDescription = document.getElementById('addproductDescription');

        // Regular expression to check for HTML and SQL injections
        const regex = /^[a-zA-Z0-9\s\.,_-]*$/;

        // Function to check for HTML or SQL injections
        function hasInjections(input) {
            const regex = /<[^>]*>?|['"\\]/g;
            return regex.test(input);
        }

        // Validate product name
        if (productName.value.trim() === '' || !regex.test(productName.value) || hasInjections(productName.value)) {
            productName.classList.add('border-red-500');
            if (hasInjections(productName.value)) {
                document.getElementById('productNameError').innerText = 'Invalid input';
            } else {
                document.getElementById('productNameError').innerText = 'Please enter a product name.';
            }
            document.getElementById('productNameError').classList.remove('hidden');
            isValid = false;
        } else {
            productName.classList.remove('border-red-500');
            document.getElementById('productNameError').classList.add('hidden');
        }

        // Validate product image (just checking for empty value)
        if (productImage.value.trim() === '') {
            productImage.classList.add('border-red-500');
            document.getElementById('productImageError').classList.remove('hidden');
            isValid = false;
        } else {
            productImage.classList.remove('border-red-500');
            document.getElementById('productImageError').classList.add('hidden');
        }

        // Validate product description (just checking for empty value)
        if (productDescription.value.trim() === '' || !regex.test(productDescription.value) || hasInjections(productDescription.value)) {
            productDescription.classList.add('border-red-500');
            if (hasInjections(productDescription.value)) {
                document.getElementById('productDescriptionError').innerText = 'Invalid input';
            } else {
                document.getElementById('productDescriptionError').innerText = 'Please enter a product description.';
            }
            document.getElementById('productDescriptionError').classList.remove('hidden');
            isValid = false;
        } else {
            productDescription.classList.remove('border-red-500');
            document.getElementById('productDescriptionError').classList.add('hidden');
        }

        return isValid;
    }

    // Handle form submission to add a new product
    $('#addProductForm').on('submit', function(event) {
        event.preventDefault();

        // Validate fields
        if (!validateFields()) {
            return;
        }

        var formData = new FormData(this);
        $.ajax({
            url: "../../../backend/product/addproduct.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            // After successfully adding a product, show the success Swal alert
            success: function(data) {
                var responseData = JSON.parse(data);
                if (responseData.success) {
                    // Show success Swal alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Product successfully added!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Show success modal
                        $("#successPopup").removeClass("hidden");
                        $("#successMessage").text("Product Successfully Added!");
                        // Hide add product modal
                        $("#addProductModal").addClass("hidden");
                        // Refresh the table after a short delay
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    });
                } else {
                    console.error("Error adding product:", responseData.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error adding product:", error);
                // Show error Swal alert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add product. Please try again.'
                });
            }
        });
    });
    // Function to add a new variation
    function addVariation() {
        const variationInputs = document.getElementById('variationInputs');
        const variationIndex = variationInputs.children.length + 1;

        const variationDiv = document.createElement('div');
        variationDiv.classList.add('mb-4', 'flex', 'flex-col');

        // Regular expression to check for HTML and SQL injections
        const regex = /^[a-zA-Z0-9\s\.,_-]*$/;

        variationDiv.innerHTML = `
        <div class="flex justify-between items-center">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Variation ${variationIndex}</h4>
            <button type="button" class="text-red-500 hover:text-red-700 focus:outline-none" onclick="removeVariation(this)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <label for="variationName${variationIndex}" class="text-sm font-medium text-gray-700 mb-1">Variation ${variationIndex} Name</label>
        <input type="text" id="variationName${variationIndex}" name="variationName${variationIndex}" placeholder="Enter Variation Name"
            class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
            onchange="validateVariationFields(${variationIndex})">
        <div id="variationNameError${variationIndex}" class="hidden text-red-500 text-sm">Invalid input</div>
        <label for="variationImage${variationIndex}" class="text-sm font-medium text-gray-700 mb-1">Insert Variation ${variationIndex} Image</label>
        <input type="file" id="variationImage${variationIndex}" name="variationImage${variationIndex}" accept=".jpg, .jpeg, .png"
            class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
            onchange="previewVariationImage(event, ${variationIndex})">
        <div id="variationImagePreview${variationIndex}"></div>
    `;
        variationInputs.appendChild(variationDiv);
    }

    function validateVariationFields(variationIndex) {
        const variationName = document.getElementById(`variationName${variationIndex}`);
        const variationNameError = document.getElementById(`variationNameError${variationIndex}`);
        const regex = /^[a-zA-Z0-9\s\.,_-]*$/;

        if (!regex.test(variationName.value)) {
            variationName.classList.add('border-red-500');
            variationNameError.classList.remove('hidden');
        } else {
            variationName.classList.remove('border-red-500');
            variationNameError.classList.add('hidden');
        }

        variationName.addEventListener('input', function() {
            if (variationName.value.trim() !== '') {
                variationName.classList.remove('border-red-500');
                variationNameError.classList.add('hidden');
            }
        });
    }

    function removeVariation(element) {
        const variationDiv = element.parentElement.parentElement;
        variationDiv.remove();
    }

    function previewVariationImage(event, variationIndex) {
        const input = event.target;
        const file = input.files[0];
        const variationImagePreview = document.getElementById(`variationImagePreview${variationIndex}`);

        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.createElement('img');
                img.src = reader.result;
                img.className = 'border rounded-md mt-2';
                img.style.maxWidth = '100px';
                img.style.maxHeight = '100px';
                variationImagePreview.innerHTML = '';
                variationImagePreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else {
            variationImagePreview.innerHTML = '';
        }
    }

    function addEventListeners() {
        const productName = document.getElementById('addproductName');
        const productImage = document.getElementById('addproductImage');
        const productDescription = document.getElementById('addproductDescription');

        // Add event listener for product name
        productName.addEventListener('input', function() {
            if (productName.value.trim() !== '') {
                productName.classList.remove('border-red-500');
                document.getElementById('productNameError').classList.add('hidden');
            }
        });
        productImage.addEventListener('change', function() {
            if (productImage.value.trim() !== '') {
                productImage.classList.remove('border-red-500');
                document.getElementById('productImageError').classList.add('hidden');
            }
        });
        productDescription.addEventListener('input', function() {
            if (productDescription.value.trim() !== '') {
                productDescription.classList.remove('border-red-500');
                document.getElementById('productDescriptionError').classList.add('hidden');
            }
        });
    }
    addEventListeners();

    function clearForm() {
        const productName = document.getElementById('addproductName');
        const productImage = document.getElementById('addproductImage');
        const productDescription = document.getElementById('addproductDescription');
        const productBrand = document.getElementById('addproductBrand');
        const productCategory = document.getElementById('addproductCategory');
        const variationInputs = document.getElementById('variationInputs');

        // Clear form fields
        productName.value = '';
        productImage.value = '';
        productDescription.value = '';
        productBrand.value = 'Select a Brand';
        productCategory.value = 'Select a Category';

        // Clear variation fields
        variationInputs.innerHTML = '';

        // Hide error messages and remove red borders
        document.getElementById('productNameError').classList.add('hidden');
        document.getElementById('productImageError').classList.add('hidden');
        document.getElementById('productDescriptionError').classList.add('hidden');
        productName.classList.remove('border-red-500');
        productImage.classList.remove('border-red-500');
        productDescription.classList.remove('border-red-500');
    }

    $(document).on("click", "#closeAddModal, #closeModal", function() {
        event.preventDefault();
        $("#addProductModal").addClass("hidden");
        clearForm();
    });


    // EDIT MODAL
    function validateInputFields() {
        let isValid = true;

        const htmlSQLRegex = /<[^>]*>|['";:()|%&]/;

        // Product Name
        const productName = $("#editProductName").val().trim();
        if (!productName) {
            $("#editProductName").addClass("border-red-500");
            $("#editProductNameError").text("Please enter a Product Name").removeClass("hidden");
            isValid = false;
        } else if (htmlSQLRegex.test(productName)) {
            $("#editProductName").addClass("border-red-500");
            $("#editProductNameError").text("Invalid input").removeClass("hidden");
            isValid = false;
        } else {
            $("#editProductName").removeClass("border-red-500");
            $("#editProductNameError").text("").addClass("hidden");
        }

        // Description
        const productDescription = $("#editProductDescription").val().trim();
        if (!productDescription) {
            $("#editProductDescription").addClass("border-red-500");
            $("#editProductDescriptionError").text("Please enter a Description").removeClass("hidden");
            isValid = false;
        } else if (htmlSQLRegex.test(productDescription)) {
            $("#editProductDescription").addClass("border-red-500");
            $("#editProductDescriptionError").text("Invalid input").removeClass("hidden");
            isValid = false;
        } else {
            $("#editProductDescription").removeClass("border-red-500");
            $("#editProductDescriptionError").text("").addClass("hidden");
        }

        // Brand
        const productBrand = $("#editProductBrand").val();
        if (!productBrand) {
            $("#editProductBrand").addClass("border-red-500");
            $("#editProductBrandError").text("Please select a Brand").removeClass("hidden");
            isValid = false;
        } else if (htmlSQLRegex.test(productBrand)) {
            $("#editProductBrand").addClass("border-red-500");
            $("#editProductBrandError").text("Invalid input").removeClass("hidden");
            isValid = false;
        } else {
            $("#editProductBrand").removeClass("border-red-500");
            $("#editProductBrandError").text("").addClass("hidden");
        }

        // Category
        const productCategory = $("#editProductCategory").val();
        if (!productCategory) {
            $("#editProductCategory").addClass("border-red-500");
            $("#editProductCategoryError").text("Please select a Category").removeClass("hidden");
            isValid = false;
        } else if (htmlSQLRegex.test(productCategory)) {
            $("#editProductCategory").addClass("border-red-500");
            $("#editProductCategoryError").text("Invalid input").removeClass("hidden");
            isValid = false;
        } else {
            $("#editProductCategory").removeClass("border-red-500");
            $("#editProductCategoryError").text("").addClass("hidden");
        }

        return isValid;
    }

    let productId;
    $(document).on("click", ".editProduct", function() {
        productId = $(this).data("productid");
        fetchProductDetails(productId, function(productDetails) {
            populateEditModal(productDetails);
            $("#editProductModal").removeClass("hidden");
        });
    });

    function populateEditModal(productDetails) {
        $("#editProductName").val(productDetails.ProductName);
        $("#editProductDescription").val(productDetails.Description);
        const productImageURL = "../../../assets/products/" + productDetails.image_urls;
        $("#previewProductImage").attr("src", productImageURL).show();
        $("#editProductImageInput").val(productImageURL);
        $("#editProductImage").change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $("#previewProductImage").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file); // Read the selected image file
            } else {
                $("#previewProductImage").hide();
            }
        });

        // Populate brand dropdown
        fetchAndPopulateBrandDropdown(productDetails.brand_id);

        // Populate category dropdown
        fetchAndPopulateCategoryDropdown(productDetails.CategoryID);

        const editVariationsSection = $("#editVariations");
        editVariationsSection.empty();
        // Populate variations if available
        if (productDetails.variations && productDetails.variations.length > 0) {
            const editVariationsSection = $("#editVariations");
            editVariationsSection.empty(); // Clear existing variation fields

            productDetails.variations.forEach((variation, index) => {
                console.log(variation);

                // Create variation fields for each variation
                const variationField = $("<div>").addClass("editVariationContainer mb-4 flex flex-col").data("variation-id", variation.VariationID);
                variationField.append($("<label>").addClass("text-sm font-medium text-gray-700 mb-1").text("Variation Name"));
                const variationNameInput = $("<input>").addClass("border rounded-md px-3 py-2 text-sm editVariationName")
                    .attr("type", "text").val(variation.VariationName);
                variationField.append(variationNameInput);

                // Fetch and display variation image
                const variationImage = $("<img>").addClass("border rounded-md mt-2 mb-2").attr("src", "../../../assets/variations/" + variation.image_url).attr("alt", "Variation Image").css({
                    "max-width": "100px",
                    "max-height": "100px"
                });
                variationField.append(variationImage);

                const variationImageInput = $("<input>").addClass("border rounded-md editVariationImage").attr("type", "file").attr("accept", "image/*").on('change', (event) => {
                    previewEditVariationImage(event, index);
                });
                variationField.append(variationImageInput);

                const deleteButton = $("<button>").addClass("mt-2 text-sm text-red-500 cursor-pointer delete-variation").text("Delete Variation").click((event) => {
                    const variationField = $(event.target).closest(".editVariationContainer");
                    variationField.hide(); // Hide the variation container
                    variationField.addClass('marked-for-deletion'); // Add class to mark for deletion
                });
                variationField.append(deleteButton);
                editVariationsSection.append(variationField);
            });
        } else {
            const noVariationsMessage = $("<p>").addClass("text-sm font-medium text-red-700").text("No Variations Added");
            editVariationsSection.append(noVariationsMessage);
        }
    }

    function previewEditVariationImage(event, variationIndex) {
        const input = event.target;
        const file = input.files[0];
        const variationImagePreview = document.getElementById(`editVariationImagePreview${variationIndex}`);

        if (variationImagePreview) {
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.className = 'border rounded-md mt-2';
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';
                    variationImagePreview.innerHTML = '';
                    variationImagePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                variationImagePreview.innerHTML = '';
            }
        }
    }

    // Function to fetch and populate brand dropdown
    function fetchAndPopulateBrandDropdown(selectedBrandId) {
        $.ajax({
            url: '../../../backend/product/getbrand.php',
            type: 'GET',
            dataType: 'json',
            success: function(brands) {
                const brandDropdown = $("#editProductBrand");
                brandDropdown.empty();
                brandDropdown.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Brand'));
                $.each(brands, function(index, brand) {
                    brandDropdown.append($('<option>').val(brand.brand_id).text(brand.brand_name));
                });
                // Set the selected brand if available
                if (selectedBrandId) {
                    brandDropdown.val(selectedBrandId);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching brands:', error);
            }
        });
    }

    // Function to fetch and populate category dropdown
    function fetchAndPopulateCategoryDropdown(selectedCategoryId) {
        $.ajax({
            url: '../../../backend/product/getproductcategory.php',
            type: 'GET',
            dataType: 'json',
            success: function(categories) {
                const categoryDropdown = $('#editProductCategory');
                categoryDropdown.empty();
                categoryDropdown.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Category'));

                // Append main categories
                const mainCategoryOptgroup = $('<optgroup label="Main Category">');
                $.each(categories["Main Category"], function(index, mainCategory) {
                    mainCategoryOptgroup.append($('<option>').val(mainCategory.CategoryID).text(mainCategory.CategoryName));
                });
                categoryDropdown.append(mainCategoryOptgroup.clone());

                // Append sub categories
                const subCategoryOptgroup = $('<optgroup label="Sub Category">');
                $.each(categories["Sub Category"], function(index, subCategory) {
                    subCategoryOptgroup.append($('<option>').val(subCategory.CategoryID).text(subCategory.CategoryName));
                });
                categoryDropdown.append(subCategoryOptgroup.clone());

                // Set the selected category if available
                if (selectedCategoryId) {
                    categoryDropdown.val(selectedCategoryId);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    $.ajax({
        url: '../../../backend/product/getproductstatus.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#statusFilter').empty();
            $('#statusFilter').append($('<option>').val('statusreset').text('Status'));

            $.each(data, function(index, status) {
                $('#statusFilter').append($('<option>').val(status).text(status));
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    $('#editProductForm').submit(function(event) {
        event.preventDefault();

        // Validate input fields
        if (!validateInputFields()) {
            return; // Stop execution if validation fails
        }

        // Display confirmation dialog before updating
        Swal.fire({
            title: 'Confirm Update',
            text: 'Are you sure you want to update the product?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Gather edited product details
                const editedProductName = $("#editProductName").val();
                const editedProductDescription = $("#editProductDescription").val();
                const editedProductBrand = $("#editProductBrand").val();
                const editedProductCategory = $("#editProductCategory").val();

                // Gather edited product image
                const editedProductImage = $("#editProductImage")[0].files[0];

                // Send edited details to the server to update the database
                const formData = new FormData();
                formData.append('productId', productId);
                formData.append('editedProductName', editedProductName);
                formData.append('editedProductDescription', editedProductDescription);
                formData.append('editedProductBrand', editedProductBrand);
                formData.append('editedProductCategory', editedProductCategory);
                formData.append('editedProductImage', editedProductImage);

                // Additional form data handling...

                $.ajax({
                    url: "../../../backend/product/editproduct.php",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Product details updated successfully!',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(function() {
                            $("#successMessage").text("Product details updated successfully.");
                            $("#successPopup").removeClass("hidden");
                            $("#editProductModal").addClass("hidden");
                            setTimeout(function() {
                                $("#successPopup").addClass("hidden");
                                location.reload();
                            }, 500);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error updating product details:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update product details. Please try again.'
                        });
                    }
                });
            }
        });
    });

    // Function to add a new variation
    function addEditVariation() {
        const editVariationInputs = document.getElementById('editVariations');
        const editVariationIndex = editVariationInputs.children.length + 1;

        const editVariationDiv = document.createElement('div');
        editVariationDiv.classList.add('mb-4', 'flex', 'flex-col', 'newVariation'); // Add a class to identify newly added variations
        editVariationDiv.innerHTML = `
<div class="flex justify-between items-center">
    <h4 class="text-sm font-medium text-gray-700 mb-2">Variation ${editVariationIndex}</h4>
    <button type="button" class="text-red-500 hover:text-red-700 focus:outline-none" onclick="removeEditVariation(this)">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
<label for="editVariationName${editVariationIndex}" class="text-sm font-medium text-gray-700 mb-2">Variation ${editVariationIndex} Name</label>
<input type="text" id="editVariationName${editVariationIndex}" name="editVariationName${editVariationIndex}" placeholder="Enter Variation Name"
    class="editVariationName border rounded-md px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
<label for="editVariationImage${editVariationIndex}" class="text-sm font-medium text-gray-700 mb-1">Insert Variation ${editVariationIndex} Image</label>
<input type="file" id="editVariationImage${editVariationIndex}" name="editVariationImage${editVariationIndex}" accept=".jpg, .jpeg, .png"
    class="editVariationImage border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
    onchange="previewEditVariationImage(event, ${editVariationIndex})">
<div id="editVariationImagePreview${editVariationIndex}"></div>
`;
        editVariationInputs.appendChild(editVariationDiv);
    }

    function removeEditVariation(element) {
        const editVariationDiv = element.parentElement.parentElement;
        editVariationDiv.remove();
    }

    function resetFormFields() {
        $('#editProductNameError').addClass('hidden');
        $('#editProductImageError').addClass('hidden');
        $('#editProductDescriptionError').addClass('hidden');
        $('#editProductBrandError').addClass('hidden');
        $('#editProductCategoryError').addClass('hidden');
        $('.border-red-500').removeClass('border-red-500');
        $('.error-message').text('').removeClass('hidden');
    }

    $(document).on("click", "#closeEditModalButton, .cancelButton", function() {
        event.preventDefault();
        resetFormFields();
        $("#editProductModal").addClass("hidden");
    });


    // VIEW MODAL
    $(document).on("click", ".viewProduct", function() {
        const productId = $(this).data("productid");
        fetchProductDetails(productId, function(productDetails) {
            populateViewModal(productDetails);
            $("#viewProductModal").removeClass("hidden");
        });
    });

    function fetchProductDetails(productId, callback) {
        $.ajax({
            url: "../../../backend/product/viewproduct.php",
            method: "GET",
            data: {
                productId: productId
            },
            success: function(response) {
                const productDetails = JSON.parse(response);
                callback(productDetails);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching product details:", error);
            }
        });
    }

    function populateViewModal(productDetails) {
        $("#viewProductName").text(productDetails.ProductName);
        $("#viewProductImage").attr("src", productDetails.imageUrl);
        $("#viewProductDescription").text(productDetails.Description);
        $("#viewProductBrand").text(productDetails.brand_name);
        $("#viewProductCategory").text(productDetails.CategoryName);
        $("#viewVariations").empty();
        if (productDetails.variations && productDetails.variations.length > 0) {
            const variationSection = $("#viewVariations");
            let variationRow = $("<div>").addClass("flex");

            productDetails.variations.forEach((variation, index) => {
                const variationField = $("<div>").addClass("mb-4 mt-2 flex flex-col px-6 mr-8");
                variationField.append($("<label>").addClass("text-sm font-medium text-gray-700 mb-1 justify-center").text(variation['VariationName']));
                variationField.append($("<img>").addClass("border rounded-md").attr("src", variation['image_url']).attr("alt", "Variation Image").css("max-width", "100px").css("max-height", "100px"));

                variationRow.append(variationField);
                if ((index + 1) % 4 === 0) {
                    variationSection.append(variationRow);
                    variationRow = $("<div>").addClass("flex ");
                }
            });
            if (productDetails.variations.length % 4 !== 0) {
                variationSection.append(variationRow);
            }
        } else {
            const noVariationMessage = $("<p>").addClass("text-sm font-medium text-red-700").text("No Variations Added");
            $("#viewVariations").append(noVariationMessage);
        }
    }

    $(document).on("click", "#closeViewModalButton, #closeViewModal, .cancelButton", function() {
        $("#viewProductModal").addClass("hidden");
    });
</script>

<?php
$script = ob_get_clean();
include("../../../public/master.php");
?>