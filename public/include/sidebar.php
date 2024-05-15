<?php
// Define your base URL dynamically
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/'; // Example: http://localhost/

// Concatenate the base URL with the image path
$image_path = $base_url . 'assets/image/projectslogo.png';

?>

<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="max-w-md w-full bg-white p-6 rounded-lg">
        <h2 class="text-xl font-bold mb-4">Are you sure you want to log out?</h2>
        <div class="flex justify-end">
            <button onclick="closeLogoutModal()" class="btn btn-secondary mr-2">Cancel</button>
            <button onclick="logout()" class="btn btn-primary mr-2">Yes, Log Out</button>
        </div>
    </div>
</div>

<section id="sidebar-container" class="sidebar minimized fixed top-0 bottom-0 lg:left-0 p-2 w-[80px] 
     text-center bg-black text-white transition-all z-50">

    <div class="text-gray-100 text-xl flex justify-between">
        <span id="toggle-sidebar" class="absolute text-white text-4xl top-4 !ml-2 mt-1 z-40 cursor-pointer burger" onclick="toggleSidebar()">
            <i class="bi bi-list px-2 text-3xl rounded-md hover:bg-yellow-600" title="Toggle Sidebar"></i>
        </span>
        <div class="p-3 mt-1 ml-32 flex items-center">
            <img src="<?php echo $image_path; ?>" class="h-[35px] w-auto icon">
        </div>
    </div>
    <div class="mt-2 bg-gray-600 h-[1px]"></div>

    <a href="/public/users/dashboard.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
            <!-- <div class="tooltip tooltip-right" data-tip="Home">
                    <i class="bi bi-house-door-fill"></i>
                </div> -->
            <div class=" flex relative ">
                <i class="bi bi-house-door-fill"> </i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Home</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.91px] m-4 mx-auto w-20 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[40%] -translate-y-[59.9%] opacity-0">Home</span>
            </div>
            <!-- <span class="text-[15px] ml-4 text-center text-gray-200 font-bold">Home</span> -->
        </div>
    </a>

    <?php
    // Determine the user's role
    $userRole = $_SESSION['user_role'] ?? "guest"; // Default to 'guest' if the role is not set


    if ($userRole == 'admin') { ?>
        <a href="/public/users/admin/users-table.php" class="group">
            <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
                <!-- <div class="tooltip tooltip-right" data-tip="Home">
                    <i class="bi bi-house-door-fill"></i>
                </div> -->
                <div class=" flex relative ">
                    <i class="bi bi-people-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200 font-bold">Users</span>
                    <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.7px] m-4 mx-auto w-20 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[40%] -translate-y-[60%] opacity-0">Users</span>
                </div>
                <!-- <span class="text-[15px] ml-4 text-center text-gray-200 font-bold">Home</span> -->
            </div>
        </a>

        <a href="/public/users/admin/auditlogs.php" class="group">
            <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
                <!-- <div class="tooltip tooltip-right" data-tip="Home">
                    <i class="bi bi-house-door-fill"></i>
                </div> -->
                <div class=" flex relative ">
                    <i class="bi bi-card-list"></i>
                    <span class="text-[15px] ml-4 text-gray-200 font-bold">Audit Logs</span>
                    <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.9px] m-4 mx-auto w-40
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[19%] -translate-y-[59.5%] opacity-0">Audit Logs</span>
                </div>
                <!-- <span class="text-[15px] ml-4 text-center text-gray-200 font-bold">Home</span> -->
            </div>
        </a>
    <?php } ?>

    <a href="/public/users/admin/admin-products.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
            <!-- <div class="tooltip tooltip-right" data-tip="Home">
                    <i class="bi bi-house-door-fill"></i>
                </div> -->
            <div class=" flex relative ">
                <i class="fa-solid fa-box-open py-1"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Products</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 pl-2 py-[8.9px] m-4 mx-auto w-24
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[20%] -translate-y-[60%] opacity-0">Products</span>
            </div>
            <!-- <span class="text-[15px] ml-4 text-center text-gray-200 font-bold">Home</span> -->
        </div>
    </a>
    <a href="/public/users/admin/admin-category.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
            <!-- <div class="tooltip tooltip-right" data-tip="Home">
                    <i class="bi bi-house-door-fill"></i>
                </div> -->
            <div class=" flex relative ">
                <i class="fa-solid fa-table-list py-1"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Category</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 pl-2 py-[8.9px] m-4 mx-auto w-24
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[20%] -translate-y-[60%] opacity-0">Category</span>
            </div>
            <!-- <span class="text-[15px] ml-4 text-center text-gray-200 font-bold">Home</span> -->
        </div>
    </a>

    <div>
        <a href="/public/users/brands-display.php" class="group">
            <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
                <div class="flex relative ">
                    <!-- <i class="bi bi-chat-left-text-fill"></i>  -->
                    <i class="fa-solid fa-tags py-1"></i>
                    <span class="text-[15px] ml-4 text-gray-200 font-bold">Brands</span>
                    <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.9px] m-4 mx-auto w-20 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[35%] -translate-y-[59.5%] opacity-0">Brands</span>
                </div>
            </div>
        </a>

        <span class="absolute hidden
            -translate-y-[32px] translate-x-[95px] 
            text-sm rotate-180 rounded-full  
            hover:bg-yellow-600 hover:text-black hover:text-[17px] 
            px-2 py-1 text-center" id="arrow" onclick="dropdown()">
            <i class="bi bi-chevron-down"></i>
        </span>
    </div>

    <div class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold transition-all" id="submenu"></div>

    <a href="/public/users/admin/locations.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">

            <div class=" flex relative ">
                <i class="bi bi-geo-alt-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Locations</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.9px] m-4 mx-auto w-40
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[19%] -translate-y-[59.5%] opacity-0">Locations</span>
            </div>
        </div>
    </a>

    <a href="/public/users/admin/testimonials.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">

            <div class=" flex relative ">
                <i class="bi bi-chat-left-text-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Testimonials</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.9px] m-4 mx-auto w-40
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[19%] -translate-y-[59.5%] opacity-0">Testimonials</span>
            </div>
        </div>
    </a>

    <a href="/public/users/admin/cmsblogs.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">

            <div class=" flex relative ">
                <i class="bi bi-bookmark-fill "></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">News & Projects</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.9px] m-4 mx-auto w-40
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[19%] -translate-y-[59.5%] opacity-0">News & Projects</span>
            </div>
        </div>
    </a>

    <a href="/public/home.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
            <div class=" flex relative ">
                <i class="fa-solid fa-earth-americas py-1"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Website</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 pl-2 py-[8.9px] m-4 mx-auto w-24
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[20%] -translate-y-[60%] opacity-0">Website</span>
            </div>
        </div>
    </a>

    <div class="my-4 bg-gray-600 h-[1px]"></div>

    <a href="/public/users/profile.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
            <!-- <div class="tooltip tooltip-right" data-tip="Home">
                    <i class="bi bi-house-door-fill"></i>
                </div> -->
            <div class=" flex relative ">
                <i class="bi bi-person"> </i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Profile</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.5px] m-4 mx-auto w-20 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[40%] -translate-y-[61%] opacity-0">Profile</span>
            </div>
            <!-- <span class="text-[15px] ml-4 text-center text-gray-200 font-bold">Home</span> -->
        </div>
    </a>

    <a class="group" onclick="openLogoutModal()">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
            <div class=" flex relative ">
                <i class="bi bi-box-arrow-in-right"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Logout</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.5px] m-4 mx-auto w-32 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[20%] -translate-y-[60.54%] opacity-0">Logout</span>
            </div>
        </div>
    </a>
</section>

<style>
    .minimized {
        width: 80px;
        /* Initial width when slimmed */
    }

    .minimized .text-gray-200 {
        display: none;
        /* Hide text when sidebar is slimmed */
    }

    .minimized .bi {
        margin-right: 0;
        /* Remove margin between icons when sidebar is slimmed */
    }
</style>

<script>
    function openLogoutModal() {
        var logoutModal = document.getElementById('logoutModal');
        logoutModal.classList.remove('hidden');
        logoutModal.classList.remove('fade-out'); // Remove fade-out class if applied
        logoutModal.classList.add('fade-in');
    }

    function closeLogoutModal() {
        var logoutModal = document.getElementById('logoutModal');
        logoutModal.classList.remove('fade-in');
        logoutModal.classList.add('fade-out');
        setTimeout(function() {
            logoutModal.classList.add('hidden');
            logoutModal.classList.remove('fade-out'); // Remove fade-out class after animation
        }, 300);
    }

    function logout() {
        // Perform logout action here
        window.location.href = '/backend/logout.php';
    }
</script>

<script>
    function dropdown() {
        document.querySelector("#submenu").classList.toggle("hidden");
        document.querySelector("#arrow").classList.toggle("rotate-0");
    }
    dropdown();

    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('minimized');

        if (sidebar.classList.contains('minimized')) {
            sidebar.classList.remove('!w-80');
            document.querySelector("#arrow").classList.toggle("hidden");
            document.querySelector("#submenu").classList.toggle("hidden");
            document.querySelector("#sidebar-container").classList.toggle("overflow-y-auto");
            // Iterate over each element with class "nav-item" and apply the class toggle
            document.querySelectorAll(".nav-item").forEach(function(navItem) {
                navItem.classList.toggle("rounded-l-md");
                navItem.classList.toggle("rounded-md");
            });
            // Iterate over each element with class "tootlips" and apply the class toggle
            document.querySelectorAll(".tootlips").forEach(function(tooltip) {
                tooltip.classList.toggle("hidden");
            });
        } else {
            sidebar.classList.add('!w-80');
            document.querySelector("#arrow").classList.toggle("hidden");
            document.querySelector("#submenu").classList.toggle("hidden");
            // Iterate over each element with class "nav-item" and apply the class toggle
            document.querySelectorAll(".nav-item").forEach(function(navItem) {
                navItem.classList.toggle("rounded-l-md");
                navItem.classList.toggle("rounded-md");
            });
            // Iterate over each element with class "tootlips" and apply the class toggle
            document.querySelectorAll(".tootlips").forEach(function(tooltip) {
                tooltip.classList.toggle("hidden");
            });
            document.querySelector("#sidebar-container").classList.toggle("overflow-y-auto");
        }

        // Adjust main content padding when sidebar is toggled
        const mainContent = document.querySelector(".page-content");
        mainContent.classList.toggle("!ml-[400px]");
    }
</script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '../../../backend/brands/brands-get.php',
            type: 'GET',
            dataType: 'json',
            success: function(brands) {
                // Render brand data
                const submenu = $('#submenu');

                brands.forEach(function(brand) {
                    submenu.append($('<h1>').text(brand.brand_name).addClass('cursor-pointer p-2 hover:bg-yellow-600 rounded-md mt-1'));
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>