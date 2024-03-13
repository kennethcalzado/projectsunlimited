<?php
$pageTitle = "Products - Blinds";
ob_start();
?>
<div class="content">
    <div class="relative">
        <img src="../assets/image/blindsproduct.jpg" class="w-full h-96 object-cover object-top">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <p class="text-white font-extrabold text-3xl text-center">BLINDS<br></p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>
