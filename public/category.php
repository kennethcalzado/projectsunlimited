<?php
$pageTitle = "Product Category";
ob_start();
?>
<style>
    .square-image {
        position: relative;
        width: 100%;
        padding-top: 100%;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .square-image-inner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .square-image:hover {
        transform: scale(1.1);
    }

    /* Apply rainbow animation on hover */
    .category-name:hover {
        color: #EAB308; /* Change the duration as needed */
    }
</style>


<div class="content">
    <div class="relative">
        <img src="../assets/image/stock.png" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <p class="text-white font-extrabold text-4xl">PRODUCTS</p>
        </div>
    </div>
    <h1 class="text-4xl font-extrabold text-center text-black bg-white p-4">PRODUCT CATEGORY</h1>
    <div id="categorycontainer">
        <div id="prodcat" class="flex flex-wrap justify-center">
            <!-- Categories will be loaded dynamically here -->
        </div>
    </div>
</div>
<div class="relative">
    <img src="../assets/image/customizebanner.png" class="w-full h-96 object-cover">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="absolute inset-0 flex items-center justify-center">
        <p class="text-[#F6E381] font-extrabold text-4xl text-center">CUSTOMIZE PRODUCTS <br>
            <span class="text-white text-2xl font-semibold">Many of our products can be customized to the requirements of our clients.<br> These may include the dimensions, colors, textures, and materials used in the item.</span>
        </p>
    </div>
</div>
<div id="customcontainer">
    <div class="p-8">
        <div class="flex items-center p-2 px-8">
            <div class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">1</div>
            <h3 class="text-gray-800 font-bold text-3xl ">INQUIRE</h3>
        </div>
        <div class="flex items-center">
            <p class="font-semibold text-2xl p-4 px-8 mx-12">Ask about the product and set an official appointment with Projects Unlimited. We are willing to get in touch with you directly and know your ideas.</p>
        </div>
        <div class="flex items-center justify-end p-2 px-8">
            <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">PLAN</h3>
            <div class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">2</div>
        </div>
        <div class="flex items-center">
            <p class="text-right font-semibold text-2xl p-4 px-8 mx-12">Discuss your desired dimension, color, texture, and materials for your customized products and we’ll do it for you. The budget and timeline will be discussed as well.</p>
        </div>
        <div class="flex items-center p-2 px-8">
            <div class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">3</div>
            <h3 class="text-gray-800 font-bold text-3xl">CREATE</h3>
        </div>
        <div class="flex items-center">
            <p class="font-semibold text-2xl p-4 px-8 mx-12">Our team will proceed to create your desired products and we’ll give you an estimated time of completion and we’ll keep you updated at all time.</p>
        </div>
        <div class="flex items-center justify-end p-2 px-8">
            <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">DELIVER & INSTALL</h3>
            <div class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">4</div>
        </div>
        <div class="flex items-center justify-end">
            <p class=" text-right font-semibold text-2xl pb-2 px-8 pt-2 mx-12">Once the products are completed, we will proceed to delivering and installing the products to your place.</p>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // AJAX request to fetch categories
        $.ajax({
            url: "../../../backend/productdisplay/fetchcategorypage.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                // Populate categories
                if (data.length > 0) {
                    data.forEach(function(category) {
                        var categoryCard = '<div class="w-1/5 px-2">' + // Changed width to 1/5 for 5 categories per row
                            '<a href="../pages' + category.page_path + '" class="block bg-white overflow-hidden transition duration-300">' +
                            '<div class="square-image">' + // Added a wrapper div for squared images
                            '<img src="../assets/category/' + category.imagecover + '" class="square-image-inner" alt="' + category.CategoryName + '">' + // Added square-image-inner class
                            '</div>' +
                            '<div class="p-4">' +
                            '<h2 class="text-2xl mt-0 font-semibold text-center category-name">' + category.CategoryName + '</h2>' +
                            '</div>' +
                            '</a>' +
                            '</div>';
                        $('#prodcat').append(categoryCard);
                    });
                } else {
                    $('#prodcat').html("<p>No categories found.</p>");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching categories:", error);
                $('#prodcat').html("<p>Error fetching categories.</p>");
            }
        });
    });
</script>
<?php
$content = ob_get_clean();
include("../public/master.php");
?>