<?php
session_start();
$pageTitle = "Users";
ob_start();
?>

<!-- Your page content goes here -->
<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">User Accounts List</h1>
        <div class=" flex flex-row justify-between items-cent">
            <button id="openCreateRoleModal"
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 mx-1 sm:mt-4 !px-4 py-0 text-lg items-center flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Role</button>
            <button id="openCreateUserModal"
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 mx-1 sm:mt-4 !px-4 py-0 text-lg items-center flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add User Accounts</button>
        </div>
    </div>

    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div>
    <div class="flex sm:flex-row items-center justify-center">
        <div class="flex sm:flex-row mb-4 sm:mb-0">
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
                    <input
                        class="border-2 border-gray-300 bg-white h-11 w-64 px-2 mt-4 sm:!mt-0 rounded-lg text-[16px] focus:outline-none"
                        type="text" name="search" placeholder="Search" id="searchInput">
                    <button type="submit" class="absolute right-0 top-0 mt-7 mr-4 sm:mt-3 ">
                        <svg class="text-gray-600 h-5 w-5 fill-current hover:text-yellow-500"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                            id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966"
                            style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px"
                            height="512px">
                            <path
                                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <button id="resetFiltersBtn"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold mt-6 py-2 px-3 rounded inline-flex items-center sm:mt-2">
            Reset
            <i class="bi bi-arrow-counterclockwise ml-2 mt-1" width="16" height="16"></i>
        </button>

    </div>

    <div class="relative overflow-x-auto mb-1 rounded-lg mt-4">
        <table class="display !w-full  ">
            <thead class="">
                <tr>
                    <th scope="col" class="text-left px-6 py-3">
                        <span id="NameOrder" class="">
                            <i id="downArrow" class="bi bi-caret-down-fill cursor-pointer"></i>
                            <i id="upArrow" class="bi bi-caret-up-fill cursor-pointer"></i>
                            <span class="ml-1">Name</span>
                        </span>
                    </th>
                    <th scope="col" class="text-left px-6 py-3">
                        <span id="RoleOrder" class="">
                            <i id="downArrow" class="bi bi-caret-down-fill cursor-pointer"></i>
                            <i id="upArrow" class="bi bi-caret-up-fill cursor-pointer"></i>

                            <span class="ml-1">Role</span>
                        </span>
                    </th>
                    <th scope="col" class="text-center px-6 py-3">
                        <span id="StatusOrder" class="">
                            <i id="downArrow" class="bi bi-caret-down-fill cursor-pointer"></i>
                            <i id="upArrow" class="bi bi-caret-up-fill cursor-pointer"></i>

                            <span class="ml-1">Status</span>
                        </span>

                    </th>
                    <th scope="col" class="text-center py-3">
                        <span id="CreatedAtOrder" class="">
                            <i id="downArrow" class="bi bi-caret-down-fill cursor-pointer"></i>
                            <i id="upArrow" class="bi bi-caret-up-fill cursor-pointer"></i>

                            <span class="ml-1"> Created At
                            </span>
                        </span>
                    </th>
                    <th scope="col" class="text-center py-3">
                        <span id="UpdatedAtOrder" class="">
                            <i id="downArrow" class="bi bi-caret-down-fill cursor-pointer"></i>
                            <i id="upArrow" class="bi bi-caret-up-fill cursor-pointer"></i>

                            <span class="ml-1"> Updated At
                            </span>
                        </span>
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

<div id="popup-handler">
</div>

<?php $content = ob_get_clean();
ob_start();
?>
<script src="../../../assets\JS\pop-up.js"></script>

<script>
    $( document ).ready( function ()
    {

        // Add yellow ring effect on hover, toggle, and focus with transition
        $( '#downArrow, #upArrow' ).on( 'mouseenter focus', function ()
        {
            $( this ).addClass( 'ring bg-yellow-200 ring-transparent transition' );
        } ).on( 'mouseleave blur', function ()
        {
            $( this ).removeClass( 'ring bg-yellow-200 ring-transparent transition' );
        } )

        //////////////////// GET DATA ///////////////////////////

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

        // Function to handle header click
        function handleHeaderClick ( headerId )
        {
            const { roleFilter, statusFilter, searchTerm, limit } = updateFiltersAndSort();
            const columnMap = {
                'NameOrder': 'lname',
                'RoleOrder': 'role_name',
                'StatusOrder': 'status',
                'CreatedAtOrder': 'created_at',
                'UpdatedAtOrder': 'updated_at'
            };

            const column = columnMap[headerId]; // Get the column name from the headerId

            const sortOrder = $( `#${ headerId }` ).data( 'sortOrder' ) || 'desc'; // Get current sort order from data attribute

            // Toggle sort order
            const newSortOrder = sortOrder === 'desc' ? 'asc' : 'desc';
            $( `#${ headerId }` ).data( 'sortOrder', newSortOrder ); // Update sort order in data attribute

            // Update caret icons based on sort order
            $( `#${ headerId } .bi-caret-down-fill` ).toggleClass( 'hidden', newSortOrder !== 'desc' );
            $( `#${ headerId } .bi-caret-up-fill` ).toggleClass( 'hidden', newSortOrder !== 'asc' );

            // Call filter function with sorting parameters
            filterUserData( roleFilter, statusFilter, searchTerm, 1, limit, column, newSortOrder ); // Pass column name and sort order
        }

        // Event listeners for header clicks
        $( '#NameOrder, #RoleOrder, #StatusOrder, #CreatedAtOrder, #UpdatedAtOrder' ).on( 'click', function ()
        {
            handleHeaderClick( $( this ).attr( 'id' ) );
        } );

        function updateFiltersAndSort ()
        {
            const roleFilter = $( '#roleFilter' ).val();
            const statusFilter = $( '#statusFilter' ).val();
            const searchTerm = $( '#searchInput' ).val();
            const limit = $( '#paginationSelect' ).val();
            const headerId = $( '.caret-header.active' ).attr( 'id' );
            return { roleFilter, statusFilter, searchTerm, limit, headerId };
        }

        // Event listener for filter inputs and pagination select
        $( '#roleFilter, #statusFilter, #searchInput, #paginationSelect' ).on( 'change input', function ()
        {
            handleFilterChange();
        } );

        // Function to handle filter and search input changes
        function handleFilterChange ()
        {
            const { roleFilter, statusFilter, searchTerm, limit, headerId } = updateFiltersAndSort();
            handleHeaderClick( headerId, roleFilter, statusFilter, searchTerm, limit );
        }

        /////////////// RESET  FILTERS AND SORTING //////////////////

        // Event listener for reset filters button
        $( '#resetFiltersBtn' ).on( 'click', function ()
        {
            resetFilters();
        } );

        // Function to reset all filters, search input, and sorting order
        function resetFilters ()
        {
            // Reset filter inputs
            $( '#roleFilter, #statusFilter' ).val( '' );

            // Reset search input
            $( '#searchInput' ).val( '' );

            // Reset sorting order and icons
            $( '.bi-caret-down-fill, .bi-caret-up-fill' ).removeClass( 'hidden' );

            // Trigger filter change handler to update data
            handleFilterChange();
        }

        // Function to filter user data with sorting
        function filterUserData ( roleFilter, statusFilter, searchTerm, page, limit, sortBy, sortOrder )
        {
            // Send AJAX request to fetch filtered and sorted data
            $.ajax( {
                url: '../../../backend/users/user-get.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    roleFilter: roleFilter,
                    statusFilter: statusFilter,
                    searchTerm: searchTerm,
                    page: page,
                    limit: limit,
                    sortBy: sortBy,
                    sortOrder: sortOrder
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

        ////////////////////// SUBMIT EVENT HANDLER (HANDLES BOTH UPDATE AND CREATE USER) ///////////////////////////

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
                let actionType;
                const userId = $( '#userModal' ).data( 'userId' );
                console.log( userId );

                if ( userId !== undefined )
                {
                    // Update user
                    actionType = 'update';
                    showPopup( 'confirmation', 'Confirm Update', null, actionType ); // Pass null for message
                    url = '../../../backend/users/user-update.php';
                    formData += '&userId=' + userId;
                } else
                {
                    // Create user
                    actionType = 'create';
                    showPopup( 'confirmation', 'Confirm Create', null, actionType ); // Pass null for message
                    url = '../../../backend/users/user-create.php';
                }

                // Store form data and action type for later use
                $( document ).data( 'formData', formData );
                $( document ).data( 'actionType', actionType );
                $( document ).data( 'url', url );
            }
        } );

        // Event listener for confirmation button click
        $( document ).on( 'click', '#confirmBtn', function ()
        {
            // Hide confirmation pop-up
            $( '.confirmation-popup' ).addClass( 'hidden' );

            // Retrieve stored form data and action type
            let formData = $( document ).data( 'formData' );
            const actionType = $( document ).data( 'actionType' );
            const url = $( document ).data( 'url' );

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
                        // Hide create user form
                        $( '#userModal' ).addClass( 'hidden' );

                        // Display success message using a pop-up
                        if ( actionType === 'update' )
                        {
                            showPopup( 'success', 'Success', null, actionType ); // Pass null for message
                        } else if ( actionType === 'create' )
                        {
                            showPopup( 'success', 'Success', null, actionType ); // Pass null for message
                        }

                        // Automatically close the success pop-up after 3 seconds
                        setTimeout( function ()
                        {
                            $( '.success-popup' ).addClass( 'hidden' );
                        }, 3000 );

                        // Refresh user data 
                        filterUserData( '', '', '', 1, 5 );
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
                                // Display error message using a pop-up
                                showPopup( 'error', 'Error', response.message[fieldName] );
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

            // Clear stored formData, actionType, and URL
            $( document ).data( 'formData', null );
            $( document ).data( 'actionType', null );
            $( document ).data( 'url', null );
            $( '#userModal' ).removeData( 'userId' );
            $( '#popup-handler' ).empty();
        } );

        //////////////////// ACTIVATE / DEACTIVATE ///////////////////////////

        // Open modal when delete button is clicked
        $( document ).on( 'click', '.delBtn', function ()
        {
            // Get user information
            const userId = $( this ).data( 'userId' );
            const userStatus = $( this ).data( 'userStatus' );
            console.log( userStatus );
            const delBtnText = "Delete"; // Assuming delBtnText is defined somewhere
            const popupMessage = userStatus === 'active' ? 'Are you sure you want to deactivate this user?' : 'Are you sure you want to activate this user?';
            const header = userStatus === 'active' ? 'Confirm Deactivation' : 'Confirm Activation';

            // Call showPopup function with confirmation parameters
            showPopup( 'delete', header, popupMessage, userStatus === 'active' ? 'deactivate' : 'activate' );

            // Store user ID for later use
            $( '#confirmDeleteBtn' ).data( 'userId', userId );
            $( '#confirmDeleteBtn' ).data( 'userStatus', userStatus );

        } );

        // Click event listener for confirmDeleteBtn
        $( document ).on( 'click', '#confirmDeleteBtn', function ()
        {
            // Get user information
            const userId = $( '#confirmDeleteBtn' ).data( 'userId' );
            const userStatus = $( '#confirmDeleteBtn' ).data( 'userStatus' );

            // Check if userId exists
            if ( userId )
            {
                // AJAX request
                $.ajax( {
                    url: '../../../backend/users/user-delete.php',
                    type: 'POST',
                    data: { userId: userId },
                    dataType: 'json',
                    success: function ( response )
                    {
                        if ( response.success )
                        {
                            // Display success message using a pop-up
                            const successMessage = response.message || 'User operation successful.';
                            showPopup( 'success', 'Success', null, userStatus === 'active' ? 'deactivate' : 'activate' );

                            // Automatically close the pop-up after 3 seconds
                            setTimeout( function ()
                            {
                                $( '.success-popup' ).addClass( 'hidden' );
                            }, 3000 );

                            filterUserData( '', '', '', 1, 5 );
                        } else
                        {
                            // Display error message using a pop-up
                            const errorMessage = response.message || 'An error occurred. Please try again later.';
                            showPopup( 'error', 'Error', errorMessage );
                        }
                    },
                    error: function ( xhr, status, error )
                    {
                        // Display error message using a pop-up
                        showPopup( 'error', 'Error', 'An error occurred. Please try again later.' );
                        console.error( 'Error:', error );
                    }
                } );
            } else
            {
                // If userId does not exist, show an error message
                showPopup( 'error', 'Error', 'User ID not provided.' );
            }
            $( '#popup-handler' ).empty();
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
                    button.addClass( 'bg-yellow-200 text-black font-bold transition' );
                } else
                {
                    button.addClass( 'bg-gray-200 text-gray-700 hover:bg-gray-300 hover:underline transition' );
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
            const popupHtml = $( '<div>' ).addClass( `${ type }-popup hidden fixed inset-0 z-50 flex items-center justify-center` ).append(
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

        filterUserData( '', '', '', 1, 5 );
    } );
</script>

<?php
$script = ob_get_clean();
include ("../../../public/master.php");
?>