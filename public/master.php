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

<<<<<<< HEAD
    <script defer src="include/app.js"></script>

<body class="bg-white">
    <!-- Header -->
    <?php
    // Determine the user's role
    // session_start();
    $userRole = $_SESSION['user_role'] ?? "guest"; // Default to 'guest' if the role is not set

    // Include appropriate navigation component based on user role
    if ($userRole == "guest") {
        include __DIR__ . "/include/navbar.php";
        if ($pageTitle == "Login") {
=======
    <body class="bg-white">
        <!-- Header -->
        <?php
        // Determine the user's role
        $userRole = $_SESSION['user_role'] ?? "guest";

        // Include appropriate navigation component based on user role
        if ($userRole == "guest") {
            if (isset($is_public_page) && $is_public_page) {
                include __DIR__ . "/include/navbar.php";

                echo "<main>";
                echo $content ?? "";
                
                if (!($pageTitle === "Login")) {
                    include __DIR__ . "/include/footer.php";
                } 
                echo "</main>";

            } else {
                // Redirect to login page
                header('Location: /public/login.php');
                exit();
            }
        } elseif (strtolower($userRole) == 'admin' || strtolower($userRole) == 'marketing') {
            include __DIR__ . "/include/sidebar.php";
>>>>>>> 4661dc7aca2329bb9f3afc4893590ae00373e1f6
            echo "<main>";
            echo $content ?? "";
            echo "</main>";
        }
    } elseif (strtolower($userRole) == 'admin' || strtolower($userRole) == 'marketing') {
        include __DIR__ . "/include/sidebar.php";
        echo "<main>";
        echo $content ?? "";
        echo "</main>";
    } else {
        include __DIR__ . "/include/footer.php";
    }

    ?>
</body>
<?php echo $script ?? "" ?>

<<<<<<< HEAD
=======
        ?>
    </body>
    <?php echo $script ?? "" ?>

>>>>>>> 4661dc7aca2329bb9f3afc4893590ae00373e1f6
</html>