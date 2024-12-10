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

    <style>
        /* Responsive Styles */
        @media only screen and (max-width: 768px) {

            /* Adjustments for smaller screens */
            .md\:w-1\/4 {
                width: 100%;
                text-align: center !important;
            }

            .mx-16 {
                margin-left: 0.5rem;
                margin-right: 0.5rem;
            }

            .block {
                text-align: center !important;
            }

            .follow {
                font-size: 1rem;
                text-align: center !important;
                margin-left: 0px !important;
                justify-content: center !important;
            }
        }

        @media only screen and (max-width: 640px) {

            /* Additional adjustments for even smaller screens */
            .w-56 {
                width: 100%;
            }

            .md\:flex-col {
                flex-direction: column;
            }

            .ml-7 {
                margin-left: 0.5rem;
            }

            .text-lg {
                font-size: 1rem;
                text-align: center !important;
            }

            .ml-8 {
                margin-left: 0.5rem;
            }

            .mr-2 {
                margin-right: 0.5rem;
            }

            .text-2xl {
                font-size: 1.5rem;
            }

            .ml-12 {
                margin-left: 0.75rem;
            }

            .text-xl {
                font-size: 1.25rem;
            }

            .mx-1 {
                margin-left: 0.25rem;
                margin-right: 0.25rem;
            }

            .mx-2 {
                margin-left: 0.5rem;
                margin-right: 0.5rem;
            }

            .mt-2 {
                margin-top: 0.5rem;
                text-align: center !important;
            }

            .footerimage {
                width: 96%;
            }
        }
    </style>
</head>



<footer class="bg-black text-white py-4">
    <div class="flex flex-col md:flex-row mx-16">
        <!-- Left Column -->
        <div class="md:w-1/4 p-2 my-2 mt-8 items-center justify-center">
            <img src="/assets/image/projectslogo.png" alt="Projects Unlimited Logo" class="footerimage w-56 h-66 ml-7">
            <p class="text-sm mt-2">620 Tytana St., Binondo, Manila, Philippines, 1006</p>
            <p class="block text-sm text-justify mt-2">Head Office Contact Number: +632 8243 8888-95</p>
            <div class="container mx-auto text-center">
                <div class="follow flex items-center ml-6 mt-2">
                    <p class="text-lg ml-8 mr-2">Follow Us:</p>
                    <div class="flex space-x-2">
                        <a href="https://www.facebook.com/projectsunlimitedph" class="text-2xl hover:text-[#F6E381]"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.instagram.com/projectsunlimitedph" class="text-2xl hover:text-[#F6E381]"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/projectsunlimited/" class="text-2xl hover:text-[#F6E381]"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="mailto:info@projectsunlimited.com.ph" class="text-2xl hover:text-[#F6E381]"><i class="fa-solid fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fetch categories dynamically -->
        <?php
        include '../backend/conn.php';
        // Fetch main categories from the database
        $query = "SELECT CategoryName, page_path FROM productcategory WHERE ParentCategoryID IS NULL AND status = 'active'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="md:w-1/4 p-2">';
            echo '<div class="mb-4 my-2 mx-2 ml-12">';
            echo '<p class="text-xl font-bold text-center">Category</p>';
            while ($row = mysqli_fetch_assoc($result)) {
                $categoryName = $row['CategoryName'];
                $pagePath = '../pages' . $row['page_path'];
        ?>
                <p class="text-sm mt-1 font-semibold text-center hover:text-[#F6E381]"><a href="<?php echo $pagePath; ?>"><?php echo $categoryName; ?></a></p>
        <?php
            }
            echo '</div>';
            echo '</div>';
        }
        ?>
        <!-- End of dynamically fetched categories -->

        <div class="md:w-1/6 p-2">
            <div class="mb-4 my-2 mx-1">
                <p class="text-xl font-bold text-center">Company</p>
                <a href="/public/about.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">About Us</a>
                <a href="/public/blogs.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">Updates</a>
                <a href="/public/contact.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">Contact Us</a>
            </div>
        </div>
        <div class="md:w-1/6 p-2">
            <div class="mb-4 my-2 mx-2">
                <p class="text-xl font-bold text-center">Services</p>
                <a href="/public/brands.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">Brands</a>
                <a href="/public/category.php" class="block text-sm mt-1 font-semibold text-center hover:text-[#F6E381]">Products</a>
            </div>
        </div>
        <div class="md:w-1/4 p-2">
            <div class="mb-4 my-2 mx-2 ml-12">
                <p class="text-xl font-bold ml-8">Office Hours</p>
                <p class="block text-sm mt-1 font-semibold  hover:text-[#F6E381]">Mondays - Fridays <u>9am - 5pm</u>
                </p>
                <p class="block text-sm font-bold hover:text-[#F6E381]">Weekends and Holidays <u>CLOSED</u></p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <p class="text-center text-sm font-bold justify-center"><i>Copyright &copy; 2024 Projects Unlimited Powered
                by Projects Unlimited</i></p>
    </div>
</footer>

</html>