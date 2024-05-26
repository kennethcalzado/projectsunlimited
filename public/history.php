<?php
$is_public_page = true;
$pageTitle = "History";
ob_start();
?>

<head>
<link rel="icon" href="../assets/image/PUlogo.png" type="image/png">
    <style>
        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .content {
                padding: 0;
            }

            .fade-in-hidden img {
                max-height: 200px;
            }

            .text-4xl {
                font-size: 18px;
                padding: 1px;
            }

            .p {
                padding-left: 10px !important;
                padding-right: 10px !important;
                padding-bottom: 20px !important;
                padding-top: 5px !important;
                font-size: 12px !important;
            }

            .achievements {
                padding-top: 10px !important;
            }

            .years,
            #years {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                margin: 0 !important;
            }

            .flex.justify-center {
                flex-direction: column;
            }

            .throughtheyrs {
                width: 85% !important;
            }

            .companyimage {
                width: auto !important;
                height: auto !important;
            }

            .image-container {
                flex-direction: column;
                align-items: center;
                top: auto !important;
                position: relative !important;
                padding-top: 10px !important;
            }

            .image-wrapper {
                margin: 10px 0 !important;
                width: 80% !important;
            }

            .image-wrapper img {
                width: 100% !important;
                height: auto;
            }

            .through {
                height: 400px !important;
            }
        }

        /* Modal styles */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Position it relative to the viewport */
            z-index: 999;
            /* Ensure it's on top of other content */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            /* Enable scrolling if needed */
            background-color: rgba(0, 0, 0, 0.5);
            /* Black background with opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            /* Center the modal horizontally */
            padding: 30px;
            border: 1px solid #888;
            width: 90%;
            /* Set the width */
            max-width: 600px;
            /* Max width of the modal */
            position: relative;
            /* Enable relative positioning */
            top: 50%;
            /* Move modal down by half its height */
            transform: translateY(-50%);
            /* Adjust vertically to center */
        }

        .close {
            position: absolute;
            top: 0;
            right: 0;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            padding: 10px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .p {
            font-size: 24px;
        }
    </style>
</head>

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

<body>
    <a href="#top" class="back-to-top">
        <div>
            <i class="fas fa-arrow-up"></i>
        </div>
    </a>
    <section class="fade-in-hidden">
        <div class="content">
            <div class="relative">
                <img src="../assets/image/history.png" class="w-full h-96 object-cover">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <p class="text-white font-bold text-4xl text-center">TIMELESS INTERIOR PRODUCTS SINCE <br> <span class="text-[#F6E381]">1968</span></p>
                </div>
            </div>
        </div>
    </section>
    <div class="fade-in-hidden" style="width: 100%; text-align: center; padding-bottom: 20px; padding-top: 20px;">
        <h1 class="text-black" style=" font-size: 38px; font-weight: 800; margin: 0;">OUR PEOPLE</h1>
    </div>
    <section class="fade-in-hidden" style="position: relative; padding-bottom: 40px;">
        <div class="projectslogo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1;">
            <img src="../assets/image/projectslogo.png" style="display: block; width: 100%; height: 100%;">
        </div>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; z-index: 2; padding: 0px 10px;">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0" style="width: 25%;">
                <img src="../assets/image/people1.png" style="width: 100%; height: 90%;" onclick="openModal('../assets/image/people1.png')">
            </div>
            <div class="transition-opacity duration-1000 delay-2000 ease-in-out hover:scale-110 opacity-0" style="width: 25%;">
                <img src="../assets/image/people5.jpg" style="width: 100%; height: 90%;" onclick="openModal('../assets/image/people5.jpg')">
            </div>
            <div class="transition-opacity duration-1000 delay-3000 ease-in-out hover:scale-110 opacity-0" style="width: 25%;">
                <img src="../assets/image/people3.jpg" style="width: 100%; height: 90%;" onclick="openModal('../assets/image/people3.jpg')">
            </div>
        </div>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; z-index: 2; padding: 0px 10px;">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0" style="width: 25%;">
                <img src="../assets/image/people6.jpg" style="width: 100%; height: 90%;" onclick="openModal('../assets/image/people6.jpg')">
            </div>
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0" style="width: 25%;">
                <img src="../assets/image/people4.jpg" style="width: 100%; height: 90%;" onclick="openModal('../assets/image/people4.jpg')">
            </div>
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0" style="width: 25%;">
                <img src="../assets/image/people2.jpg" style="width: 100%; height: 90%;" onclick="openModal('../assets/image/people2.jpg')">
            </div>
        </div>
    </section>

    <!-- The modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalContainer"></div> <!-- Container for modal content -->
        </div>
    </div>

    <script>
        // Open the modal
        function openModal(imgSrc) {
            var modal = document.getElementById("myModal");
            var modalContainer = document.getElementById("modalContainer");
            modalContainer.innerHTML = '<img src="' + imgSrc + '" style="max-width: 100%; height: auto;">'; // Set image inside container
            modal.style.display = "block";
        }

        // Close the modal
        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>

    <div class="fade-in-hidden" style="position: relative;">
        <div class="p" style="background-color: #F6E17A; width: 100%; text-align: center; padding: 0px 190px; position: relative;">
            <p class="p font-semibold text-black" style="text-align: justify; padding: 20px 40px 40px 40px; margin: 0;">
                Our people are our greatest assets. Every Projects Unlimited
                employee is a dedicated individual working hand-in–hand with
                management in the pursuit of excellence in quality and
                customer service. Projects Unlimited believes that there are no
                small employees. Each is equally important, from top
                management down to the delivery man, with distinct functions
                interlinking to achieve success in every goal.
            </p>
        </div>
        <div style="position: absolute; width: 100%; top: -20%; height: 20%; background: linear-gradient(to top, rgba(246, 225, 122, 1) 1%, transparent);"></div>
    </div>

    <section class="through fade-in-hidden" style="padding-top: 40px; position: relative; text-align: center; display: flex; justify-content: center; align-items: center;">
        <h1 class="throughtheyrs" style="text-align: center; font-size: 38px; font-weight: 800; position: absolute; top: 0; left: 50%; transform: translateX(-50%); padding-top: 30px;">PROJECTS UNLIMITED THROUGH THE YEARS</h1>

        <div class="image-container flex justify-center" style="position: absolute; z-index: 2; top: 10%;">
            <div class="image-wrapper transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0" style="margin-right: 20px; margin-bottom: 20px;">
                <img class="companyimage" src="../assets/image/company1.png" style="width: 500px; height: auto;" onclick="openModal('../assets/image/company1.png')">
            </div>
            <div class="image-wrapper transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0" style="margin-bottom: 20px;">
                <img class="companyimage" src="../assets/image/company2.jpg" style="width: 500px; height: auto;" onclick="openModal('../assets/image/company2.jpg')">
            </div>
        </div>

        <div class="image-container flex justify-center" style="position: absolute; z-index: 2; top: 50%;">
            <div class="image-wrapper transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0" style="margin-right: 20px; margin-bottom: 20px;">
                <img class="companyimage" src="../assets/image/company3.png" style="width: 500px; height: auto;" onclick="openModal('../assets/image/company3.png')">
            </div>
            <div class="image-wrapper transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0" style="margin-bottom: 20px;">
                <img class="companyimage" src="../assets/image/company4.jpg" style="width: 500px; height: auto;" onclick="openModal('../assets/image/company4.jpg')">
            </div>
        </div>

        <div style="position: relative; display: flex; align-items: center; z-index: -1; height: 100vh;">
            <h1 id="years" style="color: #F6E17A; font-size: 800px; font-weight: font-black; margin: 0; letter-spacing: -0.13em; position: relative; z-index: 1; margin-left: -90px; margin-top: -120px;"></h1>

            <div class="years" style="display: flex; flex-direction: column; z-index: 1; margin-top: -100px;">
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: font-black;">Y</p>
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: font-black;">E</p>
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: font-black;">A</p>
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: font-black;">R</p>
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: font-black;">S</p>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const images = document.querySelectorAll(".transition-opacity");

            function fadeInOnScroll() {
                images.forEach(image => {
                    const imageTop = image.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;

                    if (imageTop < windowHeight) {
                        image.classList.remove("opacity-0");
                        image.classList.add("opacity-100");
                    }
                });
            }

            window.addEventListener("scroll", fadeInOnScroll);
        });
    </script>

    <br>
    <div class="fade-in-hidden" style="position: relative; margin-top: -60px;">
        <div class="p" style=" background-color: #F6E17A; width: 100%; text-align: center; padding: 0px 190px; position: relative;">
            <p class="p font-semibold text-black" style="text-align: justify; padding: 10px 40px 40px 40px; margin: 0;">
                It started as a leading provider of two major flooring products –
                vinyl tiles and ceramic tiles – working exclusively with the
                biggest producers in USA (Amtico Vinyl and Tarkett Vinyl Floors),
                United Kingdom (Marley Floors), Italy (Ragno Ceramic Tiles,
                Ceramiche Atlas Concorde). Spain (Azulev Ceramic Tiles and
                Aparici Ceramic Tiles), and Asia (Feboflex Vinyl Tiles of Taiwan).
                PROJECTS UNLIMITED also became known for its Hey’Di
                Waterproofing Compound from Germany and for its USG
                Gypsum Boards from USA. In 1979, PROJECTS UNLIMITED pioneered in the importation of
                vinyl wallcoverings, gathering together under one roof the most
                extensive selection of wallcoverings, from commercial to
                residential grades, from the most prestigious producers of
                wallcoverings in Japan (Sangetsu), England (Kingfisher),
                Germany (Marburg International), Italy (Emiliana Parati), and
                Holland (BN International).
                </br></br>
                For many years, PROJECTS UNLIMITED dominated the
                wallcovering market, easily becoming the preferred supplier of
                every interior designer, architect, contractor or homeowner.
                Although the subsequent advance in paint technology and
                other types of wallcovering materials trimmed down the vinyl
                wallcovering market considerably, PROJECTS UNLIMITED
                remains an active player in this field until this day.
            </p>
        </div>
        <div style="position: absolute; width: 100%; top: -20%; height: 20%; background: linear-gradient(to top, rgba(246, 225, 122, 1) 1%, transparent);"></div>
    </div>

    <script>
        // Get the current year
        var currentYear = new Date().getFullYear();

        // Year the company started
        var startYear = 1968;

        // Calculate the number of years
        var years = currentYear - startYear;

        // Set the content of the years element
        document.getElementById("years").innerText = years;
    </script>


    <section class="achievements fade-in-hidden" style="padding-top: 40px; padding-bottom: 20px; background: linear-gradient(to bottom, transparent, #F6E17A);">
        <h1 style="text-align: center; font-size: 38px; font-weight: 800;">ACHIEVEMENTS</h1>
        <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/iso1.png" style="width: 400px; height: auto;"></a>
            </div>
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/greenguard.png" style="width: 400px; height: auto;"></a>
            </div>
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/iso1.png" style="width: 400px; height: auto;"></a>
            </div>
        </div>
    </section>





</body>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>