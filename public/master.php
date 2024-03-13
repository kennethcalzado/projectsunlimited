<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $pageTitle ?? "Projects Unlimited" ?>
    </title>
    <!-- Link to your Tailwind CSS file -->
    <link href="../assets/input.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">
    <!-- Header -->
    <header class="bg-black text-white p-4">
        <div class="container mx-auto">
            <nav class="p-4">
                <div class="container mx-auto flex items-center justify-between">
                    <div>
                        <a href="#" class="logo-link"> <img src="../assets/image/projects.png" alt="Logo" class="logo-image"></a>
                    </div>
                    <div class="hidden md:flex space-x-4">
                        <ul class="flex space-x-4">
                            <li><a href="../public/home.php" class="text-white font-semibold">Home</a></li>
                            <li><a href="../public/about.php" class="text-white font-semibold">About Us</a></li>
                            <li><a href="../public/arno.php" class="text-white font-semibold">Brands</a></li>
                            <li><a href="../public/category.php" class="text-white font-semibold">Products</a></li>
                            <li><a href="../public/blogs.php" class="text-white font-semibold">Blogs</a></li>
                            <li><a href="../public/contact.php" class="text-white font-semibold">Contact</a></li>
                        </ul>
                    </div>
                    <div class="md:hidden">
                        <button class="text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <?php echo $content ?? "" ?>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-4">
        <div class="flex flex-col md:flex-row mx-16">
            <!-- Left Column -->
            <div class="md:w-1/2 py-4">
                <!-- Company Logo -->
                <div class="mb-4">
                    <img src="../assets/image/projects.png" alt="Projects Unlimited Logo" class="w-56 h-66">
                </div>
                <!-- Addresses -->
                <div class="mb-4 my-8">
                    <p class="font-bold  text-xl">HEAD OFFICE</p>
                    <p class=" text-xl">Address: 620 Tytana St., Binondo, Manila,
                        Philippines, 1006.</p>
                    <p class=" text-xl">Phone: +632 8243 8888-95</p>
                    <p class=" text-xl">E-mail: info@projectsunlimited.com.ph</p>
                </div>
                <div class="mb-4 my-8">
                    <p class="font-bold  text-xl">SHOWROOM</p>
                    <p class=" text-xl">Address: Unit 104 Skyway Twin Towers, Cpt. Henry Javier Street, Oranbo, Pasig, Philippines.</p>
                    <p class=" text-xl">Phone: +632 8671 5100</p>
                    <p class=" text-xl">E-mail: barcelon.projectsunlimited@yahoo.com</p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="md:w-1/2 p-16">
                <div class="mb-4 my-8">
                    <p class="font-bold  text-xl">BRANCH OFFICE</p>
                    <p class=" text-xl">Address: 36 Granada, Quezon City, Metro Manila</p>
                    <p class=" text-xl">Phone: +632 70028005</p>
                    <p class=" text-xl">E-mail: benita_cabral@yahoo.com</p>
                </div>
                <div class="mb-4 my-8">
                    <p class="font-bold  text-xl">OPENING HOURS</p>
                    <p class=" text-xl">MONDAY TO FRIDAY: 8am - 5pm</p>
                    <p class=" text-xl">SATURDAY: </p>
                    <p class=" text-xl">SUNDAY: CLOSED </p>
                </div>
            </div>
        </div>
        <div class="container mx-auto text-center">
            <div class="flex items-center justify-center mt-4">
                <p class="mr-2 text-lg">Follow Us:</p>
                <div class="flex space-x-4 text-xl">
                    <a href="https://www.facebook.com/projectsunlimitedph"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/projectsunlimitedph"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <p class="text-base"><i>Copyright &copy; 2024 Projects Unlimited Powered by Projects Unlimited</i></p>
        </div>

    </footer>


</body>

</html>