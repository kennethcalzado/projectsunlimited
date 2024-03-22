<?php
session_start();
$pageTitle = "Users";
ob_start();
?>

<!-- Your page content goes here -->
<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">User Accounts List</h1>
        <button id="openCreateUserModal" class="yellow-btn text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-[19px]">
            Add User Account
        </button>
    </div>

    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div>
    <div class="flex flex-col sm:flex-row items-center justify-center">
        <div class="flex flex-col sm:flex-row justify-between mb-4 sm:mb-0">
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="roleFilter" class="mr-2">Filter by Role:</label>
                <select id="roleFilter" class="border rounded-md px-2 py-1">
                    <option value="">All Roles</option>
                    <!-- Role options will be dynamically added here -->
                </select>
            </div>
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="statusFilter" class="mr-2">Filter by Status:</label>
                <select id="statusFilter" class="border rounded-md px-2 py-1">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <!-- Pagination dropdown -->
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="paginationSelect" class="mr-2">Pagination:</label>
                <select id="paginationSelect" class="border rounded-md px-2 py-1">
                    <option value="5">5 per page</option>
                    <option value="10">10 per page</option>
                    <option value="50">50 per page</option>
                </select>
            </div>
        </div>
        <div class="flex justify-between">
            <div class="relative mb-1 mt-2 sm:mb-0 sm:mr-2">
                <!-- Search input -->
                <div class="relative text-gray-600">
                    <input class="border-2 border-gray-300 bg-white h-9 w-64 px-2 rounded-lg text-sm focus:outline-none"
                        type="text" name="search" placeholder="Search" id="searchInput">
                    <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                        <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;"
                            xml:space="preserve" width="512px" height="512px">
                            <path
                                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto mb-1 rounded-lg mt-4">
        <table class="display !w-full  ">
            <thead class="">
                <tr>
                    <th scope="col" class="text-left px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="text-left px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="text-left px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="text-center py-3">
                        Created At
                    </th>
                    <th scope="col" class="text-center py-3">
                        Updated At
                    </th>
                    <th scope="col" class="text-center py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody id="user-list">
                <!-- User data will be dynamically added here -->
            </tbody>
        </table>
    </div>
    <div class="flex flex-col sm:flex-row px-2 sm:self-center sm:items-center justify-between bottom-0">
        <div id="itemCount" class="text-center text-gray-500"></div>
        <div id="pagination" class="justify-center mt-4"></div>
    </div>
</div>

<div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="bg-black opacity-25 w-full h-full absolute -z-10"></div>
    <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center">
            <h2 id="userModalTitle" class="text-xl font-semibold">User Details</h2>
            <button id="closeUserModal"
                class="close rounded-full text-gray-600 px-2 hover:text-gray-800 focus:outline-none hover:bg-gray-300"
                aria-label="Close modal">&times;</button>
        </div>
        <form id="userForm" class="mt-4">
            <div class="mb-4">
                <label for="firstName" class="block text-sm font-medium text-gray-700">First Name:</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter first name"
                    class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <div id="firstNameError" class="text-red-500 text-sm mt-1"></div> <!-- Error message space -->
            </div>
            <div class="mb-4">
                <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name:</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter last name"
                    class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <div id="lastNameError" class="text-red-500 text-sm mt-1"></div> <!-- Error message space -->
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="text" id="email" name="email" placeholder="Enter email address"
                    class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <div id="emailError" class="text-red-500 text-sm mt-1"></div> <!-- Error message space -->
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
                <select id="role" name="role"
                    class="pl-2 mt-1 block w-full rounded-md border border-gray-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="" disabled selected>Select Role</option>
                    <!-- Roles options will be dynamically added here -->
                </select>
                <div id="roleError" class="text-red-500 text-sm mt-1"></div> <!-- Error message space -->
            </div>
            <div class="mb-4" id="resetPasswordContainer">
                <button type="button" id="resetPasswordBtn"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">Reset
                    Password</button>
            </div>
            <div class="flex justify-end">
                <button type="submit" id="submitUserBtn" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent 
                    rounded-md font-semibold text-xs text-white uppercase tracking-widest 
                    hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 
                    focus:ring focus:ring-green-200 disabled:opacity-25 transition">Submit</button>
                <button type="button" id="cancelUserBtn"
                    class="close inline-flex items-center justify-center ml-4 px-4 py-2 border 
                    border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase 
                    tracking-widest bg-gray-200 hover:bg-gray-300 active:bg-gray-400 focus:outline-none 
                    focus:border-gray-400 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Cancel</button>
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

<div class="delete-confirmation-popup hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-black opacity-25 w-full h-full absolute inset-0"></div>
    <div class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative">
        <div class="md:flex items-center">
            <div class="rounded-full flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                <i class="bi bi-exclamation-circle text-5xl text-red-400"></i>
            </div>
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold text-red-400">Confirm to Change Account Status?</p>
                <p class="text-sm text-gray-700 mt-1">Are you sure you want to change the status of this user?</p>
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

<?php $content = ob_get_clean();
ob_start();
?>
<script src="../../../assets\JS\pop-up.js"></script>

<script>
    $( document ).ready( function ()
    {
        //////////////////// GET DATA ///////////////////////////

        // Function to filter user data based on role, status, search term, and pagination
        function filterUserData ( roleFilter, statusFilter, searchTerm, page, limit )
        {
            // Send AJAX request to fetch filtered data
            $.ajax( {
                url: '../../../backend/users/user-get.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    roleFilter: roleFilter,
                    statusFilter: statusFilter,
                    searchTerm: searchTerm,
                    page: page,
                    limit: limit
                },
                success: function ( data )
                {
                    console.log( data );
                    renderUserData( data.users, data.pagination );
                },
                error: function ( xhr, status, error )
                {
                    console.error( 'Error:', error );
                }
            } );
        }

        $.ajax( {
            url: '../../../backend/roles/roles-get.php',
            type: 'GET',
            dataType: 'json',
            success: function ( roles )
            {
                // Render roles data
                const roleSelectForm = $( '#role' );
                const roleSelectFilter = $( '#roleFilter' );

                roles.forEach( function ( role )
                {
                    roleSelectForm.append( $( '<option>' ).val( role.role_name ).text( role.role_name ) );
                    roleSelectFilter.append( $( '<option>' ).val( role.role_name ).text( role.role_name ) );
                } );
            },
            error: function ( xhr, status, error )
            {
                console.error( 'Error:', error );
            }
        } );

        // Event listeners for dropdown menu changes, search input, and pagination dropdown
        $( '#roleFilter, #statusFilter, #searchInput, #paginationSelect' ).on( 'change input', function ()
        {
            const roleFilter = $( '#roleFilter' ).val();
            const statusFilter = $( '#statusFilter' ).val();
            const searchTerm = $( '#searchInput' ).val();
            const limit = $( '#paginationSelect' ).val();
            filterUserData( roleFilter, statusFilter, searchTerm, 1, limit ); // Reset to page 1 when filters change
        } );

        function renderUserData ( data, pagination )
        {
            const userList = $( '#user-list' );
            userList.empty(); // Clear existing user data

            if ( data.length === 0 )
            {
                const noUserRow = $( '<tr>' ).addClass( 'bg-white-200 border-b' );
                const messageCell = $( '<td>' ).addClass( 'px-6 py-4 text-center text-red-800 font-bold' ).attr( 'colspan', '7' ).text( 'No users found' );
                noUserRow.append( messageCell );
                userList.append( noUserRow );
            } else
            {
                data.forEach( function ( user )
                {
                    // Render user row
                    const userRow = $( '<tr>' ).addClass( 'bg-white-200 border-b hover:bg-yellow-200 dark:hover:bg-yellow-200' );
                    const userInfoContainer = $( '<div>' ).addClass( 'flex flex-col justify-center' );
                    userInfoContainer.append( $( '<h6>' ).addClass( 'text-left px-auto w-full' ).text( user.fname + ' ' + user.lname ) );
                    userInfoContainer.append( $( '<p>' ).addClass( 'text-left text-xs leading-tight text-slate-400' ).text( user.email ) );
                    userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).append( userInfoContainer ) );
                    userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).text( user.role_name ) );
                    userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).text( user.status ) );
                    userRow.append( $( '<td>' ).addClass( 'text-center px-6 py-4' ).text( user.created_at ) );
                    userRow.append( $( '<td>' ).addClass( 'text-center px-6 py-4' ).text( user.updated_at ) );
                    // Add edit and delete buttons
                    const delBtnText = user.status === 'active' ? 'Deactivate' : 'Activate';
                    userRow.append( $( '<td>' ).addClass( 'py-6 w-auto px-auto flex justify-center' ).append(
                        $( '<button>' ).addClass( 'editBtn btn-primary hover:underline text-[14px] mx-auto ' )
                            .attr( 'data-toggle', 'modal' )
                            .attr( 'data-target', '#userModal' )
                            .data( 'userId', user.user_id )
                            .data( 'user', user )
                            .text( 'Edit' ),
                        $( '<button>' ).addClass( 'delBtn btn-danger hover:underline text-[14px] mx-auto' )
                            .attr( 'data-toggle', 'modal' )
                            .attr( 'data-target', '#userModal' )
                            .data( 'userId', user.user_id )
                            .data( 'userStatus', user.status )
                            .data( 'user', user )
                            .text( delBtnText )
                    ) );
                    userList.append( userRow );
                } );
            }

            // Update item count display
            const currentPage = parseInt( pagination.currentPage );
            const totalRows = parseInt( pagination.totalRows );
            const perPage = parseInt( pagination.perPage );
            const startItem = parseInt( pagination.startItem );
            let endItem = parseInt( pagination.endItem );

            // Adjust endItem if it's on the last page and there are fewer items than perPage
            if ( currentPage === pagination.totalPages && totalRows % perPage < perPage )
            {
                endItem = totalRows;
            }

            $( '#itemCount' ).text( `Showing ${ startItem }-${ endItem } of ${ totalRows } items` );
            // Generate pagination buttons
            const totalPages = parseInt( pagination.totalPages );
            generatePagination( totalPages, currentPage );
        }

        //////////////////// OPEN FORMS /////////////////////////////////

        // Event listener to open modal when edit button is clicked
        $( document ).on( 'click', '.editBtn', function ()
        {
            const user = $( this ).data( 'user' );
            populateModalWithData( user );
        } );

        // Event listener to open modal when "Add User Account" button is clicked
        $( document ).on( 'click', '#openCreateUserModal', function ()
        {
            $( '#userModalTitle' ).text( 'Create User' );
            $( '#userForm' )[0].reset(); // Reset form fields
            $( '#resetPasswordContainer' ).hide();
            $( '#userModal' ).removeClass( 'hidden' );
        } );

        // Function to populate modal with user data
        function populateModalWithData ( user )
        {
            $( '#userModalTitle' ).text( 'Edit User' );
            const userId = user.user_id
            $( '#userModal' ).data( 'userId', userId );

            console.log( userId );

            $( '#firstName' ).val( user.fname );
            $( '#lastName' ).val( user.lname );
            $( '#username' ).val( user.username );
            $( '#email' ).val( user.email );
            // Populate role select options dynamically here
            $( '#role' ).val( user.role_name );
            // Show or hide reset password button based on user's status or any condition
            if ( user.status === 'active' )
            {
                $( '#resetPasswordContainer' ).show();
            } else
            {
                $( '#resetPasswordContainer' ).hide();
            }
            $( '#userModal' ).removeClass( 'hidden' );
        }

        ////////////////// VALIDATION OF FORMS /////////////////////

        // Function to validate the user form
        function validateUserForm ()
        {
            // Remove any existing error styling and messages
            $( '.border-red-500' ).removeClass( 'border-red-500' );
            $( '.text-red-500' ).removeClass( 'text-red-500' );
            $( '.error-message' ).empty();

            // Get form inputs
            const firstName = $( '#firstName' ).val();
            const lastName = $( '#lastName' ).val();
            const email = $( '#email' ).val();
            const role = $( '#role' ).val();

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Initialize error message
            let isValid = true;

            // Check if any required field is empty and build error message
            if ( !firstName || firstName.trim() === '' )
            {
                $( '#firstName' ).addClass( 'border-red-500' );
                $( '#firstNameError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'First Name is required.' );
                isValid = false;
            }
            if ( !lastName || lastName.trim() === '' )
            {
                $( '#lastName' ).addClass( 'border-red-500' );
                $( '#lastNameError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Last Name is required.' );
                isValid = false;
            }
            if ( !email || email.trim() === '' )
            {
                $( '#email' ).addClass( 'border-red-500' );
                $( '#emailError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Email is required.' );
                isValid = false;
            } else if ( !emailRegex.test( email ) )
            {
                $( '#email' ).addClass( 'border-red-500' );
                $( '#emailError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Invalid email format.' );
                isValid = false;
            }

            if ( !role || role.trim() === '' )
            {
                $( '#role' ).addClass( 'border-red-500' );
                $( '#roleError' ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Role is required.' );
                isValid = false;
            }

            return isValid;
        }

        ////////////////////// SUBMIT EVENT HANDLER ///////////////////////////

        // Event listener for form submission
        $( '#userForm' ).submit( function ( event )
        {
            // Prevent default form submission behavior
            event.preventDefault();

            // Validate the form
            if ( validateUserForm() )
            {
                let formData = $( this ).serialize(); // Serialize form data

                // Determine the URL based on whether it's an update or create action
                let url;
                const userId = $( '#userModal' ).data( 'userId' );
                if ( userId )
                {
                    // Update user URL
                    url = '../../../backend/users/user-update.php';
                    formData += '&userId=' + userId;
                } else
                {
                    // Create user URL
                    url = '../../../backend/users/user-create.php';
                }

                // Submit the form using AJAX
                $.ajax( {
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
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
                                $( '#userModal' ).addClass( 'hidden' );
                            }, 3000 );

                            // Refresh user data (assuming you have a function to fetch and display user data)
                            fetchUserData();
                        } else
                        {
                            if ( response.message )
                            {
                                // Reset error messages and styles
                                $( '.error-message' ).text( '' );
                                $( '.form-control' ).removeClass( 'border-red-500' );

                                // Display error messages received from the backend
                                Object.keys( response.message ).forEach( function ( fieldName )
                                {
                                    $( '#' + fieldName + 'Error' ).text( response.message[fieldName] );
                                    $( '#' + fieldName ).addClass( 'border-red-500' );
                                } );
                            }

                            // Display error message using a pop-up
                            $( '.error-popup .popup-message' ).text( response.message );
                            $( '.error-popup' ).removeClass( 'hidden' );
                        }
                    },
                    error: function ( xhr, status, error )
                    {
                        console.error( 'Error:', error );
                        // Display error message using a pop-up
                        $( '.error-popup .popup-message' ).text( error );
                        $( '.error-popup' ).removeClass( 'hidden' );
                    }
                } );
            }
        } );


        // Open modal when edit button is clicked
        $( document ).on( 'click', '.delBtn', function ()
        {
            // Get user information
            const userId = $( this ).data( 'userId' );
            $( '#confirmDeleteBtn' ).data( 'userId', userId );

            // Open the modal
            $( '.delete-confirmation-popup' ).removeClass( 'hidden' );
        } );

        // Click event listener for confirmDeleteBtn
        $( document ).on( 'click', '#confirmDeleteBtn', function ()
        {
            // Get user information
            const userId = $( this ).data( 'userId' );

            // AJAX request
            $.ajax( {
                url: '../../../backend/users/user-delete.php',
                type: 'POST',
                data: { userId: userId },
                dataType: 'json',
                success: function ( response )
                {
                    console.log( response );
                    if ( response.message )
                    {
                        // Display success message using a pop-up
                        $( '.success-popup .popup-message' ).text( response.message );
                        $( '.success-popup' ).removeClass( 'hidden' );

                        // Automatically close the pop-up after 3 seconds (3000 milliseconds)
                        setTimeout( function ()
                        {
                            $( '.success-popup' ).addClass( 'hidden' );
                            $( '.delete-confirmation-popup' ).addClass( 'hidden' );
                        }, 3000 );

                        filterUserData( '', '', '', 1, 5 );
                    } else
                    {
                        // Display error message using a pop-up
                        displayErrorPopup( 'An error occurred. Please try again later.' );

                    }
                },
                error: function ( xhr, status, error )
                {
                    // Handle error response
                    console.error( 'Error deleting user:', error );
                    // You can show an error message or perform other actions here
                }
            } );
        } );

        //////////////////////close buttons///////////////////////////////  
        // Function to display error message popup
        function displayErrorPopup ( message )
        {
            $( '.error-popup .popup-message' ).text( message );
            $( '.error-popup' ).removeClass( 'hidden' );
        }
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
            $( '.delete-confirmation-popup' ).addClass( 'hidden' );
        } );

        $( '#createUserModal input' ).on( 'input', function ()
        {
            const inputId = $( this ).attr( 'id' );
            const value = $( this ).val();

            // Check individual input validity
            switch ( inputId )
            {
                case 'createFirstName':
                case 'editFirstName':
                    validateFirstName( value );
                    break;
                case 'createLastName':
                case 'editLastName':
                    validateLastName( value );
                    break;
                case 'createUsername':
                case 'editUsername':
                    validateUsername( value );
                    break;
                case 'createEmail':
                case 'editEmail':
                    validateEmail( value );
                    break;
                case 'createRole':
                case 'editRole':
                    validateRole( value );
                    break;
            }
        } );

        // Handle form submission (update user)
        $( '#editUserForm' ).submit( function ( event )
        {
            event.preventDefault();
            // Show confirmation popup
            $( '.confirmation-popup' ).removeClass( 'hidden' );
        } );

        // Handle close button click for delete pop-up
        $( '#cancelDeleteBtn' ).click( function ()
        {
            $( '.delete-confirmation-popup' ).addClass( 'hidden' );
        } );

        ////////////////////// PAGINATION //////////////////////////

        function generatePagination ( totalPages, currentPage )
        {
            const paginationDiv = $( '#pagination' );
            paginationDiv.empty(); // Clear existing pagination buttons
            for ( let i = 1; i <= totalPages; i++ )
            {
                let button = $( '<button>' ).addClass( 'pagination-btn mx-1 py-1 px-3 rounded-lg' );
                if ( i === currentPage )
                {
                    button.addClass( 'bg-blue-500 text-white' );
                } else
                {
                    button.addClass( 'bg-gray-200 text-gray-700 hover:bg-gray-300' );
                }
                button.text( i );
                paginationDiv.append( button );
            }
        }

        // Event listener for pagination button click
        $( document ).on( 'click', '.pagination-btn', function ()
        {
            const page = parseInt( $( this ).text() );
            const roleFilter = $( '#roleFilter' ).val();
            const statusFilter = $( '#statusFilter' ).val();
            const searchTerm = $( '#searchInput' ).val();
            const limit = $( '#paginationSelect' ).val();
            filterUserData( roleFilter, statusFilter, searchTerm, page, limit );
        } );


        /////////////////// CLOSE / CANCEL EVENTS ////////////////////////////
        // Function to handle modal closing
        $( document ).on( 'click', '#closeUserModal, #cancelUserBtn', function ()
        {
            // Reset error markers and messages
            $( '.border-red-500' ).removeClass( 'border-red-500' );
            $( '.text-red-800' ).removeClass( 'text-red-800' );
            $( '.error-message' ).empty();

            // Hide the modal
            $( '#userModal' ).addClass( 'hidden' );
        } );
        filterUserData( '', '', '', 1, 5 );
    } );
</script>

<?php
$script = ob_get_clean();
include ("../../../public/master.php");
?>