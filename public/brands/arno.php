<?php
$pageTitle = "Home";
ob_start();
?>
<!-- Your page content goes here -->
<div id="content">
    
</div>
<?php
$content = ob_get_clean();
include("layout.php");
?>
