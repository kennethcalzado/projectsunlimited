<head>
    <style>
        /* Mobile menu */
        #menu {
            display: none;
            /* Hide the menu by default */
        }

        #menuBtn {
            display: block;
            /* Display the button for mobile */
        }

        @media screen and (min-width: 768px) {

            /* Display the menu when the screen size is 768px or larger */
            #menu {
                display: flex;
            }

            #menuBtn {
                display: none;
                /* Hide the button on larger screens */
            }
        }
    </style>

    <!-- Add this script before the closing </body> tag -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var menuBtn = document.getElementById('menuBtn');
            var menu = document.getElementById('menu');
            var navLinks = document.querySelectorAll('#menu > li > a');

            // Toggle the menu visibility when the button is clicked
            menuBtn.addEventListener('click', function() {
                if (menu.style.display === 'flex') {
                    menu.style.display = 'none';
                    // Hide the desktop navbar explicitly
                    menu.classList.remove('show-desktop');
                } else {
                    menu.style.display = 'flex';
                    // If menu is displayed, create a list for mobile view
                    createMobileMenu();
                }
            });

            // Create a list for mobile view
            function createMobileMenu() {
                // Check if the mobile menu list already exists
                var mobileMenu = document.getElementById('mobileMenu');
                if (!mobileMenu) {
                    mobileMenu = document.createElement('ul');
                    mobileMenu.id = 'mobileMenu';
                    // Clone the navigation links from the original menu
                    navLinks.forEach(function(link) {
                        var listItem = document.createElement('li');
                        listItem.appendChild(link.cloneNode(true));
                        mobileMenu.appendChild(listItem);
                    });
                    // Append the mobile menu list to the navbar container
                    menu.parentNode.appendChild(mobileMenu);
                }
            }
        });
    </script>

</head>

<!-- Header -->
<header class="bg-black text-white p-4">
    <div class="container mx-auto">
        <nav class="p-2 flex items-center justify-between">
            <div>
                <a href="/public/home.php" class="logo-link flex items-center">
                    <img src="/assets/image/projectslogo.png" alt="Logo" class="logo-image">
                </a>
            </div>
            <div class="md:flex space-x-4 items-center">
                <ul class="flex space-x-4 items-center" id="menu">
                    <li><a href="/public/home.php" class="text-white font-bold hover:text-[#F6E381]">Home</a></li>
                    <li><a href="/public/about.php" class="text-white font-bold hover:text-[#F6E381]">About Us</a></li>
                    <li><a href="/public/brands.php" class="text-white font-bold hover:text-[#F6E381]">Brands</a></li>
                    <li><a href="/public/category.php" class="text-white font-bold hover:text-[#F6E381]">Products</a></li>
                    <li><a href="/public/blogs.php" class="text-white font-bold hover:text-[#F6E381]">Blogs</a></li>
                    <li>
                        <a href="/public/contact.php" class="rounded-full bg-[#F6E381] text-black font-bold flex items-center justify-center px-4 py-2 hover:bg-[#D7CB79]">
                            <i class="fas fa-phone-alt mr-2"></i>
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button class="text-white" id="menuBtn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </div>
</header>