<?php
$pageTitle = "Projects Unlimited ";
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/input.css">

    <style>
        body,
        p {
            font-family: 'Karla', sans-serif;
            letter-spacing: -0.4px;
        }
    </style>
</head>

<body>
    <div id="content">
        <div class="carousel relative">
            <div class="carousel-inner flex">
                <div class="carousel-item w-full bg-red-500 text-white text-center">
                    <h1 class="text-4xl font-bold">Slide 1</h1>
                </div>
                <div class="carousel-item w-full bg-blue-500 text-white text-center">
                    <h1 class="text-4xl font-bold">Slide 2</h1>
                </div>
                <div class="carousel-item w-full bg-green-500 text-white text-center">
                    <h1 class="text-4xl font-bold">Slide 3</h1>
                </div>
            </div>
            <div class="carousel-arrow prev" onclick="prevSlide()" style="font-size: 99px;">
                <i class="fas fa-chevron-left text-black"></i>
            </div>
            <div class="carousel-arrow next" onclick="nextSlide()" style="font-size: 99px;">
                <i class="fas fa-chevron-right text-black"></i>
            </div>


        </div>
    </div>

    <script>
        let currentIndex = 0;
        const items = document.querySelectorAll(".carousel-item");
        const totalItems = items.length;

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
            ).style.transform = `translateX(-${width * currentIndex}px)`;
        }
    </script>


    <section>
        <p style="font-size: 31px; font-weight: 530; padding: 20px 300px 20px 300px;">Together, we provide the best quality interior products, and highest level of support at most reasonable price.</p>
    </section>

    <section class="section">
        <div class="column" align="center">
            <div class="about-us">
                <h1 style="font-size: 31px; font-weight: 530;">ABOUT US</h1>
                <button style="border-radius: 50px;" class="yellow-btn">Read more ►</button>
            </div>
        </div>
        <div class="column">
            <p style="text-align: justify; font-size: 31px; font-weight: 530;">Projects Unlimited Philippines Inc., is a leading provider of interior products, and a preferred supplier for many architects, interior designers, contractors and homeowners.</p>
        </div>
    </section>
    <div>
        <p style="text-align: center; font-size: 31px; font-weight: 530;">For more information, download our Omnibus Brochure:
            <button style="border-radius: 50px; font-weight: 400;" class="yellow-btn">Download <i class="fa-solid fa-download"></i></button>
        </p>
    </div>

    <section class="carousel-section relative">
        <div class="carousel relative">
            <div class="carousel-inner flex">
                <div class="carousel-item w-full text-black text-center">
                    <h1 class="text-4xl font-bold">Slide 1</h1>
                </div>
                <div class="carousel-item w-full text-black text-center">
                    <h1 class="text-4xl font-bold">Slide 2</h1>
                </div>
                <div class="carousel-item w-full text-black text-center">
                    <h1 class="text-4xl font-bold">Slide 3</h1>
                </div>
            </div>

            <div class="carousel-arrow prev" onclick="prevSlide()" style="font-size: 99px; padding: 100px">
                <i class="fas fa-chevron-left text-black"></i>
            </div>
            <div class="carousel-arrow next" onclick="nextSlide()" style="font-size: 99px; padding: 100px">
                <i class="fas fa-chevron-right text-black"></i>
            </div>

            <div class="carousel-dots absolute bottom-0 left-0 right-0 flex justify-center items-center w-full">
                <span class="dot bg-black"></span>
                <span class="dot bg-white"></span>
                <span class="dot bg-white"></span>
            </div>
        </div>

        <button style="border-radius: 50px;" class="learn-more-btn absolute bottom-4 right-4 bg-gray-300 text-black py-2 px-6 rounded-full">Learn more ►</button>
    </section>

    <section style="padding-top: 40px;">
        <h1 style="text-align: left; padding-left: 50px; font-size: 38px; font-weight: 800;">
            NEWS & UPDATES
        </h1>
        <div style="display: flex; padding-top: 20px;">
            <div style="flex: 2; padding-left: 50px; background-color: #ccc; height: 500px; display: flex; align-items: center;"> <!-- Left column for image -->
                <!-- Placeholder image -->
            </div>
            <div style="text-align: justify; flex: 1; padding-right: 100px; padding-left: 50px; display: flex; align-items: center;"> <!-- Right column for content -->
                <div style="margin-left: auto;">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in turpis vel odio eleifend placerat. Quisque sodales urna sit amet risus vestibulum ultricies. Donec ac odio vel velit aliquam aliquam.
                        <br>
                    <div style="padding-top: 20px; text-align: center;">
                        <button style="border-radius: 50px;" class="yellow-btn">For other updates ►</button>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section style="padding-top: 40px; padding-bottom: 20px; background: linear-gradient(to bottom, transparent, #F6E17A);">
        <h1 style="text-align: center; font-size: 38px; font-weight: 800;">
            LATEST PRODUCTS
        </h1>
        <div style="display: flex; justify-content: space-around; padding-top: 20px; padding-left: 40px; padding-right: 40px;">
            <!-- First product column -->
            <div style="flex: 1; padding: 20px; height: 400px; ">
                <div style="background-color: #E3E3E3; padding: 20px; height: 100%;">
                    <!-- Placeholder content for product -->
                </div>
                <p style="text-align: center; font-weight:600;">XERA TB102 BROWN</p>
                <p style="text-align: center;">Blackout Blinds</p>
            </div>
            <!-- Second product column -->
            <div style="flex: 1; padding: 20px; height: 400px;">
                <div style="background-color: #D5E8D4; padding: 20px; height: 100%;"></div>
                <p style="text-align: center; font-weight:600;">XERA TB102 BROWN</p>
                <p style="text-align: center;">Blackout Blinds</p>
            </div>
            <!-- Third product column -->
            <div style="flex: 1; padding: 20px;  height: 400px;">
                <div style="background-color: #E9D6D3; padding: 20px; height: 100%;"></div>
                <p style="text-align: center; font-weight:600;">XERA TB102 BROWN</p>
                <p style="text-align: center;">Blackout Blinds</p>
            </div>
            <!-- Fourth product column -->
            <div style="flex: 1; padding: 20px; height: 400px;">
                <div style="background-color: #D5DEE8; padding: 20px; height: 100%;"></div>
                <p style="text-align: center; font-weight:600;">XERA TB102 BROWN</p>
                <p style="text-align: center;">Blackout Blinds</p>
            </div>
        </div>

        <div style="padding-top: 100px; text-align: center;">
            <button style="padding: 10px 80px;" class="white-btn">See other products ►</button>
        </div>
    </section>

    <section style="padding-top: 40px; padding-bottom: 20px;">
        <h1 style="text-align: center; font-size: 38px; font-weight: 800;">
            SOME OF OUR CUSTOMERS
        </h1>
        <img src="../assets/image/customers.png" style="display: block; margin: 0 auto; width: 65%; height: auto;">
    </section>

    <section class="third-carousel-section relative">
        <div class="third-carousel relative">
            <h1 style="text-align: right; padding-right: 80px; color: #F6E17A;" class="text-4xl font-bold">HEAR WHAT OUR FRIENDS HAVE TO SAY</h1>

            <div class="third-carousel-inner flex">
                <div class="third-carousel-item w-full text-white text-center">
                    <h1 style="text-align: justify;" class="text-4xl font-bold">"Projects Unlimited delivers unparalleled excellence! Their team's attention to detail and commitment to quality surpassed our expectations. Seamless execution, innovative solutions, and outstanding professionalism make them the top choice for any project. Highly recommended!"</h1>
                    <h1 style="padding-top: 10px;" class="text-3xl font-bold">Customer Name</h1>
                    <h1 class="text-3xl font-bold">Company/Organization</h1>
                </div>

                <div class="third-carousel-item w-full text-black text-center">
                    <h1 class="text-4xl font-bold">Slide 2</h1>
                </div>
                <div class="third-carousel-item w-full text-black text-center">
                    <h1 class="text-4xl font-bold">Slide 3</h1>
                </div>
            </div>

            <div class="third-carousel-arrow prev" onclick="prevThirdSlide()" style="font-size: 99px; padding: 100px">
                <i class="fas fa-chevron-left" style="color: #F6E17A;"></i>
            </div>
            <div class="third-carousel-arrow next" onclick="nextThirdSlide()" style="font-size: 99px; padding: 100px">
                <i class="fas fa-chevron-right" style="color: #F6E17A;"></i>
            </div>


            <div class="third-carousel-dots absolute bottom-0 left-0 right-0 flex justify-center items-center w-full">
                <span class="third-dot bg-black"></span>
                <span class="third-dot bg-white"></span>
                <span class="third-dot bg-white"></span>
            </div>

        </div>
    </section>


    <script>
        let currentIndexSecondCarousel = 0;
        const itemsSecondCarousel = document.querySelectorAll(".carousel-section .carousel-item");
        const totalItemsSecondCarousel = itemsSecondCarousel.length;
        const dotsSecondCarousel = document.querySelectorAll(".carousel-section .dot");

        function nextSlideSecondCarousel() {
            if (currentIndexSecondCarousel < totalItemsSecondCarousel - 1) {
                currentIndexSecondCarousel++;
            } else {
                currentIndexSecondCarousel = 0;
            }
            updateCarouselSecondCarousel();
        }

        function prevSlideSecondCarousel() {
            if (currentIndexSecondCarousel > 0) {
                currentIndexSecondCarousel--;
            } else {
                currentIndexSecondCarousel = totalItemsSecondCarousel - 1;
            }
            updateCarouselSecondCarousel();
        }

        function updateCarouselSecondCarousel() {
            const width = itemsSecondCarousel[currentIndexSecondCarousel].clientWidth;
            document.querySelector(".carousel-section .carousel-inner").style.transform = `translateX(-${width * currentIndexSecondCarousel}px)`;

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

        // Add event listeners to arrow buttons
        document.querySelector(".carousel-section .carousel-arrow.prev").addEventListener("click", prevSlideSecondCarousel);
        document.querySelector(".carousel-section .carousel-arrow.next").addEventListener("click", nextSlideSecondCarousel);

        // Add event listeners to dots
        dotsSecondCarousel.forEach((dot, index) => {
            dot.addEventListener("click", () => {
                currentIndexSecondCarousel = index;
                updateCarouselSecondCarousel();
            });
        });
    </script>

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
confirmation sa modal
content ng blogs
profile admin
-->