<?php
$pageTitle = "Home";
ob_start();
?>

<div id="content">
    <!-- About page content goes here -->
    <h2>About Us</h2>
    <p>Learn more about our company and mission.</p>

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