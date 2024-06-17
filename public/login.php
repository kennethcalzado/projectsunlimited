<?php
$is_public_page = true;
$pageTitle = "Login";
ob_start();
?>
<div class="container mx-auto my-2 mt-6">
    <!-- Outer Row -->
    <div class="flex justify-center">
        <div class="w-full lg:w-10/12 md:w-9/12">
            <div class="card bg-white shadow-lg my-5 ">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="flex flex-wrap  ">
                        <div class="lg:w-6/12 bg-login-image lg:block hidden items-center justify-center">
                            <img class="w-full h-full object-cover"
                                src="../assets/image/pexels-mentatdgt-1799790-1024x683.jpg" alt="Login Image">
                        </div>

                        <div class="w-full lg:w-6/12 h-[440px]">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="text-2xl text-gray-900 mb-4 font-semibold">Welcome Back!</h1>
                                </div>
                                <form class="user" id="loginForm">
                                    <div class="mb-4">
                                        <label>Email</label>
                                        <input type="type"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                                            id="email" aria-describedby="emailHelp" placeholder="Enter Email Address..."
                                            name="email">
                                        <div id="emailError" class="h-[20px] text-red-500 text-sm hidden">
                                            <!-- Error message space -->

                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label>Password</label>
                                        <input type="password"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                                            id="password" placeholder="Password" name="password">
                                        <div id="passwordError" class="h-[20px] text-red-500 text-sm mt-1 hidden">
                                            <!-- Error message space -->

                                        </div>
                                    </div>

                                    <div id="loginError" class="h-[20px] text-red-500 text-sm mt-1 hidden">
                                        <!-- Error message space -->
                                    </div>
                                    <div class="mb-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox text-blue-500" name="remember">
                                            <span class="ml-2 text-gray-700">Remember Me</span>
                                        </label>
                                    </div>
                                    <button href="index.html" class="yellow-btn text-base">
                                        Login
                                    </button>
                                </form>
                                <hr class="my-4">
                                <div class="text-center">
                                    <a class="text-sm text-blue-500" href="/public/forgotpassword-email.php">Forgot
                                        Password?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container mx-auto">
            <p class="text-center text-sm font-bold text-gray-700 justify-center"><i>Copyright &copy; 2024 Projects
                    Unlimited Powered by Projects Unlimited</i></p>
        </div>
    </footer>
</div>

<div id="popup-handler"></div> <!-- Pop-up space -->

<?php $content = ob_get_clean();
ob_start();
?>
<script>
    $( document ).ready( function ()
    {
        function validateEmail ()
        {
            const email = $( '#email' ).val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let isValid = true;

            if ( !email || email.trim() === '' )
            {
                $( '#email' ).addClass( 'border-red-500' );
                $( '#emailError' ).addClass( 'error-message' ).text( 'Email is required.' );
                $( '#emailError' ).show();
                isValid = false;
            } else if ( !emailRegex.test( email ) )
            {
                $( '#email' ).addClass( 'border-red-500' );
                $( '#emailError' ).addClass( 'error-message' )
                    .text( 'Invalid email format. Please enter a valid email address in the format example@example.com.' );
                $( '#emailError' ).show();
                isValid = false;
            } else
            {
                $( '#email' ).removeClass( 'border-red-500' );
                $( '#emailError' ).empty();
                $( '#emailError' ).hide();
            }

            return isValid;
        }

        function validatePassword ()
        {
            const password = $( '#password' ).val();
            let isValid = true;

            if ( !password || password.trim() === '' )
            {
                $( '#password' ).addClass( 'border-red-500' );
                $( '#passwordError' ).addClass( 'error-message' ).text( 'Password is required.' );
                $( '#passwordError' ).show();
                isValid = false;
            } else
            {
                $( '#password' ).removeClass( 'border-red-500' );
                $( '#passwordError' ).empty();
                $( '#passwordError' ).hide();
            }

            return isValid;
        }

        function validateUserForm ()
        {
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();

            return isEmailValid && isPasswordValid;
        }

        // Add event listener for input changes to validate the form
        $( '#email' ).on( 'input', validateEmail );
        $( '#password' ).on( 'input', validatePassword );


        // Event listener for form submission
        $( '#loginForm' ).submit( function ( event )
        {
            // Prevent default form submission behavior
            event.preventDefault();

            // Validate the form
            if ( validateUserForm() )
            {
                let formData = $( this ).serialize(); // Serialize form data

                // Determine the URL based on whether it's an update or create action
                let url = "../backend/login-authentication.php";

                $.ajax( {
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function ( response )
                    {
                        if ( response.success )
                        {
                            // Redirect user based on their role
                            if ( response.role === 'admin' || response.role === 'marketing' )
                            {
                                window.location.href = '../public/users/dashboard.php';
                            } else
                            {
                                window.location.href = '../public/index.php';
                            }
                        } else
                        {
                            // Clear previous error messages
                            $( '.error-message' ).text( '' );
                            $( '.error-field' ).removeClass( 'border-red-500' );

                            if ( typeof response.message === 'string' )
                            {
                                // If the error message is a string, display it as a general error message
                                $( '#loginError' ).addClass( 'error-message' ).text( response.message );
                                $( '#loginError' ).show();
                                Swal.fire( {
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message
                                } );
                            } else
                            {
                                // If the error message is an object, iterate through the fields and display specific error messages
                                Object.keys( response.message ).forEach( function ( fieldName )
                                {
                                    $( '#' + fieldName + 'Error' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( response.message[fieldName] );
                                    $( '#' + fieldName ).addClass( 'border-red-500 error-field' );
                                } );
                            }
                        }
                    },
                    error: function ( xhr, status, error )
                    {
                        // Handle error response
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
    } );
</script>

<?php
$script = ob_get_clean();
include ("master.php");
?>