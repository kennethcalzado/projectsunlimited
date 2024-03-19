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
    <p class="text-2xl font-semibold text-black px-16 mt-8">For any inquiries about our products, you may contact or
        visit us through the details below.</p>
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="mapscontainer">
                <iframe id="googleMap"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.9708020807752!2d120.97184307591911!3d14.600739177071674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca102318b44d%3A0x6483de216eafa800!2sProjects%20Unlimited!5e0!3m2!1sen!2sph!4v1710422091205!5m2!1sen!2sph"
                    width="100%" height="500" style="border:0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="address-container mt-8">
                <h2 class="text-xl font-semibold mb-4">You can visit us at these locations:</h2>
                <ul>
                    <li class="address-item cursor-pointer font-bold text-xl" onclick="updateMap('Manila')">Head Office
                        (Manila)
                        <ul>
                            <li>Address: 620 Tytana St., Binondo, Manila, Philippines, 1006.</li>
                            <li>Phone: +632 8243 8888-95</li>
                            <li>Email: info@projectsunlimited.com.ph</li>
                        </ul>
                    </li>
                    <li class="address-item cursor-pointer mt-4 font-bold text-xl" onclick="updateMap('Pasig')">Showroom
                        (Pasig)
                        <ul>
                            <li>Address: Unit 104 Skyway Twin Towers, Cpt. Henry Javier Street, Oranbo, Pasig,
                                Philippines.</li>
                            <li>Phone: +632 8671 5100</li>
                            <li>Email: barcelon.projectsunlimited@yahoo.com</li>
                        </ul>
                    </li>
                    <li class="address-item cursor-pointer mt-4 font-bold text-xl" onclick="updateMap('Granada')">Branch
                        Office (Granada)
                        <ul>
                            <li>Address: 36 Granada, Quezon City, Metro Manila</li>
                            <li>Phone: +632 70028005</li>
                            <li>Email: benita_cabral@yahoo.com</li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="flex items-center justify-center p-2 px-16">
        <div class="border-b border-gray-800 flex-grow border-4 "></div>
        <h3 class="text-gray-800 text-right font-bold text-3xl mx-4">OR</h3>
        <div class="border-b border-gray-800 flex-grow border-4 "></div>
    </div>
    <div class="formcontainer">
        <p class="text-2xl font-semibold text-black px-16 mt-8">You can also fill out the form below and send us a
            message.</p>
        <div class="flex px-8">
            <div class="w-1/2 p-8">
                <form action="#" method="post" class="space-y-4">
                    <div class="mb-4">
                        <label for="name" class="block text-black font-bold text-xl">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Name" class="w-full p-2 border rounded-md"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-black font-bold text-xl">E-mail:</label>
                        <input type="email" id="email" name="email" placeholder="E-mail"
                            class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-black font-bold text-xl">Phone Number:</label>
                        <input type="text" id="phone" name="phone" placeholder="Phone Number"
                            class="w-full p-2 border rounded-md" required>
                        <small class="text-red-500" id="phone-error"></small>
                    </div>
                    <div class="mb-4">
                        <label for="subject" class="block text-black font-bold text-xl">Subject of Concern:</label>
                        <input type="text" id="subject" name="subject" placeholder="Subject of Concern"
                            class="w-full p-2 border rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-black font-bold text-xl">Message:</label>
                        <textarea id="message" name="message" rows="4" placeholder="Message"
                            class="w-full p-2 border resize-none rounded-md" required></textarea>
                    </div>
                    <div class="mb-4 flex justify-end">
                        <button style="border-radius: 10px;"
                            class="yellow-btn text-xl w-50 h-12 font-semibold">Submit</button>
                    </div>
                </form>
            </div>
            <div class="w-1/2 p-8">
                <div class="relative h-100 w-full flex items-center justify-center my-4">
                    <img src="../assets/image/contactusformimage.jpg" alt="Image Description"
                        class="w-full h-100 object-cover">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include ("../public/master.php");
?>

<!--SCRIPT-->
<script>
    function updateMap(location) {
        var iframe = document.getElementById('googleMap');
        if (location === 'Manila') {
            iframe.src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.9708020807752!2d120.97184307591911!3d14.600739177071674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca102318b44d%3A0x6483de216eafa800!2sProjects%20Unlimited!5e0!3m2!1sen!2sph!4v1710422091205!5m2!1sen!2sph";
            // Remove 'selected' class from all other items
            document.querySelectorAll('.address-item').forEach(item => item.classList.remove('selected'));
            // Add 'selected' class to the clicked item
            document.querySelector('[onclick="updateMap(\'Manila\')"]').classList.add('selected');
        } else if (location === 'Pasig') {
            iframe.src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.4406192475753!2d121.06409777591882!3d14.573950777726974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c86d7367414f%3A0x6cf953f8a47b432a!2sProjects%20Unlimited%20Philippines%20Incorporated!5e0!3m2!1sen!2sph!4v1710422217773!5m2!1sen!2sph";
            // Remove 'selected' class from all other items
            document.querySelectorAll('.address-item').forEach(item => item.classList.remove('selected'));
            // Add 'selected' class to the clicked item
            document.querySelector('[onclick="updateMap(\'Pasig\')"]').classList.add('selected');
        } else if (location === 'Granada') {
            iframe.src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.8409048597996!2d121.03616457591919!3d14.608137276890506!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b7d3e58c488b%3A0xd8dba9813fbcf336!2sProjects%20Unlimited!5e0!3m2!1sen!2sph!4v1710422178842!5m2!1sen!2sph";
            // Remove 'selected' class from all other items
            document.querySelectorAll('.address-item').forEach(item => item.classList.remove('selected'));
            // Add 'selected' class to the clicked item
            document.querySelector('[onclick="updateMap(\'Granada\')"]').classList.add('selected');
        }
    }
    const phoneInput = document.getElementById('phone');
    const phoneError = document.getElementById('phone-error');

    phoneInput.addEventListener('input', function () {
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