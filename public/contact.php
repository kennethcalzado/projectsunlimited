<?php
$pageTitle = "Contact Us";
ob_start();
?>
<div class="content">
<div class="relative">
        <img src="../assets/image/contactus.png" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-center">
    <p class="text-[#F6E381] font-bold text-4xl">GET IN TOUCH WITH <br> PROJECTS UNLIMITED</p>
</div>
    </div>
</div>
<?php
$content = ob_get_clean();
include("../public/master.php");
?>
