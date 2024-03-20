<?php
$pageTitle = "Products - Wallpaper";
ob_start();
?>
<div class="content">
    <div class="relative">
        <img src="../assets/image/1-1.jpg" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-end text-center">
            <p class="text-white font-extrabold text-3xl mr-8">WALLCOVERING<br>
                <span class="text-white font-semibold text-xl mr-2 mt-2">100 items<br></span>
                <span class="text-white font-semibold text-xl mt-2 hover:text-[#F6E381]">Erica<br></span>
                <span class="text-white font-semibold text-xl mr-3.5 mt-2 hover:text-[#F6E381]">Denise<br></span>
                <span class="text-white font-semibold text-xl mr-4 mt-2 hover:text-[#F6E381]">La Casa<br></span>
                <span class="text-white font-semibold text-xl mr-4 mt-2 hover:text-[#F6E381]">Wood Cladding<br></span>
            </p>
        </div>
    </div>
    <header class="bg-[#F6E381]">
        <div class="container mx-auto">
            <nav class="py-2">
                <div class="container mx-auto flex items-center justify-between">
                    <div class="hidden md:flex flex-grow">
                        <ul class="flex justify-between w-full mx-20">
                            <li><a href="../public/blinds.php" class="text-black font-bold hover:text-gray-700">BLINDS</a></li>
                            <li><a href="../public/flooring.php" class="text-black font-bold hover:text-gray-700">FLOORINGS</a></li>
                            <li><a href="../public/office.php" class="text-black font-bold hover:text-gray-700">OFFICE ACCESSORIES</a></li>
                            <li><a href="../public/modular.php" class="text-black font-bold hover:text-gray-700">MODULAR CABINETS</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <div class="flex flex-col md:flex-row items-center justify-center">
        <p class="text-3xl font-extrabold my-2 md:pl-14 md:pr-2">CATEGORY: WALLPAPER</p>
        <div class="flex flex-col md:flex-row items-center">
            <div class="relative mb-2 md:mb-0 md:mr-2">
                <select class="w-full md:w-auto bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <optgroup label="Wallpaper">
                        <option>All Wallpaper</option>
                        <option>Erica</option>
                        <option>Denise</option>
                        <option>La Casa</option>
                    </optgroup>
                    <optgroup label="Others">
                        <option>Wood Cladding</option>
                    </optgroup>
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
            <div class="flex justify-between">
                <div class="relative mb-1 sm:mb-0 sm:mr-2">
                    <!-- Search input -->
                    <div class="relative text-gray-600">
                        <input class="border-2 border-gray-300 bg-white h-9 w-64 px-2 rounded-md text-sm focus:outline-none" type="text" name="search" placeholder="Search" id="searchInput">
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

</div>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>