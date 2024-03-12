<?php
$pageTitle = "Products - Office";
ob_start();
?>
<!-- Your page content goes here -->

<?php
$content = ob_get_clean();
include("../public/master.php");
?>
