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
            z-index: 10001;
            /* Ensure the button stays on top */
            position: relative;
        }

        #menu li a {
            display: block;
            /* Ensure each link occupies its own line */
            white-space: nowrap;
            /* Prevent wrapping of text */
            text-decoration: none;
            font-weight: bold;
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

        #mobileMenu {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background-color: black;
            z-index: 10000;
            /* Ensure it is on top of everything */
            padding: 40px 16px 16px 16px;
            /* Add padding for aesthetics */
        }

        #mobileMenu li {
            list-style: none;
            margin-bottom: 10px;
            /* Add margin between menu items */
        }

        #mobileMenu a {
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* Add padding for aesthetics */
        }

        .logo-container img {
            max-height: 80px;
            /* Adjust the height of the logo as needed */
        }
    </style>
</head>

<!-- Header -->
<header class="bg-black text-white p-2">
    <div class="container mx-auto">
        <nav class="p-2 flex justify-between">
            <div class="logo-container w-full justify-between">
                <a href="/public/home.php" class="logo-link flex items-center">
                    <img src="/assets/image/projectslogo.png" alt="Logo" class="logo-image">
                </a>
                <div class="md:hidden flex justify-end">
                    <button id="menuBtn">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
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
        </nav>
        <ul id="mobileMenu"></ul>
    </div>
</header>

<!-- Add this script before the closing </body> tag -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var menuBtn = document.getElementById('menuBtn');
        var menu = document.getElementById('menu');
        var mobileMenu = document.getElementById('mobileMenu');
        var navLinks = document.querySelectorAll('#menu > li > a');

        // Toggle the menu visibility when the button is clicked
        menuBtn.addEventListener('click', function() {
            if (mobileMenu.style.display === 'block') {
                mobileMenu.style.display = 'none';
            } else {
                createMobileMenu();
            }
        });

        // Create a list for mobile view
        function createMobileMenu() {
            // Check if the mobile menu list already exists
            if (mobileMenu.children.length === 0) {
                navLinks.forEach(function(link) {
                    var listItem = document.createElement('li');
                    listItem.appendChild(link.cloneNode(true));
                    mobileMenu.appendChild(listItem);
                });
            }
            mobileMenu.style.display = 'block';
        }
    });
</script>