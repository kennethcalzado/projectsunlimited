<?php
$is_public_page = true;
$pageTitle = "Products - Modular Cabinets";
ob_start();
?>
<div class="content">
    <div class="relative">
        <img src="../assets/image/modular.jpg" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-end text-center">
            <p class="text-white font-extrabold text-3xl mr-8">MODULAR CABINETS<br>
                <span class="text-white font-semibold text-xl mr-2 mt-2 hover:text-[#F6E381]">Customize Your Own Cabinets Now!<br></span>
            </p>
        </div>
    </div>
    <header class="bg-[#F6E381]">
        <div class="container mx-auto">
            <nav class="py-2">
                <div class="container mx-auto flex items-center justify-between">
                    <div class="hidden md:flex flex-grow">
                        <ul class="flex justify-between w-full mx-20">
                            <li><a href="../public/blinds.php" class="text-black font-bold hover:text-gray-700">BLINDS</a></li>
                            <li><a href="../public/flooring.php" class="text-black font-bold hover:text-gray-700">FLOORINGS</a></li>
                            <li><a href="../public/wallcover.php" class="text-black font-bold hover:text-gray-700">WALLCOVERING</a></li>
                            <li><a href="../public/office.php" class="text-black font-bold hover:text-gray-700">OFFICE ACCESSORIES</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <div id="customcontainer">
        <div class="p-8">
            <div class="flex items-center p-2 px-8">
                <div class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">1</div>
                <h3 class="text-gray-800 font-bold text-3xl ">INQUIRE</h3>
            </div>
            <div class="flex items-center">
                <p class="font-semibold text-2xl p-4 px-8 mx-12">Ask about the product and set an official appointment with Projects Unlimited. We are willing to get in touch with you directly and know your ideas.</p>
            </div>
            <div class="flex items-center justify-end p-2 px-8">
                <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">PLAN</h3>
                <div class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">2</div>
            </div>
            <div class="flex items-center">
                <p class="text-right font-semibold text-2xl p-4 px-8 mx-12">Discuss your desired dimension, color, texture, and materials for your customized products and we’ll do it for you. The budget and timeline will be discussed as well.</p>
            </div>
            <div class="flex items-center p-2 px-8">
                <div class="w-10 h-10 bg-gray-800 text-white flex items-center justify-center rounded-full text-xl font-bold mr-4">3</div>
                <h3 class="text-gray-800 font-bold text-3xl">CREATE</h3>
            </div>
            <div class="flex items-center">
                <p class="font-semibold text-2xl p-4 px-8 mx-12">Our team will proceed to create your desired products and we’ll give you an estimated time of completion and we’ll keep you updated at all time.</p>
            </div>
            <div class="flex items-center justify-end p-2 px-8">
                <h3 class="text-gray-800 text-right font-bold text-3xl mr-4">DELIVER & INSTALL</h3>
                <div class="w-10 h-10 border-4 border-gray-800 text-gray-800 flex items-center justify-center rounded-full text-xl font-bold mr-4">4</div>
            </div>
            <div class="flex items-center justify-end">
                <p class=" text-right font-semibold text-2xl pb-2 px-8 pt-2 mx-12">Once the products are completed, we will proceed to delivering and installing the products to your place.</p>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-center p-2 px-8">
        <div class="border-b border-gray-800 flex-grow border-4 "></div>
        <h3 class="text-gray-800 text-right font-bold text-3xl mx-4">OR</h3>
        <div class="border-b border-gray-800 flex-grow border-4 "></div>
    </div>
    <div class="formcontainer">
        <p class="text-2xl font-semibold text-black px-16 mt-2">You can also fill out the form below and send us a
            message.</p>
        <div class="mx-16 mt-2 mb-4">
            <form action="#" method="post" class="space-y-4">
                <div class="mb-4">
                    <label for="name" class="block text-black font-bold text-xl">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Name" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-black font-bold text-xl">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="E-mail" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-black font-bold text-xl">Phone Number:</label>
                    <input type="text" id="phone" name="phone" placeholder="Phone Number" class="w-full p-2 border rounded-md" required>
                    <small class="text-red-500" id="phone-error"></small>
                </div>
                <div class="mb-4">
                    <label for="subject" class="block text-black font-bold text-xl">Subject of Concern:</label>
                    <input type="text" id="subject" name="subject" placeholder="Subject of Concern" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-black font-bold text-xl">Message:</label>
                    <textarea id="message" name="message" rows="4" placeholder="Message" class="w-full p-2 border resize-none rounded-md"></textarea>
                </div>
                <button style="border-radius: 10px;" class="yellow-btn text-xl font-semibold justify-right">Submit</button>
            </form>
        </div>
    </div>
    <script>
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phone-error');

        phoneInput.addEventListener('input', function() {
            // Remove non-numeric characters
            phoneInput.value = phoneInput.value.replace(/\D/g, '');

            // Check if the input contains letters
            if (/[a-zA-Z]/.test(phoneInput.value)) {
                phoneError.textContent = 'Phone number should only contain numbers.';
                phoneInput.setCustomValidity('Invalid phone number.');
            } else {
                phoneError.textContent = '';
                phoneInput.setCustomValidity('');
            }
        });
    </script>
    <?php
    $content = ob_get_clean();
    include("../public/master.php");
    ?>