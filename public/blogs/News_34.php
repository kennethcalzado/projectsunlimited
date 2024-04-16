<?php
$pageTitle = 'Projects Unlimited';
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../../../assets/input.css">
</head>

<body>
    <!-- Your HTML content goes here -->
</body>

</html>

<?php
$content = ob_get_clean();
include("../master.php");
?>