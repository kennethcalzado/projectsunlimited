<?php
session_start();
$pageTitle = ucfirst($_SESSION['user_role']) . " Dashboard";
ob_start();

include("../../backend/conn.php");

// Determine the user's role
$userRole = $_SESSION['user_role'];

// Query to count the number of users
$query = "SELECT COUNT(*) AS total_users FROM users";
$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch the total number of users
    $row = mysqli_fetch_assoc($result);
    $total_users = $row['total_users'];
} else {
    // Handle error if query fails
    $total_users = "N/A";
}

// Query to count the number of users
$query = "SELECT COUNT(*) AS total_products FROM product";
$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch the total number of users
    $row = mysqli_fetch_assoc($result);
    $total_products = $row['total_products'];
} else {
    // Handle error if query fails
    $total_users = "N/A";
}

// Query to count the number of users
$query = "SELECT COUNT(*) AS total_brands FROM brands";
$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch the total number of users
    $row = mysqli_fetch_assoc($result);
    $total_brands = $row['total_brands'];
} else {
    // Handle error if query fails
    $total_users = "N/A";
}

// Query to count the number of users
$query = "SELECT COUNT(*) AS total_categories FROM productcategory";
$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch the total number of users
    $row = mysqli_fetch_assoc($result);
    $total_categories = $row['total_categories'];
} else {
    // Handle error if query fails
    $total_users = "N/A";
}

// Query to count the number of users
$query = "SELECT COUNT(*) AS total_locations FROM locations";
$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch the total number of users
    $row = mysqli_fetch_assoc($result);
    $total_locations = $row['total_locations'];
} else {
    // Handle error if query fails
    $total_users = "N/A";
}

// Query to count the number of users
$query = "SELECT COUNT(*) AS total_blogs FROM blogs";
$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch the total number of users
    $row = mysqli_fetch_assoc($result);
    $total_blogs = $row['total_blogs'];
} else {
    // Handle error if query fails
    $total_users = "N/A";
}


?>

<head>
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../../assets/input.css">

    <style>
        /* Table styling */
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            border: 1px solid #dddddd;
            /* Add border around the tables */
            border-radius: 10px;
            /* Add border radius */
        }

        th,
        td {
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #F6E17A;
        }

        /* Add border between rows */
        tr {
            border-bottom: 1px solid #dddddd;
        }

        .table-container {
            width: 48%;
            padding-right: 20px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: black;
            border-top-left-radius: 10px;
            /* Add border radius */
            border-top-right-radius: 10px;
            /* Add border radius */
        }

        .table-header h2 {
            margin: 0;
            color: white;
            font-weight: bold;
            padding-left: 10px;
        }

        tr:hover {
            background-color: #f5f4f4;
            /* Gray */
        }

        tr.dark:hover {
            background-color: #f5f4f4;
            /* Off White */
        }

        p {
            font-size: 27px !important;
        }

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

        .description-column {
            max-width: 200px;
            /* Adjust the maximum width as needed */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
</head>

<body>
    <div class="page-content ml-[100px] transition-all duration-300">
        <br><br>
        <h1 style="text-align: center;" class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">
            <?php echo ucfirst($_SESSION['user_role']); ?> Dashboard
        </h1>
        <!-- component -->
        <div style="padding-right: 20px; padding-left: 20px;" class="flex flex-row items-center">
            <div class='flex flex-col justify-center items-center'>
                <div class='bg-black h-2 w-8 rounded-t-md'></div> <!-- Change color to F6E17A -->
                <div class='w-12 h-40 bg-black rounded-t-md'></div> <!-- Change color to gray -->
                <div class='w-12 h-2 bg-gray-600 rounded-t-full -mt-2'></div> <!-- Change color to white -->
                <div class='bg-black h-2 w-8 rounded-b-md'></div> <!-- Change color to black -->
            </div>
            <div style="padding-right: 10px;" class='box-content relative h-36 w-full relative border-gray-600 border-8 slide-ltr sliding-ltr flex flex-row ease justify-center'>
                <div class="rounded-lg shadow-md p-4">
                    <!-- Image -->
                    <img src="../../assets/image/PUlogo.png" alt="Dashboard Image" style="height: auto; width: 110px;">
                </div>
                <div class="rounded-lg shadow-md p-7">
                    <div class="text-lg mb-4">
                        <i class="bi bi-people-fill"></i> Total Users
                    </div>
                    <p class="text-black"><?php echo $total_users; ?> administrators</p>
                </div>
                <div class="rounded-lg shadow-md p-7">
                    <div class="text-lg mb-4">
                        <i class="bi bi-box-seam"></i> Total Products
                    </div>
                    <p class="text-black"><?php echo $total_products; ?> products</p>
                </div>
                <div class="rounded-lg shadow-md p-7">
                    <div class="text-lg mb-4">
                        <i class="bi bi-tag-fill"></i> Total Brands
                    </div>
                    <p class="text-black"><?php echo $total_brands; ?> brands</p>
                </div>
                <div class="rounded-lg shadow-md p-7">
                    <div class="text-lg mb-4">
                        <i class="bi bi-folder-fill"></i> Total Categories
                    </div>
                    <p class="text-black"><?php echo $total_categories; ?> categories</p>
                </div>
                <div class="rounded-lg shadow-md p-7">
                    <div class="text-lg mb-4">
                        <i class="bi bi-geo-alt-fill"></i> Total Branches
                    </div>
                    <p class="text-black"><?php echo $total_locations; ?> branches</p>
                </div>
                <div class="rounded-lg shadow-md p-7">
                    <div class="text-lg mb-4">
                        <i class="bi bi-newspaper"></i> Total Blogs
                    </div>
                    <p class="text-black"><?php echo $total_blogs; ?> blogs</p>
                </div>
            </div>
        </div>
        <br>
        <div style="display: flex; justify-content: space-around;">
            <div class="table-container">
                <div class="table-header">
                    <h2>Products</h2>
                    <a href="/public/users/admin/admin-products.php" class="yellow-btn">View</a>
                </div>
                <table id="logsTable" class="display">
                    <thead>
                        <th scope="col" class="px-6 py-3 w-1/12">Product Name</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Description</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Availability</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Status</th>
                    </thead>

                    <tbody>
                        <?php
                        $sql = 'SELECT * FROM product ORDER BY created_at DESC LIMIT 3';
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['ProductName']; ?></td>
                                    <td><?php echo $row['Description']; ?></td>
                                    <td><?php echo $row['availability']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h2>Product Categories</h2>
                    <a href="/public/users/admin/admin-category.php" class="yellow-btn">View</a>
                </div>
                <table id="logsTable" class="display">
                    <thead>
                        <th scope="col" class="px-6 py-3 w-1/12">Category Name</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Type</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Status</th>
                    </thead>

                    <tbody>
                        <?php
                        $sql = 'SELECT * FROM productcategory ORDER BY created_at DESC LIMIT 3';
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['CategoryName']; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div style="display: flex; justify-content: space-around; padding-bottom: 40px;">
            <div class="table-container">
                <div class="table-header">
                    <h2>Users</h2>
                    <?php if ($userRole == 'admin') : ?>
                        <a href="/public/users/admin/users-table.php" class="yellow-btn">View</a>
                    <?php endif; ?>
                </div>
                <table id="usersTable" class="display">
                    <thead>
                        <th scope="col" class="px-6 py-3 w-1/12">Name</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Role</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Email</th>
                    </thead>

                    <tbody>
                        <?php
                        $sql = 'SELECT * FROM users ORDER BY created_at DESC LIMIT 3';
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['fname'], ' ', $row['lname']; ?></td>
                                    <td><?php echo $row['role_id']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h2>Brands</h2>
                    <a href="/public/users/brands-display.php" class="yellow-btn">View</a>
                </div>
                <table id="usersTable" class="display">
                    <thead>
                        <th scope="col" class="px-6 py-3 w-1/12">Brand Name</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Description</th>
                        <th scope="col" class="px-6 py-3 w-1/12">Status</th>
                    </thead>

                    <tbody>
                        <?php
                        $sql = 'SELECT * FROM brands ORDER BY created_at DESC LIMIT 3';
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['brand_name']; ?></td>
                                    <td class="description-column"><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>



<?php $content = ob_get_clean();
ob_start();
?>

<?php
$script = ob_get_clean();
include("../../public/master.php");
?>