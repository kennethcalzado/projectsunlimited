<?php
$is_public_page = true;
$pageTitle = "Product Category";
ob_start();
?>

<head>
    <link rel="stylesheet" href="../assets/input.css">
</head>
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

    .category-name:hover {
        color: #EAB308;
    }

    /* Mobile-specific styles */
    @media (max-width: 768px) {
        .content {
            padding: 0;
        }

        .fade-in-hidden img {
            max-height: 200px;
        }

        .text-4xl {
            font-size: 18px;
            padding: 1px;
        }

        #prodcat>div {
            width: 80%;
            /* Adjusted to take up more space on small screens */
            text-align: center;
        }

        .text-2xl {
            font-size: 14px !important;
            /* Increased for better readability on small screens */
        }

        .square-image {
            height: 200px;
            padding-top: 0;
        }

        .square-image-inner {
            height: 100%;
            width: 100%;
        }

        .square-image:hover {
            transform: scale(1.1);
        }

        .category-name:hover {
            color: #EAB308;
        }

        .content h1.text-4xl {
            font-size: 24px;
            /* Ensure the main title is readable on small screens */
        }

        .content p {
            font-size: 16px;
            /* Ensure the text is readable on small screens */
        }

        .custombanner .text-4xl {
            font-size: 16px !important;
            margin-top: 15px !important;
            margin-top: 2% !important;
        }

        .custombanner .text-2xl,
        .custombanner .text-container a {
            font-size: 13px !important;
            padding: 0px 0px !important;
            margin-top: 0px !important;
            line-height: normal !important;
            margin-left: 2% !important;
            margin-right: 2% !important;
        }

        .customcontainer h3.text-3xl {
            font-size: 20px !important;
            margin-left: 4px !important;
            margin-right: 8px !important;
            margin-bottom: 0% !important;
        }

        .customcontainer p.text-2xl {
            font-size: 14px !important;
            margin-top: 0% !important;
            text-align: justify !important;
        }

        .customcontainer .p-8 {
            padding: 10px !important;
        }

        .customcontainer .px-8 {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }

        .customcontainer .mx-12 {
            margin-left: 4px !important;
            margin-right: 4px !important;
        }

        .customcontainer .mr-4 {
            margin-right: 2px !important;
        }

        .customcontainer .w-10 {
            width: 24px !important;
            height: 24px !important;
            font-size: 12px !important;
            line-height: 24px !important;
        }

        .banner {
            font-size: 24px !important;
        }
    }
</style>
<a href="#top" class="back-to-top">
    <div>
        <i class="fas fa-arrow-up"></i>
    </div>
</a>
<div class="content fade-in-hidden">
    <div class="relative">
        <img src="../assets/image/stock.png" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <p class="banner text-white font-bold text-4xl">PRODUCTS</p>
        </div>
    </div>
    <h1 class="text-4xl font-extrabold text-center text-black p-4">CATEGORIES</h1>
    <div id="categorycontainer">
        <div id="prodcat" class="flex flex-wrap justify-center">
            <!-- Categories will be loaded dynamically here -->
        </div>
    </div>
</div>
<div class="custombanner mt-4">
    <div class="relative fade-in-hidden">
        <img src="../assets/image/customizebanner.png" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <p class="text-[#F6E381] font-extrabold text-4xl text-center">CUSTOMIZE PRODUCTS <br>
                <span class="text-white text-2xl font-semibold">Many of our products can be customized to the requirements
                    of our clients.<br> These may include the dimensions, colors, textures, and materials used in the
                    item.</span><br>
                <span class="text-white text-2xl font-semibold block mt-12">Send us an email at:
                    <a href="mailto:info@projectsunlimited.com.ph" class="text-2xl hover:underline">
                        <i class="fa-solid fa-envelope"></i> info@projectsunlimited.com.ph
                    </a>
                </span>
            </p>
        </div>
    </div>
</div>
<div class="customcontainer fade-in-hidden">
    <div class="p-8">
        <div class="flex items-center p-2 px-8 fade-in-hidden">
            <div class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">
                1</div>
            <h3 class="text-gray-800 font-bold text-3xl ">INQUIRE</h3>
        </div>
        <div class="flex items-center fade-in-hidden">
            <p class="font-semibold text-2xl p-4 px-8 mx-12">Ask about the product and set an official appointment with
                Projects Unlimited. We are willing to get in touch with you directly and know your ideas.</p>
        </div>
        <div class="flex items-center justify-end p-2 px-8 fade-in-hidden">
            <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">PLAN</h3>
            <div class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">
                2</div>
        </div>
        <div class="flex items-center fade-in-hidden">
            <p class="text-right font-semibold text-2xl p-4 px-8 mx-12">Discuss your desired dimension, color, texture,
                and materials for your customized products and we’ll do it for you. The budget and timeline will be
                discussed as well.</p>
        </div>
        <div class="flex items-center p-2 px-8 fade-in-hidden">
            <div class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">
                3</div>
            <h3 class="text-gray-800 font-bold text-3xl">CREATE</h3>
        </div>
        <div class="flex items-center fade-in-hidden">
            <p class="font-semibold text-2xl p-4 px-8 mx-12">Our team will proceed to create your desired products and
                we’ll give you an estimated time of completion and we’ll keep you updated at all time.</p>
        </div>
        <div class="flex items-center justify-end p-2 px-8 fade-in-hidden">
            <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">DELIVER & INSTALL</h3>
            <div class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">
                4</div>
        </div>
        <div class="flex items-center justify-end fade-in-hidden">
            <p class=" text-right font-semibold text-2xl pb-2 px-8 pt-2 mx-12">Once the products are completed, we will
                proceed to delivering and installing the products to your place.</p>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // When the page is scrolled, show/hide the back-to-top button
        window.addEventListener("scroll", function() {
            var backToTopButton = document.querySelector('.back-to-top');
            if (window.scrollY > 200) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        // Smooth scrolling when the button is clicked
        var backToTopButton = document.querySelector('.back-to-top a');
        if (backToTopButton) {
            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // AJAX request to fetch categories
        $.ajax({
            url: "../../../backend/productdisplay/fetchcategorypage.php",
            type: "GET",
            dataType: "json",
            success: function(data) {
                // Populate categories
                if (data.length > 0) {
                    data.forEach(function(category) {
                        var categoryCard = '<div class="w-1/5 px-2">' +
                            '<a href="../pages' + category.page_path + '" class="block overflow-hidden transition duration-300">' +
                            '<div class="square-image">' +
                            '<img src="../assets/category/' + category.imagecover + '" class="square-image-inner" alt="' + category.CategoryName + '">' +
                            '</div>' +
                            '<div class="p-2">' +
                            '<h2 class="text-2xl mt-0 font-semibold text-center category-name" id="catname">' + category.CategoryName + '</h2>' +
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