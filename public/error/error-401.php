<?php
$pageTitle = "Error 401";
ob_start();
?>
<!-- Your page content goes here -->
<div class="bg-gray-100 flex flex-col justify-center items-center w-screen h-screen bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-9xl font-bold text-red-600 mb-4">Error 401</h1>
    <p class="text-lg text-gray-800 mb-4">Unauthorized Access</p>
    <p class="text-gray-600">Sorry, you are not authorized to access this page. Please contact the administrator for
        assistance.</p>
    <a href="/public\home.php" class="text-blue-600 mt-4 inline-block">Go to Homepage</a>
</div>

<?php
$content = ob_get_clean();
include("../../public/master.php");
?>