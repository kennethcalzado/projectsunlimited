<?php
$pageTitle = "Brands - Arno";
ob_start();
?>
<!-- Your page content goes here -->
<div id="content">
    <!-- CAROUSEL -->
    <div id="brand-slider-container">
        <div class="carousel relative !h-dvh">
            <div class="carousel-inner flex">
                <div class="carousel-item w-full text-white text-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-yellow-300 to-transparent h-dvh">
                        <img src="../assets/image/arno.png" alt="Image 1"
                            class="z-10 mx-auto object-contain w-screen !h-dvh">
                    </div>
                </div>
                <div class="carousel-item w-full text-white text-center h-96 relative">
                    <img src="../assets/image/flooring.png" alt="Image 2" class="mx-auto object-contain max-h-full">
                </div>
                <div class="carousel-item w-full text-white text-center h-96 relative">
                    <img src="../assets/image/office.png" alt="Image 3" class="mx-auto object-contain max-h-full">
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
            <p>
                <strong>ARNO</strong> is a Projects Unlimited’s homegrown brand for office and commercial furniture. A
                trusted brand
                by designers and end users alike, ARNO furniture provides long-lasting comfort in your working space. We
                ensure that our products are durable, sleek, and elegant. With several designs and features to choose
                from
            </p>
        </blockquote>
    </div>
    <!-- PICS -->
    <div id="brand-content cotainer">
        <div id="table-concepts-pic cotainer">
            <div class="relative flex justify-center items-center">
                <div class="absolute m-20 h-32 w-full bg-black"></div> <!-- Adjusted height and added width -->
                <div class="flex justify-between relative z-10 mb-20">
                    <div class="w-1/4 p-4 rounded-lg">
                        <!-- Image 1 -->
                        <img src="../assets\image\wallpaper.png" alt="Image 1">
                    </div>
                    <div class="w-1/4 p-4 rounded-lg">
                        <!-- Image 2 -->
                        <img src="../assets\image\wallpaper.png" alt="Image 2">
                    </div>
                    <div class="w-1/4 p-4 rounded-lg">
                        <!-- Image 3 -->
                        <img src="../assets\image\wallpaper.png" alt="Image 3">
                    </div>
                    <div class="w-1/4 p-4 rounded-lg">
                        <!-- Image 4 -->
                        <img src="../assets\image\wallpaper.png" alt="Image 4">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <table>
                <tr>
                    <th>Concepts</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>
                        <p class="font-karla font-extrabold text-3xl leading-relaxed text-center text-black">
                            TABLE CONCEPTS
                        </p>
                        <button type="button"
                            class="w-80 h-16 inset-0 bg-yellow-300 rounded-full  left-0 top-0 font-normal text-xl leading-relaxed text-center text-black hover:bg-yellow-200 hover:font-semibold hover:shadow-md">
                            View Catalog
                        </button>
                    </td>
                    <td>
                        <p class="font-karla font-medium leading-relaxed text-justify text-black">
                            ARNO is a Projects Unlimited’s homegrown brand for office and commercial furniture. A
                            trusted brand
                            by designers and end users alike, ARNO furniture provides long-lasting comfort in your
                            working
                            space.
                            We ensure that our products are durable, sleek, and elegant. With several designs and
                            features to
                            choose from
                        </p>
                    </td>
                </tr>
                <tr>
                    
                </tr>
            </table>
        </div>
        <div class="flex items-center justify-center my-10">
            <div id="table-concept-button" class="ml-10">
                <p class="font-karla font-extrabold text-3xl leading-relaxed text-center text-black">
                    TABLE CONCEPTS
                </p>

                <button type="button"
                    class="w-80 h-16 inset-0 bg-yellow-300 rounded-full  left-0 top-0 font-normal text-xl leading-relaxed text-center text-black hover:bg-yellow-200 hover:font-semibold hover:shadow-md">
                    View Catalog
                </button>
            </div>
            <div id="table-concept-descrip" class="mx-10"> <!-- Added margin-right for spacing -->
                <p class="font-karla font-medium leading-relaxed text-justify text-black">
                    ARNO is a Projects Unlimited’s homegrown brand for office and commercial furniture. A trusted brand
                    by designers and end users alike, ARNO furniture provides long-lasting comfort in your working
                    space.
                    We ensure that our products are durable, sleek, and elegant. With several designs and features to
                    choose from
                </p>
            </div>
        </div>

        <div class="flex items-center justify-center my-10">
            <div id="table-concept-descrip" class="mx-10">
                <p class="font-karla font-medium leading-relaxed text-justify text-black">
                    ARNO Office Furniture can have your workspace customized to you and your staff’s needs, through
                    various office accessories, ensuring a comfortable and efficient work flow. Our available office
                    system accessories include:
                </p>
                <ul class="font-karla font-medium leading-relaxed text-justify text-black list-disc list-inside">
                    <li class="pl-10">Wire management and Cable Boxes</li>
                    <li class="pl-10">Desk Partitioning and Screens</li>
                    <li class="pl-10">Specialized Storage and Organizers</li>
                    <li class="pl-10">Adjustable Table Legs</li>
                </ul>
            </div>
            <div id="table-concept-button" class="mr-10">
                <p class="font-karla font-extrabold text-3xl leading-relaxed text-center text-black">
                    OFFICE ACCESSORIES
                </p>
                <button type="button"
                    class="w-80 h-16 inset-0 bg-yellow-300 rounded-full  left-0 top-0 font-normal text-xl leading-relaxed text-center text-black hover:bg-yellow-200 hover:font-semibold hover:shadow-md">
                    View Catalog
                </button>
            </div>
        </div>

        <div id="table-concepts-pic cotainer">
            <div class="relative flex justify-center items-center">
                <div class="absolute m-20 h-32 w-full bg-black"></div> <!-- Adjusted height and added width -->

                <div class="flex justify-between relative z-10">
                    <div class="w-1/4 p-4 rounded-lg">
                        <!-- Image 1 -->
                        <img src="../assets\image\wallpaper.png" alt="Image 1">
                    </div>
                    <div class="w-1/4 p-4 rounded-lg">
                        <!-- Image 2 -->
                        <img src="../assets\image\wallpaper.png" alt="Image 2">
                    </div>
                    <div class="w-1/4 p-4 rounded-lg">
                        <!-- Image 3 -->
                        <img src="../assets\image\wallpaper.png" alt="Image 3">
                    </div>
                    <div class="w-1/4 p-4 rounded-lg">
                        <!-- Image 4 -->
                        <img src="../assets\image\wallpaper.png" alt="Image 4">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center my-10">
            <div id="table-concept-button" class="mx-10">
                <p class="font-karla font-extrabold text-3xl leading-relaxed text-center text-black">
                    OFFICE CHAIRS
                </p>
                <div class="flex flex-col items-center"> <!-- Added flex container for vertical alignment -->
                    <button type="button"
                        class="w-80 h-16 bg-yellow-300 rounded-full font-normal text-xl leading-relaxed text-center text-black hover:bg-yellow-200 hover:font-semibold hover:shadow-md mb-2">
                        View Catalog 1
                    </button>

                    <button type="button"
                        class="w-80 h-16 bg-yellow-300 rounded-full font-normal text-xl leading-relaxed text-center text-black hover:bg-yellow-200 hover:font-semibold hover:shadow-md mb-2">
                        View Catalog 2
                    </button>

                    <button type="button"
                        class="w-80 h-16 bg-yellow-300 rounded-full font-normal text-xl leading-relaxed text-center text-black hover:bg-yellow-200 hover:font-semibold hover:shadow-md">
                        View Our On-hand Product
                    </button>
                </div>
            </div>
            <div id="table-concept-descrip" class="mx-10">
                <p class="font-karla font-medium leading-relaxed text-justify text-black">
                    Today, office seating is not enough if it's only comfortable; it must be durable and elegant as
                    well.
                    Check out our on-hand stock today.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-center my-10">
            <div id="table-concept-descrip" class="mx-10">
                <p class="font-karla font-medium leading-relaxed text-justify text-black">
                    Every office requires storage space to house documents, files, and personal items. Although the
                    purpose of office storage is purely utilitarian it does not mean that they cannot be aesthetically
                    pleasing as well. ARNO Office Furniture has a variety of steel and laminated storage options to
                    choose from.
                </p>
            </div>
            <div id="table-concept-button" class="mr-10">
                <p class="font-karla font-extrabold text-3xl leading-relaxed text-center text-black">
                    STORAGE AND OTHERS </p>
                <button type="button"
                    class="w-80 h-16 inset-0 bg-yellow-300 rounded-full  left-0 top-0 font-normal text-xl leading-relaxed text-center text-black hover:bg-yellow-200 hover:font-semibold hover:shadow-md">
                    View Catalog
                </button>
            </div>
        </div>
    </div>

    <div class="relative w-full h-screen">
        <div class="w-full h-full py-5 bg-yellow-200 flex flex-col justify-center items-center">
            <div class="w-4/5">
                <h1 class="font-karla font-bold text-4xl md:text-5xl lg:text-6xl text-black">
                    The <span class="text-yellow-950">possibilities</span> are
                    <span class="text-yellow-950">unlimited</span>.
                </h1>

                <p class="font-karla font-medium text-lg md:text-xl lg:text-2xl text-justify text-black mt-4">Whatever
                    concept or
                    aesthetic you are planning for, we can build and help design with you. Get in touch now to
                    schedule
                    measurement and layouting for free!</p>
            </div>
            <div class="!mt-10">
                <button type="button"
                    class="w-80 h-16 bg-gray-800 rounded-full text-white font-quicksand font-normal text-lg md:text-xl lg:text-2xl flex items-center justify-center shadow-md hover:bg-gray-700 hover:font-semibold">
                    Contact Us
                </button>
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
include ("../../public/master.php");
?>