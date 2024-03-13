<?php
$pageTitle = "Products - Blinds";
ob_start();
?>
<div class="content">
    <div class="relative">
        <img src="../assets/image/blindsproduct.jpg" class="w-full h-96 object-cover object-top">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-end text-center">
            <p class="text-white font-extrabold text-3xl mr-8">BLINDS<br>
            <span class="text-white font-semibold text-xl mr-5 mt-2">100 items</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>
