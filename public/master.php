<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $pageTitle . " - Projects Unlimited" ?>
    </title>
    <!-- Link to your Tailwind CSS file -->
    <link href="../assets/input.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">
    <!-- Header -->
    <?php
    // Determine the user's role
    // session_start();
    $userRole = $_SESSION['user_role'] ?? "guest"; // Default to 'guest' if the role is not set

    // Include appropriate navigation component based on user role
    if ($userRole == "guest") {
        include __DIR__ . "/include/navbar.php";
        // Include footer for guests
        include __DIR__ . "/include/footer.php";
    } elseif ($userRole == 'Admin' || $userRole == 'Marketing') {
        include __DIR__ . "/include/sidebar.php";
        echo "<main>";
        echo $content ?? "";
        echo "</main>";
    }
    ?>


</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?php echo $script ?? "" ?>

</html>