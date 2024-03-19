<?php
session_start();
$pageTitle = "Products";
ob_start();
?>

<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">Products</h1>
    </div>
    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div>
</div>

<?php
$content = ob_get_clean();
include ("../../../public/master.php");
include ("../../../backend/conn.php");
?>