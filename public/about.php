<?php
$is_public_page = true;
$pageTitle = "About Us";
ob_start();
?>

<head>
    <style>
        .content {
            padding: 0px !important;
            /* Add padding to the content for better readability */
        }

        /* Mobile styles */
        @media only screen and (max-width: 768px) {
            .text-4xl {
                font-size: 1.5rem;
                /* Adjust font size for smaller screens */
            }

            .h-96 {
                height: auto;
                /* Allow image height to adjust based on content */
            }

            .grid-cols-1 {
                grid-template-columns: 1fr;
                /* Set grid to single column for mobile */
            }

            .content {
                padding: 10px;
                /* Adjust padding for smaller screens */
            }

            .text-9xl {
                font-size: 3rem;
                /* Adjust font size for smaller screens */
            }

            .text-5xl {
                font-size: 1.75rem;
                /* Adjust font size for smaller screens */
            }


            .section {
                padding-left: 20px;
                padding-right: 20px;
                flex-direction: column;
                /* Stack columns on top of each other */
                align-items: stretch;
                /* Stretch columns to full width */
            }

            .column {
                width: 100%;
                /* Make columns full width in mobile view */
            }

            .values {
                padding-top: 10px !important;
                padding-bottom: 0px !important;
            }

            .balyu {
                margin-top: -10px !important;
                align-items: center !important;
                width: 100% !important;
            }

            #values {
                padding-bottom: 20px !important;
            }

            .services {
                font-size: 16px !important;
                text-align: center !important;
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .serv {
                text-align: justify !important;
                font-size: 14px !important;
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .diamond {
                width: 50px !important;
                height: 50px !important;
            }

            .servicesection {
                padding-left: 10px !important;
                padding-right: 10px !important;
                padding-top: 10px !important;
                padding-bottom: 20px !important;
            }

            .servdiv {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .years {
                margin-top: -20px !important;
            }

            .grace {
                margin-top: -20px !important;
            }

            .yearss {
                margin-top: -10px !important;
            }
        }
    </style>
</head>


<body>
    <a href="#top" class="back-to-top">
        <div>
            <i class="fas fa-arrow-up"></i>
        </div>
    </a>
    <section class="fade-in-hidden">
        <div class="relative">
            <img src="../assets/image/about.png" class="w-full h-96 object-cover">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <p class="text-white font-bold text-4xl text-center">GET TO KNOW <br> <span class="text-[#F6E381]">PROJECTS UNLIMITED</span></p>
            </div>
        </div>
    </section>

    <section class="section fade-in-hidden">
        <div class="content">
            <div class="grid grid-cols-1 md:grid-cols-[1fr,3fr] gap-0 md:gap-0">
                <div class="yearss flex items-center justify-center">
                    <div id="year-count" class="year-animation flex flex-col items-center">
                        <p id="year-count-text" class="text-[#F6E17A] text-9xl font-extrabold mb-1">Loading...</p>
                        <p class="years text-[#F6E17A] text-5xl font-bold">YEARS</p>
                    </div>
                </div>
                <div class="column" style="display: flex; align-items: center;">
                    <p class="text-2xl font-semibold text-black" style="text-align: justify;">Projects Unlimited Philippines Inc., is a leading provider of interior products, and a preferred supplier for many architects, interior designers, contractors, and homeowners.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section fade-in-hidden" style="margin-top: -30px; display: flex; justify-content: space-between; align-items: center;">
        <div class="content">
            <div style="display: flex; flex-direction: column;">
                <p class="grace text-2xl font-semibold text-black" style="padding-top: 50px; text-align: justify;">
                    Projects Unlimited has been offering graceful and practical interiors for our longstanding clients and has also created long-lasting impact on the field of architecture and interior design due to its introduction of several timeless interior products into the market after being in the industry since 1958.
                </p>
            </div>

            <span style="align-self: flex-end; text-align: right; margin-top: -30px;">
                <p class="text-2xl font-semibold text-black px-16 mt-5" style="text-align: center;">
                    To know more about Projects Unlimited,
                    <a href="history.php" style="text-decoration: none;">
                        <button style="border-radius: 50px; font-weight: 400;" class="yellow-btn">Click here ►</button>
                    </a>
                </p>
            </span>
        </div>
    </section>

    <section class="section fade-in-hidden" style="padding-top: 30px; display: flex; justify-content: center; align-items: center;">
        <div class="column" style="padding: 20px; flex-grow: 1; width: 100%; text-align: center;">
            <p style="padding-bottom: 10px; text-align:left; font-weight: 800;">MISSION</p>
            <p class="text-2xl text-black" style="text-align: justify;">
                To improve the quality of life of the Filipino in the home and at the workplace by providing quality products and services at a cost that doesn’t go beyond the limits and to provide continuing employment to the members of its corporate family. 
            </p>
        </div>
        <div class="column" style="flex-grow: 1; width: 100%; background-color: #F6E17A; padding: 20px; text-align: center;">
            <p class="text-2xl  text-black" style="text-align: justify;">
                Projects Unlimited looks ahead to a still brighter future. It will maintain its general product structure but is constantly on the look out to introduce new trends in interior decors to the Philippine market.
            </p>
            <p style="padding-top: 10px; text-align:right; font-weight: 800;">VISION</p>
        </div>
    </section>

    <div class="values fade-in-hidden" style="text-align: center;  padding-top: 25px; padding-bottom: 15px;">
        <h1 style="font-size: 38px; font-weight: 800; ">VALUES</h1>
    </div>

    <section id="values" class="section fade-in-hidden" style="margin-top: -20px; padding-bottom: 40px; display: flex; justify-content: center;">
        <div class="balyu" style="flex-grow: 1; width: 25%; text-align: center; border-right: 2px solid #F6E17A;">
            <p class="text-2xl" style=" font-weight: bold;">Full Customer Support</p>
        </div>
        <div class="balyu" style="border-left: 2px solid #F6E17A; flex-grow: 1; width: 25%; text-align: center; border-right: 2px solid #F6E17A;">
            <p class="text-2xl" style="font-weight: bold;">Quality Assurance</p>
        </div>
        <div class="balyu" style="flex-grow: 1; width: 25%; text-align: center; border-left: 2px solid #F6E17A; border-right: 2px solid #F6E17A;">
            <p class="text-2xl" style="font-weight: bold;">Affordability</p>
        </div>
        <div class="balyu" style="border-left: 2px solid #F6E17A; flex-grow: 1; width: 25%; text-align: center; ">
            <p class="text-2xl" style="font-weight: bold;">Trendsetting Designs</p>
        </div>
    </section>





    <section class="servicesection" style="padding-top: 40px; padding-bottom: 20px; padding-left: 190px; padding-right: 190px; background: linear-gradient(to bottom, #F6E17A, transparent 50%, #F6E17A 100%);">
        <div style="position: relative;">
            <img class="diamond" src="../assets/image/element.png" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 150px; height: 150px; z-index: -1;">
            <h1 style="text-align: center; font-size: 38px; font-weight: 800;">SERVICES</h1>
            <div style="display: flex; padding-top: 20px; align-items: center;">
                <div class="servimage1" style="flex: 1; display: flex; align-items: center; position: relative;">
                    <img src="../assets/image/designplan.png" style="width: 100%; height: auto;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
                </div>

                <div class="servdiv fade-in-hidden" style="text-align: justify; flex: 2; padding-left: 50px; display: flex; align-items: center;">
                    <div>
                        <p class="services" style="padding-bottom: 10px; text-align:left; font-weight: 800;">Designing and Planning</p>
                        <p class="serv" style="font-size: 24px;">
                            Getting started on your space is sometimes the hardest part as all the different choices can become overwhelming. Fortunately, our highly talented and friendly staff can support and guide you at every step of the way. From choosing colors and designs to creating a layout and render of your space, we want our project with you to be exactly how you imagine it to be.
                            <br>
                        </p>
                    </div>
                </div>
            </div>

            <div class="fade-in-hidden" style="display: flex; padding-top: 20px; align-items: center;">
                <div style="text-align: justify; flex: 2; display: flex; align-items: center;">
                    <div>
                        <p class="services" style="padding-right: 50px; padding-bottom: 10px; text-align:right; font-weight: 800;">Customize Order</p>
                        <p class="serv" style="padding-right: 50px; font-size: 24px;">
                            As a local manufacturer many of our products can be customized to the requirements of our clients. These may include the dimensions, colors, textures, and materials used in the item. We take pride in having a large variety of choices for our clients to choose from for any type of project.
                            <br>
                        </p>
                    </div>
                </div>
                <div style="flex: 1; display: flex; align-items: center; position: relative;">
                    <img src="../assets/image/customorder.png" style="width: 100%; height: auto;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
                </div>
            </div>

            <div class="fade-in-hidden" style="display: flex; padding-top: 20px; align-items: center;">
                <div style="flex: 1; display: flex; align-items: center; position: relative;">
                    <img src="../assets/image/install.png" style="width: 100%; height: auto;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
                </div>
                <div class="servdiv" style="text-align: justify; flex: 2; padding-left: 50px; display: flex; align-items: center;">
                    <div>
                        <p class="services" style="padding-bottom: 10px; text-align:left; font-weight: 800;">Installation and Project Management</p>
                        <p class="serv" style="font-size: 24px;">
                            Projects Unlimited has been in business for over half a century already. In this time we made huge leaps in fully integrated our core business units from manufacturing up until installation. Not only can we customize your interior decors to your requirements, but we can manage your project with us through our in-house installation and project management teams.
                            <br>
                        </p>
                    </div>
                </div>
            </div>

            <div style="display: flex; padding-top: 20px; align-items: center;">
                <div class="fade-in-hidden" style="text-align: justify; flex: 2; display: flex; align-items: center;">
                    <div>
                        <p class="services" style="padding-right: 50px; padding-bottom: 10px; text-align:right; font-weight: 800;">After Sales Support</p>
                        <p class="serv" style="padding-right: 50px; font-size: 24px;">
                            A common pain that we hear from our new clients is that their past suppliers are unreliable after a transaction is made. At Projects Unlimited, we understand that projects come with several obstacles, changes, and added requirements. Thus, we feature a robust after-sales service that goes beyond service warranties. We are committed to providing you not only with a high quality product, but also a premium experience — all for an affordable price.
                            <br>
                        </p>
                    </div>
                </div>
                <div class="servimage2" style="flex: 1; display: flex; align-items: center; justify-content: center; position: relative;">
                    <img src="../assets/image/aftersales.png" style="width: 100%; height: auto;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);"></div>
                </div>
            </div>
        </div>
    </section>


    <script>
        // Get the founding year of the company
        const foundingYear = 1968;

        // Function to update the year count with animation
        function updateYearCount() {
            const currentYear = new Date().getFullYear();
            const yearsElapsed = currentYear - foundingYear;
            const yearCountText = document.getElementById("year-count-text");
            let count = 1;

            // Animate the year count incrementally
            const intervalId = setInterval(function() {
                yearCountText.innerText = count;
                count++;

                if (count > yearsElapsed) {
                    clearInterval(intervalId); // Stop the animation when count reaches the total elapsed years
                }
            }, 40);
        }

        // Update the year count animation
        updateYearCount();
    </script>

</body>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>