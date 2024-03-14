<?php
session_start();
$pageTitle = "Users";
ob_start();
?>
<!-- Your page content goes here -->
<div class="page-content ml-20 transition-all duration-300">
    <h1 class="text-3xl font-bold mb-4 ml-16">Admin Dashboard</h1>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Username
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody id="user-list">
                <!-- User data will be dynamically added here -->
            </tbody>
        </table>
    </div>
</div>

<div id="editUserModal" class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Edit User</h2>
            <button class="close text-gray-600 hover:text-gray-800 focus:outline-none" data-twe-toggle="modal"
                data-twe-target="#editUserModal" aria-label="Close modal">&times;</button>
        </div>
        <form id="editUserForm" class="mt-4">
            <div class="mb-4">
                <label for="editFirstName" class="block text-sm font-medium text-gray-700">First Name:</label>
                <input type="text" id="editFirstName" name="editFirstName"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    required>
            </div>
            <div class="mb-4">
                <label for="editLastName" class="block text-sm font-medium text-gray-700">Last Name:</label>
                <input type="text" id="editLastName" name="editLastName"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    required>
            </div>
            <div class="mb-4">
                <label for="editEmail" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="editEmail" name="editEmail"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    required>
            </div>
            <div class="mb-4">
                <label for="editRole" class="block text-sm font-medium text-gray-700">Role:</label>
                <select id="editRole" name="editRole"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <!-- Roles options will be dynamically added here -->
                </select>
            </div>
            <div class="mb-4">
                <button type="button" id="resetPasswordBtn"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">Reset
                    Password</button>
            </div>
            <div class="flex justify-end">
                <button type="submit" id="updateUserBtn"
                    class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 disabled:opacity-25 transition">Update</button>
                <button type="button"
                    class="close inline-flex items-center justify-center ml-4 px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest bg-gray-200 hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                    data-twe-toggle="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="confirmation-popup hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-black opacity-25 w-full h-full absolute inset-0"></div>
    <div class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative">
        <div class="md:flex items-center">
            <div class="rounded-full flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                <i class="bi bi-exclamation-circle text-5xl"></i>
            </div>
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold">Confirm Update</p>
                <p class="text-sm text-gray-700 mt-1">Are you sure you want to update this user?</p>
            </div>
        </div>
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button id="confirmUpdateBtn"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-yellow-200 text-black rounded-lg font-semibold text-sm md:ml-2 md:order-2 hover:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:border-yellow-500 focus:ring focus:ring-yellow-200 disabled:opacity-25 transition">Confirm</button>
            <button id="cancelUpdateBtn"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4 md:mt-0 md:order-1 hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Cancel</button>
        </div>
    </div>
</div>

<div class="success-popup hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-black opacity-25 w-full h-full absolute inset-0"></div>
    <div class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative">
        <div class="md:flex items-center">
            <div class="rounded-full flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                <i class="bi bi-check-circle text-5xl"></i>
            </div>
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold">Update Successful</p>
                <p class="text-sm text-gray-700 mt-1">The user has been updated successfully.</p>
            </div>
        </div>
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button id="closeSuccessBtn"
                class="close block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-blue-200 text-blue-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2">Close</button>
        </div>
    </div>
</div>

<div class="error-popup hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-black opacity-25 w-full h-full absolute inset-0"></div>
    <div class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative">
        <div class="md:flex items-center">
            <div class="rounded-full flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                <i class="bx bi-exclamation-triangle text-5xl text-red-400"></i>
            </div>
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold text-red-400">Update Failed</p>
                <p class="text-sm text-gray-700 mt-1">Failed to update the user. Please try again later.</p>
            </div>
        </div>
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button id="closeErrorBtn"
                class="close block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2">Close</button>
        </div>
    </div>
</div>

<div class="delete-confirmation-popup hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-black opacity-25 w-full h-full absolute inset-0"></div>
    <div class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative">
        <div class="md:flex items-center">
            <div class="rounded-full flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                <i class="bi bi-exclamation-circle text-5xl text-red-400"></i>
            </div>
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold text-red-400">Confirm Delete</p>
                <p class="text-sm text-gray-700 mt-1">Are you sure you want to delete this user?</p>
            </div>
        </div>
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button id="confirmDeleteBtn"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-yellow-200 text-black rounded-lg font-semibold text-sm md:ml-2 md:order-2 hover:bg-yellow-400 active:bg-yellow-500 focus:outline-none focus:border-yellow-500 focus:ring focus:ring-yellow-200 disabled:opacity-25 transition">Confirm</button>
            <button id="cancelDeleteBtn"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4 md:mt-0 md:order-1 hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Cancel</button>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();
ob_start();
?>
<script src="../../../assets\JS\pop-up.js"></script>

<script>
    $( document ).ready( function ()
    {
        $( '#editUserModal' ).hide();

        function fetchUserData ()
        {
            $.ajax( {
                url: '../../../backend/users/user-get.php',
                type: 'GET',
                dataType: 'json',
                success: function ( data )
                {
                    renderUserData( data );
                },
                error: function ( xhr, status, error )
                {
                    console.error( 'Error:', error );
                }
            } );
        }

        function renderUserData ( data )
        {
            const userList = $( '#user-list' );
            userList.empty(); // Clear existing user data
            data.forEach( function ( user )
            {
                const userRow = $( '<tr>' ).addClass( 'bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600' );
                const userInfoContainer = $( '<div>' ).addClass( 'flex flex-col justify-center' );
                userInfoContainer.append( $( '<h6>' ).addClass( 'mb-0 text-sm leading-normal dark:text-white' ).text( user.fname + ' ' + user.lname ) );
                userInfoContainer.append( $( '<p>' ).addClass( 'mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400' ).text( user.email ) );
                userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).append( userInfoContainer ) );
                userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).text( user.username ) );
                userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).text( user.role ) );
                userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).append(
                    $( '<button>' ).addClass( 'editBtn font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2' )
                        .attr( 'data-toggle', 'modal' )
                        .attr( 'data-target', '#editUserModal' )
                        .data( 'userId', user.user_id )
                        .text( 'Edit' )
                        .data( 'user', user ),
                    $( '<button>' ).addClass( 'font-medium text-red-600 dark:text-red-500 hover:underline' ).text( 'Delete' ).click( function ()
                    {
                        // Implement delete functionality here
                        // console.log('Delete button clicked for user:', user);
                    } )
                ) );
                userList.append( userRow );
            } );
        }

        $.ajax( {
            url: '../../../backend/roles/roles-get.php',
            type: 'GET',
            dataType: 'json',
            success: function ( roles )
            {
                // Render roles data
                const roleSelect = $( '#editRole' );
                roles.forEach( function ( role )
                {
                    roleSelect.append( $( '<option>' ).val( role.role_id ).text( role.role_name ) );
                } );
            },
            error: function ( xhr, status, error )
            {
                console.error( 'Error:', error );
            }
        } );

        // Open modal when edit button is clicked
        $( document ).on( 'click', '.editBtn', function ()
        {
            // Get user information
            const user = $( this ).data( 'user' );
            const userId = $( this ).data( 'userId' ); // Retrieve userId from button's data
            $( '#editUserForm' ).data( 'userId', userId );
            $( '#editFirstName' ).val( user.fname );
            $( '#editLastName' ).val( user.lname );
            $( '#editEmail' ).val( user.email );

            // Open the modal
            $( '#editUserModal' ).removeClass( 'hidden' );
            $( '#editUserModal' ).show();
        } );

        // Handle confirm update action
        $( '#confirmUpdateBtn' ).click( function ()
        {
            // Perform update action here (call backend API)
            const userId = $( '#editUserForm' ).data( 'userId' );
            const firstName = $( '#editFirstName' ).val();
            const lastName = $( '#editLastName' ).val();
            const email = $( '#editEmail' ).val();
            const roleId = $( '#editRole' ).val();

            // You need to implement the AJAX call to update the user
            $.ajax( {
                url: '../../../backend/users/user-update.php', // Update the URL with your backend endpoint
                type: 'POST',
                dataType: 'json',
                data: {
                    userId: userId,
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    roleId: roleId
                },
                success: function ( response )
                {
                    if ( response.success )
                    {
                        // Display success message using a pop-up
                        $( '.success-popup .popup-message' ).text( response.message );
                        $( '.success-popup' ).removeClass( 'hidden' );

                        // Automatically close the pop-up after 3 seconds (3000 milliseconds)
                        setTimeout( function ()
                        {
                            $( '.success-popup' ).addClass( 'hidden' );
                            $( '#editUserModal' ).addClass( 'hidden' );
                        }, 3000 );

                        fetchUserData();
                    } else
                    {
                        // Display error message using a pop-up
                        $( '.error-popup .popup-message' ).text( response.message );
                        $( '.error-popup' ).removeClass( 'hidden' );
                    }

                    // Close modal regardless of success or failure
                    $( '#editUserModal' ).modal( 'hide' );
                },
                error: function ( xhr, status, error )
                {
                    console.error( 'Error:', error );
                    // Display error message
                    // Display error message using a pop-up
                    $( '.error-popup .popup-message' ).text( error );
                    $( '.error-popup' ).removeClass( 'hidden' );
                }
            } );
            $( '.confirmation-popup' ).addClass( 'hidden' );
        } );

        // Handle cancel update action
        $( '#cancelUpdateBtn' ).click( function ()
        {
            // Hide the confirmation popup and keep the edit modal open
            $( '.confirmation-popup' ).addClass( 'hidden' );
        } );

        // Handle close button click for success pop-up
        $( '#closeSuccessBtn' ).click( function ()
        {
            $( '.success-popup' ).addClass( 'hidden' );
            $( '#editUserModal' ).addClass( 'hidden' );
        } );

        // Handle close button click for error pop-up
        $( '#closeErrorBtn' ).click( function ()
        {
            $( '.error-popup' ).addClass( 'hidden' );
        } );

        // Handle click on the X button for edit user modal
        $( '#editUserModal .close' ).click( function ()
        {
            $( '#editUserModal' ).addClass( 'hidden' );
        } );

        // Handle form submission (update user)
        $( '#editUserForm' ).submit( function ( event )
        {
            event.preventDefault();
            // Show confirmation popup
            $( '.confirmation-popup' ).removeClass( 'hidden' );
        } );

        // Handle password reset button click
        $( '#resetPasswordBtn' ).click( function ()
        {
            // Perform password reset action here
            // Display confirmation message
            alert( 'Password reset successful!' );
        } );


        fetchUserData();
    } );
</script>

<?php
$script = ob_get_clean();
include("../../../public/master.php");
?>