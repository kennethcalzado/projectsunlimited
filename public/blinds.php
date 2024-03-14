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
                <span class="text-white font-semibold text-xl mr-16 mt-2 hover:text-[#F6E381]">Blackout Blinds<br></span>
                <span class="text-white font-semibold text-xl mr-14 mt-2 hover:text-[#F6E381]">Vertical Blinds<br></span>
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
                            <li><a href="../public/flooring.php" class="text-black font-bold hover:text-gray-700">FLOORINGS</a></li>
                            <li><a href="../public/wallpaper.php" class="text-black font-bold hover:text-gray-700">WALLPAPERS</a></li>
                            <li><a href="../public/office.php" class="text-black font-bold hover:text-gray-700">OFFICE ACCESSORIES</a></li>
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
            <select class="w-full md:w-auto bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option>All Blinds</option>
                <option>Combi Blinds</option>
                <option>Roller Blinds</option>
                <option>Blackout Blinds</option>
                <option>Vertical Blinds</option>
                <option>Horizontal Blinds</option>
            </select>
        </div>
        <div class="relative mb-2 md:mb-0 md:mr-2">
            <select class="w-full md:w-auto bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option>Sort By</option>
                <option>Newest Product</option>
                <option>Oldest Product</option>
                <option>Most Popular Product</option>
            </select>
        </div>
        <div class="relative flex items-center">
            <input type="text" placeholder="Search" class="block appearance-none w-full md:w-auto bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-l-lg focus:outline-none focus:bg-white focus:border-gray-500">
            <button class="text-white font-bold border border-blue-500 bg-blue-500 py-2 px-4 rounded-r-lg focus:outline-none">Search</button>
        </div>
    </div>
</div>

</div>
<?php
$content = ob_get_clean();
include("../public/master.php");
?>