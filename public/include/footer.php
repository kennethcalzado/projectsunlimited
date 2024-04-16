<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $pageTitle . " - Projects Unlimited" ?>
    </title>
    <!-- Link to your Tailwind CSS file -->
    <link href="/assets/input.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />

</head>


<main>
    <?php echo $content ?? "" ?>
</main>
<!-- Footer -->
<footer class="bg-black text-white py-4">
    <div class="flex flex-col md:flex-row mx-16">
        <!-- Left Column -->
        <div class="md:w-1/4 p-2 my-2 mt-8 items-center justify-center">
            <img src="/assets/image/projectslogo.png" alt="Projects Unlimited Logo" class="w-56 h-66 ml-7">
            <p class="text-sm mt-2">620 Tytana St., Binondo, Manila, Philippines, 1006</p>
            <div class="container mx-auto text-center">
                <div class="flex items-center ml-6 mt-2">
                    <p class="text-lg ml-8 mr-2">Follow Us:</p>
                    <div class="flex space-x-2">
                        <a href="https://www.facebook.com/projectsunlimitedph" class="text-2xl hover:text-[#F6E381]"><i class="fab fa-facebook light"></i></a>
                        <a href="https://www.instagram.com/projectsunlimitedph" class="text-2xl hover:text-[#F6E381]"><i class="fab fa-instagram light"></i></a>
                        <a href="https://www.linkedin.com/company/projectsunlimited/" class="text-2xl hover:text-[#F6E381]"><i class="fab fa-linkedin light"></i></a>
                        <a href="mailto:info@projectsunlimited.com.ph" class="text-2xl hover:text-[#F6E381]"><i class="fab fa-google"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="md:w-1/6 p-2">
            <div class="mb-4 my-2 mx-2">
                <p class="text-xl font-bold text-center justify-center">Category</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Blinds</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Floorings</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Wallcovering</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Office</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Modular Cabinets</p>
            </div>
        </div>
        <div class="md:w-1/6 p-2">
            <div class="mb-4 my-2 mx-2">
                <p class="text-xl font-bold text-center justify-center">Company</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">About Us</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Updates</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Locations</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Contact Us</p>
            </div>
        </div>
        <div class="md:w-1/6 p-2">
            <div class="mb-4 my-2 mx-2">
                <p class="text-xl font-bold text-center justify-center">Services</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Brands</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Gallery</p>
                <p class="text-sm mt-1 font-semibold text-center justify-center  hover:text-[#F6E381]">Products</p>
            </div>
        </div>
        <div class="md:w-1/4 p-2">
            <div class="mb-4 my-2 mx-2 ml-12">
                <p class="text-xl font-bold text-left">Office Hours</p>
                <p class="text-sm mt-1 font-semibold text-left  hover:text-[#F6E381]">Mondays - Fridays <u>8am - 5pm</u></p>
                <!-- <p class="text-sm mt-1 font-semibold text-left  hover:text-[#F6E381]">Saturdays <u>8am - 5pm</u></p>-->
                <p class="text-sm font-bold text-left">Sundays and Holidays <u>CLOSED</u></p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <p class="text-center text-sm font-bold justify-center"><i>Copyright &copy; 2024 Projects Unlimited Powered by Projects Unlimited</i></p>
    </div>
</footer>

</html>