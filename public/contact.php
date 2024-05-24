<?php
$is_public_page = true;
$pageTitle = "Contact Us";
ob_start();

include("../backend/conn.php");

function extractMapURL($iframeCode)
{
    preg_match('/src="([^"]+)"/', $iframeCode, $matches);
    $mapURL = isset($matches[1]) ? $matches[1] : '';
    return $mapURL;
}

$sql = "SELECT * FROM locations";
$result = $conn->query($sql);

$locations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
} else {
    echo "0 results";
}

function generateLocationHTML($location)
{
    $name = htmlspecialchars($location['name']);
    $address = htmlspecialchars($location['address']);
    $time = htmlspecialchars($location['time']);
    $phone = htmlspecialchars($location['phone']);
    $email = htmlspecialchars($location['email']);
    $map = ($location['map']);

    $mapURL = extractMapURL($map);

    $html = "<li class='loc address-item cursor-pointer font-bold text-xl' onclick=\"updateMap('$mapURL', '$name')\">$name
        <ul>
            <li>Address: $address</li>
            <li>Time: $time</li>";

    if (!empty($phone)) {
        $html .= "<li>Phone: $phone</li>";
    }

    if (!empty($email)) {
        $html .= "<li>Email: $email</li>";
    }

    $html .= "</ul></li>";

    return $html;
}

?>
<script>
    // When the page is scrolled, show/hide the back-to-top button
    window.addEventListener("scroll", function() {
        var backToTopButton = document.querySelector('.back-to-top');
        if (window.scrollY > 200) {
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });

    // Smooth scrolling when the button is clicked
    document.querySelector('.back-to-top a').addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>

<script>
    function updateMap(mapURL, location) {
        var iframe = document.getElementById('googleMap');
        iframe.src = mapURL;

        document.querySelectorAll('.address-item').forEach(item => item.classList.remove('selected'));
        document.querySelector(`[onclick="updateMap('${mapURL}', '${location}')"]`).classList.add('selected');
    }
</script>

<head>
    <style>
        @media only screen and (max-width: 768px) {

            /* Adjust font sizes */
            body {
                font-size: 16px;
                /* Example font size for body text on mobile */
            }

            /* Adjust padding and margins to fit smaller screens */
            .container {
                padding: 10px;
                /* Example padding for container elements on mobile */
            }

            /* Adjust image sizes */
            .logo-image {
                width: 100px;
                /* Example width for logo image on mobile */
            }

            /* Hide certain elements on mobile */
            .hide-on-mobile {
                display: none;
                /* Example of hiding elements on mobile */
            }

            /* Adjust column layout for smaller screens */
            .grid-cols-1 {
                grid-template-columns: 1fr;
                /* Example of adjusting column layout for mobile */
            }

            /* Stack elements on top of each other */
            .formcontainer .flex {
                flex-direction: column;
            }

            /* Maximize form width */
            .formcontainer .p-8 {
                width: 100%;
                padding: 8px;
            }

            /* Center form horizontally */
            .formcontainer .p-8 {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                width: 100%;
            }

            /* Make input fields wider */
            .formcontainer input[type="text"],
            .formcontainer input[type="email"],
            .formcontainer textarea {
                width: calc(100% - 10px);
                /* Adjust width as needed */
                padding: 0px;
                margin-bottom: 10px;
            }

            /* Adjust button width */
            .formcontainer #submitButton {
                width: calc(100% - 10px);
                /* Adjust width as needed */
            }

            .banner {
                font-size: 24px !important;
            }

            .bannerimage {
                height: 170px !important;
            }

            .text-xl {
                font-size: 14px !important;
            }

            #googleMap {
                height: 300px !important;
            }

            .loc {
                margin-top: -10px !important;
            }

            #contactForm {
                width: 100% !important;
            }

            .formimage {
                margin-top: 15px !important;
            }

            .address-container {
                margin-top: -18px !important;
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
            <img src="../assets/image/contact.jpg" class="bannerimage w-full h-96 object-cover">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <p class="banner text-white font-bold text-4xl text-center">GET IN TOUCH WITH<br> <span class="text-[#F6E381]">PROJECTS UNLIMITED</span></p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="content">
            <p class="text-2xl font-semibold text-black px-16 mt-8">For any inquiries about our products, you may contact or
                visit us through the details below.</p>
            <div class="container mx-auto px-4 py-8 fade-in-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <iframe id="googleMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.9708020807752!2d120.97184307591911!3d14.600739177071674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca102318b44d%3A0x6483de216eafa800!2sProjects%20Unlimited!5e0!3m2!1sen!2sph!4v1710422091205!5m2!1sen!2sph" width="100%" height="500" style="border:0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div class="address-container">
                        <h2 class="text-2xl font-semibold mb-4">You can visit us at these locations:</h2>
                        <ul>
                            <?php foreach ($locations as $location) : ?>
                                <?= generateLocationHTML($location) ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center p-2 px-16 fade-in-hidden">
                <div class="border-b border-gray-800 flex-grow border-4 "></div>
                <h3 class="text-gray-800 text-right font-bold text-3xl mx-4">OR</h3>
                <div class="border-b border-gray-800 flex-grow border-4 "></div>
            </div>
            <div class="formcontainer fade-in-hidden">
                <p class="text-2xl font-semibold text-black px-16 mt-8">You can also fill out the form below and send us a message.</p>
                <div class="flex px-8">
                    <div class="w-1/2 p-8">
                        <form id="contactForm" class="space-y-4">
                            <div class="mb-4">
                                <label for="name" class="block text-black font-bold text-xl">Name:</label>
                                <input type="text" id="name" name="name" placeholder="Name" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                                <small class="text-red-500" id="name-error"></small>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-black font-bold text-xl">E-mail:</label>
                                <input type="email" id="email" name="email" placeholder="E-mail (e.g example@gmail.com)" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                                <small class="text-red-500" id="email-error"></small>
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="block text-black font-bold text-xl">Phone Number:</label>
                                <input type="text" id="phone" name="phone" placeholder="Phone Number (e.g. 09xxxxxxxxx)" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                                <small class="text-red-500" id="phone-error"></small>
                            </div>
                            <div class="mb-4">
                                <label for="subject" class="block text-black font-bold text-xl">Subject of Concern:</label>
                                <input type="text" id="subject" name="subject" placeholder="Subject of Concern" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            </div>
                            <div class="mb-4">
                                <label for="message" class="block text-black font-bold text-xl">Message:</label>
                                <textarea id="message" name="message" rows="4" placeholder="Enter Your Inquiry or Concern" class="w-full p-2 border resize-none rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required></textarea>
                                <small class="text-red-500" id="message-error"></small>
                            </div>
                            <div class="mb-4 flex justify-end">
                                <button id="submitButton" style="border-radius: 10px;" class="yellow-btn text-xl w-50 h-12 font-semibold">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="w-1/2 p-8">
                        <div class="formimage relative h-100 w-full flex items-center justify-center my-4">
                            <img src="../assets/image/contactusformimage.jpg" alt="Image Description" class="w-full h-100 object-cover">
                            <div class="absolute inset-0 bg-black opacity-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    $content = ob_get_clean();
    include("../public/master.php");
    ?>
</body>

<!--SCRIPT-->
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

    $(document).ready(function() {
        function sanitizeInput(input) {
            return $('<div/>').text(input).html();
        }

        function isValidInput(input) {
            // Regular expressions to detect HTML tags and SQL injection patterns
            var htmlPattern = /<[^>]*>/g;
            var sqlPattern = /('|"|--|;|\/\*|\*\/|\\)/g;

            if (htmlPattern.test(input) || sqlPattern.test(input)) {
                return false;
            }
            return true;
        }

        $('#submitButton').click(function(e) {
            e.preventDefault(); // Prevent form submission

            var isValid = true;

            // Validation
            $('#contactForm input, #contactForm textarea').each(function() {
                var element = $(this);
                var value = element.val().trim();
                var id = element.attr('id');
                var errorElement = $('#' + id + '-error');

                // Reset previous error messages and border colors
                errorElement.text('');
                element.css('border-color', '');

                // Check if field is empty (except subject) or contains invalid input
                if ((id !== 'subject' && !value) || !isValidInput(value)) {
                    if (!value) {
                        errorElement.text('Please enter ' + id.replace(/-/g, ' ') + '.');
                    } else {
                        errorElement.text('Input Invalid.');
                    }
                    element.css('border-color', 'red');
                    isValid = false;
                } else {
                    // Additional validations for email and phone fields
                    if (id === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        errorElement.text('Please enter a valid email address.');
                        element.css('border-color', 'red');
                        isValid = false;
                    }
                    if (id === 'phone' && (!/^\d{11}$/.test(value) || /\D/.test(value))) {
                        errorElement.text('Phone number must be exactly 11 digits.');
                        element.css('border-color', 'red');
                        isValid = false;
                    }
                }

                // Sanitize input if valid
                if (isValid) {
                    element.val(sanitizeInput(value));
                }
            });

            if (isValid) {
                // Show loading alert
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we send your message.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Get form data
                var formData = $('#contactForm').serialize();

                // Send AJAX request to server-side script
                $.ajax({
                    type: 'POST',
                    url: '../backend/contact/contact.php', // Path to your server-side script
                    data: formData,
                    success: function(response) {
                        // Clear form fields
                        $('#contactForm')[0].reset();

                        // Show success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Message Sent',
                            text: 'Thank you for contacting Projects Unlimited! We will get back to you in a while.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            $('#contactForm')[0].reset();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while sending the email. Please try again later.',
                        });
                    }
                });
            }
        });
    });
</script>