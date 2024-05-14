<?php
$is_public_page = true;

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
            background-image: url('../../assets/image/arrowgold.png');
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
</head>

<body>
    <section style="text-align: center; padding-left: 190px; padding-right: 190px; padding-bottom: 25px;">
        <div class="flex justify-between items-center mb-3">
            <!-- "Back" link -->
            <a href="../blogs.php" class="text-black font-semibold text-2xl flex items-center mt-8" style="transition: color 0.3s;" onmouseover="this.style.color='#F6E17A'" onmouseout="this.style.color='black'">
                <i class="fas fa-chevron-left mr-2"></i> Back
            </a>
            <!-- Spacer -->
            <div></div> <!-- This empty div acts as a spacer to push the title to the center -->
            <!-- Title -->
            <h1 class="text-black font-bold text-4xl text-center" style="padding-top: 25px;"><?php echo $blog_data['title']; ?></h1>

            <div></div>
            <h1 class="text-black font-semibold text-2xl text-center" style="padding-top: 25px;"><?php echo $formatted_date; ?></h1>
        </div>
        <div class="border-b border-black flex-grow border-4 mt-2 mb-5"></div>


        <div class="container flex">
            <div style="width: 60%;" class=" description-column flex items-center">
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

    <section style="text-align: center; padding-left: 140px; padding-right: 140px; padding-bottom: 25px;">
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
                    echo '<div class="w-full flex justify-center"><div class="absolute h-[160px] m-[98px] w-3/5 bg-[#F6E381]" style="z-index: -1;"></div></div>';

                    echo '<div class="flex flex-wrap justify-center items-center">'; // Start flex container and center items
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

<?php
$content = ob_get_clean();
include("../master.php");
?>