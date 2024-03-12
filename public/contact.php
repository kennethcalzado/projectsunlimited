<?php
$pageTitle = "Contact Us";
ob_start();
?>
<div class="content">
<div class="relative">
        <img src="../assets/image/contactus.png" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>
</div>
<?php
$content = ob_get_clean();
include("../public/master.php");
?>
