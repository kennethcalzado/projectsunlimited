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
            padding: 10px 20px 20px 20px;
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
            font-size: 17px;
            color: black;
            margin-bottom: 5px;
        }

        .thumbnail {
            width: 100%;
            height: 100%;
            position: absolute;
            z-index: 2;
            border: 8px solid black;
            object-fit: cover;
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

    <script>
        // When the page is scrolled, show/hide the back-to-top button
        window.addEventListener("scroll", function() {
            var backToTopButton = document.querySelector('.back-to-top');
            if (window.scrollY > 200) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        // Smooth scrolling when the button is clicked
        document.querySelector('.back-to-top a').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <!-- Your existing head content -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

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

            function formatDate(dateString) {
                // Convert dateString to JavaScript Date object
                var date = new Date(dateString);

                // Format the date using PHP-like format "F j, Y"
                var formattedDate = date.toLocaleDateString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                });

                return formattedDate;
            }

            // Update updateDisplay function to display items for the current page
            function updateDisplay(data, currentPage, perPage) {
                var html = '';
                var counter = 0; // Initialize counter variable
                var itemsPerRow = 5; // Number of items per row
                // var startIndex = (currentPage - 1) * perPage; // Calculate start index for current page

                // var endIndex = Math.min(startIndex + perPage, data.length); // Calculate end index for current page
                var totalItems = data.length; // Total number of items for current page
                const startIndex = ((currentPage - 1) * perPage) + 1;
                const endIndex = Math.min(startIndex + perPage - 1, data.length + perPage);

                // console.log(data);

                if (totalItems > 0) {
                    // Generate the first background div
                    html += '<div class="w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div>';
                    html += '<div class="flex flex-wrap justify-center items-center">'; // Start flex container and center items

                    // Loop through each item for the current page
                    for (var i = 0; i < data.length; i++) {

                        var item = data[i];
                        // Output card HTML dynamically with data from the response
                        html += '<div class="card-group z-10" data-category="' + item.type + '">';
                        html += '<a href="' + item.page + '" class="card-link">';
                        html += '<div class="date">' + formatDate(item.date) + '</div>';
                        html += '<div class="placeholder">';
                        html += '<img src="../assets/blogs_img/' + item.thumbnail + '" alt="Thumbnail" class="thumbnail">';
                        html += '</div>';
                        html += '<div class="title">' + item.title + '</div>';
                        html += '</a>';
                        html += '</div>';

                        // Increment the counter
                        counter++;

                        // Check if the current item is the last one or if the next item will start a new row
                        if (counter % itemsPerRow == 0 || i == endIndex - 1) {
                            // Check if it's not the last item and there are enough items to complete another row
                            if (i != endIndex - 1 && totalItems - counter >= itemsPerRow) {
                                html += '</div><div class="w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div><div class="flex flex-wrap justify-center items-center">';
                            }
                        }
                    }

                    html += '</div>'; // Close flex container
                } else {
                    html += '<div>No blogs found.</div>';
                }

                $('#card-groups-container').html(html); // Update HTML content
            }

            // Update initializePagination function to use the total count for dynamic pagination
            function initializePagination(totalDisplayed, currentPage, perPage) {
                var totalPages = Math.ceil(totalDisplayed / perPage); // Calculate total pages based on displayed items
                var pagination = $('#pagination');
                pagination.empty(); // Clear previous pagination buttons

                // Hide pagination if there are no results or only one page
                if (totalPages <= 1) {
                    pagination.hide();
                    return;
                }

                // Create Page buttons
                for (var i = 1; i <= totalPages; i++) {
                    var pageBtn = $('<button>').text(i).addClass('pagination-btn mx-1 py-1 px-3 rounded-lg');

                    if (i === parseInt(currentPage)) { // Convert currentPage to integer for comparison
                        pageBtn.addClass('bg-yellow-200 text-black font-bold transition');
                    } else {
                        pageBtn.addClass('bg-gray-200 text-gray-700 hover:bg-gray-300 hover:underline transition');
                    }

                    // Attach click event handler
                    pageBtn.click(function(page) {

                        // console.log($('#categoryFilter').val());
                        // console.log($('#sortFilter').val());
                        // console.log(page);
                        // console.log(perPage);
                        return function() {
                            fetchData($('#categoryFilter').val(), $('#sortFilter').val(), page, perPage);
                        };
                    }(i));

                    pagination.append(pageBtn);
                }
                pagination.addClass('flex justify-end');
                pagination.show(); // Show pagination
            }

            // Update fetchData function to pass perPage parameter
            function fetchData(category, sortOption, page = 1, perPage = 10) {
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
                        console.log(response.data);
                        updateDisplay(response.data, page, perPage); // Update display with fetched data and current page number

                        initializePagination(response.total, page, perPage); // Pass the current page number and perPage to initializePagination
                    }
                });
            }

            // Initialize pagination when the page loads
            fetchData('', 'new'); // Fetch initial data
        });
    </script>
</head>

<body>
    <a href="#top" class="back-to-top">
        <div>
            <i class="fas fa-arrow-up"></i>
        </div>
    </a>
    <section class="fade-in-hidden">
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

    <section class="fade-in-hidden">
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

            <section class="fade-in-hidden" style="padding-top: 20px;">
                <div class="container mx-auto">
                    <div id="card-groups-container" class="card-groups-container">
                        <?php
                        function formatDate($dateString)
                        {
                            // Convert date string to Unix timestamp
                            $timestamp = strtotime($dateString);
                            // Format the timestamp to "Month Date, Year" format
                            return date("F j, Y", $timestamp);
                        }

                        $counter = 0; // Initialize counter variable
                        $itemsPerRow = 5; // Number of items per row
                        $totalItems = mysqli_num_rows($result); // Total number of items 

                        if ($totalItems > 0) {
                            // Generate the first background div
                            echo '<div class="w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div>';

                            echo '<div class="flex flex-wrap justify-center items-center">'; // Start flex container and center items
                            // Loop through each row
                            while ($row = mysqli_fetch_assoc($result)) {

                                $formattedDate = formatDate($row['date']);
                                // Output card HTML dynamically with data from the database
                                echo '
                <div class="card-group z-10" data-category="' . $row['type'] . '">
                    <a href="' . $row['page'] . '" class="card-link">
                        <div class="date">' . $formattedDate . '</div>
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
                        } else {
                            echo "No blogs found.";
                        }
                        ?>
            </section>
            <div id="pagination" class="mt-4" style="padding: 0px 100px 90px 0px;"></div>

        </div>
    </section>


</body>



<?php
$content = ob_get_clean();
include("../public/master.php");
?>