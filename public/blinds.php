<?php
$pageTitle = "Products - Blinds";
ob_start();
?>
<div class="content">
    <div class="relative">
        <img src="../assets/image/blindsproduct.jpg" class="w-full h-96 object-cover object-top">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-end text-center">
            <p class="text-white font-extrabold text-3xl mr-8">BLINDS<br>
                <span class="text-white font-semibold text-xl mr-2 mt-2">100 items<br></span>
                <span class="text-white font-semibold text-xl mr-10 mt-2 hover:text-[#F6E381]">Combi Blinds<br></span>
                <span class="text-white font-semibold text-xl mr-9 mt-2 hover:text-[#F6E381]">Roller Blinds<br></span>
                <span class="text-white font-semibold text-xl mr-16 mt-2 hover:text-[#F6E381]">Blackout
                    Blinds<br></span>
                <span class="text-white font-semibold text-xl mr-14 mt-2 hover:text-[#F6E381]">Vertical
                    Blinds<br></span>
                <span class="text-white font-semibold text-xl mr-20 mt-2 hover:text-[#F6E381]">Horizontal Blinds</span>
            </p>
        </div>
    </div>
    <header class="bg-[#F6E381]">
        <div class="container mx-auto">
            <nav class="py-2">
                <div class="container mx-auto flex items-center justify-between">
                    <div class="hidden md:flex flex-grow">
                        <ul class="flex justify-between w-full mx-20">
                            <li><a href="../public/flooring.php"
                                    class="text-black font-bold hover:text-gray-700">FLOORINGS</a></li>
                            <li><a href="../public/wallcover.php"
                                    class="text-black font-bold hover:text-gray-700">WALLCOVERING</a></li>
                            <li><a href="../public/office.php" class="text-black font-bold hover:text-gray-700">OFFICE
                                    ACCESSORIES</a></li>
                            <li><a href="../public/modular.php" class="text-black font-bold hover:text-gray-700">MODULAR
                                    CABINETS</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <div class="flex flex-col md:flex-row items-center justify-center">
        <p class="text-3xl font-extrabold my-2 md:pl-14 md:pr-2">CATEGORY: BLINDS</p>
        <div class="flex flex-col md:flex-row items-center">
            <div class="relative mb-2 md:mb-0 md:mr-2">
                <select
                    class="w-full md:w-auto bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <optgroup label="Blinds">
                        <option>All Blinds</option>
                        <option>Combi Blinds</option>
                        <option>Roller Blinds</option>
                        <option>Blackout Blinds</option>
                        <option>Vertical Blinds</option>
                        <option>Horizontal Blinds</option>
                    </optgroup>
                </select>
            </div>
            <div class="relative mb-2 md:mb-0 md:mr-2">
                <select
                    class="w-full md:w-auto bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option>Sort By</option>
                    <option>Newest Product</option>
                    <option>Oldest Product</option>
                    <option>Most Popular Product</option>
                </select>
            </div>
            <div class="flex justify-between">
                <div class="relative mb-1 sm:mb-0 sm:mr-2">
                    <!-- Search input -->
                    <div class="relative text-gray-600">
                        <input
                            class="border-2 border-gray-300 bg-white h-9 w-64 px-2 rounded-md text-sm focus:outline-none"
                            type="text" name="search" placeholder="Search" id="searchInput">
                        <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;"
                                xml:space="preserve" width="512px" height="512px">
                                <path
                                    d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products section -->
    <div class="container mx-auto my-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Products will be dynamically added here -->
        </div>
    </div>

    <div id="productModal" class="hidden fixed inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
        <div class="modal-content bg-white shadow-lg rounded-sm overflow-hidden w-full md:w-3/4 lg:w-2/3 xl:w-1/2 relative max-h-screen overflow-y-auto">
                <!-- X button positioned at the upper-right corner -->
                <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="closeProductModal()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/2">
                        <div class="p-4">
                            <h2 id="modalProductName" class="text-gray-800 font-extrabold text-2xl mb-2 uppercase">Product Name
                            </h2>
                            <img id="modalProductImg" src="#" alt="Product Image"
                                class="w-full h-64 object-cover object-center mb-4">
                            <!-- Label for variation images -->
                            <p class="text-gray-800 text-sm font-bold mb-2">Variations</p>
                            <!-- Display variation images here if available -->
                            <div id="variationImages" class="flex justify-center flex-wrap"></div>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <div class="p-4">
                            <p class="text-sm font-bold">Description:</p>
                            <p id="modalProductDescription" class="text-sm font-base text-gray-800 mb-4"></p>
                            <p class="text-sm font-bold">Brand:</p>
                            <p id="modalProductBrand" class="text-sm font-base text-gray-800 mb-4"></span></p>
                            <p class="text-sm font-bold">Category: </p>
                            <p id="modalProductCategory" class="text-sm font-base text-gray-800 mb-4"></p>
                            <p class="text-sm font-bold">Availability: </p>
                            <p id="modalProductAvailability" class="text-sm font-base text-gray-800 mb-4"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fetchProducts() {
        const categories = ['Blinds', 'Combi', 'Roller', 'Horizontal', 'Blackout', 'Vertical'];
        const formData = new FormData();
        formData.append('categories', JSON.stringify(categories));

        fetch('../../../backend/productdisplay/fetchproducts.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(productsData => {
                const productsContainer = document.querySelector('.grid');
                productsContainer.innerHTML = ''; // Clear previous content
                productsData.forEach(product => {
                    const productCard = `
                    <div class="bg-white shadow-lg rounded-[4px] overflow-hidden">
                        <img src="${product.image_urls}" alt="${product.ProductName}" class="w-full h-64 object-cover object-center">
                        <div class="p-4">
                            <h2 class="text-gray-800 font-extrabold text-xl mb-2 uppercase">${product.ProductName}</h2>
                            <p class="text-gray-600 text-base">${product.Description}</p>
                            <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="openProductModal(${product.ProductID})">View Product</button>
                        </div>
                    </div>
                `;
                    productsContainer.innerHTML += productCard;
                });
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    }

    function openProductModal(productId) {
        const productModal = document.getElementById('productModal');

        // Fetch product details for the specified productId from the server
        fetch(`../../../backend/productdisplay/fetchblindsprod.php?productId=${productId}`)
            .then(response => response.json())
            .then(product => {
                // Populate modal content with product details
                document.getElementById('modalProductName').textContent = product.ProductName;
                document.getElementById('modalProductImg').src = product.product_image;
                document.getElementById('modalProductDescription').textContent = product.Description;
                document.getElementById('modalProductBrand').textContent = product.brand_name; // Assuming brand_name is available in the product data
                document.getElementById('modalProductCategory').textContent = product.CategoryName; // Assuming CategoryName is available in the product data
                document.getElementById('modalProductAvailability').textContent = product.availability;

                // Display variation images if available
                if (product.variations && product.variations.length > 0) {
                    const variationImagesContainer = document.getElementById('variationImages');
                    variationImagesContainer.innerHTML = ''; // Clear previous content
                    product.variations.forEach(variation => {
                        const variationImage = document.createElement('img');
                        variationImage.src = variation.image_url;
                        variationImage.alt = variation.VariationName;
                        variationImage.classList.add('w-12', 'h-12', 'object-cover', 'object-center', 'mr-2', 'mb-2', 'cursor-pointer');
                        variationImage.onclick = () => changeModalImage(variation.image_url);
                        variationImagesContainer.appendChild(variationImage);
                    });
                }

                // Show the modal
                productModal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
            });
    }
    function changeModalImage(imageUrl) {
        document.getElementById('modalProductImg').src = imageUrl;
    }

    function closeProductModal() {
        const productModal = document.getElementById('productModal');
        productModal.classList.add('hidden');
    }

    window.addEventListener('load', fetchProducts);
</script>

<?php
$content = ob_get_clean();
include ("../public/master.php");
?>