<?php
session_start();
$pageTitle = "Profile";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <link rel="stylesheet" href="../../assets/input.css">
</head>

<section>
    <div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20">
        <div style="padding-top: 15px; padding-bottom: 15px;" class="container">
</section>


<?php
$script = ob_get_clean();
include("../../public/master.php");
include("../../backend/conn.php");
?>