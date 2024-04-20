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
    </style>
</head>

<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">Products</h1>
        <div class="flex justify-end">
            <button id="uploadImage"
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Upload Image </button>
            <button id="addProduct"
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
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
                        <input
                            class="border-2 border-gray-300 bg-white h-10 w-64 px-2 pr-10 mt-4 sm:!mt-0 rounded-lg text-[16px] focus:outline-none"
                            type="text" name="search" placeholder="Search" id="searchInput">
                        <button type="submit" class="absolute right-0 top-0 mt-7 mr-4 sm:mt-3">
                            <svg class="text-gray-600 h-5 w-5 fill-current hover:text-gray-500 "
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966"
                                style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px"
                                height="512px">
                                <path
                                    d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
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
            images into the table, select all product images.
            Once
            everything is uploaded, you may insert the product details such as name, brand, category, and description
            via the edit button under the action column</p>
        <form id="uploadImageForm" enctype="multipart/form-data" class="mt-2">
            <div class="mb-4 flex flex-col">
                <label for="images" class="text-sm font-medium text-gray-700 mb-1">Select Images</label>
                <input type="file" id="images" name="images[]" multiple accept=".jpg, .jpeg, .png"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="flex justify-end">
                <button type="submit" id="uploadImagesBtn"
                    class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Upload
                    Images</button>
                <button type="button" id="closeUploadModal"
                    class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
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
                <input type="text" id="addproductName" name="productName" placeholder="Enter Product Name"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="mb-4 flex flex-col">
                <label for="addproductImage" class="text-sm font-medium text-gray-700 mb-1">Insert Product Image</label>
                <input type="file" id="addproductImage" name="productImage" accept=".jpg, .jpeg, .png"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    onchange="previewImage(event)">
            </div>
            <div id="imagePreview"></div>
            <div class="mb-4 flex flex-col">
                <label for="addproductDescription" class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="addproductDescription" name="productDescription" rows="4"
                    placeholder="Enter Product Description"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
            </div>
            <div class="flex mb-4 justify-center">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="addproductBrand" class="text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <select id="addproductBrand" name="productBrand"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="addproductCategory" class="text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="addproductCategory" name="productCategory"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
            </div>
            <!-- Variation Section -->
            <div id="variationsSection" class="mb-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Add Variations</h3>
                <div id="variationInputs"></div>
                <button type="button" onclick="addVariation()"
                    class="flex items-center text-blue-500 hover:text-blue-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Variation
                </button>
            </div>
            <!-- End of Variation Section -->
            <div class="flex justify-end">
                <button type="submit" id="addProductbtn"
                    class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Add
                    Product</button>
                <button type="button" id="closeModal"
                    class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
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
            </div>
            <!-- Product Image -->
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Product Image</label>
                <input type="file" id="editProductImage" name="editedProductImage" accept=".jpg, .jpeg, .png">
                <img id="previewProductImage" class="border rounded-md mt-2" src="#" alt="Product Image"
                    style="max-width: 100px; max-height: 100px; display: none;">
            </div>

            <!-- Description -->
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="editProductDescription" class="border rounded-md px-3 py-2 text-sm"></textarea>
            </div>
            <!-- Brand and Category -->
            <div class="flex mb-4 justify-center">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label class="text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <select id="editProductBrand" class="border rounded-md px-3 py-2 text-sm">
                        <!-- Options will be dynamically added here -->
                    </select>
                </div>
                <div class="flex flex-col" style="flex: 1;">
                    <label class="text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="editProductCategory" class="border rounded-md px-3 py-2 text-sm">
                        <!-- Options will be dynamically added here -->
                    </select>
                </div>
            </div>
            <!-- Variation Section -->
            <label class="text-sm font-medium text-gray-700 mb-1">Variations</label>
            <div class="mb-4 flex flex-col" id="editVariations">
                <!-- Variation fields will be dynamically added here -->
            </div>
            <div id="editVariationInputs"></div>
            <button type="button" onclick="addEditVariation()"
                class="flex items-center text-blue-500 hover:text-blue-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Variation
            </button>
            <!-- End of Variation Section -->
            <!-- Save Changes and Close Buttons -->
            <div class="flex justify-end">
                <button id="saveChangesButton" type="submit"
                    class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Save
                    Changes</button>
                <button id="closeEditModalButton"
                    class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center ml-2">Close</button>
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
                <img id="viewProductImage" class="border rounded-md" src="#" alt="Product Image"
                    style="max-width: 100px; max-height: 100px;">
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
                <label class="text-sm font-medium text-gray-700 mb-1">Variations</label>
                <div id="viewVariations">
                    <!-- Variation fields will be dynamically added here -->
                </div>
            </div>

            <!-- End of Variation Section -->
        </div>
        <div class="flex justify-end">
            <button id="closeViewModal"
                class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Close</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md w-full sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-bold" id="confirmationTitle"> DELETE</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <p class="text-lg font-bold" id="confirmationMessage"></p>
        <div class="flex justify-end">
            <button id="confirmDelete"
                class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Confirm
                Delete</button>
            <button id="cancelDelete"
                class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
        </div>
    </div>
</div>

<!-- Success -->
<div id="successPopup" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md w-full h-40 sm:w-[70%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-extrabold" id="SuccessTitle">Success</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <p class="text-xl font-bold text-green-600" id="successMessage"></p>
    </div>
</div>

<?php $content = ob_get_clean();
ob_start();
?>

<!-- JAVASCRIPT -->
<script>
    $(document).ready(function () {
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
                    searchQuery: $("#searchInput").val() || ""
                },
                success: function (data) {
                    console.log("Total rows: " + data.products.length);
                    populateProductTable(data.products);
                    console.log('data.totalRows');

                    console.log(data.totalRows);
                    generatePagination(data.totalPages, data.totalRows, page);
                },
                error: function (xhr, status, error) {
                    handleFetchError();
                }
            });

        }

        function generatePagination(totalPages, totalRows, currentPage, categoryId, brandId, sortValue, searchQuery) {
            const paginationBar = $('#pagination');

            // Clear existing pagination bar
            paginationBar.empty();

            // Get the total number of products and the number of products per page
            const totalProducts = totalPages * 5;
            const productsPerPage = 5;

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
            paginationBar.find('.btn-pagination').click(function () {
                const pageNumber = $(this).text();
                console.log("Clicked page number: " + pageNumber); // Debug statement
                fetchFilteredProducts(pageNumber, 5, categoryId, brandId, sortValue, searchQuery); // Include filter values in request data
            });

            // Add active class to current page button
            paginationBar.find(`.btn-pagination:contains(${currentPage})`).addClass('active');

            // Style the pagination bar using CSS Flexbox
            paginationBar.addClass('flex justify-end');
        }

        // Fetch products on page load
        fetchProducts(1, 5);

        // Handle category filter change
        $('#categoryFilter').change(function () {
            fetchFilteredProducts(1, 5, true);
        });

        // Handle brand filter change
        $('#brandFilter').change(function () {
            fetchFilteredProducts(1, 5, true);
        });

        // Handle sort filter change
        $('#sortFilter').change(function () {
            sortValue = $(this).val();
            fetchFilteredProducts(1, 5, true);
        });

        // Handle search input change
        $('#searchInput').on('input', function () {
            fetchFilteredProducts(1, 5, true);
        });

        function fetchFilteredProducts(page, limit, categoryId, brandId, sortValue, searchQuery) {
            // Get selected values
            categoryId = $('#categoryFilter').val();
            brandId = $('#brandFilter').val();
            sortValue = $('#sortFilter').val();
            searchQuery = $('#searchInput').val();

            // Check if 'All Category' is selected
            if (categoryId === 'categoriesreset') {
                // If 'All Category' is selected, pass an empty string as categoryId to fetch all products
                categoryId = '';
            }

            // Check if 'All Brand' is selected
            if (brandId === 'brandsreset') {
                // If 'All Brand' is selected, pass an empty string as brandId to fetch all products
                brandId = '';
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
                    searchQuery: searchQuery
                },
                success: function (data) {
                    populateProductTable(data.products);
                    generatePagination(data.totalPages, data.totalRows, page, categoryId, brandId, sortValue, searchQuery);

                },
                error: function (xhr, status, error) {
                    handleFetchError();
                }
            });
        }

        function populateProductTable(data) {
            const productListing = $("#productlisting");
            productListing.empty(); // Clear existing table rows

            if (data.length > 0) {
                // Iterate through the data array
                data.forEach(function (product) {
                    // Create table row for each product
                    const tr = $("<tr>").addClass("hover:bg-zinc-100 border-b bg-white-200");

                    // Create select element for availability
                    const availabilitySelect = $("<select>").addClass("availability-dropdown");

                    // Set a placeholder option while availability options are being fetched
                    availabilitySelect.append($("<option>").attr("value", "").text("-"));

                    // Fetch availability options for the current product
                    fetchAvailabilityOptions(product.ProductID, function (availabilityOptions) {
                        // Add options based on fetched availability options
                        availabilityOptions.forEach(function (option) {
                            const optionElement = $("<option>").attr("value", option).text(option);
                            availabilitySelect.append(optionElement);
                        });

                        // Set selected option based on product's availability
                        availabilitySelect.val(product.availability);
                    });

                    // Append other product details to table row
                    tr.html(`
                        <td>${product.ProductName}</td>
                        <td><img class="centered-image" src="../../../assets/products/${product.image_urls[0]}" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
                        <td>${product.brand_name}</td>
                        <td></td> <!-- This will be replaced by the availability dropdown -->
                        <td>${product.CategoryName}</td>
                        <td>
                            <div>
                                <span>${product.created_date}</span><br>
                                <span class="text-sm text-gray-500">${product.created_time}</span>
                            </div>
                        </td>
                        <td>
                            <div class="flex justify-center">
                                <button type="button" class="btn btn-view rounded-md text-center sm:mt-4!px-4 text-sm flex items-center mr-2 viewProduct" data-productid="${product.ProductID}"><i class="fas fa-eye mr-2 fa-sm"></i><span class="hover:underline">View</span></button>
                                <button type="button" class="btn btn-primary rounded-md text-center sm:mt-4!px-4 text-sm flex items-center mr-2 editProduct" data-productid="${product.ProductID}"><i class="fas fa-edit mr-2 fa-sm"></i>Edit</button>
                                <button type="button" class="btn btn-danger rounded-md text-center sm:mt-4!px-4 text-sm flex items-center mr-2 deleteProduct" data-productid="${product.ProductID}"><i class="fas fa-trash-alt mr-2 fa-sm"></i>Delete</button>
                            </div>
                        </td>
                    `);


                    // Append availability dropdown to table cell
                    tr.find("td:eq(3)").append(availabilitySelect);

                    // Append table row to productListing
                    productListing.append(tr);
                });

                // Add event listener for availability dropdown change
                $(".availability-dropdown").on("change", function () {
                    const productId = $(this).closest("tr").find(".editProduct").data("productid");
                    const newAvailability = $(this).val();

                    // Call function to update availability in the backend
                    updateProductAvailability(productId, newAvailability);
                });

                $(".deleteProduct").on("click", function () {
                    const productId = $(this).data("productid");
                    const tr = $(this).closest("tr");
                    // Show the delete confirmation modal
                    $("#deleteModal").removeClass("hidden");
                    $("#confirmationMessage").text("Are you sure you want to delete this?");
                    // Set event listener for confirm delete button in the modal
                    $("#confirmDelete").on("click", function () {
                        // Call function to update product status to "inactive" in the backend
                        updateProductStatus(productId, function () {
                            // Hide the delete confirmation modal
                            $("#deleteModal").addClass("hidden");

                            // Hide the corresponding row in the frontend table
                            tr.hide();
                        });

                        // Remove the event listener to prevent multiple executions
                        $("#confirmDelete").off("click");
                    });

                    // Set event listener for cancel delete button in the modal
                    $("#cancelDelete").on("click", function () {
                        // Hide the delete confirmation modal
                        $("#deleteModal").addClass("hidden");

                        // Remove the event listener to prevent multiple executions
                        $("#cancelDelete").off("click");
                    });
                });
            } else {
                productListing.html("<tr><td colspan='7' class='text-center font-bold text-red-800'>No products available</td></tr>");
            }
        }

        // Function to update product status to "inactive" in the backend
        function updateProductStatus(productId, callback) {
            // Send a request to the backend to update product status
            // Example AJAX request:
            $.ajax({
                url: "../../../backend/product/deleteproduct.php",
                type: "POST",
                data: {
                    productId: productId,
                    status: "inactive"
                },
                success: function (response) {
                    // Callback function after successful update
                    if (callback && typeof callback === "function") {
                        callback();
                    }
                    // Show success popup
                    $("#successMessage").text("Product deleted successfully!");
                    $("#successPopup").removeClass("hidden");

                    // Hide the success popup after 3 seconds
                    setTimeout(function () {
                        $("#successPopup").addClass("hidden");
                        // Refresh the table after hiding the success popup
                        refreshTable();
                    }, 500);
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error("Error updating product status:", error);
                }
            });
        }

        // Function to update product availability in the backend
        function updateProductAvailability(productId, availability) {
            $.ajax({
                url: "../../../backend/product/updateavail.php",
                type: "POST",
                data: {
                    ProductID: productId,
                    availability: availability
                },
                dataType: "json",
                success: function (response) {
                    // Handle success
                    console.log("Availability updated successfully:", response);
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error("Error updating availability:", error);
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
                success: function (response) {
                    const availabilityOptions = response;

                    // If callback function is provided, invoke it with availability options
                    if (callback) {
                        callback(availabilityOptions);
                    }
                },
                error: function (xhr, status, error) {
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

    function validateForm() {
        let isValid = true;
        // Loop through each input field
        $('#addProductForm input[type="text"], #addProductForm textarea').each(function () {
            // If the field is empty, add red border and show error message
            if (!$(this).val()) {
                $(this).addClass('border-red-600');
                $(this).siblings('.error-message').text('Please fill this field').show();
                isValid = false;
            } else {
                $(this).removeClass('border-red-600'); // Remove red border when field is filled
                $(this).siblings('.error-message').hide();
            }
        });
        // Check if a file is selected
        const fileInput = $('#addproductImage');
        if (!fileInput.val()) {
            fileInput.addClass('border-red-600');
            fileInput.siblings('.error-message').text('Please choose an image').show();
            isValid = false;
        } else {
            fileInput.removeClass('border-red-600');
            fileInput.siblings('.error-message').hide();
        }
        return isValid;
    }

    // Open modal when Add Product button is clicked
    $("#addProduct").click(function () {
        $("#addProductModal").removeClass("hidden");
    });

    // Close modal when Close button or "x" button is clicked
    $("#closeModal, #closeAddModal").click(function () {
        $("#addProductModal").addClass("hidden");
    });

    // Close modal when clicking outside the modal
    $("#addProductModal").click(function (event) {
        if (event.target === this) {
            $(this).addClass("hidden");
        }
    });

    // Preview image function
    function previewImage(event) {
        const preview = $('#imagePreview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
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
    $("#uploadImage").click(function () {
        $("#uploadImageModal").removeClass("hidden");
    });

    // Close upload image modal
    $("#closeUploadModal").click(function () {
        $("#uploadImageModal").addClass("hidden");
    });

    // Handle form submission to upload images
    $("#uploadImageForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "../../../backend/product/bulkupload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Images uploaded successfully:", response);
                // Close modal after successful upload
                $("#successPopup").removeClass("hidden");
                $("#successMessage").text("Images Successfully Added!");
                $("#successBulkPopup").removeClass("hidden");
                setTimeout(function () {
                    $("#successBulkPopup").addClass("hidden"); // Hide success modal after 0.5 seconds
                    setTimeout(function () {
                        location.reload(); // Refresh the page after 1 second
                    }, 500); // 1 second
                }, 500); // 0.5 seconds
            },
            error: function (xhr, status, error) {
                console.error("Error uploading images:", error);
                // Handle error if any
            }
        });
    });

    // Fetch and populate dropdowns for brand and category
    $.ajax({
        url: '../../../backend/product/getproductcategory.php',
        type: 'GET',
        dataType: 'json',
        success: function (categories) {
            const categoryForm = $('#addproductCategory');
            categoryForm.empty();
            categoryForm.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Category'));
            $.each(categories, function (index, category) {
                categoryForm.append($('<option>').val(category.CategoryID).text(category.CategoryName));
            });
            const categoryFilter = $('#categoryFilter');
            categoryFilter.empty();
            categoryFilter.append($('<option>').val('categoryreset').text('All Category')); // Add 'All Category' option
            $.each(categories, function (index, category) {
                categoryFilter.append($('<option>').val(category.CategoryID).text(category.CategoryName));
            });
            const categoryDropdown = $('#editProductCategory');
            categoryDropdown.empty();
            categoryDropdown.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Category'));
            $.each(categories, function (index, category) {
                categoryDropdown.append($('<option>').val(category.CategoryID).text(category.CategoryName));
            });
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });

    $.ajax({
        url: '../../../backend/product/getbrand.php',
        type: 'GET',
        dataType: 'json',
        success: function (brands) {
            const brandForm = $('#addproductBrand');
            brandForm.empty();
            brandForm.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Brand'));
            $.each(brands, function (index, brand) {
                brandForm.append($('<option>').val(brand.brand_id).text(brand.brand_name));
            });
            const brandFilter = $('#brandFilter');
            brandFilter.empty();
            brandFilter.append($('<option>').val('brandsreset').text('All Brand')); // Add 'All Brand' option
            $.each(brands, function (index, brand) {
                brandFilter.append($('<option>').val(brand.brand_id).text(brand.brand_name));
            });
            const brandDropdown = $("#editProductBrand");
            brandDropdown.empty();
            brandDropdown.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Brand'));
            $.each(brands, function (index, brand) {
                brandDropdown.append($('<option>').val(brand.brand_id).text(brand.brand_name));
            });
        },
        error: function (xhr, status, error) {
            console.error('Error fetching brands:', error);
        }
    });

    // Handle form submission to add a new product
    $('#addProductForm').on('submit', function (event) {
        event.preventDefault();
        // Validate form fields
        if (validateForm()) {
            var formData = new FormData(this);
            $.ajax({
                url: "../../../backend/product/addproduct.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                // After successfully adding a product, show the success modal and hide the add product modal
                success: function (data) {
                    var responseData = JSON.parse(data);
                    if (responseData.success) {
                        console.log("Product added successfully:", responseData);
                        $("#successPopup").removeClass("hidden");
                        $("#successMessage").text("Product Successfully Added!");
                        // Hide add product modal
                        $("#addProductModal").addClass("hidden");
                        // Hide success modal and refresh the page after 3 seconds
                        setTimeout(function () {
                            $("#successModal").addClass("hidden");
                            // Refresh table after 1 second
                            setTimeout(function () {
                                location.reload(); // Refresh the page
                            }, 500); //
                        }, 500); //
                    } else {
                        console.error("Error adding product:", responseData.error);
                    }
                },
            });
        }
    });

    function addVariation() {
        const variationInputs = document.getElementById('variationInputs');
        const variationIndex = variationInputs.children.length + 1;

        const variationDiv = document.createElement('div');
        variationDiv.classList.add('mb-4', 'flex', 'flex-col');
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
            class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
        <label for="variationImage${variationIndex}" class="text-sm font-medium text-gray-700 mb-1">Insert Variation ${variationIndex} Image</label>
        <input type="file" id="variationImage${variationIndex}" name="variationImage${variationIndex}" accept=".jpg, .jpeg, .png"
            class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
            onchange="previewVariationImage(event, ${variationIndex})">
        <div id="variationImagePreview${variationIndex}"></div>
    `;
        variationInputs.appendChild(variationDiv);
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
            reader.onload = function () {
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

    // EDIT MODAL
    // Declare productId variable in a broader scope
    let productId;
    // Add event listener to the "Edit" button
    $(document).on("click", ".editProduct", function () {
        // Set the value of productId in the broader scope
        productId = $(this).data("productid");
        // Fetch product details for the specified product ID
        fetchProductDetails(productId, function (productDetails) {
            // Populate the edit modal with the retrieved product details
            populateEditModal(productDetails);
            // Show the edit modal
            $("#editProductModal").removeClass("hidden");
        });
    });

    // Inside the populateEditModal function
    function populateEditModal(productDetails) {
        $("#editProductName").val(productDetails.ProductName);
        $("#editProductDescription").val(productDetails.Description);

        // Display product image
        // Construct full URL for product image
        const productImageURL = "../../../assets/products/" + productDetails.image_urls; // Assuming image_urls contains the file name
        $("#previewProductImage").attr("src", productImageURL).show();

        // Show file name in insert image input field
        $("#editProductImageInput").val(productImageURL);

        // Add event listener to change event of product image input field
        $("#editProductImage").change(function () {
            const file = this.files[0]; // Get the selected file
            if (file) {
                const reader = new FileReader(); // Create a new FileReader object
                reader.onload = function (e) {
                    // Set the source of the preview image to the data URL
                    $("#previewProductImage").attr("src", e.target.result).show();
                };
                reader.readAsDataURL(file); // Read the selected file as a data URL
            } else {
                // If no file is selected, hide the preview image
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
                reader.onload = function () {
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
            success: function (brands) {
                const brandDropdown = $("#editProductBrand");
                brandDropdown.empty();
                brandDropdown.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Brand'));
                $.each(brands, function (index, brand) {
                    brandDropdown.append($('<option>').val(brand.brand_id).text(brand.brand_name));
                });
                // Set the selected brand if available
                if (selectedBrandId) {
                    brandDropdown.val(selectedBrandId);
                }
            },
            error: function (xhr, status, error) {
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
            success: function (categories) {
                const categoryDropdown = $('#editProductCategory');
                categoryDropdown.empty();
                categoryDropdown.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Category'));
                $.each(categories, function (index, category) {
                    categoryDropdown.append($('<option>').val(category.CategoryID).text(category.CategoryName));
                });
                // Set the selected category if available
                if (selectedCategoryId) {
                    categoryDropdown.val(selectedCategoryId);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    // Add event listener to save changes button in the edit modal
    $('#editProductForm').submit(function (event) {
        event.preventDefault();

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

        $(".editVariationContainer").each(function () {
            const variationID = $(this).data("variation-id");
            const variationName = $(this).find(".editVariationName").val();
            const variationImage = $(this).find(".editVariationImage")[0].files[0];
            const status = $(this).is(":visible") ? "active" : "inactive"; // Check if variation container is visible

            // Append variation details to FormData object if variation name is not empty
            if (variationName.trim() !== '') {
                formData.append(`variations[${variationID}][variationName]`, variationName);
                formData.append(`variations[${variationID}][variationImage]`, variationImage);
                formData.append(`variations[${variationID}][status]`, status); // Append variation status
            }
        });
        // Gather data for newly added variations
        $(".newVariation").each(function () {
            const variationName = $(this).find(".editVariationName").val();
            const variationImage = $(this).find(".editVariationImage")[0].files[0];

            // Append variation details to FormData object if variation name is not empty
            if (variationName.trim() !== '') {
                formData.append('newVariations[]', variationName);
                formData.append('newVariationImages[]', variationImage);
            }
        });

        // Mark variations for deletion and append their IDs to the form data
        $(".editVariationContainer.marked-for-deletion").each(function () {
            const variationID = $(this).data("variation-id");
            formData.append('deletedVariations[]', variationID);
        });

        // Send the form data using AJAX
        $.ajax({
            url: "../../../backend/product/editproduct.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Show success popup
                $("#successMessage").text("Product details updated successfully.");
                $("#successPopup").removeClass("hidden");
                // Close the success popup after a few seconds
                setTimeout(function () {
                    $("#successPopup").addClass("hidden");
                    location.reload();
                }, 1000);
            },
            error: function (xhr, status, error) {
                console.error("Error updating product details:", error);
                // Handle error
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

    // Function to remove a variation
    function removeEditVariation(element) {
        const editVariationDiv = element.parentElement.parentElement;
        editVariationDiv.remove();
    }
    // Add event listener to close the view modal when cancel button or close button is clicked
    $(document).on("click", "#closeEditModalButton, .cancelButton", function () {
        event.preventDefault();
        // Hide the view modal
        $("#editProductModal").addClass("hidden");
    });

    // VIEW MODAL
    // Add event listener to the "View" button
    $(document).on("click", ".viewProduct", function () {
        const productId = $(this).data("productid"); // Get the product ID from the button data attribute

        // Fetch product details for the specified product ID
        fetchProductDetails(productId, function (productDetails) {
            // Populate the view modal with the retrieved product details
            populateViewModal(productDetails);

            // Show the view modal
            $("#viewProductModal").removeClass("hidden");
        });
    });

    // Function to fetch product details based on product ID
    function fetchProductDetails(productId, callback) {
        // Make an AJAX request to fetch product details
        $.ajax({
            url: "../../../backend/product/viewproduct.php", // Replace with the actual endpoint for fetching product details
            method: "GET",
            data: {
                productId: productId
            },
            success: function (response) {
                // Parse the JSON response
                const productDetails = JSON.parse(response);
                // Execute the callback function with the retrieved product details
                callback(productDetails);
            },
            error: function (xhr, status, error) {
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

        // Clear existing variation fields
        $("#viewVariations").empty();

        // Populate variations if available
        if (productDetails.variations && productDetails.variations.length > 0) {
            const variationSection = $("#viewVariations");
            let variationRow = $("<div>").addClass("flex");

            productDetails.variations.forEach((variation, index) => {
                const variationField = $("<div>").addClass("mb-4 mt-2 flex flex-col px-6 mr-8");
                variationField.append($("<label>").addClass("text-sm font-medium text-gray-700 mb-1 justify-center").text(variation['VariationName']));
                variationField.append($("<img>").addClass("border rounded-md").attr("src", variation['image_url']).attr("alt", "Variation Image").css("max-width", "100px").css("max-height", "100px"));

                // Add variation to the current row
                variationRow.append(variationField);

                // Create a new row after every 4 variations
                if ((index + 1) % 4 === 0) {
                    variationSection.append(variationRow);
                    variationRow = $("<div>").addClass("flex ");
                }
            });

            // Add any remaining variations to the last row
            if (productDetails.variations.length % 4 !== 0) {
                variationSection.append(variationRow);
            }
        } else {
            // If no variations available, display a message
            const noVariationMessage = $("<p>").addClass("text-sm font-medium text-red-700").text("No Variations Added");
            $("#viewVariations").append(noVariationMessage);
        }
    }

    // Add event listener to close the view modal when cancel button or close button is clicked
    $(document).on("click", "#closeViewModalButton, #closeViewModal, .cancelButton", function () {
        // Hide the view modal
        $("#viewProductModal").addClass("hidden");
    });
</script>

<?php
$script = ob_get_clean();
include ("../../../public/master.php");
?>