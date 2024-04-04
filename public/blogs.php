<?php
$pageTitle = "News & Projects";
ob_start();
include("../backend/conn.php");

$sql = 'SELECT * FROM blogs ORDER BY date DESC';
$result = mysqli_query($conn, $sql);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/input.css">
    <style>
        .card-group {
            width: 250px;
            height: 330px;
            margin: 1%;
            display: inline-block;
            background-color: #D9D9D9;
            vertical-align: top;
            box-sizing: border-box;
            padding: 20px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .placeholder {
            width: 210px;
            height: 215px;
            background-color: black;
            margin: auto;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        /* Title styling */
        .title {
            font-weight: bold;
            color: black;
            position: relative;
            font-size: 16px;
            text-align: left;
        }

        .title::after {
            content: "";
            background-image: url('../assets/image/arrowgold.png');
            background-size: contain;
            width: 30px;
            height: 30px;
            position: absolute;
            top: 50%;
            right: -10px;
            transform: translateY(-50%);
            background-repeat: no-repeat;
            transition: background-image 0.3s ease;
        }

        .card-group:hover {
            background-color: #F6E381;
        }

        .card-group:hover .title::after {
            background-image: url('../assets/image/arrowblack.png');
        }

        .date {
            font-size: 19px;
            color: black;
            margin-bottom: 5px;
        }

        .thumbnail {
            max-width: auto;
            max-height: auto;
            position: absolute;
            z-index: 2;
            border: 10px solid black;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        @media (max-width: 768px) {
            .card {
                width: 48%;
            }
        }

        @media (max-width: 480px) {
            .card {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <section>
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
            <h1 style="padding-top: 25px; font-size: 38px; font-weight: 800; margin: 0;">NEWS & PROJECTS</h1>

            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="categoryFilter" class="mr-2">Filter by Category</label>
                <select id="categoryFilter" class="border rounded-md px-2 py-1">
                    <option value="">All Categories</option>
                    <option value="News">News & Updates</option>
                    <option value="Projects">Projects</option>
                </select>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#categoryFilter').change(function() {
                    var selectedCategory = $(this).val();

                    $('.card-group').hide(); // Hide all card-groups

                    if (selectedCategory === '') {
                        $('.card-group').show(); // Show all card-groups if no category selected
                    } else {
                        $('.card-group[data-category="' + selectedCategory + '"]').show(); // Show card-groups with selected category
                    }
                });
            });
        </script>

        <section style="padding-top: 20px; padding-bottom: 90px;">
            <div class="container mx-auto">
                <?php
                $counter = 0; // Initialize counter variable
                $itemsPerRow = 4; // Number of items per row
                $totalItems = mysqli_num_rows($result); // Total number of items

                if ($totalItems > 0) {
                    // Generate the first background div
                    echo '<div class="w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div>';

                    echo '<div class="flex flex-wrap justify-center items-center">'; // Start flex container and center items
                    // Loop through each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Output card HTML dynamically with data from the database
                        echo '
                <div class="card-group z-10" data-category="' . $row['type'] . '">
                    <a href="' . $row['page'] . '" class="card-link">
                        <div class="date">' . $row['date'] . '</div>
                        <div class="placeholder">
                            <img src="../assets/blogs_img/' . $row['thumbnail'] . '" alt="Thumbnail" class="thumbnail">
                        </div>
                        <div class="title">' . $row['title'] . '</div>
                    </a>
                </div>';

                        // Increment the counter
                        $counter++;

                        // Check if the current item is the last one or if the next item will start a new row
                        if ($counter % $itemsPerRow == 0 || $counter == $totalItems) {
                            // Check if it's not the last item and there are enough items to complete another row
                            if ($counter != $totalItems && $totalItems - $counter >= $itemsPerRow) {
                                echo '<div class="w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div><div class="flex flex-wrap justify-center items-center">';
                            }
                        }
                    }
                    echo '</div>'; // Close flex container
                } else {
                    echo "No blogs found.";
                }
                ?>
            </div>
        </section>
</body>



<?php
$content = ob_get_clean();
include("../public/master.php");
?>