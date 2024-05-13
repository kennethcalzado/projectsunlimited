<?php
$is_public_page = true;
    $pageTitle = "Products - Projects Unlimited";
    ob_start();
    ?>
    <style>
        #productModal {
            width: 100%;
            height: 100%;
            z-index: 1000;
        }
        .modal-content {
            width: 90%;
            max-width: 800px;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999i;
        }
        body.modal-open {
            overflow: hidden;
        }
    </style>
    <div class="content">
        <div class="relative">
            <img src="../assets/catheader/lhtqjazuprq-breather.jpg" class="w-full h-96 object-cover object-top">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 flex items-center justify-center text-center">
                <p class="text-white font-extrabold text-4xl">BLINDS<br></p>
            </div>
        </div>
        <header class="bg-[#F6E381]">
        </header>
    </div>
    <?php
    $content = ob_get_clean();
    include ("../public/master.php");
    ?>