<?php
// Define your base URL dynamically
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/'; // Example: http://localhost/

// Concatenate the base URL with the image path
$image_path = $base_url . 'assets/image/projectslogo.png';

?>

<div id="sidebar-container" class="sidebar minimized fixed top-0 bottom-0 lg:left-0 p-2 w-[80px] 
     text-center bg-black text-white transition-all z-50">

    <div class="text-gray-100 text-xl flex justify-between">
        <span id="toggle-sidebar" class="absolute text-white text-4xl top-4 !ml-2 mt-1 z-40 cursor-pointer burger"
            onclick="toggleSidebar()">
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
                    pr-5 py-[8.5px] m-4 mx-auto w-20 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[40%] -translate-y-[59%] opacity-0">Home</span>
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
                    left-1/2 translate-x-[40%] -translate-y-[58.5%] opacity-0">Users</span>
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
                <i class="bi bi-box2-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Products</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.7px] m-4 mx-auto w-20 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[40%] -translate-y-[61.3%] opacity-0">Products</span>
            </div>
            <!-- <span class="text-[15px] ml-4 text-center text-gray-200 font-bold">Home</span> -->
        </div>
    </a>

    <!-- <div class="p-2.5 mt-3 flex items-center rounded-md px-6 duration-300 cursor-pointer hover:bg-yellow-600 text-white"
        onclick="dropdown()" title="Brands">
        <div class="tooltip tooltip-right" data-tip="Brands">
            <i class="bi bi-chat-left-text-fill"></i>
        </div>
        <div class="flex justify-between w-full items-center">
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Brands</span>
            <span class="text-sm rotate-180 hidden" id="arrow">
                <i class="bi bi-chevron-down"></i>
            </span>
        </div>
    </div> -->

    <div>
        <a href="/public/users/brands-display.php" class="group">
            <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">
                <div class="flex relative ">
                <!-- <i class="bi bi-chat-left-text-fill"></i>  -->
                    <i class="fa-solid fa-handshake py-1"></i>
                    <span class="text-[15px] ml-4 text-gray-200 font-bold">Brands</span>
                    <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.96px] m-4 mx-auto w-20 
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

    <a href="/public/users/admin/cmsblogs.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">

            <div class=" flex relative ">
                <i class="bi bi-bookmark-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">News & Blogs</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[8.5px] m-4 mx-auto w-32 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[20%] -translate-y-[59%] opacity-0">News & Blogs</span>
            </div>
        </div>
    </a>

    <div class="my-4 bg-gray-600 h-[1px]"></div>

    <a href="/backend/logout.php" class="group">
        <div class="nav-item mt-3 flex items-center rounded-l-md px-6 p-2
            transition-opacity duration-300 cursor-pointer text-white group-hover:bg-yellow-600 group-hover:ease-in">

            <div class=" flex relative ">
                <i class="bi bi-box-arrow-in-right"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Logout</span>
                <span class="tootlips 
                    group-hover:ease-in group-hover:opacity-100 group-hover:visible 
                    transition-opacity duration-300 
                    bg-yellow-600 rounded-r-md 
                    pr-5 py-[9px] m-4 mx-auto w-32 
                    text-[15px] font-bold text-white 
                    absolute  invisible
                    left-1/2 translate-x-[20%] -translate-y-[60.54%] opacity-0">Logout</span>
            </div>
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
    function dropdown ()
    {
        document.querySelector( "#submenu" ).classList.toggle( "hidden" );
        document.querySelector( "#arrow" ).classList.toggle( "rotate-0" );
    }
    dropdown();

    function toggleSidebar ()
    {
        const sidebar = document.querySelector( '.sidebar' );
        sidebar.classList.toggle( 'minimized' );

        if ( sidebar.classList.contains( 'minimized' ) )
        {
            sidebar.classList.remove( '!w-80' );
            document.querySelector( "#arrow" ).classList.toggle( "hidden" );
            document.querySelector( "#submenu" ).classList.toggle( "hidden" );
            document.querySelector( "#sidebar-container" ).classList.toggle( "overflow-y-auto" );
            // Iterate over each element with class "nav-item" and apply the class toggle
            document.querySelectorAll( ".nav-item" ).forEach( function ( navItem )
            {
                navItem.classList.toggle( "rounded-l-md" );
                navItem.classList.toggle( "rounded-md" );
            } );
            // Iterate over each element with class "tootlips" and apply the class toggle
            document.querySelectorAll( ".tootlips" ).forEach( function ( tooltip )
            {
                tooltip.classList.toggle( "hidden" );
            } );
        } else
        {
            sidebar.classList.add( '!w-80' );
            document.querySelector( "#arrow" ).classList.toggle( "hidden" );
            document.querySelector( "#submenu" ).classList.toggle( "hidden" );
            // Iterate over each element with class "nav-item" and apply the class toggle
            document.querySelectorAll( ".nav-item" ).forEach( function ( navItem )
            {
                navItem.classList.toggle( "rounded-l-md" );
                navItem.classList.toggle( "rounded-md" );
            } );
            // Iterate over each element with class "tootlips" and apply the class toggle
            document.querySelectorAll( ".tootlips" ).forEach( function ( tooltip )
            {
                tooltip.classList.toggle( "hidden" );
            } );
            document.querySelector( "#sidebar-container" ).classList.toggle( "overflow-y-auto" );
        }

        // Adjust main content padding when sidebar is toggled
        const mainContent = document.querySelector( ".page-content" );
        mainContent.classList.toggle( "!ml-[400px]" );
    }
</script>

<script>
    $( document ).ready( function ()
    {
        $.ajax( {
            url: '../../../backend/brands/brands-get.php',
            type: 'GET',
            dataType: 'json',
            success: function ( brands )
            {
                // Render brand data
                const submenu = $( '#submenu' );

                brands.forEach( function ( brand )
                {
                    submenu.append( $( '<h1>' ).text( brand.brand_name ).addClass( 'cursor-pointer p-2 hover:bg-yellow-600 rounded-md mt-1' ) );
                } );
            },
            error: function ( xhr, status, error )
            {
                console.error( 'Error:', error );
            }
        } );
    } );
</script>