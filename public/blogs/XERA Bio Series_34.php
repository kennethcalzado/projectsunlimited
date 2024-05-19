<?php
$is_public_page = true;
$is_blog = true;

$pageTitle = 'News & Projects';
ob_start();
include("../../backend/conn.php");

// Extract the blog ID from the filename
$filename = basename(__FILE__); // Get the current filename
$parts = explode('_', $filename);
$blog_id = (int) end($parts); // Extract the numeric value after the underscore

// Retrieve data of the inserted blog based on its ID
$sql = "SELECT * FROM blogs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $blog_data = $result->fetch_assoc();

    // Retrieve images data for the carousel
    $images = explode(',', $blog_data['images']);
}

$date = strtotime($blog_data['date']);
$formatted_date = date("F j, Y", $date);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../../../assets/input.css">

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
            background-image: url('../../assets/image/arrowgold.png');
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
            background-image: url('../../assets/image/arrowblack.png');
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

        @media (max-width: 768px) {

            .card-group {
                width: 250px;
                height: 330px;
                margin: 1%;
                display: inline-block;
                background-color: #D9D9D9;
                vertical-align: top;
                box-sizing: border-box;
                padding: 5px 15px 15px 15px;
                text-align: center;
                transition: background-color 0.3s ease;
            }

            .banner {
                font-size: 24px !important;
            }

            .bannerimage {
                height: 170px !important;
            }

            .text-xl {
                font-size: 14px !important;
            }

            .card-group {
                width: 160px;
                height: 240px;
            }

            .placeholder {
                width: 123px;
                height: 140px;
                background-color: black;
                margin: auto;
                margin-bottom: 10px;
                position: relative;
                z-index: 1;
                overflow: hidden;
            }

            .date {
                font-size: 12px;
                color: black;
                margin-bottom: 5px;
            }

            /* Title styling */
            .title {
                font-weight: bold;
                color: black;
                position: relative;
                font-size: 12px;
                text-align: left;
            }

            .title::after {
                content: "";
                background-image: url('../../assets/image/arrowgold.png');
                background-size: contain;
                width: 20px;
                height: 20px;
                position: absolute;
                top: 40px;
                right: -10px;
                transform: translateY(-50%);
                background-repeat: no-repeat;
                transition: background-image 0.3s ease;
                z-index: 10;
                /* Ensures the pseudo-element is on top */
            }

            .card-group:hover .title::after {
                background-image: url('../../assets/image/arrowblack.png');
            }

            .bgdiv {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                margin: 0 !important;
            }

            .blog {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .flexx {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .back-link {
                flex: 0 0 auto;
            }

            .spacer {
                display: none;
            }

            .title-date-container {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .blog-title,
            .blog-date {
                text-align: left;
                padding-top: 0;
            }

            .blog-title {
                font-size: 1.5rem;
                /* Adjust as needed */
            }

            .blog-date {
                font-size: 1rem;
                /* Adjust as needed */
            }

            .description-column {
                width: 100% !important;
            }

            .carousel-column {
                width: 100% !important;
                padding-top: 10px;
            }

            .container {
                flex-direction: column;
                align-items: center;
            }

            .other {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            .br {
                display: none;
            }

            .otherz {
                align-items: center !important;
                justify-content: center !important;
            }
        }

        .spacer {
            flex: 1;
        }

        .blog-title,
        .blog-date {
            display: inline-block;
            padding-top: 25px;
        }
    </style>
</head>

<body>
    <section class="blog" style="text-align: center; padding-left: 190px; padding-right: 190px; padding-bottom: 25px;">
        <div class="flexx flex justify-between items-center mb-3">
            <!-- "Back" link -->
            <a href="../blogs.php" class="text-black font-semibold text-2xl flex items-center mt-8 back-link" style="transition: color 0.3s;" onmouseover="this.style.color='#F6E17A'" onmouseout="this.style.color='black'">
                <i class="fas fa-chevron-left mr-2"></i> Back
            </a>
            <!-- Spacer -->
            <div class="spacer"></div>
            <!-- Title and Date Container -->
            <div style="text-align: right;" class="title-date-container">
                <!-- Title -->
                <h1 style="text-align: right;" class="text-black font-bold text-4xl blog-title"><?php echo $blog_data['title']; ?></h1><br class="br">
                <!-- Date -->
                <h1 style="text-align: right;" class="text-black font-semibold text-2xl blog-date"><?php echo $formatted_date; ?></h1>
            </div>
        </div>

        <div class="border-b border-black flex-grow border-4 mt-2 mb-5"></div>


        <div class="container flex">
            <div style="width: 60%;" class="description-column flex items-center">
                <p class="text-2xl text-black" style="text-align: justify; padding-right: 20px;">
                    <?php
                    // Function to convert URLs into clickable links
                    function makeClickableLinks($text)
                    {
                        $text = preg_replace_callback('#(https?://\S+|www\.\S+)#i', function ($matches) {
                            return '<a href="' . $matches[1] . '" target="_blank" style="text-decoration: none; color: inherit;" onmouseover="this.style.color=\'#F6E17A\';" onmouseout="this.style.color=\'inherit\';">' . $matches[1] . '</a>';
                        }, $text);
                        return $text;
                    }

                    echo nl2br(makeClickableLinks($blog_data['description']));
                    ?>
                </p>
            </div>
            <div class="carousel-column" style="width: 40%; overflow: hidden;"> <!-- Added style for width and overflow -->
                <div class="carousel relative" style="height: 100%;"> <!-- Added fixed height -->
                    <div class="carousel-inner flex" style="height: 100%;"> <!-- Set height to 100% to fill the carousel container -->
                        <?php if (isset($images)) : ?>
                            <?php foreach ($images as $image) : ?>
                                <div class="carousel-item w-full" style="height: 100%; object-fit: cover;"> <!-- Set height to 100% to fill the carousel container -->
                                    <img src="<?php echo "../../../assets/blogs_img/$image"; ?>" alt="Slide Image" style="width: 100%; height: 100%; object-fit: cover;"> <!-- Set width to auto and height to 100% to maintain aspect ratio and fill the container -->
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="carousel-item w-full">
                                <p>No images found for this blog.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="carousel-arrow prev" onclick="prevSlide()" style="font-size: 59px;">
                        <i style="padding-left: 40px; color: #F6E17A;" class="fas fa-chevron-left"></i>
                    </div>
                    <div class="carousel-arrow next" onclick="nextSlide()" style="font-size: 59px;">
                        <i style="padding-right: 40px; color: #F6E17A;" class="fas fa-chevron-right text-black"></i>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let currentIndex = 0;
            const items = document.querySelectorAll(".carousel-item");
            const totalItems = items.length;
            const intervalTime = 3000; // Interval time in milliseconds (3 seconds)

            function nextSlide() {
                if (currentIndex < totalItems - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateCarousel();
            }

            function prevSlide() {
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = totalItems - 1;
                }
                updateCarousel();
            }

            function updateCarousel() {
                const width = items[currentIndex].clientWidth;
                document.querySelector(
                    ".carousel-inner"
                ).style.transform = 'translateX(-' + (width * currentIndex) + 'px)';
            }

            // Function to auto-swipe the carousel
            function startCarouselAutoSwipe() {
                setInterval(nextSlide, intervalTime);
            }

            // Start auto-swiping on page load
            startCarouselAutoSwipe();
        </script>
    </section>

    <section class="other" style="text-align: center; padding-left: 140px; padding-right: 140px; padding-bottom: 25px;">
        <h1 class="text-black font-bold text-2xl text-center" style="padding-top: 25px;">Read more blogs:</h1>

        <div class="container mx-auto">
            <div id="card-groups-container" class="card-groups-container">
                <?php
                // Execute a new query to fetch other blog entries
                $otherBlogsQuery = "SELECT * FROM blogs WHERE id != ? ORDER BY date DESC LIMIT 5";
                $otherStmt = $conn->prepare($otherBlogsQuery);
                $otherStmt->bind_param("i", $blog_id);
                $otherStmt->execute();
                $otherResult = $otherStmt->get_result();

                if ($otherResult->num_rows > 0) {
                    $counter = 0; // Initialize counter variable
                    $itemsPerRow = 5; // Number of items per row
                    $totalItems = $otherResult->num_rows; // Total number of items 

                    // Generate the first background div
                    echo '<div class="bgdiv w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div>';

                    echo '<div class="otherz flex flex-wrap justify-center items-center">'; // Start flex container and center items
                    while ($row = $otherResult->fetch_assoc()) {
                        $formattedDate = date("F j, Y", strtotime($row['date']));
                        echo '
                <div class="card-group z-10" data-category="' . $row['type'] . '">
                    <a href="' . $row['page'] . '" class="card-link">
                        <div class="date">' . $formattedDate . '</div>
                        <div class="placeholder">
                            <img src="../../assets/blogs_img/' . $row['thumbnail'] . '" alt="Thumbnail" class="thumbnail">
                        </div>
                        <div class="title">' . $row['title'] . '</div>
                    </a>
                </div>';
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
                    echo "No other blogs found.";
                }
                ?>
            </div>
        </div>
    </section>

</body>

</html>

<footer class="bg-black text-white py-4">
    <div class="flex flex-col md:flex-row mx-16">
        <!-- Left Column -->
        <div class="md:w-1/4 p-2 my-2 mt-8 items-center justify-center">
            <img src="/assets/image/projectslogo.png" alt="Projects Unlimited Logo" class="w-56 h-66 ml-7">
            <p class="text-sm mt-2">620 Tytana St., Binondo, Manila, Philippines, 1006</p>
            <p class="block text-sm text-justify mt-2">Head Office Contact Number: +632 8243 8888-95</p>
            <div class="container mx-auto text-center">
                <div class="flex items-center ml-6 mt-2">
                    <p class="text-lg ml-8 mr-2">Follow Us:</p>
                    <div class="flex space-x-2">
                        <a href="https://www.facebook.com/projectsunlimitedph" class="text-2xl hover:text-[#F6E381]"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.instagram.com/projectsunlimitedph" class="text-2xl hover:text-[#F6E381]"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/projectsunlimited/" class="text-2xl hover:text-[#F6E381]"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="mailto:info@projectsunlimited.com.ph" class="text-2xl hover:text-[#F6E381]"><i class="fa-solid fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fetch categories dynamically -->
        <?php
        include '../../backend/conn.php';
        // Fetch main categories from the database
        $query = "SELECT CategoryName, page_path FROM productcategory WHERE ParentCategoryID IS NULL AND status = 'active'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="md:w-1/4 p-2">';
            echo '<div class="mb-4 my-2 mx-2 ml-12">';
            echo '<p class="text-xl font-bold text-center">Category</p>';
            while ($row = mysqli_fetch_assoc($result)) {
                $categoryName = $row['CategoryName'];
                $pagePath = '../../pages' . $row['page_path'];
        ?>
                <p class="text-sm mt-1 font-semibold text-center hover:text-[#F6E381]"><a href="<?php echo $pagePath; ?>"><?php echo $categoryName; ?></a></p>
        <?php
            }
            echo '</div>';
            echo '</div>';
        }
        ?>
        <!-- End of dynamically fetched categories -->

        <div class="md:w-1/6 p-2">
            <div class="mb-4 my-2 mx-1">
                <p class="text-xl font-bold text-center">Company</p>
                <a href="/public/about.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">About Us</a>
                <a href="/public/blogs.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">Updates</a>
                <a href="/public/contact.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">Contact Us</a>
            </div>
        </div>
        <div class="md:w-1/6 p-2">
            <div class="mb-4 my-2 mx-2">
                <p class="text-xl font-bold text-center">Services</p>
                <a href="/public/brands.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">Brands</a>
                <a href="/public/category.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">Products</a>
            </div>
        </div>
        <div class="md:w-1/4 p-2">
            <div class="mb-4 my-2 mx-2 ml-12">
                <p class="text-xl font-bold ml-8">Office Hours</p>
                <p class="block text-sm mt-1 font-semibold  hover:text-[#F6E381]">Mondays - Fridays <u>9am - 5pm</u>
                </p>
                <p class="block text-sm font-bold hover:text-[#F6E381]">Sundays and Holidays <u>CLOSED</u></p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <p class="text-center text-sm font-bold justify-center"><i>Copyright &copy; 2024 Projects Unlimited Powered
                by Projects Unlimited</i></p>
    </div>
</footer>

<?php
$content = ob_get_clean();
include("../master.php");
?>