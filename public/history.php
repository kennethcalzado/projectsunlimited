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

    <section style="padding-top: 20px; padding-bottom: 90px;">
        <div style="width: 100%; text-align: center;">
            <h1 style="font-size: 38px; font-weight: 800; margin: 0;">MEET THE TEAM</h1>
        </div>

        <div style="text-align: center; height: 100vh; padding-top: 20px; padding-bottom: 40px;">
            <div style="position: relative; width: 100%; height: 85%;">
                <img src="../assets/image/teamsample.png" style="display: block; width: 100%; height: 100%;">
                <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 40%; background: linear-gradient(to top, rgba(246, 225, 122, 1) 1%, transparent);"></div>
            </div>
            <div style="background-color: #F6E17A; width: 100%; height: auto; padding: 20px 190px; text-align: center;">
                <p style="text-align: justify; color: black; padding: 20px 80px; margin: 0;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec diam vitae ligula tincidunt aliquet. Phasellus ultricies, lorem et faucibus mollis, justo mauris hendrerit dolor, a tristique velit neque et purus. Proin non felis eget enim posuere vestibulum. Integer nec augue nec ante malesuada bibendum. Sed euismod turpis sed felis vehicula, eget maximus libero dignissim. Donec sit amet lectus id libero dignissim convallis. Duis non velit at lacus volutpat auctor.
                </p>
            </div>
        </div>

    </section>

    <section style="text-align: center; display: flex; justify-content: center; align-items: center;  margin-top: -30px; margin-bottom: -30px;">
        <div style="display: flex; align-items: center;">
            <h1 id="years" style="color: #F6E17A; font-size: 800px; font-weight: extrabold; margin: 0; letter-spacing: -0.13em;"></h1>
            <div style="display: flex; flex-direction: column; margin-left: 10px;">
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: extrablack;">Y</p>
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: extrablack;">E</p>
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: extrablack;">A</p>
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: extrablack;">R</p>
                <p style="padding-left: 80px; color: #F6E17A; font-size: 98px; margin: 0; font-weight: extrablack;">S</p>
            </div>
        </div>
    </section>
    <p style="text-align: justify; color: black; padding: 0px 190px; margin: 0;">
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