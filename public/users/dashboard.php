<?php
session_start();

$pageTitle = $_SESSION['user_role'] . " Dashboard";
ob_start();
?>
<div class="page-content ml-[100px] transition-all duration-300">
    <h1 class="text-3xl font-bold mb-8">Welcome to the
        <?php echo $_SESSION['user_role']; ?> Dashboard
    </h1>
    <!-- Sample Content -->
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-lg font-semibold mb-4">Total Users</div>
                <p class="text-gray-700">There are currently 1000 registered users.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-lg font-semibold mb-4">Total Products</div>
                <p class="text-gray-700">There are 500 products in the inventory.</p>
            </div> -->
        </div>
    </div>

    <!-- component -->
    <div class="flex flex-row items-center">
        <div class='flex flex-col justify-center items-center'>
            <div class='bg-zinc-900 h-4 w-8 rounded-t-md'></div>
            <div class='w-12 h-60 bg-yellow-600 rounded-t-md'></div>
            <div class='w-12 h-2 bg-sky-900 rounded-t-full -mt-2'></div>
            <div class='bg-zinc-900 h-4 w-8 rounded-b-md'></div>
        </div>
        <div class=' box-content relative h-52 w-[1200px] relative border-yellow-600 
        border-8 slide-ltr sliding-ltr flex flex-row ease'>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-lg font-semibold mb-4">Total Users</div>
                <p class="text-gray-700">There are currently 1000 registered users.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-lg font-semibold mb-4">Total Users</div>
                <p class="text-gray-700">There are currently 1000 registered users.</p>
            </div>
        </div>

    </div>

    <style>
        .ease {
            animation-timing-function: ease;
        }

        .slide-ltr {
            clip-path: polygon(100% 0, 100% 100%, 100% 100%, 100% 0);
        }

        .sliding-ltr {
            animation-name: sliding-ltr;
            animation-duration: 1s;
            animation-fill-mode: forwards;
            animation-delay: 0.5s;
        }

        @keyframes sliding-ltr {
            0% {
                transform: translateX(-100%);
                clip-path: polygon(100% 0, 100% 100%, 100% 100%, 100% 0);
            }

            100% {
                transform: translateX(-0.5%);
                clip-path: polygon(100% 0, 100% 100%, 0% 100%, 0 0);
            }
        }
    </style>
</div>



<?php $content = ob_get_clean();
ob_start();
?>

<?php
$script = ob_get_clean();
include ("../../public/master.php");
?>