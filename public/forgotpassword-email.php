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
                <form id="forgotPasswordForm" method="post">
                    <div id="emailSection" class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                        <p id="emailError" class="text-sm text-red-500 mt-1 error-message"></p>
                    </div>
                    <div id="codeSection" class="mb-6 hidden">
                        <label for="verificationCode" class="block text-gray-700 text-sm font-bold mb-2">Verification
                            Code</label>
                        <input type="text" id="verificationCode" name="verificationCode"
                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p id="codeError" class="text-sm text-red-500 mt-1 error-message"></p>
                        <button id="resendCodeBtn" type="button" class="mt-2 text-blue-500 hover:underline bg-blue-50"
                            disabled>Resend Code</button>
                        <p id="resendCodeTimer" class="text-sm text-gray-600 mt-1"></p>
                    </div>
                    <div id="passwordSection" class="mb-6 hidden">
                        <label for="newPassword" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                        <input type="password" id="newPassword" name="newPassword"
                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <label for="confirmPassword" class="block text-gray-700 text-sm font-bold mb-2 mt-4">Confirm
                            Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <p id="passwordError" class="text-sm text-red-500 mt-1 error-message"></p>
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
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full md:w-auto">Submit</button>
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
    $( document ).ready( function ()
    {
        // Function to validate email
        function validateEmail ()
        {
            const email = $( '#email' ).val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let isValid = true;

            if ( !email || email.trim() === '' )
            {
                $( '#email' ).addClass( 'border-red-500' );
                $( '#emailError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Email is required.' );
                isValid = false;
            } else if ( !emailRegex.test( email ) )
            {
                $( '#email' ).addClass( 'border-red-500' );
                $( '#emailError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Invalid email format. Please enter a valid email address.' );
                isValid = false;
            } else
            {
                $( '#email' ).removeClass( 'border-red-500' );
                $( '#emailError' ).empty();
            }

            return isValid;
        }

        // Function to validate verification code
        function validateVerificationCode ()
        {
            const code = $( '#verificationCode' ).val();
            let isValid = true;

            if ( !code || code.trim() === '' )
            {
                $( '#verificationCode' ).addClass( 'border-red-500' );
                $( '#codeError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Verification code is required.' );
                isValid = false;
            } else
            {
                $( '#verificationCode' ).removeClass( 'border-red-500' );
                $( '#codeError' ).empty();
            }

            return isValid;
        }

        // Function to validate passwords
        function validatePasswords ()
        {
            const newPassword = $( '#newPassword' ).val();
            const confirmPassword = $( '#confirmPassword' ).val();
            let isValid = true;

            // Regular expressions for password strength requirements
            const lengthRegex = /.{8,}/; // At least 8 characters
            const specialCharRegex = /[!@#$%^&*(),.?'":{}|<>]/; // At least one special character
            const numberRegex = /[0-9]/; // At least one number
            const capitalRegex = /[A-Z]/; // At least one capital letter

            // Check if the password meets length requirement
            if ( !lengthRegex.test( newPassword ) )
            {
                $( '#newPassword' ).addClass( 'border-red-500' );
                $( '#passwordError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Password must be at least 8 characters long.' );
                isValid = false;
            } else if ( newPassword !== confirmPassword )
            {
                $( '#confirmPassword' ).addClass( 'border-red-500' );
                $( '#passwordError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Passwords do not match.' );
                isValid = false;
            } else if ( !specialCharRegex.test( newPassword ) )
            {
                $( '#newPassword' ).addClass( 'border-red-500' );
                $( '#passwordError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Password must contain at least one special character.' );
                isValid = false;
            } else if ( !numberRegex.test( newPassword ) )
            {
                $( '#newPassword' ).addClass( 'border-red-500' );
                $( '#passwordError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Password must contain at least one number.' );
                isValid = false;
            } else if ( !capitalRegex.test( newPassword ) )
            {
                // Finish the validatePasswords function
                $( '#newPassword' ).addClass( 'border-red-500' );
                $( '#passwordError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Password must contain at least one capital letter.' );
                isValid = false;
            } else
            {
                // If all requirements are met, remove error classes and messages
                $( '#newPassword, #confirmPassword' ).removeClass( 'border-red-500' );
                $( '#passwordError' ).empty();
            }

            return isValid;
        }

        // Function to validate form based on current step
        function validateForm ( step )
        {
            if ( step === 'email' )
            {
                return validateEmail();
            } else if ( step === 'code' )
            {
                return validateVerificationCode();
            } else if ( step === 'password' )
            {
                return validatePasswords();
            }
        }

        // Function to display email errors
        function displayEmailError ( message )
        {
            $( '#email' ).addClass( 'border-red-500' );
            $( '#emailError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( message );
        }

        // Function to display verification code errors
        function displayVerificationCodeError ( message )
        {
            $( '#verificationCode' ).addClass( 'border-red-500' );
            $( '#codeError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( message );
        }

        // Function to display password errors
        function displayPasswordError ( message )
        {
            $( '#newPassword' ).addClass( 'border-red-500' );
            $( '#confirmPassword' ).addClass( 'border-red-500' );
            $( '#passwordError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( message );
        }

        // Event listener for password field to check password strength
        $( '#newPassword' ).on( 'input', function ()
        {
            checkPasswordStrength( $( this ).val() );
        } );

        // Function to start the resend code timer
        function startResendCodeTimer ()
        {
            let timer = 60;
            $( '#resendCodeBtn' ).prop( 'disabled', true );
            $( '#resendCodeTimer' ).text( `You can resend the code in ${ timer } seconds.` );

            const interval = setInterval( () =>
            {
                timer--;
                $( '#resendCodeTimer' ).text( `You can resend the code in ${ timer } seconds.` );
                if ( timer <= 0 )
                {
                    clearInterval( interval );
                    $( '#resendCodeTimer' ).empty();
                    $( '#resendCodeBtn' ).prop( 'disabled', false ); // Enable the button
                }
            }, 1000 );
        }

        // Function to handle resend code button click
        $( '#resendCodeBtn' ).click( function ()
        {
            // Disable the button and start the timer
            $( '#resendCodeBtn' ).prop( 'disabled', true );
            startResendCodeTimer();

            // Display processing dialog
            Swal.fire( {
                title: 'Processing',
                text: 'Please wait...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () =>
                {
                    Swal.showLoading();
                }
            } );

            // Trigger resend code action
            $.ajax( {
                url: '../../backend/contact/forgotpassword-resendcode.php',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function ( response )
                {
                    Swal.close();

                    // Handle success response
                    Swal.fire( {
                        icon: 'success',
                        title: 'Code Resent',
                        text: 'A new verification code has been sent to your email.',
                    } );
                },
                error: function ( xhr, status, error )
                {
                    Swal.close();

                    // Handle error response
                    Swal.fire( {
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to resend verification code. Please try again later.',
                    } );
                }
            } );
        } );

        // Start the timer when the page loads
        startResendCodeTimer();

        $( '#forgotPasswordForm' ).submit( function ( event )
        {
            event.preventDefault();

            const currentStep = $( '#emailSection' ).is( ':visible' ) ? 'email' : ( $( '#codeSection' ).is( ':visible' ) ? 'code' : 'password' );

            if ( validateForm( currentStep ) )
            {
                $( '#email' ).prop( 'required', currentStep === 'email' );
                $( '#verificationCode' ).prop( 'required', currentStep === 'code' );
                $( '#newPassword' ).prop( 'required', currentStep === 'password' );
                $( '#confirmPassword' ).prop( 'required', currentStep === 'password' );

                // Remove unnecessary fields from FormData object
                let formData = new FormData( $( '#forgotPasswordForm' )[0] );
                if ( currentStep === 'email' )
                {
                    formData.delete( 'verificationCode' );
                    formData.delete( 'newPassword' );
                    formData.delete( 'confirmPassword' );
                } else if ( currentStep === 'code' )
                {
                    formData.delete( 'email' );
                    formData.delete( 'newPassword' );
                    formData.delete( 'confirmPassword' );
                } else if ( currentStep === 'password' )
                {
                    formData.delete( 'email' );
                    formData.delete( 'verificationCode' );
                }

                // Display processing dialog
                Swal.fire( {
                    title: 'Processing',
                    text: 'Please wait...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () =>
                    {
                        Swal.showLoading();
                    }
                } );

                $.ajax( {
                    url: '../../backend/contact/forgotpassword-sendcode.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function ( response )
                    {
                        Swal.close();

                        if ( response.success )
                        {
                            if ( currentStep === 'email' )
                            {
                                $( '#emailSection' ).hide();
                                $( '#codeSection' ).show();
                            } else if ( currentStep === 'code' )
                            {
                                $( '#codeSection' ).hide();
                                $( '#passwordSection' ).show();
                            } else if ( currentStep === 'password' )
                            {
                                Swal.fire( {
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Password has been reset successfully.'
                                } ).then( () =>
                                {
                                    window.location.href = '../public/login.php';
                                } );
                            }
                        } else
                        {
                            // Handle backend validation errors based on the step
                            if ( currentStep === 'email' )
                            {
                                displayEmailError( response.message );
                            } else if ( currentStep === 'code' )
                            {
                                displayVerificationCodeError( response.message );
                            } else if ( currentStep === 'password' )
                            {
                                displayPasswordError( response.message );
                            } else
                            {
                                Swal.fire( {
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message
                                } );
                            }
                        }
                    },
                    error: function ( xhr, status, error )
                    {
                        Swal.close();
                        Swal.fire( {
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred. Please try again later.'
                        } );
                        console.error( 'Error:', error );
                    }
                } );
            }
        } );

        // Function to calculate password strength (customize this as needed)
        function calculatePasswordStrength ( password )
        {
            let strength = 0;
            // For simplicity, let's assume 1 point for each fulfilled requirement
            if ( password.length >= 8 ) strength++;
            if ( /[!@#$%^&*(),.?\':{}|<>]/.test( password ) ) strength++;
            if ( /[0-9]/.test( password ) ) strength++;
            if ( /[A-Z]/.test( password ) ) strength++;
            return strength;
        }
    } );
</script>
<?php
$script = ob_get_clean();
include ("../public/master.php");
?>