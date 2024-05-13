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

    $html = "<li class='address-item cursor-pointer font-bold text-xl' onclick=\"updateMap('$mapURL', '$name')\">$name
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

<a href="#top" class="back-to-top">
    <div>
        <i class="fas fa-arrow-up"></i>
    </div>
</a>

<div class="content">
    <div class="relative fade-in-hidden">
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
    <div class="container mx-auto px-4 py-8 fade-in-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <iframe id="googleMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.9708020807752!2d120.97184307591911!3d14.600739177071674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca102318b44d%3A0x6483de216eafa800!2sProjects%20Unlimited!5e0!3m2!1sen!2sph!4v1710422091205!5m2!1sen!2sph" width="100%" height="500" style="border:0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="address-container">
                <h2 class="text-xl font-semibold mb-4">You can visit us at these locations:</h2>
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
        <p class="text-2xl font-semibold text-black px-16 mt-8">You can also fill out the form below and send us a
            message.</p>
        <div class="flex px-8">
            <div class="w-1/2 p-8">
                <form id="contactForm" class="space-y-4">
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
                        <textarea id="message" name="message" rows="4" placeholder="Enter Your Inquiry or Concern" class="w-full p-2 border resize-none rounded-md" required></textarea>
                    </div>
                    <div class="mb-4 flex justify-end">
                        <button id="submitButton" style="border-radius: 10px;" class="yellow-btn text-xl w-50 h-12 font-semibold">Submit</button>
                    </div>
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
</div>
<?php
$content = ob_get_clean();
include("../public/master.php");
?>

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
        $('#submitButton').click(function(e) {
            e.preventDefault(); // Prevent form submission

            // Get form data
            var formData = $('#contactForm').serialize();

            // Send AJAX request to server-side script
            $.ajax({
                type: 'POST',
                url: '../backend/contact/contact.php', // Path to your server-side script
                data: formData,
                success: function(response) {
                    $('#contactForm').html('<p class="text-3xl font-extrabold text-black px-16 mt-8">Thank You for Contacting Projects Unlimited! We will get back to you in a while.</p>');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error message
                    alert('An error occurred while sending the email. Please try again later.');
                }
            });
        });
    });
</script>