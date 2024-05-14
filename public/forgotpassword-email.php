<?php
$is_public_page = true;
$pageTitle = "Forgot Password";
ob_start();
?>
<div class="container mx-auto my-8">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-md md:max-w-lg">
        <div class="md:flex">
            <div class="w-full px-6 py-8">
                <h2 class="text-2xl font-semibold text-gray-700 mb-6">Forgot Password</h2>
                <form id="forgotPasswordForm" method="post" >
                    <div id="emailSection" class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                        <input type="email" id="email" name="email" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <p id="emailError" class="text-sm text-red-500 mt-1 error-message"></p>
                    </div>
                    <div id="codeSection" class="mb-6 hidden">
                        <label for="verificationCode" class="block text-gray-700 text-sm font-bold mb-2">Verification Code</label>
                        <input type="text" id="verificationCode" name="verificationCode" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p id="codeError" class="text-sm text-red-500 mt-1 error-message"></p>
                    </div>
                    <div id="passwordSection" class="mb-6 hidden">
                        <label for="newPassword" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                        <input type="password" id="newPassword" name="newPassword" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <label for="confirmPassword" class="block text-gray-700 text-sm font-bold mb-2 mt-4">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p id="passwordError" class="text-sm text-red-500 mt-1 error-message"></p>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full md:w-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean();
ob_start();
?>
<script>
    $(document).ready(function() {
        // Function to validate email
        function validateEmail() {
            const email = $('#email').val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let isValid = true;

            if (!email || email.trim() === '') {
                $('#email').addClass('border-red-500');
                $('#emailError').addClass('text-sm text-red-500 mt-1 error-message').text('Email is required.');
                isValid = false;
            } else if (!emailRegex.test(email)) {
                $('#email').addClass('border-red-500');
                $('#emailError').addClass('text-sm text-red-500 mt-1 error-message').text('Invalid email format. Please enter a valid email address.');
                isValid = false;
            } else {
                $('#email').removeClass('border-red-500');
                $('#emailError').empty();
            }

            return isValid;
        }

        // Function to validate verification code
        function validateVerificationCode() {
            const code = $('#verificationCode').val();
            let isValid = true;

            if (!code || code.trim() === '') {
                $('#verificationCode').addClass('border-red-500');
                $('#codeError').addClass('text-sm text-red-500 mt-1 error-message').text('Verification code is required.');
                isValid = false;
            } else {
                $('#verificationCode').removeClass('border-red-500');
                $('#codeError').empty();
            }

            return isValid;
        }

        // Function to validate passwords
        function validatePasswords() {
            const newPassword = $('#newPassword').val();
            const confirmPassword = $('#confirmPassword').val();
            let isValid = true;

            if (!newPassword || newPassword.trim() === '') {
                $('#newPassword').addClass('border-red-500');
                $('#passwordError').addClass('text-sm text-red-500 mt-1 error-message').text('New password is required.');
                isValid = false;
            } else if (newPassword !== confirmPassword) {
                $('#confirmPassword').addClass('border-red-500');
                $('#passwordError').addClass('text-sm text-red-500 mt-1 error-message').text('Passwords do not match.');
                isValid = false;
            } else {
                $('#newPassword').removeClass('border-red-500');
                $('#confirmPassword').removeClass('border-red-500');
                $('#passwordError').empty();
            }

            return isValid;
        }

        // Function to validate form based on current step
        function validateForm(step) {
            if (step === 'email') {
                return validateEmail();
            } else if (step === 'code') {
                return validateVerificationCode();
            } else if (step === 'password') {
                return validatePasswords();
            }
        }

        // Event listener for form submission
        $('#forgotPasswordForm').submit(function(event) {
            // Prevent default form submission behavior
            event.preventDefault();

            const currentStep = $('#emailSection').is(':visible') ? 'email' : ($('#codeSection').is(':visible') ? 'code' : 'password');

            // Validate the form
            if (validateForm(currentStep)) {
                // Make only the relevant fields required based on the current step
                $('#email').prop('required', currentStep === 'email');
                $('#verificationCode').prop('required', currentStep === 'code');
                $('#newPassword').prop('required', currentStep === 'password');
                $('#confirmPassword').prop('required', currentStep === 'password');

                let formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: '../../backend/contact/forgotpassword-sendcode.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            if (currentStep === 'email') {
                                $('#emailSection').hide();
                                $('#codeSection').show();
                            } else if (currentStep === 'code') {
                                $('#codeSection').hide();
                                $('#passwordSection').show();
                            } else if (currentStep === 'password') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Password has been reset successfully.'
                                }).then(() => {
                                    window.location.href = '../public/login.php';
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred. Please try again later.'
                        });
                        console.error('Error:', error);
                    }
                });
            }
        });
    });
</script>
<?php
$script = ob_get_clean();
include("../public/master.php");
?>
