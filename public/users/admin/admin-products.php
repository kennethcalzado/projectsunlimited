<?php
session_start();
$pageTitle = "Products";
ob_start();
?>

<head>
    <link rel="stylesheet" href="../../../assets/input.css">
</head>

<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">Products</h1>
        <button id="addProduct" class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg> Add Product </button>

    </div>
    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div>
    <div class="flex flex-col sm:flex-row items-center justify-center">
        <div class="flex flex-col sm:flex-row justify-between mb-4 sm:mb-0">
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="roleFilter" class="mr-2">Category</label>
                <select id="roleFilter" class="border rounded-md px-2 py-1">
                    <optgroup label="Filter By:">
                        <option>All</option>

                </select>
            </div>
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="sortFilter" class="mr-2">Sort</label>
                <select id="sortFilter" class="border rounded-md px-2 py-1">
                    <optgroup label="Sort By:">
                        <option>Sort By</option>
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
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date Added
                    </th>
                    <th scope="col" class="px-6 py-3">
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
        <h2 class="text-2xl font-bold">Add Product</h2>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <form id="addProductForm" class="mt-4">
            <div class="mb-4 flex flex-col">
                <label for="addproductName" class="text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" id="addproductName" name="productName" placeholder="Enter Product Name" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="mb-4 flex flex-col">
                <label for="addproductImage" class="text-sm font-medium text-gray-700 mb-1">Insert Product Image</label>
                <input type="file" id="addproductImage" name="productImage" accept="image/*" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>
            <div class="mb-4 flex flex-col">
                <label for="addproductDescription" class="text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="addproductDescription" name="productDescription" rows="4" placeholder="Enter Product Description" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"></textarea>
            </div>
            <div class="mb-4 flex flex-col">
                <label for="addproductCategory" class="text-sm font-medium text-gray-700 mb-1">Category</label>
                <select id="addproductCategory" name="productCategory" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <option value="">Select Category</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" id="addProductbtn" class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Add Product</button>
                <button type="button" id="closeModal" class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Close</button>
            </div>
        </form>
    </div>
</div>


<?php $content = ob_get_clean();
ob_start();
?>

<!-- JAVASCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("../../../backend/product/productdisplay.php")
            .then(response => response.json())
            .then(data => {
                const productListing = document.getElementById("productlisting");
                if (data.length > 0) {
                    data.forEach(product => {
                        const tr = document.createElement("tr");
                        tr.innerHTML = `
                            <td>${product.name}</td>
                            <td>${product.description}</td>
                            <td>${product.image}</td>
                            <td>${product.category}</td>
                            <td>${product.date_added}</td>
                            <td>Action</td>
                        `;
                        productListing.appendChild(tr);
                    });
                } else {
                    productListing.innerHTML = "<tr><td colspan='6' class='text-center font-bold text-red-800'>No products available</td></tr>";
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                const productListing = document.getElementById("productlisting");
                productListing.innerHTML = "<tr><td colspan='6'class='text-center font-bold text-red-800'>Failed to fetch products</td></tr>";
            });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Open modal when Add Product button is clicked
        const addProductButton = document.getElementById("addProduct");
        const addProductModal = document.getElementById("addProductModal");
        const closeModal = document.getElementById("closeModal");

        addProductButton.addEventListener("click", function() {
            addProductModal.classList.remove("hidden");
        });

        // Close modal when Close button is clicked
        closeModal.addEventListener("click", function() {
            addProductModal.classList.add("hidden");
        });

        // Close modal when clicking outside the modal
        addProductModal.addEventListener("click", function(event) {
            if (event.target === addProductModal) {
                addProductModal.classList.add("hidden");
            }
        });
    });

    const server = http.createServer((req, res) => {
        if (req.url === '/categories' && req.method === 'GET') {
            // Fetch categories
            const query = 'SELECT * FROM productcategory';
            connection.query(query, (err, results) => {
                if (err) {
                    console.error('Error fetching categories: ', err);
                    res.writeHead(500, {
                        'Content-Type': 'application/json'
                    });
                    res.end(JSON.stringify({
                        error: 'Internal server error'
                    }));
                    return;
                }
                res.writeHead(200, {
                    'Content-Type': 'application/json'
                });
                res.end(JSON.stringify(results));
            });
        } else {
            // Handle other routes or methods
            res.writeHead(404, {
                'Content-Type': 'application/json'
            });
            res.end(JSON.stringify({
                error: 'Not found'
            }));
        }
    });

    // Start the server
    const PORT = process.env.PORT || 3000;
    server.listen(PORT, () => {
        console.log(`Server is running on port ${PORT}`);
    });
</script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '../../../backend/product/getproductcategory.php',
            type: 'GET',
            dataType: 'json',
            success: function(categories) {
                // Render categories data
                const categoryForm = $('#addproductCategory');

                // Clear existing options
                categoryForm.empty();

                // Append each category to the dropdown
                $.each(categories, function(index, category) {
                    categoryForm.append($('<option>').val(category.CategoryID).text(category.CategoryName));
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>


<?php
$script = ob_get_clean();
include("../../../public/master.php");
?>