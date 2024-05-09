<?php
session_start();
$pageTitle = "Profile";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <style>
        .success-alert {
            background-color: #4CAF50;
            color: black;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .passreq {
            font-size: 18px;
            color: #000;
            text-align: left;
            /* Align the text to the left */
        }

        .passreq ul {
            list-style-type: none;
            padding: 5px;
        }

        .password-requirements-title {
            font-size: 15px;
            margin-left: 3px;
        }

        .passreq {
            display: none;
            height: 0;
            opacity: 0;
            overflow: hidden;
            transition: height 0.3s ease, opacity 0.3s ease;
            margin-bottom: -5.5%;
        }

        .passreq.show {
            display: block;
            height: auto;
            opacity: 1;
        }

        .toggle-confirm-password {
            position: absolute;
            top: 46%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #5A6268;
        }

        .toggle-confirm-password i {
            cursor: pointer;
        }

        .toggle-old-password {
            position: absolute;
            top: 46%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #5A6268;
        }

        .toggle-old-password i {
            cursor: pointer;
        }

        .toggle-password {
            position: absolute;
            top: 46%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #5A6268;
        }

        .toggle-password i {
            cursor: pointer;
        }

        .checklogo {
            position: absolute;
            font-size: 22px;
            left: 91%;
            top: 47%;
            transform: translateY(-50%);
        }

        .checklogo2 {
            position: absolute;
            font-size: 22px;
            left: 91%;
            top: 50%;
            transform: translateY(-50%);
        }

        .checklogo3 {
            position: absolute;
            font-size: 22px;
            left: 95%;
            top: 100%;
            transform: translateY(-50%);
        }

        .error-container {
            position: fixed;
            top: 75%;
            /* Adjust the top position as needed */
            right: 39%;
            /* Adjust the right position as needed */
            z-index: 1000;
            width: 22%;
            text-align: center;

        }

        .fullname {
            text-align: center;
            font-size: 30px;
            color: #45494C;
            font-weight: bold;
            margin-top: -3%;
        }

        .email {
            text-align: center;
            font-size: 20px;
            margin-top: -3%;
            margin-bottom: 3%;

        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Card styles */
        .card-shadow {
            border: none;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            border-radius: 10px;
            flex: 1;
            background-color: white;
            width: 70%;
        }

        .card {
            background-color: white;
            padding: 10px;
            flex: 1;
        }

        .card-container {
            display: flex;
            gap: 50px;
            /* Adjust the gap between the cards */
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10 flex justify-center items-center h-screen">
        <div class="max-w-md w-full">
            <div class="bg-white shadow-md rounded-lg p-8">
                <div class="profile-image-container mb-6 flex justify-center items-center">
                    <img src="../../assets/image/projectslogo.png" alt="Profile Image">
                </div>

                <div class="container">
                    <div class="card-container">
                        <div class="card">
                            <h4 class="text-xl font-semibold mb-4">Update Password</h4>
                            <form method="post">
                                <label for="oldPass" class="block mb-2">Input Old Password</label>
                                <div class="input-group input-group-alternative mb-4 relative">
                                    <input class="form-control input-field bg-gray-100 w-full pr-10" id="oldPass" required name="oldPass" type="password">
                                    <span toggle="#oldPass" class="toggle-old-password cursor-pointer absolute top-0 right-0 mr-3">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <label for="password" class="block mb-2">New Password</label>
                                <div class="input-group input-group-alternative mb-4 relative">
                                    <input class="form-control input-field bg-gray-100 w-full pr-10" id="password" required name="password" type="password" minlength="8" oninput="checkPasswordStrength(this.value)">
                                    <span id="passwordStrengthIcon" class="absolute top-0 right-0 mr-3"></span>
                                    <span toggle="#passwordconfirm" class="toggle-password cursor-pointer absolute top-0 right-0 mr-3">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <!-- Password requirements -->
                                <div class="passreq mb-4" id="passwordRequirementsContainer">
                                    <p class="password-requirements-title"><b>Password Requirements:</b></p>
                                    <ul id="passwordRequirements" class="listreq pl-4">
                                        <li id="length">Minimum of 8 characters</li>
                                        <li id="specialChar">At least one special character/symbol</li>
                                        <li id="number">At least one number</li>
                                        <li id="capital">At least one capital letter</li>
                                    </ul>
                                </div>

                                <label for="passwordconfirm" class="block mb-2">Confirm New Password</label>
                                <div class="input-group input-group-alternative mb-4 relative">
                                    <input class="form-control input-field bg-gray-100 w-full pr-10" id="passwordconfirm" required name="passwordconfirm" type="password" minlength="8" oninput="checkPasswordMatch(this.value)">
                                    <span id="confirmPasswordIcon" class="absolute top-0 right-0 mr-3"></span>
                                    <span toggle="#passwordconfirm" class="toggle-confirm-password cursor-pointer absolute top-0 right-0 mr-3">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="text-center">
                                    <button type="submit" name="submit_info" class="btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showPasswordRequirements() {
            const passwordRequirements = document.querySelector('.passreq');
            passwordRequirements.classList.add('show');
        }

        // Function to hide password requirements
        function hidePasswordRequirements() {
            const passwordRequirements = document.querySelector('.passreq');
            passwordRequirements.classList.remove('show');
        }

        // Event listener for focus on password input
        const passwordInput = document.querySelector('input[name="password"]');
        passwordInput.addEventListener('focus', showPasswordRequirements);

        // Event listener for blur on password input
        passwordInput.addEventListener('blur', hidePasswordRequirements);



        function checkPasswordMatch(confirmPassword) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');

            if (confirmPassword === password && confirmPassword !== '') {
                confirmPasswordIcon.innerHTML = '<i class="fas fa-check checklogo2" style="color: #08b708;"></i>';
            } else {
                confirmPasswordIcon.innerHTML = '<i class="fas fa-times checklogo2" style="color: red;"></i>';
            }
        }

        function closeError() {
            var errorContainer = document.getElementById('errorContainer');
            errorContainer.style.display = 'none';
        }

        // Automatically close the error after 3 seconds (3000 milliseconds)
        setTimeout(function() {
            closeError();
        }, 3000);
    </script>

    <script>
        const toggleOldPasswordVisibility = () => {
            const confirmPasswordField = document.getElementById('oldPass');
            const toggleIcon = document.querySelector('.toggle-old-password i');

            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        };
    </script>

    <script>
        const toggleConfirmPasswordVisibility = () => {
            const confirmPasswordField = document.getElementById('passwordconfirm');
            const toggleIcon = document.querySelector('.toggle-confirm-password i');

            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        };

        const togglePasswordVisibility = () => {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        };
    </script>

    <script>
        function checkPasswordStrength(password) {
            const lengthReq = document.getElementById('length');
            const specialCharReq = document.getElementById('specialChar');
            const numberReq = document.getElementById('number');
            const capitalReq = document.getElementById('capital');
            const passwordStrengthIcon = document.getElementById('passwordStrengthIcon'); // New

            // Check length
            if (password.length >= 8) {
                lengthReq.style.color = 'green';
            } else {
                lengthReq.style.color = 'red';
            }

            // Check for at least one special character
            if (/[!@#$%^&*(),.?\':{}|<>]/.test(password)) {
                specialCharReq.style.color = 'green';
            } else {
                specialCharReq.style.color = 'red';
            }

            // Check for at least one number
            if (/[0-9]/.test(password)) {
                numberReq.style.color = 'green';
            } else {
                numberReq.style.color = 'red';
            }

            // Check for at least one capital letter
            if (/[A-Z]/.test(password)) {
                capitalReq.style.color = 'green';
            } else {
                capitalReq.style.color = 'red';
            }

            // Update the password strength icon
            const passwordStrength = calculatePasswordStrength(password);
            if (passwordStrength >= 4) {
                passwordStrengthIcon.innerHTML = '<i class="fas fa-check checklogo" style="color:#08b708;"></i>';
            } else {
                passwordStrengthIcon.innerHTML = '<i class="fas fa-times checklogo" style="color:#CC212D;"></i>';
            }
        }

        function restrictToNumbers(input) {
            input.value = input.value.replace(/\D/g, ''); // Replace any non-numeric characters with an empty string
        }

        // Function to calculate password strength (customize this as needed)
        function calculatePasswordStrength(password) {
            let strength = 0;
            // Add your own logic to calculate password strength
            // For simplicity, let's assume 1 point for each fulfilled requirement
            if (password.length >= 8) strength++;
            if (/[!@#$%^&*(),.?\':{}|<>]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            return strength;
        }
    </script>
</body>




<?php
$script = ob_get_clean();
include("../../public/master.php");
include("../../backend/conn.php");
?>