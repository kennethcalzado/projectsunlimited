<?php
// Define your base URL dynamically
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/'; // Example: http://localhost/

// Concatenate the base URL with the image path
$image_path = $base_url . 'assets/image/projects.png';
?>

<span id="toggle-sidebar" class="fixed text-white text-4xl top-5 z-40 ml-4 cursor-pointer burger" onclick="toggleSidebar()">
    <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md" title="Toggle Sidebar"></i>
</span>

<div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[80px] overflow-y-auto text-center bg-black text-white minimized transition-all">
    <div class="text-gray-100 text-xl">
        <div class="p-2.5 mt-1 ml-32 flex items-center">
            <img src="<?php echo $image_path; ?>" class="h-[35px] w-auto icon">
        </div>
        <div class="my-2 bg-gray-600 h-[1px]"></div>
    </div>
    <div class="p-2.5 mt-3 flex items-center rounded-md px-6 duration-300 cursor-pointer hover:bg-yellow-600 text-white">
        <a href="/public/users/dashboard.php" class="flex items-center cursor-pointer hover:bg-yellow-600 text-white" title="News & Blogs">
            <div class="tooltip tooltip-right" data-tip="Home">
                <i class="bi bi-house-door-fill"></i>
            </div>
            <span class="text-[15px] ml-4 text-center text-gray-200 font-bold">Home</span>
        </a>
    </div>
    <?php
    // Determine the user's role
    $userRole = $_SESSION['user_role'] ?? "guest"; // Default to 'guest' if the role is not set

    // Include appropriate navigation component based on user role
    if ($userRole == 'Admin') { ?>
        <a href="/public/users/admin/users-table.php">
            <div class="p-2.5 mt-3 flex items-center rounded-md px-6 duration-300 cursor-pointer hover:bg-yellow-600 text-white" title="Users">
                <div class="tooltip tooltip-right" data-tip="Users">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Users</span>
            </div>
        </a>
    <?php } ?>
    <div class="p-2.5 mt-3 flex items-center rounded-md px-6 duration-300 cursor-pointer hover:bg-yellow-600 text-white" title="Products">
        <div class="tooltip tooltip-right" data-tip="Products">
            <i class="bi bi-bookmark-fill"></i>
        </div>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Products</span>
    </div>
    <div class="p-2.5 mt-3 flex items-center rounded-md px-6 duration-300 cursor-pointer hover:bg-yellow-600 text-white" onclick="dropdown()" title="Brands">
        <div class="tooltip tooltip-right" data-tip="Brands">
            <i class="bi bi-chat-left-text-fill"></i>
        </div>
        <div class="flex justify-between w-full items-center">
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Brands</span>
            <span class="text-sm rotate-180 hidden" id="arrow">
                <i class="bi bi-chevron-down"></i>
            </span>
        </div>
    </div>
    <div class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold" id="submenu">
        <h1 class="cursor-pointer p-2 hover:bg-yellow-600 rounded-md mt-1">
            Arno
        </h1>
        <h1 class="cursor-pointer p-2 hover:bg-yellow-600 rounded-md mt-1">
            Cabitech
        </h1>
        <h1 class="cursor-pointer p-2 hover:bg-yellow-600 rounded-md mt-1">
            Decoria
        </h1>
        <h1 class="cursor-pointer p-2 hover:bg-yellow-600 rounded-md mt-1">
            Sunpro
        </h1>
        <h1 class="cursor-pointer p-2 hover:bg-yellow-600 rounded-md mt-1">
            Turnils
        </h1>
    </div>
    <div class="p-2.5 mt-3 flex items-center rounded-md px-6 duration-300 cursor-pointer hover:bg-yellow-600 text-white" title="News & Blogs">
        <a href="/public/users/admin/cmsblogs.php" class="flex items-center cursor-pointer hover:bg-yellow-600 text-white" title="News & Blogs">
            <div class="tooltip tooltip-right" data-tip="News & Blogs">
                <i class="bi bi-bookmark-fill"></i>
            </div>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">News & Blogs</span>
        </a>
    </div>
    <div class="my-4 bg-gray-600 h-[1px]"></div>
    <a href="/backend/logout.php">
        <div class="p-2.5 mt-3 flex items-center rounded-md px-6 duration-300 cursor-pointer hover:bg-yellow-600 text-white" title="Logout">
            <div class="tooltip tooltip-right" data-tip="Logout">
                <i class="bi bi-box-arrow-in-right"></i>
            </div>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Logout</span>
        </div>
    </a>
</div>

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
    function dropdown() {
        document.querySelector("#submenu").classList.toggle("hidden");
        document.querySelector("#arrow").classList.toggle("rotate-0");
    }
    dropdown();

    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('minimized');
        document.querySelector("#toggle-sidebar i").classList.toggle("bg-gray-900");

        if (sidebar.classList.contains('minimized')) {
            sidebar.classList.remove('!w-80');
            document.querySelector("#arrow").classList.toggle("hidden");

        } else {
            sidebar.classList.add('!w-80');
            document.querySelector("#arrow").classList.toggle("hidden");
        }

        // Adjust main content padding when sidebar is toggled
        const mainContent = document.querySelector(".page-content");
        mainContent.classList.toggle("ml-20");
        mainContent.classList.toggle("ml-[400px]");
    }
</script>