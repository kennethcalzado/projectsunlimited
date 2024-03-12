<?php
$pageTitle = "Product Category";
ob_start();
?>
<div class="content">
    <div class="relative">
        <img src="../assets/image/stock.png" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-center">
        <p class="text-white font-bold text-4xl">PRODUCTS</p>
    </div>
    </div>
    <h1 class="text-4xl font-bold text-center text-black bg-white p-4">PRODUCT CATEGORY</h1>
    <div id="categorycontainer">
        <div id="prodcat">
            <div class="relative bg-white p-2">
                <div class="absolute h-30 bg-black "></div>
                <div class="flex justify-between relative z-10">
                    <div class="flex">
                        <a href="../public/blinds.php" class="w-1/4 bg-white p-4 pt-3 rounded-lg">
                            <!-- Image 1 -->
                            <img src="../assets/image/blinds.png" alt="Blinds" class="w-full h-70 object-cover">
                        </a>
                        <a href="../public/flooring.php" class="w-1/4 bg-white p-4 pt-3 rounded-lg">
                            <!-- Image 2 -->
                            <img src="../assets/image/flooring.png" alt="Flooring" class="w-full h-70 object-cover">
                        </a>
                        <a href="../public/wallpaper.php" class="w-1/4 bg-white p-4 pt-3 rounded-lg">
                            <!-- Image 3 -->
                            <img src="../assets/image/wallpaper.png" alt="Wallpaper" class="w-full h-70 object-cover">
                        </a>
                        <a href="../public/office.php" class="w-1/4 bg-white p-4 pt-3 rounded-lg">
                            <!-- Image 4 -->
                            <img src="../assets/image/office.png" alt="Office" class="w-full h-70 object-cover">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="relative">
    <img src="../assets/image/customizebanner.png" class="w-full h-96 object-cover">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="absolute inset-0 flex items-center justify-center">
    <p class="text-[#F6E381] font-bold text-4xl">CUSTOMIZE PRODUCTS</p>
</div>
</div>
<div id="customcontainer">
    <h3 class="text-gray-800 font-bold text-3xl p-4 px-8">INQUIRE</h3>
    <p class="font-semibold text-2xl p-4 px-8">Ask about the product and set an official appointment with Projects Unlimited. We are willing to get in touch with you directly and know your ideas.</p>
    <h3 class="text-gray-800 text-right font-bold text-3xl p-4 px-8">PLAN</h3>
    <p class="text-right font-semibold text-2xl p-4 px-8">Discuss your desired dimension, color, texture, and materials for your customized products and we’ll do it for you. The budget and timeline will be discussed as well.</p>
    <h3 class="text-gray-800 font-bold text-3xl p-4 px-8">CREATE</h3>
    <p class="font-semibold text-2xl p-4 px-8">Our team will proceed to create your desired products and we’ll give you an estimated time of completion and we’ll keep you updated at all time.</p>
    <h3 class="text-gray-800 text-right font-bold text-3xl p-4 px-8">DELIVER & INSTALL</h3>
    <p class=" text-right font-semibold text-2xl p-4 px-8">Once the products are completed, we will proceed to delivering and installing the products to your place.</p>
</div>
</div>
<?php
$content = ob_get_clean();
include("../public/master.php");
?>