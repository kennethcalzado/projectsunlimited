<?php
$pageTitle = "Home";
ob_start();
?>

<body>
    <section>
        <div class="content">
            <div class="relative">
                <img src="../assets/image/blogbanner.png" class="w-full h-96 object-cover">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <p class="text-white font-bold text-4xl text-center">STAY UPDATED WITH <br> <span class="text-[#F6E381]">PROJECTS UNLIMITED</span></p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top: 20px; padding-bottom: 90px;">
        <div style="width: 100%; text-align: center;">
            <h1 style="font-size: 38px; font-weight: 800; margin: 0;">NEWS & PROJECTS</h1>
        </div>
    </section>


</body>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>