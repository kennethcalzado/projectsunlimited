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
    <div class="bg-white p-4 rounded-md shadow-md w-full sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
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
            <div class="flex mx-4">
                <div class="mb-4 flex flex-col mr-8">
                    <label for="addproductBrand" class="text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <select id="addproductBrand" name="productBrand"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
                <div class="mb-4 flex flex-col ">
                    <label for="addproductCategory" class="text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="addproductCategory" name="productCategory"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
            </div>
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
    <div class="bg-white p-4 rounded-md shadow-md w-full sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-bold">Edit Product</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <form id="editProductForm" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-4 flex flex-col">
                <label for="updateproductName" class="text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" id="updateproductName" name="productName" placeholder="Enter Product Name"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="mb-4 flex flex-col">
                <label for="updateproductImage" class="text-sm font-medium text-gray-700 mb-1">Product Image</label>
                <div id="imagePreview" class="mt-2"></div>
                <input type="file" id="updateproductImage" name="productImage" accept=".jpg, .jpeg, .png"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="mb-4 flex flex-col">
                <label for="updateproductDescription" class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="updateproductDescription" name="productDescription" rows="4"
                    placeholder="Enter Product Description"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
            </div>
            <div class="flex mx-4">
                <div class="mb-4 flex flex-col mr-8">
                    <label for="updateproductBrand" class="text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <select id="updateproductBrand" name="productBrand"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
                <div class="mb-4 flex flex-col">
                    <label for="updateproductCategory" class="text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="updateproductCategory" name="productCategory"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" id="updateProductbtn"
                    class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Save
                    Changes</button>
                <button type="button" id="closeModal"
                    class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md w-full sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-bold" id="confirmationTitle"></h2>
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
    <div class="bg-white p-4 rounded-md shadow-md w-full h-56 sm:w-[70%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-extrabold">Success</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <p class="text-xl font-bold text-green-600">Product added successfully!</p>
    </div>
</div>
<!-- Success Bulk Upload -->
<div id="successBulkPopup" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md w-full h-56 sm:w-[70%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-extrabold">Success</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <p class="text-xl font-bold text-green-600">Bulk Product Upload successful!</p>
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
                    <td>${product.created_at}</td>
                    <td>
                        <div class="flex justify-center">
                            <button type="button" class="btn btn-view rounded-md text-center sm:mt-4!px-4 text-sm flex items-center mr-2 viewProduct data-productid="${product.ProductID}"><i class="fas fa-eye mr-2 fa-sm"></i><span class="hover:underline">View</span></button>
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
            } else {
                productListing.html("<tr><td colspan='7' class='text-center font-bold text-red-800'>No products available</td></tr>");
            }
        }
        // Function to update product availability in the backend
        function updateProductAvailability(productId, availability) {
            $.ajax({
                url: "../../../backend/product/updateavail.php",
                type: "POST",
                data: { ProductID: productId, availability: availability },
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
        function fetchAvailabilityOptions(productId, callback) {
            $.ajax({
                url: "../../../backend/product/getavail.php",
                type: "GET",
                data: { ProductID: productId }, // Pass the product ID in the GET request
                dataType: "json",
                success: function (response) {
                    const availabilityOptions = response;
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
        $('#addProductForm input[type="text"], #addProductForm textarea, #addProductForm select').each(function () {
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
                $("#uploadImageModal").addClass("hidden");
                // Show success modal
                $("#successBulkPopup").removeClass("hidden");
                // Optionally, you can perform any additional actions here, such as refreshing the page or updating UI.
                setTimeout(function () {
                    window.location.reload(); // Refresh the page after 2 seconds
                }, 2000); // 2 seconds
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
                        // Show success modal
                        $("#successPopup").removeClass("hidden");
                        // Hide add product modal
                        $("#addProductModal").addClass("hidden");
                        // Hide success modal and refresh the page after 3 seconds
                        setTimeout(function () {
                            $("#successModal").addClass("hidden");
                            location.reload(); // Refresh the page
                        }, 2000); // 2 seconds
                    } else {
                        console.error("Error adding product:", responseData.error);
                    }
                },
            });
        }
    });

</script>

<?php
$script = ob_get_clean();
include ("../../../public/master.php");
?>