<?php
$pageTitle = "Error 404";
ob_start();
?>
<!-- Your page content goes here -->
<div class="bg-gray-100 flex flex-col justify-center items-center max-w-lg h-screen bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-4xl font-bold text-red-600 mb-4">Error 404</h1>
    <p class="text-lg text-gray-800 mb-4">Page Not Found</p>
    <p class="text-gray-600">Sorry, the page you are looking for could not be found. Please check the URL and try again.
    </p>
    <a href="/" class="text-blue-600 mt-4 inline-block">Go to Homepage</a>
</div>

<?php
$content = ob_get_clean();
include("../../public/master.php");
?>