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
    <div class="flex flex-col sm:flex-row items-center justify-center">
        <div class="flex flex-col sm:flex-row justify-between mb-4 sm:mb-0">
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="brandFilter" class="mr-2">Brands</label>
                <select id="brandFilter" class="border rounded-md px-2 py-1">
                    <option value="brandsreset">All Brand</option>
                    <!-- Add your brand options here -->
                </select>
            </div>
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="categoryFilter" class="mr-2">Blinds</label>
                <select id="categoryFilter" class="border rounded-md px-2 py-1">
                    <option value="categoryreset">Category</option>
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
                <div class="relative mb-1 mt-3.5 sm:mb-0 sm:mr-2">
                    <!-- Search input -->
                    <div class="relative">
                        <input class="border-2 border-gray-300 bg-white h-9 w-64 px-2 pr-10 mt-10 sm:!mt-0 rounded-lg text-[16px] focus:outline-none" type="text" name="search" placeholder="Search" id="blindssearchInput">
                        <button type="submit" class="absolute right-0 top-0 mt-7 mr-4 sm:mt-3">
                            <svg class="text-gray-600 h-5 w-5 fill-current hover:text-gray-500 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
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