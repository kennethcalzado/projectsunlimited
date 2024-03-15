<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $pageTitle . " - Projects Unlimited" ?>
    </title>
    <!-- Link to your Tailwind CSS file -->
    <link href="../assets/input.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />

</head>


<main>
    <?php echo $content ?? "" ?>
</main>
<!-- Footer -->
<footer class="bg-black text-white py-4">
    <div class="flex flex-col md:flex-row mx-16">
        <!-- Left Column -->
        <div class="md:w-1/3 p-4">
            <img src="../assets/image/projects.png" alt="Projects Unlimited Logo" class="w-56 h-66">

            <div class="mb-4 my-8">
                <p class="font-bold  text-xl">HEAD OFFICE</p>
                <p class=" text-xl">Address: 620 Tytana St., Binondo, Manila,
                    Philippines, 1006.</p>
                <p class=" text-xl">Phone: +632 8243 8888-95</p>
                <p class=" text-xl">E-mail: info@projectsunlimited.com.ph</p>
            </div>
        </div>
        <div class="md:w-1/3 p-4">
            <div class="mb-4 my-20">
                <p class="font-bold  text-xl">SHOWROOM</p>
                <p class=" text-xl">Address: Unit 104 Skyway Twin Towers, Cpt. Henry Javier Street, Oranbo,
                    Pasig, Philippines.</p>
                <p class=" text-xl">Phone: +632 8671 5100</p>
                <p class=" text-xl">E-mail: barcelon.projectsunlimited@yahoo.com</p>
            </div>
        </div>

        <!-- Right Column -->
        <div class="md:w-1/3 p-4">
            <div class="mb-4 my-20">
                <p class="font-bold  text-xl">BRANCH OFFICE</p>
                <p class=" text-xl">Address: 36 Granada, Quezon City, Metro Manila</p>
                <p class=" text-xl">Phone: +632 70028005</p>
                <p class=" text-xl">E-mail: benita_cabral@yahoo.com</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto text-center">
        <div class="flex items-center justify-center mt-4">
            <p class=" mr-1 text-lg">Follow Us:</p>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/projectsunlimitedph" class="text-2xl hover:text-[#F6E381]"><i class="fab fa-facebook light"></i></a>
                <a href="https://www.instagram.com/projectsunlimitedph" class="text-2xl hover:text-[#F6E381]"><i class="fab fa-instagram light"></i></a>
            </div>
        </div>

        <p class="text-base"><i>Copyright &copy; 2024 Projects Unlimited Powered by Projects Unlimited</i></p>
    </div>

</footer>



</html>