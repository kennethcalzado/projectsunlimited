<?php
$pageTitle = "Brands - Arno";
ob_start();
?>
<!-- Your page content goes here -->
<div id="content">
    <!-- CAROUSEL -->
    <div id="brand-slider cotainer">
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
            <div class="carousel-arrow prev" onclick="prevSlide()">
                <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M6.707 10l5.147-5.146a.5.5 0 0 1 .708.708l-4.793 4.793 4.793 4.793a.5.5 0 1 1-.708.708l-5.147-5.146a.5.5 0 0 1 0-.708z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="carousel-arrow next" onclick="nextSlide()">
                <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M13.293 10l-5.147 5.146a.5.5 0 0 0 .708.708l4.793-4.793-4.793-4.793a.5.5 0 1 0-.708.708l5.147 5.146a.5.5 0 0 0 0-.708z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
    <!-- DESCRIPTION -->
    <div id="brand-definition cotainer">
        <blockquote class="text-xl text-justify px-24 py-10 font-semibold text-gray-900 dark:text-dark">
            <p>ARNO is a Projects Unlimited’s homegrown brand for office and commercial furniture. A trusted brand
                by designers and end users alike, ARNO furniture provides long-lasting comfort in your working space. We
                ensure that our products are durable, sleek, and elegant. With several designs and features to choose
                from</p>
        </blockquote>
    </div>
    <!-- DESCRIPTION -->
    <div id="brand-content cotainer">
        <div id="table-concepts-pic cotainer">
            <div class="relative bg-white p-4">
                <div class="absolute h-30 bg-black"></div>
                <div class="flex justify-between relative z-10">
                    <div class="w-1/4 bg-white p-4 rounded-lg">
                        <!-- Image 1 -->
                        <img src="https://picsum.photos/300/300" alt="Image 1">
                    </div>
                    <div class="w-1/4 bg-white p-4 rounded-lg">
                        <!-- Image 2 -->
                        <img src="https://picsum.photos/300/300" alt="Image 2">
                    </div>
                    <div class="w-1/4 bg-white p-4 rounded-lg">
                        <!-- Image 3 -->
                        <img src="https://picsum.photos/300/300" alt="Image 3">
                    </div>
                    <div class="w-1/4 bg-white p-4 rounded-lg">
                        <!-- Image 4 -->
                        <img src="https://picsum.photos/300/300" alt="Image 4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentIndex = 0;
    const items = document.querySelectorAll( ".carousel-item" );
    const totalItems = items.length;

    function nextSlide ()
    {
        if ( currentIndex < totalItems - 1 )
        {
            currentIndex++;
        } else
        {
            currentIndex = 0;
        }
        updateCarousel();
    }

    function prevSlide ()
    {
        if ( currentIndex > 0 )
        {
            currentIndex--;
        } else
        {
            currentIndex = totalItems - 1;
        }
        updateCarousel();
    }

    function updateCarousel ()
    {
        const width = items[currentIndex].clientWidth;
        document.querySelector(
            ".carousel-inner"
        ).style.transform = `translateX(-${ width * currentIndex }px)`;
    }
</script>

<?php
$content = ob_get_clean();
include("../public/master.php");
?>