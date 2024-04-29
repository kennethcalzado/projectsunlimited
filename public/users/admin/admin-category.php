<?php
session_start();
$pageTitle = "Category";
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
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">Category</h1>
        <div class="flex justify-end">
            <button id="addCategory"
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-4 sm:mt-4 !px-4 py-0 text-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Category </button>
        </div>
    </div>
    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div>
    <div class="flex flex-col sm:flex-row items-center justify-center">
        <div class="flex flex-col sm:flex-row justify-between mb-4 sm:mb-0">
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="typeFilter" class="mr-2">Page Type:</label>
                <select id="typeFilter" class="border rounded-md px-2 py-1">
                    <option value="typereset">All Type</option>
                    <!-- Add your type options here -->
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
        <table id="category" class="display w-full  ">
            <thead class="">
                <tr>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody id="categorylisting">
                <!-- Content will be loaded dynamically using JavaScript -->
            </tbody>
        </table>
        <div id="pagination" class="flex justify-end mt-4"></div>
    </div>
</div>
<!-- MODALS -->
<!-- Add Category Modal -->
<div id="addProdCategoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md max-w-3xl w-full h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Add Category</h2>
            <button id="closeAddModal" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <form id="addCategoryForm" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-4 flex flex-col">
                <label for="addcategoryName" class="text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" id="addcategoryName" name="productName" placeholder="Enter Category Name"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="flex mb-4 justify-center">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="addcategoryType" class="text-sm font-medium text-gray-700 mb-2">Page Type:</label>
                    <select id="addcategoryType" name="pageType"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="addcategoryCat" class="text-sm font-medium text-gray-700 mb-2">Type of Category</label>
                    <select id="addcategoryCat" name="categoryType" onchange="toggleMainCategoryDropdown()"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Select a Type of Category</option>
                        <option value="main">Main Category</option>
                        <option value="sub">Sub Category</option>
                    </select>
                </div>
            </div>
            <!-- Main Category Dropdown -->
            <div id="mainCategoryDropdown" class="flex mb-4 justify-center hidden">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="mainCategory" class="text-sm font-medium text-gray-700 mb-2">Main Category</label>
                    <select id="mainCategory" name="mainCategory"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>
            </div>
            <!-- Main Category Image Insert -->
            <div id="mainCategoryImage" class="flex flex-col mb-4 hidden">
                <label for="mainCategoryImageInput" class="text-sm font-medium text-gray-700 mb-2">Main Category
                    Image</label>
                <p class="text-sm font-medium italic mb-2">The image will be used for the product category selction
                    page.</p>
                <input type="file" id="mainCategoryImageInput" name="mainCategoryImageInput"
                    accept="image/jpeg, image/jpg, image/png"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    onchange="previewMainCategoryImage(event)">
                <div id="mainCategoryImagePreview"></div>
            </div>
            <!-- Main Category Image Insert -->
            <div id="mainCategoryCover" class="flex flex-col mb-4 hidden">
                <label for="mainCategoryCoverInput" class="text-sm font-medium text-gray-700 mb-2">Main Category
                    Cover</label>
                <p class="text-sm font-medium italic mb-2">The image will be used for the product header cover.</p>
                <input type="file" id="mainCategoryCoverInput" name="mainCategoryCoverInput"
                    accept="image/jpeg, image/jpg, image/png"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    onchange="previewMainCategoryCover(event)">
                <div id="mainCategoryCoverPreview"></div>
            </div>

            <div class="flex justify-end">
                <button type="submit" id="addCategorybtn"
                    class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Add
                    Category</button>
                <button type="button" id="closeModal"
                    class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
            </div>
        </form>
    </div>
</div>
<!-- View Category Modal -->
<div id="viewCategoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md max-w-3xl w-full h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Category Details</h2>
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
                <label class="text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <p id="viewCategoryName" class="border rounded-md px-3 py-2 text-sm"></p>
            </div>
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Page Type</label>
                <p id="viewCategoryType" class="border rounded-md px-3 py-2 text-sm"></p>
            </div>
            <div class="mb-4 flex flex-col">
                <label class="text-sm font-medium text-gray-700 mb-1">Type of Category</label>
                <p id="viewCategoryTypeOfCategory" class="border rounded-md px-3 py-2 text-sm"></p>
            </div>
            <div id="viewCategoryImages" class="mb-4 flex flex-col hidden">
                <label class="text-sm font-medium text-gray-700 mb-1">Category Images</label>
                <div class="flex">
                    <div id="viewCategoryImageCover" class="mr-4">
                        <label class="text-xs font-medium text-gray-700 mb-1">Image Cover</label>
                        <img id="viewCategoryCoverImage" class="border rounded-md" src="#" alt="Category Cover Image"
                            style="max-width: 100px; max-height: 100px;">
                    </div>
                    <div id="viewCategoryImageHeader">
                        <label class="text-xs font-medium text-gray-700 mb-1">Image Header</label>
                        <img id="viewCategoryHeaderImage" class="border rounded-md" src="#" alt="Category Header Image"
                            style="max-width: 100px; max-height: 100px;">
                    </div>
                </div>
            </div>
            <div class="mb-4 flex flex-col hidden" id="viewMainCategory">
                <label class="text-sm font-medium text-gray-700 mb-1">Main Category</label>
                <p id="viewMainCategoryName" class="border rounded-md px-3 py-2 text-sm"></p>
            </div>
            <!-- Display Subcategories -->
            <div id="subcategoriesList" class="mt-2">
                <label class="text-sm font-medium text-gray-700 mb-1">Subcategories</label>
                <ul id="subcategories" class="list-disc pl-5"></ul>
            </div>
        </div>
        <div class="flex justify-end">
            <button id="closeViewModal"
                class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Close</button>
        </div>
    </div>
</div>
<!-- Edit Category Modal -->
<div id="editCategoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-md shadow-md max-w-3xl w-full h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Edit Category</h2>
            <button id="closeEditModal" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <form id="editCategoryForm" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-4 flex flex-col">
                <label for="editCategoryName" class="text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" id="editCategoryName" name="editCategoryName" placeholder="Enter Category Name"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="flex mb-4 justify-center">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="editCategoryType" class="text-sm font-medium text-gray-700 mb-2">Page Type:</label>
                    <select id="editCategoryType" name="editCategoryType"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                    </select>
                </div>
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="editCategoryCat" class="text-sm font-medium text-gray-700 mb-2">Type of Category</label>
                    <select id="editCategoryCat" name="editCategoryType" onchange="toggleMainCategoryDropdown()"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Select a Type of Category</option>
                        <option value="main">Main Category</option>
                        <option value="sub">Sub Category</option>
                    </select>
                </div>
            </div>
            <!-- Main Category Dropdown -->
            <div id="editMainCategoryDropdown" class="flex mb-4 justify-center hidden">
                <div class="flex flex-col mr-4" style="flex: 1;">
                    <label for="editMainCategory" class="text-sm font-medium text-gray-700 mb-2">Main Category</label>
                    <select id="editMainCategory" name="editMainCategory"
                        class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="" disabled selected></option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>
            </div>
            <!-- Main Category Image Insert -->
            <div id="editMainCategoryImage" class="flex flex-col mb-4 hidden">
                <label for="editMainCategoryImageInput" class="text-sm font-medium text-gray-700 mb-2">Main Category
                    Image</label>
                <p class="text-sm font-medium italic mb-2">The image will be used for the product category selection
                    page.</p>
                <input type="file" id="editMainCategoryImageInput" name="editMainCategoryImageInput"
                    accept="image/jpeg, image/jpg, image/png"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    onchange="previewMainCategoryImage(event)">
                <div id="editMainCategoryImagePreview"></div>
            </div>
            <!-- Main Category Image Insert -->
            <div id="editMainCategoryCover" class="flex flex-col mb-4 hidden">
                <label for="editMainCategoryCoverInput" class="text-sm font-medium text-gray-700 mb-2">Main Category
                    Cover</label>
                <p class="text-sm font-medium italic mb-2">The image will be used for the product header cover.</p>
                <input type="file" id="editMainCategoryCoverInput" name="editMainCategoryCoverInput"
                    accept="image/jpeg, image/jpg, image/png"
                    class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                    onchange="previewMainCategoryCover(event)">
                <div id="editMainCategoryCoverPreview"></div>
            </div>

            <div class="flex justify-end">
                <button type="submit" id="editCategoryBtn"
                    class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Save
                    Changes</button>
                <button type="button" id="closeEditModalBtn"
                    class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
            </div>
        </form>
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
    function toggleMainCategoryDropdown() {
        var categoryType = $('#addcategoryCat').val();
        var mainCategoryDropdown = $('#mainCategoryDropdown');
        var mainCategoryImage = $('#mainCategoryImage');
        var mainCategoryCover = $('#mainCategoryCover');

        if (categoryType === "sub") {
            mainCategoryDropdown.removeClass("hidden");
            mainCategoryCover.addClass("hidden");
            mainCategoryImage.addClass("hidden");
        } else if (categoryType === "main") {
            mainCategoryDropdown.addClass("hidden");
            mainCategoryCover.removeClass("hidden");
            mainCategoryImage.removeClass("hidden");
        }
    }

    // Event listener for category type change
    $('#addcategoryCat').change(function () {
        toggleMainCategoryDropdown();
    });

    // Function to preview main category image
    function previewMainCategoryImage(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('mainCategoryImagePreview');
            output.innerHTML = '<img src="' + reader.result + '" style="max-width: 100px; max-height: 100px;" class="mt-2 max-w-full h-auto">';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Function to preview main category image
    function previewMainCategoryCover(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('mainCategoryCoverPreview');
            output.innerHTML = '<img src="' + reader.result + '" style="max-width: 450px; max-height: 450px;" class="mt-2 max-w-full h-auto">';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    $(document).ready(function () {
        var itemsPerPage = 5;
        var currentPage = 1;

        // Function to fetch and display categories based on filters and pagination
        function fetchAndDisplayCategories() {
            var typeFilter = $('#typeFilter').val();
            var statusFilter = $('#statusFilter').val();
            var sortFilter = $('#sortFilter').val();

            $.ajax({
                url: '../../../backend/category/fetchcategory.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    type: typeFilter,
                    status: statusFilter,
                    sort: sortFilter,
                    page: currentPage // Pass currentPage to the backend
                },
                success: function (response) {
                    if (response && response.categories && response.categories.length > 0) {
                        // Display categories for the table
                        displayCategories(response.categories);
                    } else {
                        // Display "No Categories Found" message
                        $('#categorylisting').html('<tr><td colspan="4" class="text-center font-bold text-red-800">No Categories Found</td></tr>');
                        // Also, clear any existing pagination
                        $('#pagination').empty();
                    }

                    // Populate main category dropdown
                    if (response && response.mainCategories && response.mainCategories.length > 0) {
                        $('#mainCategory').empty(); // Empty the dropdown
                        $('#mainCategory').append($('<option>').text("Select a Main Category").attr('disabled', true).attr('selected', true)); // Add option label
                        $.each(response.mainCategories, function (index, category) {
                            $('#mainCategory').append($('<option>').val(category.CategoryID).text(category.CategoryName));
                        });
                    } else {
                        $('#mainCategory').empty();
                        $('#mainCategory').append($('<option>').text("No main categories found").attr('disabled', true).attr('selected', true));
                    }
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error("Status:", status);
                    console.error("Error:", error);
                    console.error("Response:", xhr.responseText);
                    $('#categorylisting').html('<tr><td colspan="4" class="text-center font-bold text-red-800">Error fetching categories</td></tr>');
                }
            });
        }
        // Function to handle pagination and display categories
        function displayCategories(categories) {
            var startIndex = (currentPage - 1) * itemsPerPage;
            var endIndex = startIndex + itemsPerPage;
            var slicedCategories = categories.slice(startIndex, endIndex);

            $('#categorylisting').empty();

            $.each(slicedCategories, function (index, category) {
                var row = $('<tr>');
                row.append('<td class="px-4 py-2 border-b">' + category.CategoryName + '</td>');
                row.append('<td class="px-4 py-2 border-b">' + category.type + '</td>');
                row.append('<td class="px-4 py-2 border-b">' + category.status + '</td>');
                row.append('<td class="px-4 py-2 border-b">' +
                    '<div class="flex justify-center">' +
                    '<button type="button" class="btn btn-view rounded-md text-center sm:mt-4 px-4 text-sm flex items-center mr-2 viewCategory" data-categoryid="' + category.CategoryID + '"><i class="fas fa-eye mr-2 fa-sm"></i><span class="hover:underline">View</span></button>' +
                    '<button type="button" class="btn btn-primary rounded-md text-center sm:mt-4 px-4 text-sm flex items-center mr-2 editCategory" data-categoryid="' + category.CategoryID + '"><i class="fas fa-edit mr-2 fa-sm"></i><span class="hover:underline">Edit</span></button>' +
                    '<button type="button" class="btn btn-danger rounded-md text-center sm:mt-4 px-4 text-sm flex items-center mr-2 deleteCategory" data-categoryid="' + category.CategoryID + '"><i class="fas fa-trash-alt mr-2 fa-sm"></i><span class="hover:underline">Delete</span></button>' +
                    '</div>' +
                    '</td>');
                $('#categorylisting').append(row);
            });

            generatePagination(Math.ceil(categories.length / itemsPerPage), categories.length);
        }

        // Function to generate pagination
        function generatePagination(totalPages, totalRows) {
            const paginationBar = $('#pagination');
            paginationBar.empty();

            const itemCountElement = $('<div class="text-[16px] text-gray-500 item-count">').text(`Showing ${(currentPage - 1) * itemsPerPage + 1} - ${Math.min(currentPage * itemsPerPage, totalRows)} of ${totalRows} items`);
            paginationBar.append(itemCountElement);

            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationBar.append(`<button class=" btn-primary btn-pagination">${i}</button>`);
                } else {
                    paginationBar.append(`<button class="btn btn-secondary btn-pagination">${i}</button>`);
                }
            }

            paginationBar.find('.btn-pagination').click(function () {
                const pageNumber = $(this).text();
                currentPage = parseInt(pageNumber);
                fetchAndDisplayCategories(); // Update categories when page changes
                return false;
            });

            paginationBar.find(`.btn-pagination:contains(${currentPage})`).addClass('active');
            paginationBar.addClass('flex justify-end');
        }

        // Fetch and display categories on page load
        fetchAndDisplayCategories();

        // Event listener for type filter change
        $('#typeFilter').change(function () {
            currentPage = 1; // Reset currentPage to 1 when filter changes
            fetchAndDisplayCategories();
        });

        // Event listener for status filter change
        $('#statusFilter').change(function () {
            currentPage = 1; // Reset currentPage to 1 when filter changes
            fetchAndDisplayCategories();
        });

        // Event listener for sort filter change
        $('#sortFilter').change(function () {
            currentPage = 1; // Reset currentPage to 1 when filter changes
            fetchAndDisplayCategories();
        });

        // Show add category modal
        $("#addCategory").click(function () {
            $("#addProdCategoryModal").removeClass("hidden");
        });

        // Close modal when Close button or "x" button is clicked
        $("#closeAddModal, #closeModal").click(function () {
            $("#addProdCategoryModal").addClass("hidden");
        });
        // AJAX request to fetch page types
        $.ajax({
            url: '../../../backend/category/fetchcategorytype.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#addcategoryType').empty();
                $('#editCategoryType').empty();
                $('#typeFilter').empty();

                $('#addcategoryType').append($('<option>').val('').text('Select Page Type'));
                $('#typeFilter').append($('<option>').val('typereset').text('All Type'));

                $('#editCategoryType').append($('<option>').val('').text('Select Page Type'));
                $('#typeFilter').append($('<option>').val('typereset').text('All Type'));

                $.each(data, function (index, type) {
                    $('#addcategoryType').append($('<option>').val(type).text(type));
                    $('#editCategoryType').append($('<option>').val(type).text(type));
                    $('#typeFilter').append($('<option>').val(type).text(type));
                });
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });

        // AJAX request to fetch page types
        $.ajax({
            url: '../../../backend/category/fetchcategorystatus.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#statusFilter').empty();
                $('#statusFilter').append($('<option>').val('statusreset').text('Status'));

                $.each(data, function (index, status) { // Change 'status' to 'type'
                    $('#statusFilter').append($('<option>').val(status).text(status)); // Change 'status' to 'type'
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    // ADD MODAL
    $('#addCategoryForm').submit(function (event) {
        event.preventDefault();

        var formData = new FormData($(this)[0]);

        $.ajax({
            type: 'POST',
            url: '../../../backend/category/addcategory.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);

                $('#successMessage').text("Category has been successfully added.");
                $('#successPopup').removeClass("hidden");

                $('#addProdCategoryModal').addClass("hidden");
                setTimeout(function () {
                    location.reload();
                }, 500);

                setTimeout(function () {
                    $('#successPopup').addClass("hidden");
                }, 1000);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // VIEW MODAL
    $(document).on('click', '.viewCategory', function () {
        var categoryId = $(this).data('categoryid');
        $.ajax({
            url: '../../../backend/category/viewcategory.php',
            type: 'POST',
            dataType: 'json',
            data: {
                categoryId: categoryId
            },
            success: function (response) {
                if (response && response.success) {
                    var category = response.category;
                    // Populate modal content based on category type
                    $('#viewCategoryName').text(category.CategoryName);
                    $('#viewCategoryType').text(category.type);
                    if (category.imagecover && category.imageheader) {
                        $('#viewCategoryCoverImage').attr('src', category.imagecover);
                        $('#viewCategoryHeaderImage').attr('src', category.imageheader);
                        $('#viewCategoryImages').removeClass('hidden');
                    } else {
                        $('#viewCategoryImages').addClass('hidden');
                    }
                    if (response.isMainCategory) {
                        $('#viewCategoryTypeOfCategory').text('Main Category');
                        $('#viewMainCategory').addClass('hidden');
                        // Show subcategories and populate the list
                        $('#subcategoriesList').removeClass('hidden');
                        $('#subcategories').empty(); // Clear previous subcategories
                        $.each(response.subcategories, function (index, subcategory) {
                            $('#subcategories').append('<li class="text-sm text-gray-700">' + subcategory + '</li>');
                        });
                    } else {
                        $('#viewCategoryTypeOfCategory').text('Sub Category');
                        $('#viewMainCategoryName').text(category.MainCategoryName);
                        $('#viewMainCategory').removeClass('hidden');
                        // Hide subcategories for sub categories
                        $('#subcategoriesList').addClass('hidden');
                        $('#subcategories').empty(); // Clear previous subcategories
                    }
                    $('#viewCategoryModal').removeClass('hidden');
                } else {
                    console.error("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Status: " + status);
                console.error("Error: " + error);
                console.error("Response: " + xhr.responseText);
            }
        });
    });
    // Close view modal when Close button or "x" button is clicked
    $("#closeViewModalButton, #closeViewModal").click(function () {
        $("#viewCategoryModal").addClass("hidden");
    });

    // EDIT MODAL
    $(document).on('click', '.editCategory', function () {
        var categoryId = $(this).data('categoryid');
        $("#editCategoryModal").removeClass("hidden");
    });

    // Close edit modal when Close button or "x" button is clicked
    $("#closeEditModal, #closeEditModalBtn").click(function () {
        $("#editCategoryModal").addClass("hidden");
    });
</script>
<?php
$script = ob_get_clean();
include ("../../../public/master.php");
?>