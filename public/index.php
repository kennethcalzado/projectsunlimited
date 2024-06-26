<?php
$is_public_page = true;
$pageTitle = "Projects Unlimited ";
ob_start();

include("../backend/conn.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="icon" href="../assets/image/PUlogo.png" type="image/png">
    <link rel="stylesheet" href="assets/input.css">

    <style>
        body,
        p {
            font-family: 'Karla', sans-serif;
            letter-spacing: -0.4px;
        }

        /* Active dot style */
        .carousel-dot.active {
            background-color: #F6E17A;
        }

        .brand-logo {
			min-height: 300px;
            max-height: 450px;
            min-width: 1000px;
            max-width: 1000px;
            width: auto;
            margin: 0 auto;
            /* Add any additional styling here */
        }
    </style>
</head>

<body>
    <a href="#top" class="back-to-top">
        <div>
            <i class="fas fa-arrow-up"></i>
        </div>
    </a>
    <div id="content" class="hidden">
        <div class="carousel relative">
            <div class="carousel-inner flex">
                <?php
                // Fetch the last 3 blog entries
                $sql = "SELECT * FROM blogs ORDER BY date DESC LIMIT 5";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    $index = 0; // Counter for delay calculation
                    $isProjectDisplayed = false; // Flag to check if a project is displayed
                    while ($row = $result->fetch_assoc()) {
                        // Split the images string by commas
                        $images = $row['thumbnail'];
                        // Check if the blog type is Projects
                        if ($row['type'] == 'Projects') {
                            // Set flag to true
                            $isProjectDisplayed = true;
                        }
                        // Output the first image as a carousel item
                        echo '<div class="carousel-item relative w-full bg-red-500 text-white text-center">';
                        // Add "FEATURED PROJECTS" heading
                        echo '<img src="../assets/blogs_img/' . $images . '" alt="Slide Image" style="object-fit: cover; width: 100%; height: 100%;">';
                        // Add translucent overlay
                        echo '<div class="absolute inset-0 bg-black opacity-50"></div>';
                        if ($isProjectDisplayed) {
                            echo '<h1 class="feature absolute bottom-0 right-0 m-4 text-4xl font-bold opacity-0 animate-fade-in">FEATURED PROJECT</h1>';
                        }
                        // Add title text in the lower right corner with fade-in animation
                        echo '<h1 class="titlee absolute bottom-0 right-0 m-4 text-4xl font-bold opacity-0 animate-fade-in">' . $row['title'] . '</h1>';
                        // Add button with link from the page column with fade-in animation
                        echo '<a href="' . $row['page'] . '" class="page-button absolute bottom-0 right-0 m-4 px-4 py-2 bg-yellow-400 text-black text-center rounded-md yellow-btn opacity-0 animate-fade-in">Read More</a>';
                        echo '</div>';
                        $index++;
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>
            <!-- Carousel Dots -->
            <div style="margin-bottom: 20px;" class="carousel-dots flex justify-center absolute bottom-4 w-full">
                <?php
                for ($i = 0; $i < $result->num_rows; $i++) {
                    echo '<div class="carousel-dot w-4 h-4 rounded-full bg-gray-400 mx-2"></div>';
                }
                ?>
            </div>
            <div class="carousel-arrow prev" onclick="prevSlide()" style="font-size: 99px;">
                <i class="fas fa-chevron-left" style="color: #F6E17A; padding-left: 120px;"></i>
            </div>
            <div class="carousel-arrow next" onclick="nextSlide()" style="font-size: 99px;">
                <i class="fas fa-chevron-right" style="color: #F6E17A; padding-right: 120px;"></i>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var content = document.getElementById('content');
            content.classList.remove('hidden');
            content.classList.add('animate-fade-in');

            // After the slide-in animation completes, remove opacity-0 class to fade in the elements
            content.addEventListener('animationend', function() {
                var elements = document.querySelectorAll(".animate-fade-in-text, .animate-fade-in-btn");
                elements.forEach(function(element) {
                    element.classList.remove('opacity-0');
                });
            });
        });


        let currentIndex = 0;
        const items = document.querySelectorAll(".carousel-item");
        const totalItems = items.length;
        const dots = document.querySelectorAll(".carousel-dot");

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
            document.querySelector(".carousel-inner").style.transform = `translateX(-${width * currentIndex}px)`;

            // Update active dot
            dots.forEach(dot => dot.classList.remove('active'));
            dots[currentIndex].classList.add('active');
        }

        // Automatic slide every 4 seconds
        setInterval(nextSlide, 4000);
    </script>

    <section class="fade-in-hidden">
        <p style="text-align: center;" class="section text-2xl font-semibold text-black mt-8">Together, we provide the best quality interior products, and highest level of support at most reasonable price.</p>
    </section>

    <section class="section fade-in-hidden">
        <div class="column" style="display: flex; justify-content: center; align-items: center;">
            <div class="about-us" style="text-align: center;">
                <h1 style="font-size: 31px; font-weight: 700;">ABOUT US</h1>
                <a href="about.php">
                    <button style="border-radius: 50px;" class="yellow-btn">Read more ►</button>
                </a>
            </div>
        </div>
        <div class="column">
            <p class="text-2xl font-semibold text-black px-16 mt-8" style="text-align: justify;">
                Projects Unlimited Philippines Inc., is a leading provider of interior products, and a preferred supplier for many architects, interior designers, contractors, and homeowners.
            </p>
        </div>
    </section>

    <div class="fade-in-hidden">
        <p class="text-2xl font-semibold text-black px-16 mt-8" style="text-align: center;">
            For more information, download our Omnibus Brochure:
            <a href="../assets/PROJECTS_UNLIMITED-OMNIBUS_BROCHURE.pdf" download>
                <button style="border-radius: 50px; font-weight: 400;" class="yellow-btn">Download <i class="fa-solid fa-download"></i></button>
            </a>
        </p>
    </div>

    <section class="carousel-section relative fade-in-hidden">
        <h1 style="text-align: center; font-size: 38px; font-weight: 800;">BRANDS</h1>
        <div class="carousel relative">
            <div class="carousel-inner flex carousel-brands-inner">
                <?php
                // Fetch data from the brands table
                $sql = "SELECT * FROM brands";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        // Output carousel item for each brand
                        echo '<div class="carousel-item w-full text-black text-center carousel-brands-item flex justify-center">';
                        // Output brand logo
                        echo '<img src="' . $row['logo_url'] . '" alt="' . $row['brand_name'] . '" class="brand-logo">';
                        echo '</div>';
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>

            <div class="carousel-arrow prev absolute left-0 flex items-center" onclick="prevSlideSecondCarousel()" style="font-size: 99px; padding: 100px">
                <i class="fas fa-chevron-left text-black"></i>
            </div>
            <div class="carousel-arrow next absolute right-0 flex items-center" onclick="nextSlideSecondCarousel()" style="font-size: 99px; padding: 100px">
                <i class="fas fa-chevron-right text-black"></i>
            </div>

            <div class="carousel-dots absolute bottom-0 left-0 right-0 flex justify-center items-center w-full carousel-brands-dots">
                <?php
                // Reset the result pointer to the beginning
                $result->data_seek(0);
                $count = 0;
                while ($count < $result->num_rows) {
                    echo '<span class="dot bg-' . ($count == 0 ? 'black' : 'white') . '"></span>';
                    $count++;
                }
                ?>
            </div>
        </div>

        <a href="/public/brands.php" style="border-radius: 50px;" class="learn-more-btn absolute bottom-4 right-4 bg-gray-300 text-black py-2 px-6 rounded-full">Learn more ►</a>
    </section>

    <script>
        let currentIndexSecondCarousel = 0;
        // Adjust the selectors to be specific to this carousel
        const itemsSecondCarousel = document.querySelectorAll(".carousel-brands-inner .carousel-brands-item");
        const dotsSecondCarousel = document.querySelectorAll(".carousel-brands-dots .dot");
        const totalItemsSecondCarousel = itemsSecondCarousel.length;

        function nextSlideSecondCarousel() {
            currentIndexSecondCarousel = (currentIndexSecondCarousel + 1) % totalItemsSecondCarousel;
            updateCarouselSecondCarousel();
        }

        function prevSlideSecondCarousel() {
            currentIndexSecondCarousel = (currentIndexSecondCarousel - 1 + totalItemsSecondCarousel) % totalItemsSecondCarousel;
            updateCarouselSecondCarousel();
        }

        function updateCarouselSecondCarousel() {
            const width = itemsSecondCarousel[currentIndexSecondCarousel].clientWidth;
            document.querySelector(".carousel-brands-inner").style.transform = `translateX(-${width * currentIndexSecondCarousel}px)`;

            // Update dots
            dotsSecondCarousel.forEach((dot, index) => {
                if (index === currentIndexSecondCarousel) {
                    dot.classList.add("bg-black");
                    dot.classList.remove("bg-white");
                } else {
                    dot.classList.remove("bg-black");
                    dot.classList.add("bg-white");
                }
            });
        }

        // Function to move to the next slide automatically every 5 seconds
        function autoMoveSlide() {
            setInterval(() => {
                nextSlideSecondCarousel();
            }, 5000); // 5000 milliseconds = 5 seconds
        }

        // Call the autoMoveSlide function to start the automatic sliding
        autoMoveSlide();
    </script>

    <section class="fade-in-hidden news-section">

        <div class="news-content">
            <div class="news-image">
                <?php
                $sql = "SELECT * FROM blogs WHERE type = 'News' ORDER BY date DESC LIMIT 1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $images = explode(",", $row['images']);
                    echo '<div class="image" style="background-image: url(\'../assets/blogs_img/' . $images[0] . '\')"></div>';
                } else {
                    echo '<div class="image"></div>'; // Default image path or no image available
                }
                ?>
            </div>
            <div class="news-text">
                <h1 class="section-title">NEWS & UPDATES</h1>
                <?php
                // Reuse the fetched data
                if ($result->num_rows > 0) {
                    // Display limited text from the description column
                    $description = substr($row['description'], 0, 200); // Display first 200 characters
                    echo '<p class="description font-semibold">' . $description . '...</p>';
                } else {
                    echo '<p class="description">No news available</p>';
                }
                ?>
                <a href="blogs.php">
                    <button style="border-radius: 50px;" class="yellow-btn">For other updates ►</button>
                </a>
            </div>
        </div>
    </section>

    <section class="fade-in-hidden latest-products">
        <h1 class="section-title">LATEST PRODUCTS</h1>
        <div class="products-container">
            <?php
            // Fetch products from the database
            $sql = "SELECT * FROM product ORDER BY created_at DESC LIMIT 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Split the image URLs string by commas
                    $image_urls = explode(",", $row['image_urls']);
                    // Take the first image URL
                    $image_url = $image_urls[0];
            ?>
                    <!-- Product column -->
                    <div class="product-column">
                        <div class="product-image" style="background-image: url('../assets/products/<?php echo $image_url; ?>');"></div>
                        <p class="product-name"><?php echo $row['ProductName']; ?></p>
                        <p class="product-description"><?php echo $row['Description']; ?></p>
                    </div>
            <?php
                }
            } else {
                echo "No products available";
            }
            ?>
        </div>

        <div class="products-button-container">
            <a href="category.php">
                <button class="white-btn">See other products ►</button>
            </a>
        </div>
    </section>

    <section class="customers fade-in-hidden" style="padding-top: 40px; padding-bottom: 20px;">
        <h1 style="text-align: center; font-size: 38px; font-weight: 800;">
            SOME OF OUR CUSTOMERS
        </h1>
        <img src="../assets/image/customers.png" style="display: block; margin: 0 auto; width: 65%; height: auto;">
    </section>

    <section id="third-carousel-section" class="third-carousel-section relative fade-in-hidden">
        <div class="third-carousel relative">
            <h1 style="text-align: right; padding-right: 80px; color: #F6E17A;" class="hearr text-4xl font-bold">HEAR WHAT OUR FRIENDS HAVE TO SAY</h1>

            <div class="third-carousel-inner">
                <?php
                // Fetch testimonials from the database
                $sql = "SELECT * FROM testimonials";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Display carousel item for each testimonial
                        echo '<div class="third-carousel-item text-white">';
                        echo '<h1 class="testimonial-message text-3xl font-bold">"' . $row['message'] . '"</h1>';
                        echo '<div class="flex items-center flex-col">'; // Add flex-col to make them stack vertically
                        echo '<div class="cname text-3xl font-bold">' . $row['cname'] . '</div>'; // Change h1 to div
                        echo '<div class="company text-3xl font-bold">' . $row['company'] . '</div>'; // Change h1 to div
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No testimonials available";
                }
                ?>
            </div>

            <div class="third-carousel-arrow prev" onclick="prevThirdSlide()" style="font-size: 99px; padding: 100px">
                <i class="fas fa-chevron-left" style="color: #F6E17A;"></i>
            </div>
            <div class="third-carousel-arrow next" onclick="nextThirdSlide()" style="font-size: 99px; padding: 100px">
                <i class="fas fa-chevron-right" style="color: #F6E17A;"></i>
            </div>

            <div class="third-carousel-dots absolute flex justify-center items-center w-full">
                <?php
                // Reset result pointer
                $result->data_seek(0);
                $dotCount = 0;
                while ($dotCount < $result->num_rows) {
                    echo '<span class="third-dot bg-black"></span>';
                    $dotCount++;
                }
                ?>
            </div>
        </div>
    </section>

    <script>
        let currentIndexThirdCarousel = 0;
        const itemsThirdCarousel = document.querySelectorAll(".third-carousel-section .third-carousel-item");
        const totalItemsThirdCarousel = itemsThirdCarousel.length;
        const dotsThirdCarousel = document.querySelectorAll(".third-carousel-section .third-dot");

        function nextSlideThirdCarousel() {
            if (currentIndexThirdCarousel < totalItemsThirdCarousel - 1) {
                currentIndexThirdCarousel++;
            } else {
                currentIndexThirdCarousel = 0;
            }
            updateCarouselThirdCarousel();
        }

        function prevSlideThirdCarousel() {
            if (currentIndexThirdCarousel > 0) {
                currentIndexThirdCarousel--;
            } else {
                currentIndexThirdCarousel = totalItemsThirdCarousel - 1;
            }
            updateCarouselThirdCarousel();
        }

        function updateCarouselThirdCarousel() {
            const width = itemsThirdCarousel[currentIndexThirdCarousel].clientWidth;
            document.querySelector(".third-carousel-section .third-carousel-inner").style.transform = `translateX(-${width * currentIndexThirdCarousel}px)`;

            // Update dots
            dotsThirdCarousel.forEach((dot, index) => {
                if (index === currentIndexThirdCarousel) {
                    dot.classList.add("bg-black");
                    dot.classList.remove("bg-white");
                } else {
                    dot.classList.remove("bg-black");
                    dot.classList.add("bg-white");
                }
            });
        }

        // Add event listeners to arrow buttons
        document.querySelector(".third-carousel-section .third-carousel-arrow.prev").addEventListener("click", prevSlideThirdCarousel);
        document.querySelector(".third-carousel-section .third-carousel-arrow.next").addEventListener("click", nextSlideThirdCarousel);

        // Add event listeners to dots
        dotsThirdCarousel.forEach((dot, index) => {
            dot.addEventListener("click", () => {
                currentIndexThirdCarousel = index;
                updateCarouselThirdCarousel();
            });
        });

        // Auto slide every 8 seconds
        setInterval(nextSlideThirdCarousel, 8000);

        // Function to check if an element is in the viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        // Function to handle the scroll event
        function handleScroll() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(element => {
                if (isInViewport(element)) {
                    element.classList.add('visible');
                }
            });
        }

        // Add event listener for scroll event
        document.addEventListener('scroll', handleScroll);
    </script>

</body>

</html>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>

<!-- 
Bg div element sa blogs.php ------------
Yung mga filter chuchu sa cms (pagination nalang/ oks na) -----
Add news editor -----------
Update images delete/xbutton ---------
filter blogs display (date and categories) -------------
pagination blogs (konting polish pa pero gumagana thank you kyle) -------
total items chuchu sa table ng cmsblogs ------------
confirmation, animation, x button modal  ------------
logout modal ----------
change home elements size --------
content ng blogs ------
testimonials cms -----
contact cms -------
dagdag office hours sa locations -------
filecontent sa add blog ------
insert real data (blogs) -----
profile admin (sinimulan na) --------
update history from gdrive (pics) digicam pic kulang sa through the eyars ----
page animations---------
audit logs ---------
connect db sa home display (brands nalang) ---------
add featured project text sa home carousel ------
brands carousel sa home ---------
to know more chuchu sa about  ----------
rearrange sidebar -------
remove product category text sa products -------
modal validations (done) --------
finalize main page contents
mobile view
add banner image column sa blogs
lagyan ng fade yung open and close ng modals
-->