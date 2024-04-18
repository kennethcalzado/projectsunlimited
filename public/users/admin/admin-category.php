<?php
session_start();
$pageTitle = "Category";
ob_start();
?>
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
                <label for="typeFilter" class="mr-2">Type</label>
                <select id="typeFilter" class="border rounded-md px-2 py-1">
                    <option value="typereset">All Type</option>
                    <!-- Add your brand options here -->
                </select>
            </div>
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="statusFilter" class="mr-2">Status</label>
                <select id="statusFilter" class="border rounded-md px-2 py-1">
                    <option value="statusreset">Status</option>
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
<script>
    $(document).ready(function () {
        var itemsPerPage = 5;
        var currentPage = 1;

        function displayCategories(categories, page) {
            var startIndex = (page - 1) * itemsPerPage;
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
                    '<button type="button" class="btn btn-primary rounded-md text-center sm:mt-4 px-4 text-sm flex items-center mr-2 editCategory" data-categoryid="' + category.CategoryID + '"><i class="fas fa-edit mr-2 fa-sm"></i>Edit</button>' +
                    '<button type="button" class="btn btn-danger rounded-md text-center sm:mt-4 px-4 text-sm flex items-center mr-2 deleteCategory" data-categoryid="' + category.CategoryID + '"><i class="fas fa-trash-alt mr-2 fa-sm"></i>Delete</button>' +
                    '</div>' +
                    '</td>');
                $('#categorylisting').append(row);
            });

            generatePagination(Math.ceil(categories.length / itemsPerPage), categories.length, page, categories);
        }

        function generatePagination(totalPages, totalRows, currentPage, categories) {
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
                displayCategories(categories, parseInt(pageNumber));
                return false;
            });

            paginationBar.find(`.btn-pagination:contains(${currentPage})`).addClass('active');
            paginationBar.addClass('flex justify-end');
        }

        $.ajax({
            url: '../../../backend/category/fetchcategory.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    displayCategories(response, currentPage);
                } else {
                    $('#categorylisting').html('<tr><td colspan="4">No categories found</td></tr>');
                }
            },
            error: function (xhr, status, error) {
                console.error("Status:", status);
                console.error("Error:", error);
                console.error("Response:", xhr.responseText);
                $('#categorylisting').html('<tr><td colspan="4">Error fetching categories</td></tr>');
            }
        });
    });
</script>
<?php
$script = ob_get_clean();
include ("../../../public/master.php");
?>