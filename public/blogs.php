<?php
$pageTitle = "News & Projects";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/input.css">

    <style>
        .card {
            width: 300px;
            /* Set fixed width */
            height: 400px;
            /* Set fixed height */
        }
    </style>
</head>

<body>
    <section>
        <div class="content">
            <div class="relative">
                <img src="../assets/image/blogbanner.png" class="w-full h-96 object-cover">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <p class="text-white font-bold text-4xl text-center">STAY UPDATED WITH <br> <span class="text-[#F6E381]">PROJECTS UNLIMITED</span></p>
                </div>
            </div>
        </div>
    </section>

    <div style="width: 100%; text-align: center;">
        <h1 style="font-size: 38px; font-weight: 800; margin: 0;">NEWS & PROJECTS</h1>
    </div>

    <section style="padding-top: 20px; padding-bottom: 90px;">
        <div class="container mx-auto flex flex-wrap justify-center">
            <?php
            include("../backend/conn.php");

            $sql = 'SELECT * FROM blogs ORDER BY date DESC';
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $count = 0; // Counter to track the number of cards in the current row
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="card bg-white rounded-xl overflow-hidden shadow-md m-4">
                        <div class="bg-gray-200 h-32">
                            <p class="text-center pt-2"><?php echo $row['date']; ?></p>
                        </div>
                        <img src="../assets/blogs_img/<?php echo $row['thumbnail']; ?>" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-xl font-bold"><?php echo $row['title']; ?></h2>
                            <div class="flex justify-end">
                                <a href="#" class="text-[#F6E381]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                    $count++;
                    // If 4 cards have been displayed in the current row, start a new row
                    if ($count % 4 == 0) {
                        echo '</div><div class="container mx-auto flex flex-wrap justify-center">';
                    }
                }
            } else {
                echo "<p class='text-center'>No records found</p>";
            }
            ?>
        </div>
    </section>

</body>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>