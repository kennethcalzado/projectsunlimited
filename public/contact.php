<?php
$pageTitle = "Contact Us";
ob_start();
?>
<div class="content">
    <div class="relative">
        <img src="../assets/image/contact.jpg" class="w-full h-96 object-cover object-top">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <p class="text-white font-extrabold text-3xl text-center">
                GET IN TOUCH WITH <br>
                <span class="text-[#F6E381]">PROJECTS UNLIMITED</span>
            </p>
        </div>
    </div>
    <p class="text-xl font-semibold text-black px-16 mt-8">You can also fill out the form below and send us a message.</p>
    <div class="flex px-8">
    <div class="w-1/2 p-8">
        <form action="#" method="post" class="space-y-4">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold">Name:</label>
                <input type="text" id="name" name="name" placeholder="Name" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="E-mail" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-bold">Phone Number:</label>
                <input type="tel" id="phone" name="phone" placeholder="Phone Number" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="subject" class="block text-gray-700 font-bold">Subject of Concern:</label>
                <input type="text" id="subject" name="subject" placeholder="Subject of Concern" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-gray-700 font-bold">Message:</label>
                <textarea id="message" name="message" rows="4" placeholder="Message" class="w-full p-2 border rounded-md"></textarea>
            </div>
            <button style="border-radius: 10px;" class="yellow-btn text-xl font-semibold justify-right">Submit</button>
        </form>
    </div>
    <div class="w-1/2 p-8">
        <div class="relative h-100 w-full flex items-center justify-center my-4">
        <img src="../assets/image/contactusformimage.jpg" alt="Image Description" class="w-full h-100 object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>
    </div>
</div>
</div>
<?php
$content = ob_get_clean();
include("../public/master.php");
?>