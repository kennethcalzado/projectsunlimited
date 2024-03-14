<?php
session_start();
$pageTitle = $_SESSION['user_role'] . " Dashboard";
ob_start();
?>
<div class="page-content ml-[300px] transition-all duration-300">
    <h1 class="text-3xl font-bold mb-8">Welcome to the
        <?php echo $_SESSION['user_role']; ?> Dashboard
    </h1>
    <!-- Sample Content -->
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-lg font-semibold mb-4">Total Users</div>
                <p class="text-gray-700">There are currently 1000 registered users.</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-lg font-semibold mb-4">Total Products</div>
                <p class="text-gray-700">There are 500 products in the inventory.</p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include("../../public/master.php");
?>