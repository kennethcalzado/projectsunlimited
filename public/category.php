<?php
$pageTitle = "Product Category";
ob_start();
?>
<div class="content">
<div class="relative">
        <img src="../assets/image/stock.png" class="w-full h-32 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>
<h1 class="text-4xl font-bold text-center text-black bg-white p-4">PRODUCT CATEGORY</h1>
<div id="categorycontainer">
        <div id="prodcat">
            <div class="relative bg-white p-2">
                <div class="absolute h-30 bg-black "></div>
                <div class="flex justify-between relative z-10">
                <div class="flex">
        <a href="../public/blinds.php" class="w-1/4 bg-white p-4 rounded-lg">
            <!-- Image 1 -->
            <img src="../assets/image/blinds.png" alt="Blinds" class="w-full h-32 object-cover">
        </a>
        <a href="../public/flooring.php" class="w-1/4 bg-white p-4 rounded-lg">
            <!-- Image 2 -->
            <img src="../assets/image/flooring.png" alt="Flooring" class="w-full h-32 object-cover">
        </a>
        <a href="../public/wallpaper.php" class="w-1/4 bg-white p-4 rounded-lg">
            <!-- Image 3 -->
            <img src="../assets/image/wallpaper.png" alt="Wallpaper" class="w-full h-32 object-cover">
        </a>
        <a href="../public/office.php" class="w-1/4 bg-white p-4 rounded-lg">
            <!-- Image 4 -->
            <img src="../assets/image/office.png" alt="Office" class="w-full h-32 object-cover">
        </a>
    </div>
                </div>
            </div>
        </div>
    </div>



<!-- Add more cards as needed -->

</div>
</div> 
<?php
$content = ob_get_clean();
include("../public/master.php");
?>
