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
                    <p class="text-white font-bold text-4xl text-center">TIMELESS INTERIOR PRODUCTS SINCE <br> <span class="text-[#F6E381]">1968</span></p>
                </div>
            </div>
        </div>
    </section>
    <div style="width: 100%; text-align: center; padding-bottom: 20px; padding-top: 20px;">
        <h1 class="text-black" style=" font-size: 38px; font-weight: 800; margin: 0;">OUR PEOPLE</h1>
    </div>
    <section style="position: relative; padding-bottom: 40px;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1;">
            <img src="../assets/image/projectslogo.png" style="display: block; width: 100%; height: 100%;">
        </div>
        <div style="display: flex; justify-content: space-around; z-index: 2; padding: 0px 190px;">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/people1.png" style="width: 450px !important; height: auto !important;">
            </div>
            <div style="display: flex; justify-content: space-around; z-index: 2;" class="transition-opacity duration-1000 delay-2000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/people5.jpg" style="width: 450px !important; height: auto !important;">
            </div>
            <div class="transition-opacity duration-1000 delay-3000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/people3.jpg" style="width: 450px !important; height: auto !important;">
            </div>
        </div>

        <div style="display: flex; justify-content: space-around; z-index: 3; padding: 0px 190px;">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/people6.jpg" style="width: 450px !important; height: auto !important;">
            </div>
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/people4.jpg" style="width: 450px !important; height: auto !important;">
            </div>
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/people2.jpg" style="width: 450px !important; height: auto !important;">
            </div>
        </div>
    </section>
    <div style="position: relative;">
        <div style=" background-color: #F6E17A; width: 100%; text-align: center; padding: 0px 190px; position: relative;">
            <p class="text-2xl font-semibold text-black" style="text-align: justify; padding: 20px 40px 40px 40px; margin: 0;">
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

    <section style="padding-top: 40px; position: relative; text-align: center; display: flex; justify-content: center; align-items: center;">
        <h1 style="text-align: center; font-size: 38px; font-weight: 800; position: absolute; top: 0; left: 50%; transform: translateX(-50%); padding-top: 30px;">PROJECTS UNLIMITED THROUGH THE YEARS</h1>


        <div class="flex justify-center mt-10" style="padding-left: 190px; position: absolute; z-index: 2; top: 120px; left: 0;">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/company1.png" style="width: 450px !important; height: auto !important;">
            </div>
        </div>
        <div class="flex justify-center items-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/company2.jpg" style="width: 450px !important; height: auto !important;">
            </div>
        </div>
        <div class="flex justify-center mt-10" style="padding-right: 190px; position: absolute; bottom: 90px; right: 0;">
            <div class="transition-opacity duration-1000 delay-1000 ease-in-out hover:scale-110 opacity-0">
                <img src="../assets/image/company3.png" style="width: 450px !important; height: auto !important;">
            </div>
        </div>


        <div style="position: relative; display: flex; align-items: center; z-index: -1; height: 100vh;">
            <h1 id="years" style="color: #F6E17A; font-size: 800px; font-weight: font-black; margin: 0; letter-spacing: -0.13em; position: relative; z-index: 1; margin-left: -90px; margin-top: -120px;"></h1>

            <div style="display: flex; flex-direction: column; z-index: 1; margin-top: -100px;">
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

    </p>
    <br>
    <div style="position: relative;">
        <div style=" background-color: #F6E17A; width: 100%; text-align: center; padding: 0px 190px; position: relative;">
            <p class="text-2xl font-semibold text-black" style="text-align: justify; padding: 20px 40px 40px 40px; margin: 0;">
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



    <section style="padding-top: 40px; padding-bottom: 20px; background: linear-gradient(to bottom, transparent, #F6E17A);">
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