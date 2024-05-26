<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $pageTitle . " - Projects Unlimited" ?>
    </title>
    <!-- Link to your Tailwind CSS file -->
    <!-- <link href="../assets/input.css" rel="stylesheet"> -->
    <!-- Favicon for website -->
    <link rel="icon" href="../assets/image/PUlogo.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="/assets/input.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!--Sweet Alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Data Tables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>

    <script defer src="include/app.js"></script>

<body>
    <!-- Header -->
    <?php
    // Determine the user's role
    $userRole = $_SESSION['user_role'] ?? "guest";

    if ($userRole == "guest") {
        if (isset($is_public_page) && $is_public_page) {
            include __DIR__ . "/include/navbar.php";
            echo "<main>";
            echo $content ?? "";

            if (!($pageTitle === "Login")) {
                if (!isset($is_blog) || !$is_blog) {
                    include __DIR__ . "/include/footer.php";
                }
            }

            echo "</main>";
        } else {
            // Redirect to login page
            header('Location: /public/login.php');
            exit();
        }
    } elseif (strtolower($userRole) == 'admin' || strtolower($userRole) == 'marketing') {
        include __DIR__ . "/include/sidebar.php";
        echo "<main>";
        echo $content ?? "";
        echo "</main>";
    }
    ?>
</body>
<?php echo $script ?? "" ?>

</html>