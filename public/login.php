<?php
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
                                    <div class="mb-2">
                                        <label>Email</label>
                                        <input type="type"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                                            id="email" aria-describedby="emailHelp" placeholder="Enter Email Address..."
                                            name="email">
                                        <div id="emailError" class="h-[20px] text-red-500 text-sm mt-1">
                                            <!-- Error message space -->

                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label>Password</label>
                                        <input type="password"
                                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"
                                            id="password" placeholder="Password" name="password">
                                        <div id="passwordError" class="h-[20px] text-red-500 text-sm mt-1">
                                            <!-- Error message space -->

                                        </div>
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
                                    <a class="text-sm text-blue-500" href="forgot-password.html">Forgot Password?</a>
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
        function validateUserForm ()
        {
            // Remove any existing error styling and messages
            $( '.border-red-500' ).removeClass( 'border-red-500' );
            $( '.text-red-500' ).removeClass( 'text-red-500' );
            $( '.error-message' ).empty();

            // Get form inputs
            const email = $( '#email' ).val();
            const password = $( '#password' ).val();

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Initialize error message
            let isValid = true;

            if ( !email || email.trim() === '' )
            {
                $( '#email' ).addClass( 'border-red-500' );
                $( '#emailError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Email is required.' );
                isValid = false;
            } else if ( !emailRegex.test( email ) )
            {
                $( '#email' ).addClass( 'border-red-500' );
                $( '#emailError' ).addClass( 'text-sm text-red-500 mt-1 error-message' )
                    .text( 'Invalid email format. Please enter a valid email address in the format example@example.com.' );
                isValid = false;
            }

            if ( !password || password.trim() === '' )
            {
                $( '#password' ).addClass( 'border-red-500' );
                $( '#passwordError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Password is required.' );
                isValid = false;
            }

            return isValid;
        }

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
                            console.log( response );
                            // Redirect user based on their role
                            if ( response.role === 'admin' || response.role === 'marketing' )
                            {
                                window.location.href = '../public/users/dashboard.php';
                            } else
                            {
                                window.location.href = '../public/home.php';
                            }
                        } else
                        {
                            // Display error messages received from the backend
                            if ( response.message )
                            {
                                Object.keys( response.message ).forEach( function ( fieldName )
                                {
                                    $( '#' + fieldName + 'Error' ).addClass( 'text-sm text-red-500 mt-1 error-message' )
                                        .text( response.message[fieldName] );

                                    $( '#' + fieldName ).addClass( 'border-red-500' );
                                } );
                            }
                        }
                    },
                    error: function ( xhr, status, error )
                    {
                        console.error( 'Error:', error );
                        // Display error message using a pop-up
                        showPopup( 'error', 'Error', 'An error occurred. Please try again later.' );
                    }
                } );
            }
        } );

        /////////////////// POP UP FUNCTION ////////////////////////////
        function showPopup ( type, header, message, actionType )
        {
            const popupConfig = {
                confirmation: {
                    iconClass: 'bi-exclamation-circle',
                    buttonClass: 'confirmBtn',
                    buttonText: 'Confirm',
                    buttonBgColor: 'bg-yellow-200',
                    buttonTextColor: 'text-black',
                    hoverBgColor: 'hover:bg-yellow-400',
                    activeBgColor: 'active:bg-yellow-500',
                    focusStyles: 'focus:outline-none focus:border-yellow-500 focus:ring focus:ring-yellow-200',
                    transition: 'transition disabled:opacity-25',
                    iconColor: 'text-black'
                },
                success: {
                    iconClass: 'bi-check-circle',
                    buttonClass: 'closeSuccessBtn',
                    buttonText: 'Close',
                    buttonBgColor: 'bg-gray-200',
                    buttonTextColor: 'text-black',
                    hoverBgColor: 'hover:bg-gray-300',
                    activeBgColor: 'active:bg-gray-400',
                    focusStyles: 'focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300',
                    transition: 'transition disabled:opacity-25',
                    iconColor: 'text-green-400'
                },
                error: {
                    iconClass: 'bi-exclamation-triangle',
                    buttonClass: 'closeErrorBtn',
                    buttonText: 'Close',
                    buttonBgColor: 'bg-gray-200',
                    buttonTextColor: 'text-black',
                    hoverBgColor: 'hover:bg-gray-300',
                    activeBgColor: 'active:bg-gray-400',
                    focusStyles: 'focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300',
                    transition: 'transition disabled:opacity-25',
                    iconColor: 'text-red-400'
                },
                delete: { // Configuration for delete action
                    iconClass: 'bi-trash',
                    buttonClass: 'confirmDeleteBtn',
                    buttonText: 'Confirm',
                    buttonBgColor: 'bg-red-500',
                    buttonTextColor: 'text-white',
                    hoverBgColor: 'hover:bg-red-600',
                    activeBgColor: 'active:bg-red-700',
                    focusStyles: 'focus:outline-none focus:border-red-600 focus:ring focus:ring-red-400',
                    transition: 'transition disabled:opacity-25',
                    iconColor: 'text-red-400'
                }
            };

            const {
                iconClass,
                buttonClass,
                buttonText,
                buttonBgColor,
                buttonTextColor,
                hoverBgColor,
                activeBgColor,
                focusStyles,
                transition,
                iconColor
            } = popupConfig[type];

            // Adjust message based on actionType
            if ( actionType === 'update' )
            {
                if ( type === 'confirmation' )
                {
                    message = 'Are you sure you want to update this user?';
                } else if ( type === 'success' )
                {
                    message = 'User updated successfully.';
                }
            } else if ( actionType === 'create' )
            {
                if ( type === 'confirmation' )
                {
                    message = 'Are you sure you want to create this user?';
                } else if ( type === 'success' )
                {
                    message = 'User created successfully.';
                }
            } else if ( actionType === 'delete' )
            { // Adjust for delete action
                if ( type === 'confirmation' )
                {
                    message = 'Are you sure you want to delete this user?';
                } else if ( type === 'success' )
                {
                    message = 'User deleted successfully.';
                }
            } else if ( actionType === 'activate' )
            { // Adjust for activate action
                if ( type === 'confirmation' )
                {
                    message = 'Are you sure you want to activate this user?';
                } else if ( type === 'success' )
                {
                    message = 'User activated successfully.';
                }
            } else if ( actionType === 'deactivate' )
            { // Adjust for deactivate action
                if ( type === 'confirmation' )
                {
                    message = 'Are you sure you want to deactivate this user?';
                } else if ( type === 'success' )
                {
                    message = 'User deactivated successfully.';
                }
            }

            // Create the pop-up HTML using jQuery
            const popupHtml = $( '<div>' ).addClass( `${ type }-popup hidden fixed inset-0 z-50 flex items-center` ).append(
                $( '<div>' ).addClass( 'bg-black opacity-25 w-full h-full absolute inset-0' ),
                $( '<div>' ).addClass( 'bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative' ).append(
                    $( '<div>' ).addClass( 'md:flex items-center' ).append(
                        $( '<div>' ).addClass( 'rounded-full flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto' ).append(
                            $( '<i>' ).addClass( `bi ${ iconClass } text-5xl ${ iconColor }` )
                        ),
                        $( '<div>' ).addClass( 'mt-4 md:mt-0 md:ml-6 text               -center md:text-left' ).append(
                            $( '<p>' ).addClass( `font-bold ${ iconColor }` ).text( header ),
                            $( '<p>' ).addClass( 'text-sm text-gray-700 mt-1' ).text( message )
                        )
                    ),
                    $( '<div>' ).addClass( 'text-center md:text-right mt-4 md:flex md:justify-end' ).append(
                        $( '<button>' ).attr( 'id', buttonClass ).addClass( `block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 rounded-lg font-semibold text-sm md:ml-2 md:order-2 ${ buttonBgColor } ${ buttonTextColor } ${ hoverBgColor } ${ activeBgColor } ${ focusStyles } ${ transition }` ).text( buttonText ),
                        type === 'confirmation' || type === 'delete' ? $( '<button>' ).addClass( 'cancel block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 rounded-lg font-semibold text-sm mt-4 md:mt-0 md:order-1 bg-gray-200 hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 disabled:opacity-25 transition' ).text( 'Cancel' ) : null
                    )
                )
            );

            // Append the pop-up HTML to the specified div
            $( '#popup-handler' ).append( popupHtml );

            // Show the pop-up
            $( `.${ type }-popup` ).removeClass( 'hidden' );

            // Add event listener to close button using event delegation
            $( '#popup-handler' ).on( 'click', `#${ buttonClass }`, function ()
            {
                $( `.${ type }-popup` ).hide();
            } );

            // Add event listener to cancel button if it exists
            if ( type === 'confirmation' || type === 'delete' )
            {
                $( '.cancel' ).click( function ()
                {
                    $( `.${ type }-popup` ).hide();
                } );
            }
        }
    } );

</script>>

<?php
$script = ob_get_clean();
include ("master.php");
?>