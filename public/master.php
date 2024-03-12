<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php echo $pageTitle ?? "Projects Unlimited" ?>
        </title>
        <!-- Link to your Tailwind CSS file -->
        <link href="../assets/output.css" rel="stylesheet">
    </head>

<body class="bg-gray-100">
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
        <div class="container mx-auto text-center">
           <i> Copyright &copy; 2024 Projects Unlimited Powered by Projects Unlimited </i>
        </div>
    </footer>

    </body>
</html>