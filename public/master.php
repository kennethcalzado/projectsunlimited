<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <!-- Link to your Tailwind CSS file -->
    <link href="styles.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold">My Website</h1>
            <nav class="bg-yellow-400 p-4">
                <div class="container mx-auto flex items-center justify-between">
                    <div>
                        <a href="#" class="text-white text-xl font-bold">Logo</a>
                    </div>
                    <div class="hidden md:flex space-x-4">
                        <ul class="flex space-x-4">
                            <li><a href="#" class="text-white">Home</a></li>
                            <li><a href="#" class="text-white">Services</a></li>
                            <li><a href="#" class="text-white">About</a></li>
                            <li><a href="#" class="text-white">Contact</a></li>
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

    <!-- Main Content -->
    <main class="container mx-auto mt-4">
        <!-- Placeholder for page-specific content -->
        <div id="content">
            <!-- Page-specific content will be inserted here -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto text-center">
            &copy; 2024 My Website. All rights reserved.
        </div>
    </footer>

</body>

</html>
