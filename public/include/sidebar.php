<span class="absolute text-white text-4xl top-1/2 left-4 cursor-pointer" onclick="openSidebar()">
    <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
</span>

<div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-black text-white ">
    <div class="text-gray-100 text-xl">
        <div class="p-2.5 mt-1 flex items-center">
            <img src="../../assets\image\projects.png" class="h-[35px] w-auto">
            <i class="bi bi-x cursor-pointer ml-24" onclick="openSidebar()"></i>
        </div>
        <div class="my-2 bg-gray-600 h-[1px]"></div>
    </div>
    <div
        class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-yellow-600 text-white">
        <i class="bi bi-house-door-fill"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Home</span>
    </div>
    <?php
    // Determine the user's role
    $userRole = $_SESSION['user_role'] ?? "guest"; // Default to 'guest' if the role is not set
    
    // Include appropriate navigation component based on user role
    if ($userRole == '1') { ?>
        <div
            class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-yellow-600 text-white">
            <i class="bi bi-bookmark-fill"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Users</span>
        </div>
    <?php } ?>
    <div
        class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-yellow-600 text-white">
        <i class="bi bi-bookmark-fill"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Products</span>
    </div>
    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-yellow-600 text-white"
        onclick="dropdown()">
        <i class="bi bi-chat-left-text-fill"></i>
        <div class="flex justify-between w-full items-center">
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Brands</span>
            <span class="text-sm rotate-180" id="arrow">
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
    <div
        class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-yellow-600 text-white">
        <i class="bi bi-bookmark-fill"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">News & Blogs</span>
    </div>
    <div class="my-4 bg-gray-600 h-[1px]"></div>
    <div
        class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-yellow-600 text-white">
        <a href="../../backend/logout.php">
            <i class="bi bi-box-arrow-in-right"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Logout</span>
        </a>
    </div>
</div>

<script type="text/javascript">
    function dropdown ()
    {
        document.querySelector( "#submenu" ).classList.toggle( "hidden" );
        document.querySelector( "#arrow" ).classList.toggle( "rotate-0" );
    }
    dropdown();

    function openSidebar ()
    {
        const sidebar = document.querySelector( ".sidebar" );
        sidebar.classList.toggle( "hidden" );

        // Adjust main content padding when sidebar is toggled
        const mainContent = document.querySelector( ".page-content" );
        mainContent.classList.toggle( "ml-[300px]" );

        // Toggle transition effect for smooth animation
        setTimeout( () =>
        {
            mainContent.classList.toggle( "transition-all" );
        }, 50 );
    }
</script>