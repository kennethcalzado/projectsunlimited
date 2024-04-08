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

    <!-- Your existing head content -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize pagination when the page loads
            fetchData('', 'new');

            // Change event handlers for filters
            $('#categoryFilter, #sortFilter').change(function() {
                var selectedCategory = $('#categoryFilter').val();
                var sortOption = $('#sortFilter').val();

                // Check if "All Categories" is selected and adjust the category parameter accordingly
                if (selectedCategory === "All Categories") {
                    selectedCategory = null; // or any other indicator
                }

                fetchData(selectedCategory, sortOption);
            });
        });

        // Function to update display with fetched data
        function updateDisplay(data) {
            var html = '';
            var counter = 0; // Initialize counter variable
            var itemsPerRow = 4; // Number of items per row
            var totalItems = data.length; // Total number of items 

            if (totalItems > 0) {
                // Generate the first background div
                html += '<div class="w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div>';
                html += '<div class="flex flex-wrap justify-center items-center">'; // Start flex container and center items

                // Loop through each item
                $.each(data, function(index, item) {
                    // Output card HTML dynamically with data from the response
                    html += '<div class="card-group z-10" data-category="' + item.type + '">';
                    html += '<a href="' + item.page + '" class="card-link">';
                    html += '<div class="date">' + item.date + '</div>';
                    html += '<div class="placeholder">';
                    html += '<img src="../assets/blogs_img/' + item.thumbnail + '" alt="Thumbnail" class="thumbnail">';
                    html += '</div>';
                    html += '<div class="title">' + item.title + '</div>';
                    html += '</a>';
                    html += '</div>';

                    // Increment the counter
                    counter++;

                    // Check if the current item is the last one or if the next item will start a new row
                    if (counter % itemsPerRow == 0 || counter == totalItems) {
                        // Check if it's not the last item and there are enough items to complete another row
                        if (counter != totalItems && totalItems - counter >= itemsPerRow) {
                            html += '</div><div class="w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div><div class="flex flex-wrap justify-center items-center">';
                        }
                    }
                });

                html += '</div>'; // Close flex container
            } else {
                html += '<div>No blogs found.</div>';
            }

            $('.card-groups-container').html(html); // Update HTML content
        }

        // Function to initialize pagination controls
        function initializePagination(totalCount, perPage) {
            var totalPages = Math.ceil(totalCount / perPage); // Calculate total pages
            var pagination = $('#pagination');
            pagination.empty(); // Clear previous pagination buttons

            // Hide pagination if there is only one page of results or if no results are found
            if (totalPages <= 1) {
                pagination.hide();
                return;
            }

            var currentPage = parseInt($('.pagination-btn.bg-yellow-200').text()); // Get the current page number

            // Create Page buttons
            for (var i = 1; i <= totalPages; i++) {
                var pageBtn = $('<button>').text(i).addClass('pagination-btn mx-1 py-1 px-3 rounded-lg');

                if (i === currentPage) {
                    pageBtn.addClass('bg-yellow-200 text-black font-bold transition');
                } else {
                    pageBtn.addClass('bg-gray-200 text-gray-700 hover:bg-gray-300 hover:underline transition');
                }

                // Attach click event handler
                pageBtn.click(function(page) {
                    return function() {
                        fetchData($('#categoryFilter').val(), $('#sortFilter').val(), page, perPage);
                    };
                }(i));

                pagination.append(pageBtn);
            }
            pagination.addClass('flex justify-end');
            pagination.show(); // Show pagination if there are multiple pages
        }


        // Function to fetch data from the server
        function fetchData(category, sortOption, page = 1, perPage = 8) {
            $.ajax({
                url: '../../../backend/blogs/fetch_blog.php',
                method: 'POST',
                data: {
                    category: category,
                    sortOption: sortOption,
                    page: page,
                    perPage: perPage
                },
                dataType: 'json',
                success: function(response) {
                    updateDisplay(response.data); // Update display with fetched data
                    initializePagination(response.total, perPage); // Initialize pagination controls
                }
            });
        }
    </script>
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

            <div class="flex flex-col sm:flex-row items-center justify-center">
                <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                    <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                        <label for="categoryFilter" class="mr-2">Filter by Category:</label>
                        <select id="categoryFilter" class="border rounded-md px-2 py-1">
                            <option value="">All Categories</option>
                            <option value="News">News & Updates</option>
                            <option value="Projects">Projects</option>
                        </select>
                    </div>
                </div>

                <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                    <label for="sortFilter" class="mr-2">Sort by:</label>
                    <select id="sortFilter" class="border rounded-md px-2 py-1">
                        <optgroup label="Sort By:">
                            <option value="new">Newest to Oldest</option>
                            <option value="old">Oldest to Newest</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <section style="padding-top: 20px; padding-bottom: 90px;">
                <div class="container mx-auto">
                    <div class="card-groups-container">
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
                </div>
            </section>
            <div id="pagination" class="mt-4"></div>
</body>



<?php
$content = ob_get_clean();
include("../public/master.php");
?>