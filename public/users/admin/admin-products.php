<?php
session_start();
$pageTitle = "Products";
ob_start();
?>

<head>
    <link rel="stylesheet" href="../../../assets/input.css">
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
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="brandFilter" class="mr-2">Brands</label>
                <select id="brandFilter" class="border rounded-md px-2 py-1">
                    <option value="" disabled selected>Filter by Brand</option>
                    <!-- Add your brand options here -->
                </select>
            </div>
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="categoryFilter" class="mr-2">Category</label>
                <select id="categoryFilter" class="border rounded-md px-2 py-1">
                    <option value="" disabled selected>Filter by Category</option>
                    <!-- Add your brand options here -->
                </select>
            </div>
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="sortFilter" class="mr-2">Sort</label>
                <select id="sortFilter" class="border rounded-md px-2 py-1">
                    <option value="" disabled selected>Sort By</option>
                    <option>Newest to Oldest</option>
                    <option>Oldest to Newest</option>
                </select>
            </div>
            <div class="flex justify-between">
                <div class="relative mb-1 mt-1 sm:mb-0 sm:mr-2">
                    <!-- Search input -->
                    <div class="relative text-gray-600">
                        <input class="border-2 border-gray-300 bg-white h-9 w-64 px-2 rounded-md text-sm focus:outline-none" type="text" name="search" placeholder="Search Product" id="searchInput">
                        <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
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
                        Description
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
    </div>
</div>
<!-- Add Product Modal -->
<div id="addProductModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md w-full sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Add Product</h2>
            <button id="closeAddModal" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <form id="addProductForm" action="your-backend-endpoint-url" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-4 flex flex-col">
                <label for="addproductName" class="text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" id="addproductName" name="productName" placeholder="Enter Product Name" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="mb-4 flex flex-col">
                <label for="addproductImage" class="text-sm font-medium text-gray-700 mb-1">Insert Product Image</label>
                <input type="file" id="addproductImage" name="productImage" accept=".jpg, .jpeg, .png" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" onchange="previewImage(event)">
            </div>
            <div id="imagePreview"></div>
            <div class="mb-4 flex flex-col">
                <label for="addproductDescription" class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="addproductDescription" name="productDescription" rows="4" placeholder="Enter Product Description" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
            </div>
            <div class="flex mx-4">
                <div class="mb-4 flex flex-col mr-8">
                    <label for="addproductBrand" class="text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <select id="addproductBrand" name="productBrand" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
                <div class="mb-4 flex flex-col ">
                    <label for="addproductCategory" class="text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="addproductCategory" name="productCategory" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" id="addProductbtn" class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Add
                    Product</button>
                <button type="button" id="closeModal" class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Close</button>
            </div>
        </form>
    </div>
</div>
<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md w-full sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-extrabold">Success</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <p class="text-xl font-bold text-green-600">Product added successfully!</p>
    </div>
</div>
<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md w-full sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%]">
        <h2 class="text-2xl font-bold">Edit Product</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <form id="editProductForm" action="your-backend-endpoint-url" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-4 flex flex-col">
                <label for="editProductName" class="text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" id="editProductName" name="productName" placeholder="Enter Product Name" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="mb-4 flex flex-col">
                <label for="editProductDescription" class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="editProductDescription" name="productDescription" rows="4" placeholder="Enter Product Description" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
            </div>
            <div class="flex px-10">
                <div class="mb-4 flex flex-col mr-2">
                    <label for="editProductBrand" class="text-sm font-medium text-gray-700 mb-2">Brand</label>
                    <select id="editProductBrand" name="productBrand" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
                <div class="mb-4 flex flex-col">
                    <label for="editProductCategory" class="text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="editProductCategory" name="productCategory" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" id="saveChangesBtn" class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Save Changes</button>
                <button type="button" id="closeEditModal" class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Close</button>
            </div>
        </form>
    </div>
</div>

<?php $content = ob_get_clean();
ob_start();
?>

<!-- JAVASCRIPT -->
<script>
    $(document).ready(function() {
        // Fetch products and populate the table
        function fetchProducts() {
            $.ajax({
                url: "../../../backend/product/productdisplay.php",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    const productListing = $("#productlisting");
                    productListing.empty(); // Clear existing table rows
                    if (data.length > 0) {
                        $.each(data, function(index, product) {
                            // Create table row for each product
                            const tr = $("<tr>").addClass("hover:bg-zinc-100 border-b bg-white-200");
                            tr.html(`
                            <td>${product.ProductName}</td>
                            <td><img class="centered-image" src="../../../assets/products/${product.image_urls}" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
                            <td>${product.brand_name}</td>
                            <td>${product.Description}</td>
                            <td>${product.CategoryName}</td>
                            <td>${product.created_at}</td>
                            <td>
                                <div class="flex justify-center">
                                    <button class="btn btn-view rounded-md text-center h-8 mt-3 sm:mt-4 !px-4 py-0 text-sm flex items-center mr-2"><i class="fas fa-eye mr-2 fa-sm"></i><span class="hover:underline">View</span></button>
                                    <button class="btn btn-primary rounded-md text-center h-8 mt-3 sm:mt-4 !px-4 py-0 text-sm flex items-center mr-2 hover:underline editProduct" data-id="${product.id}"><i class="fas fa-edit mr-2 fa-sm"></i>Edit</button>
                                    <button class="btn btn-danger rounded-md text-center h-8 mt-3 sm:mt-4 !px-4 py-0 text-sm flex items-center mr-2 hover:underline deleteProduct" data-id="${product.id}"><i class="fas fa-trash-alt mr-2 fa-sm"></i>Delete</button>
                                </div>
                            </td>
                        `);
                            productListing.append(tr);
                        });
                    } else {
                        productListing.html("<tr><td colspan='6' class='text-center font-bold text-red-800'>No products available</td></tr>");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    const productListing = $("#productlisting");
                    productListing.html("<tr><td colspan='6' class='text-center justify-center font-bold text-red-800'>Failed to fetch products</td></tr>");
                }
            });
        }

        // Fetch products on page load
        fetchProducts();
    });

    function validateForm() {
        let isValid = true;
        // Loop through each input field
        $('#addProductForm input[type="text"], #addProductForm textarea, #addProductForm select').each(function() {
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

    // Fetch and populate dropdowns for brand and category
    $.ajax({
        url: '../../../backend/product/getproductcategory.php',
        type: 'GET',
        dataType: 'json',
        success: function(categories) {
            const categoryForm = $('#addproductCategory');
            categoryForm.empty();
            categoryForm.append($('<option>').prop('disabled', true).prop('selected', true).text('Select a Category'));
            $.each(categories, function(index, category) {
                categoryForm.append($('<option>').val(category.CategoryID).text(category.CategoryName));
            });
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
        },
        error: function(xhr, status, error) {
            console.error('Error fetching brands:', error);
        }
    });

    // Handle form submission to add a new product
    $('#addProductForm').on('submit', function(event) {
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
                success: function(data) {
                    var responseData = JSON.parse(data);
                    if (responseData.success) {
                        console.log("Product added successfully:", responseData);
                        // Show success modal
                        $("#successModal").removeClass("hidden");
                        // Hide add product modal
                        $("#addProductModal").addClass("hidden");
                        // Hide success modal and refresh the page after 3 seconds
                        setTimeout(function() {
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
include("../../../public/master.php");
?>