<?php
$pageTitle = "HIstory";
ob_start();
?>

<body>
    <section>
        <div class="content">
            <div class="relative">
                <img src="../assets/image/history.png" class="w-full h-96 object-cover">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <p class="text-white font-bold text-4xl text-center">TIMELESS INTERIOR PRODUCTS SINCE <br> <span class="text-[#F6E381]">1958</span></p>
                </div>
            </div>
        </div>
    </section>
    <div style="width: 100%; text-align: center; padding-bottom: 20px; padding-top: 20px;">
        <h1 class="text-black" style=" font-size: 38px; font-weight: 800; margin: 0;">MEET THE TEAM</h1>
    </div>
    <section>
        <div style="text-align: center; height: 100vh;">
            <div style="position: relative; width: 100%; height: 90%;">
                <img src="../assets/image/teamsample.png" style="display: block; width: 100%; height: 100%;">
                <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 40%; background: linear-gradient(to top, rgba(246, 225, 122, 1) 1%, transparent);"></div>
            </div>
            <div style=" background-color: #F6E17A;width: 100%; height: auto; text-align: center; padding: 0px 190px;">
                <p class="text-2xl font-semibold text-black" style=" text-align: justify; padding: 20px 40px; margin: 0;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec diam vitae ligula tincidunt aliquet. Phasellus ultricies, lorem et faucibus mollis, justo mauris hendrerit dolor, a tristique velit neque et purus. Proin non felis eget enim posuere vestibulum. Integer nec augue nec ante malesuada bibendum. Sed euismod turpis sed felis vehicula, eget maximus libero dignissim. Donec sit amet lectus id libero dignissim convallis. Duis non velit at lacus volutpat auctor.
                </p>
            </div>
        </div>
    </section>

    <section style="padding-top: 20px; position: relative; text-align: center; display: flex; justify-content: center; align-items: center;">
        <h1 style="padding-top: 100px; text-align: center; font-size: 38px; font-weight: 800; position: absolute; top: 0; left: 50%; transform: translateX(-50%); margin: 0;">PROJECTS UNLIMITED THROUGH THE YEARS</h1>


        <div class="flex justify-center mt-10" style="padding-left: 190px; position: absolute; z-index: 2; top: 120px; left: 0;">
            <div style="padding-top:20px ;padding-right: 20px;" class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/history1.png" style="width: 450px !important; height: auto !important;">
            </div>
        </div>
        <div class="flex justify-center items-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/history2.png" style="width: 450px !important; height: auto !important;">
            </div>
        </div>
        <div class="flex justify-center mt-10" style="padding-right: 190px; position: absolute; bottom: 90px; right: 0;">
            <div style="padding-left: 20px;" class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/history3.png" style="width: 450px !important; height: auto !important;">
            </div>
        </div>


        <div style="position: relative; display: flex; align-items: center; z-index: -1; height: 100vh;">
            <h1 id="years" style="color: #F6E17A; font-size: 800px; font-weight: font-black; margin: 0; letter-spacing: -0.13em; position: relative; z-index: 1; margin-left: -90px;"></h1>

            <div style="display: flex; flex-direction: column; z-index: 1;">
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





    <p class="text-2xl font-semibold text-black" style=" text-align: justify;  padding: 0px 190px; margin: 0;">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec diam vitae ligula tincidunt aliquet. Phasellus ultricies, lorem et faucibus mollis, justo mauris hendrerit dolor, a tristique velit neque et purus. Proin non felis eget enim posuere vestibulum. Integer nec augue nec ante malesuada bibendum. Sed euismod turpis sed felis vehicula, eget maximus libero dignissim. Donec sit amet lectus id libero dignissim convallis. Duis non velit at lacus volutpat auctor.
    </p>


    <script>
        // Get the current year
        var currentYear = new Date().getFullYear();

        // Year the company started
        var startYear = 1958;

        // Calculate the number of years
        var years = currentYear - startYear;

        // Set the content of the years element
        document.getElementById("years").innerText = years;
    </script>



    <section style="padding-top: 40px; padding-bottom: 20px; background: linear-gradient(to bottom, transparent, #F6E17A);">
        <h1 style="text-align: center; font-size: 38px; font-weight: 800;">ACHIEVEMENTS</h1>
        <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
            <a href="image1_link"><img src="../assets/image/iso1.png" style="width: 400px; height: auto;"></a>
            <a href="image2_link"><img src="../assets/image/greenguard.png" style="width: 400px; height: auto;"></a>
            <a href="image3_link"><img src="../assets/image/iso1.png" style="width: 400px; height: auto;"></a>
        </div>
    </section>





</body>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>