<?php
session_start();
$pageTitle = "Users Table";

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin' || !isset($_SESSION['user_id'])) {
    header('Location: /public/error/error-401.php');
    exit;
}

ob_start();
?>
<!-- Your page content goes here -->
<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">User Accounts List</h1>
        <div class=" flex flex-row justify-between items-cent">
            <button id="addUserDropdownBtn"
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 mx-1 sm:mt-4 !px-4 py-0 text-lg items-center flex">
                <i class="fa-light fa-plus text-3xl pb-1 pr-2"></i>
                Add User
            </button>
            <div class="absolute 
                text-left text-sm text-center
                w-[150px] z-10
                transition-all bg-[#F6E17A] rounded-md shadow-md
                opacity-0 
                translate-y-[60px] -translate-x-[11px] space-y-1" id="addUserDropdown">

                <button class="hidden cursor-pointer hover:bg-[#F9E89B] p-4 rounded-md w-full" id="openCreateUserModal">
                    Add Single User
                </button>
                <button class="hidden cursor-pointer hover:bg-[#F9E89B] p-4 rounded-md w-full" id="openBulkUserModal">
                    Add Bulk User
                </button>
            </div>
        </div>
    </div>

    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div> <!--Divider-->

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
                <div class="relative">
                    <input
                        class="border-2 border-gray-300 bg-white h-11 w-64 px-2 pr-10 mt-4 sm:!mt-0 rounded-lg text-[16px] focus:outline-none"
                        type="text" name="search" placeholder="Search" id="searchInput">
                    <button type="submit" class="absolute right-0 top-0 mt-7 mr-4 sm:mt-3">
                        <svg class="text-gray-600 h-5 w-5 fill-current hover:text-gray-500 "
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
        <button id="resetFiltersBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold 
            mt-6 py-2 px-3 rounded inline-flex items-center sm:mt-2">
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

<div id="userModal" class="modal fixed inset-0 z-50 flex items-center justify-center hidden">
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
            <hr></form>
            <button type="button" id="showPasswordBtn" class="btn-primary showpw-btn inline-flex items-center px-4 py-2 mb-2 border border-transparent 
                    rounded-md font-medium text-xs uppercase tracking-widest 
                    transition">Default Password Template</button>

            <div class="flex justify-end">
                <button type="submit" id="submitUserBtn" class="btn-primary inline-flex items-center px-4 py-2 border border-transparent 
                    rounded-md font-semibold text-xs uppercase tracking-widest 
                    disabled:opacity-25 transition">Submit</button>
                <button type="button" id="cancelUserBtn"
                    class="close inline-flex items-center justify-center ml-4 px-4 py-2 border 
                    border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase 
                    tracking-widest bg-gray-200 hover:bg-gray-300 active:bg-gray-400 focus:outline-none 
                    focus:border-gray-400 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="uploadUserModal" class="modal fixed inset-0 flex items-center justify-center 
    bg-gray-800 bg-opacity-50 z-20 w-full hidden">
    <div class="bg-black opacity-25 w-full h-full absolute -z-10"></div>
    <div class="bg-white p-4 rounded-md w-full max-w-md">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">Upload .xlsx or .csv file</h2>
            <button id="closeUploadModal"
                class="close rounded-full text-gray-600 px-2 text-center text-lg hover:text-gray-800 focus:outline-none hover:bg-gray-300"
                aria-label="Close modal">&times;</button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <!-- Add instruction -->
        <p class="text-black justify-center mb-4 text-lg"><b class="mr-2">Instruction:</b>To upload multiple or bulk
            users information into the table, select an excel or a CSV file.
        </p>
        <form id="uploadUserForm" enctype="multipart/form-data" class="mt-2">
            <div class="mb-4 flex flex-col">
                <label for="dropzone-file" class="text-sm font-medium text-gray-700 mb-1">Select File</label>
                <div id="dropzone-holder" class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-900 border-dashed 
                        rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 
                        dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <div id="uploadModalIconHolder">
                                <i class="fa-solid fa-file-arrow-up text-3xl mb-3 text-zinc-300"></i>
                            </div>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                    to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">CSV, or XLSX (MAX. 800x400px)</p>
                            <!-- Placeholder for the file name -->
                            <p id="file-name" class="text-xs text-gray-500 dark:text-gray-400 mt-4"></p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" name="upload_user" accept=".xlsx, .csv" />
                    </label>
                </div>
            </div>

            <button type="button" id="showPasswordBtn" class="btn-primary showpw-btn inline-flex items-center px-4 py-2 mb-2 border border-transparent 
                    rounded-md font-medium text-xs uppercase tracking-widest 
                    transition">Default Password Template</button>

            <div class="flex justify-end">
                <button type="submit" id="uploadSubmitBtn"
                    class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Upload
                    File</button>
                <button type="button" id="cancelUploadModal"
                    class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
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

        /////////////// USER DATA FETCH //////////////////

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
                    // console.log( data );
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
                    const userRow = $( '<tr>' ).addClass( 'bg-white-200 border-b hover:bg-zinc-100 dark:hover:bg-zinc-100' );
                    const userInfoContainer = $( '<div>' ).addClass( 'flex flex-col justify-center' );
                    userInfoContainer.append( $( '<h6>' ).addClass( 'text-left px-auto w-full' ).text( user.fname + ' ' + user.lname ).attr( 'id', 'fullname' ) );
                    userInfoContainer.append( $( '<p>' ).addClass( 'text-left text-xs leading-tight text-slate-400' ).text( user.email ) );
                    userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).append( userInfoContainer ) );
                    userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).text( user.role_name ) );
                    userRow.append( $( '<td>' ).addClass( 'px-6 py-4' ).text( user.status ) );

                    const dateTd = $( '<td>' ).addClass( 'text-center px-4 py-2' ).append(
                        $( '<div>' ).text( formatDate( user.created_at ) ).addClass( 'text-sm' ), // Date with smaller text
                        $( '<div>' ).text( formatTime( user.created_at ) ).addClass( 'text-xs text-gray-500' ) // Time with even smaller and gray text
                    );
                    userRow.append( dateTd );

                    const updateDateTd = $( '<td>' ).addClass( 'text-center px-4 py-2' ).append(
                        $( '<div>' ).text( formatDate( user.updated_at ) ).addClass( 'text-sm' ), // Date with smaller text
                        $( '<div>' ).text( formatTime( user.updated_at ) ).addClass( 'text-xs text-gray-500' ) // Time with even smaller and gray text
                    );
                    userRow.append( updateDateTd );

                    const editButton = $( '<button>' ).addClass( 'editBtn yellow-btn btn-primary hover:underline text-[14px]' )
                        .attr( 'data-toggle', 'modal' )
                        .attr( 'data-target', '#userModal' )
                        .data( 'userId', user.user_id )
                        .data( 'user', user );

                    editButton.append(
                        $( '<i>' ).addClass( 'fas fa-edit pr-[3px]' ),
                        $( '<span>' ).text( 'Update' )
                    );

                    const delBtnText = user.status === 'active' ? 'Deactivate' : 'Activate';
                    const delBtnIconClass = user.status === 'active' ? 'fas fa-trash-alt pr-[3px]' : 'fas fa-check-circle pr-[3px]';
                    const deleteButton = $( '<button>' ).addClass( 'delBtn btn-danger hover:underline text-[14px]' )
                        .attr( {
                            'data-toggle': 'modal',
                            'data-target': '#userModal'
                        } )
                        .data( 'userId', user.user_id )
                        .data( 'userStatus', user.status )
                        .data( 'user', user )
                        .addClass( user.status === 'inactive' ? '!bg-emerald-500' : '' )
                        .append(
                            $( '<i>' ).addClass( delBtnIconClass ),
                            $( '<span>' ).text( delBtnText )
                        );

                    const actiontd = $( '<td>' ).addClass( 'py-6 w-auto px-auto flex justify-center space-x-2' )
                        .append( editButton, deleteButton );

                    userRow.append( actiontd );


                    userList.append( userRow );
                } );
            }

            console.log( pagination );

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

            $( "#addUserDropdown" ).toggleClass( "transition-opacity opacity-100 ease-in-out duration-100" );
            $( "#openCreateUserModal" ).toggleClass( "hidden" );
            $( "#openBulkUserModal" ).toggleClass( "hidden" );

            $( '#userModal' ).removeClass( 'hidden' );
        } );

        $( document ).on( 'click', '#openBulkUserModal', function ()
        {
            $( '#uploadUserModal' ).toggleClass( 'hidden' );

            $( "#addUserDropdown" ).toggleClass( "transition-opacity opacity-100 ease-in-out duration-100" );
            $( "#openCreateUserModal" ).toggleClass( "hidden" );
            $( "#openBulkUserModal" ).toggleClass( "hidden" );
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

        function showDefaultPasswordTemplate ()
        {
            // Show SweetAlert popup asking for password
            Swal.fire( {
                title: 'Enter Your Password',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                preConfirm: ( password ) =>
                {
                    return new Promise( ( resolve, reject ) =>
                    {
                        // Make an AJAX request to validate the password
                        $.ajax( {
                            url: '../../../backend/users/users-showpassword.php',
                            type: 'POST',
                            data: {
                                password: password
                            },
                            success: function ( response )
                            {
                                if ( response === 'valid' )
                                {
                                    // Password is correct, resolve the promise
                                    Swal.fire( {
                                        title: 'Default Password Template',
                                        icon: 'info',
                                        timer: 10000,
                                        timerProgressBar: true,
                                        html: `
                                        <div class="bg-white rounded-lg shadow-2xl p-6 max-w-md mx-auto">
                                            <div class="mt-4 text-justify">
                                                <p class="text-base text-gray-700">
                                                    <span class="font-semibold">First two uppercase letters</span> of the user's first name connected by a <span class="font-semibold">dot or a period</span>, then the <span class="font-semibold">first two uppercase letters</span> of the user's last name connected again by a <span class="font-semibold">dot or a period</span>, then the <span class="font-semibold">role id</span> of the user: for admin it is <span class="text-blue-600">001</span> and for marketing it's <span class="text-blue-600">002</span>.
                                                </p>
                                                <p class="text-base text-gray-700 mt-2">
                                                    <span class="font-semibold">Example:</span> If the admin user is <span class="italic">Juan Dela Cruz</span>, the default password would be: <span class="bg-gray-200 p-1 rounded font-mono">JU.DE.001</span>
                                                </p>
                                            </div>
                                        </div>
                                        `
                                    } );
                                    resolve();
                                } else
                                {
                                    // Error handling for AJAX request
                                    Swal.getConfirmButton().removeAttribute( 'disabled' );
                                    Swal.getCancelButton().removeAttribute( 'disabled' );
                                    Swal.showValidationMessage( 'Error validating password. Please try again.' );
                                    reject();
                                }
                            },
                            error: function ()
                            {
                                Swal.getConfirmButton().removeAttribute( 'disabled' );
                                Swal.getCancelButton().removeAttribute( 'disabled' );

                                // Error handling for AJAX request
                                reject( new Error( 'Error validating password. Please try again.' ) );
                            }
                        } );
                    } );
                },
            } ).catch( ( error ) =>
            {
                // Password validation failed, display error message
                if ( error !== 'cancel' )
                {
                    Swal.showValidationMessage( error.message );
                }
            } );
        }

        // Event listener for the button to show the default password template
        $( '.showpw-btn' ).click( function ()
        {
            showDefaultPasswordTemplate();
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

        $( document ).on( 'click', '#cancelUploadModal, #closeUploadModal', function ()
        {
            // Hide the modal
            $( '#uploadUserModal' ).closest( '.modal' ).toggleClass( 'hidden' );
        } );

        ////////////////// VALIDATION OF FORMS /////////////////////

        // Function to validate the first name input field
        function validateFirstName ()
        {
            const firstName = $( '#firstName' ).val().trim();
            const firstNameError = $( '#firstNameError' );

            // Regular expression to check for HTML tags
            const htmlRegex = /<\/?[\w\s="/.':;#-\/\?]+>/gi;

            // Regular expression to check for SQL injection
            const sqlRegex = /\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/ig;

            // Regular expression to check for PHP tags
            const phpRegex = /<\?(php)?[\s\S]*?\?>/ig;

            if ( !firstName )
            {
                $( '#firstName' ).addClass( 'border-red-500' );
                firstNameError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'First Name is required.' );
                return false;
            } else if ( htmlRegex.test( firstName ) )
            { // Check if HTML tags are present
                $( '#firstName' ).addClass( 'border-red-500' );
                firstNameError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'First Name cannot contain HTML elements.' );
                return false;
            } else if ( sqlRegex.test( firstName ) )
            { // Check for SQL injection
                $( '#firstName' ).addClass( 'border-red-500' );
                firstNameError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'First Name cannot contain SQL injection.' );
                return false;
            } else if ( phpRegex.test( firstName ) )
            { // Check for PHP tags
                $( '#firstName' ).addClass( 'border-red-500' );
                firstNameError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'First Name cannot contain PHP tags.' );
                return false;
            } else
            {
                $( '#firstName' ).removeClass( 'border-red-500' );
                firstNameError.empty();
                return true;
            }
        }

        // Function to validate the last name input field
        function validateLastName ()
        {
            const lastName = $( '#lastName' ).val().trim();
            const lastNameError = $( '#lastNameError' );

            // Regular expression to check for HTML tags
            const htmlRegex = /<\/?[\w\s="/.':;#-\/\?]+>/gi;

            // Regular expression to check for SQL injection
            const sqlRegex = /\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/ig;

            // Regular expression to check for PHP tags
            const phpRegex = /<\?(php)?[\s\S]*?\?>/ig;

            if ( !lastName )
            {
                $( '#lastName' ).addClass( 'border-red-500' );
                lastNameError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Last Name is required.' );
                return false;
            } else if ( htmlRegex.test( lastName ) )
            { // Check if HTML tags are present
                $( '#lastName' ).addClass( 'border-red-500' );
                lastNameError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Last Name cannot contain HTML elements.' );
                return false;
            } else if ( sqlRegex.test( lastName ) )
            { // Check for SQL injection
                $( '#lastName' ).addClass( 'border-red-500' );
                lastNameError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Last Name cannot contain SQL injection.' );
                return false;
            } else if ( phpRegex.test( lastName ) )
            { // Check for PHP tags
                $( '#lastName' ).addClass( 'border-red-500' );
                lastNameError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Last Name cannot contain PHP tags.' );
                return false;
            } else
            {
                $( '#lastName' ).removeClass( 'border-red-500' );
                lastNameError.empty();
                return true;
            }
        }

        // Function to validate the email input field
        function validateEmail ()
        {
            const email = $( '#email' ).val().trim();
            const emailError = $( '#emailError' );
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Regular expression to check for HTML tags
            const htmlRegex = /<\/?[\w\s="/.':;#-\/\?]+>/gi;

            // Regular expression to check for SQL injection
            const sqlRegex = /\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/ig;

            // Regular expression to check for PHP tags
            const phpRegex = /<\?(php)?[\s\S]*?\?>/ig;

            if ( !email )
            {
                $( '#email' ).addClass( 'border-red-500' );
                emailError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Email is required.' );
                return false;
            } else if ( !emailRegex.test( email ) )
            {
                $( '#email' ).addClass( 'border-red-500' );
                emailError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Invalid email format.' );
                return false;
            } else if ( htmlRegex.test( email ) )
            { // Check if HTML tags are present
                $( '#email' ).addClass( 'border-red-500' );
                emailError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Email cannot contain HTML elements.' );
                return false;
            } else if ( sqlRegex.test( email ) )
            { // Check for SQL injection
                $( '#email' ).addClass( 'border-red-500' );
                emailError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Email cannot contain SQL injection.' );
                return false;
            } else if ( phpRegex.test( email ) )
            { // Check for PHP tags
                $( '#email' ).addClass( 'border-red-500' );
                emailError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Email cannot contain PHP tags.' );
                return false;
            } else
            {
                $( '#email' ).removeClass( 'border-red-500' );
                emailError.empty();
                return true;
            }
        }

        // Function to validate the role input field
        function validateRole ()
        {
            const role = $( '#role' );
            const roleError = $( '#roleError' );
            const roleValue = role.val().trim();

            // Regular expression to check for HTML tags
            const htmlRegex = /<\/?[\w\s="/.':;#-\/\?]+>/gi;

            // Regular expression to check for SQL injection
            const sqlRegex = /\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/ig;

            // Regular expression to check for PHP tags
            const phpRegex = /<\?(php)?[\s\S]*?\?>/ig;

            if ( roleValue )
            {
                role.removeClass( 'border-red-500' );
                roleError.empty();
                return true;
            } else if ( htmlRegex.test( roleValue ) )
            { // Check if HTML tags are present
                role.addClass( 'border-red-500' );
                roleError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Role cannot contain HTML elements.' );
                return false;
            } else if ( sqlRegex.test( roleValue ) )
            { // Check for SQL injection
                role.addClass( 'border-red-500' );
                roleError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Role cannot contain SQL injection.' );
                return false;
            } else if ( phpRegex.test( roleValue ) )
            { // Check for PHP tags
                role.addClass( 'border-red-500' );
                roleError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Role cannot contain PHP tags.' );
                return false;
            } else
            {
                role.addClass( 'border-red-500' );
                roleError.addClass( 'text-sm text-red-500 mt-1 error-message' ).text( 'Role is required.' );
                return false;
            }
        }

        // Add event listener for input event on the first name field
        $( '#firstName' ).on( 'input', function ()
        {
            validateFirstName();
        } );

        // Add event listener for input event on the last name field
        $( '#lastName' ).on( 'input', function ()
        {
            validateLastName();
        } );

        // Add event listener for input event on the email field
        $( '#email' ).on( 'input', function ()
        {
            validateEmail();
        } );

        // Add event listener for input event on the role field
        $( '#role' ).on( 'input', function ()
        {
            validateRole();
        } );

        // Function to validate the user form
        function validateUserForm ()
        {
            // Call each individual validation function
            const isValidFirstName = validateFirstName();
            const isValidLastName = validateLastName();
            const isValidEmail = validateEmail();
            const isValidRole = validateRole();

            // Combine the results of individual validations
            return isValidFirstName && isValidLastName && isValidEmail && isValidRole;
        }


        ////////////////////// SUBMIT EVENT HANDLER (HANDLES BOTH UPDATE AND CREATE USER) ///////////////////////////

        $( '#userForm' ).submit( function ( event )
        {
            event.preventDefault();

            if ( validateUserForm() )
            {
                let formData = $( this ).serialize();
                let url;
                let actionType;
                const userId = $( '#userModal' ).data( 'userId' );

                if ( userId !== undefined )
                {
                    actionType = 'update';
                    url = '../../../backend/users/user-update.php';
                    formData += '&userId=' + userId;
                } else
                {
                    actionType = 'create';
                    url = '../../../backend/users/user-create.php';
                }

                let title = actionType === 'update' ? 'Confirm Update' : 'Confirm Create';
                let text = actionType === 'update' ? `Are you sure you want to update this user?` : 'Are you sure you want to create this user?';

                // Fetch user name if available
                let userName = '';
                if ( actionType === 'update' )
                {
                    userName = $( '#firstName' ).val() + ' ' + $( '#lastName' ).val();
                }

                // Show SweetAlert confirmation
                Swal.fire( {
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                } ).then( ( result ) => 
                {
                    if ( result.isConfirmed )
                    {
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
                                    $( '#userModal' ).addClass( 'hidden' );
                                    // Show SweetAlert success message
                                    Swal.fire( {
                                        title: 'Success',
                                        text: 'Operation successful!',
                                        icon: 'success',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: true
                                    } );
                                    // Refresh user data
                                    filterUserData( '', '', '', 1, 5 );
                                } else
                                {
                                    if ( response.message )
                                    {
                                        Object.keys( response.message ).forEach( function ( fieldName )
                                        {
                                            $( `#${ fieldName }Error` ).addClass( 'text-sm text-red-500 mt-1 error-message' ).text( response.message[fieldName] );
                                            $( `#${ fieldName }` ).addClass( 'border-red-500' );
                                        } );
                                    }
                                }
                            },
                            error: function ( xhr, status, error )
                            {
                                console.error( 'Error:', error );
                                // Show SweetAlert error message
                                Swal.fire( {
                                    title: 'Error',
                                    text: 'An error occurred. Please try again later.',
                                    icon: 'error'
                                } );
                            }
                        } );
                    }
                } );
            }
        } );

        //////////////////// ACTIVATE / DEACTIVATE ///////////////////////////

        // Open modal when delete button is clicked
        $( document ).on( 'click', '.delBtn', function ()
        {
            // Get user information
            const userId = $( this ).data( 'userId' );
            const userStatus = $( this ).data( 'userStatus' );
            console.log( userStatus );
            const popupMessage = userStatus === 'active' ? 'Are you sure you want to deactivate this user?' : 'Are you sure you want to activate this user?';
            const header = userStatus === 'active' ? 'Confirm Deactivation' : 'Confirm Activation';
            console.log( userId );
            // Call Swal.fire with confirmation parameters
            Swal.fire( {
                title: header,
                text: popupMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: userStatus === 'active' ? 'Deactivate' : 'Activate',
                cancelButtonText: 'Cancel'
            } ).then( ( result ) =>
            {
                if ( result.isConfirmed )
                {
                    // Store user ID and status for later use
                    const popUpType = userStatus === 'active' ? 'deactivate' : 'activate';
                    confirmUserAction( userId );
                }
            } );
        } );

        // Function to handle user action confirmation
        function confirmUserAction ( userId )
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
                        // Display success message using Swal.fire
                        Swal.fire( {
                            title: 'Success',
                            text: response.message || 'User operation successful.',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: true
                        } );

                        filterUserData( '', '', '', 1, 5 );
                    } else
                    {
                        // Display error message using Swal.fire
                        Swal.fire( {
                            title: 'Error',
                            text: response.message || 'An error occurred. Please try again later.',
                            icon: 'error'
                        } );
                    }
                },
                error: function ( xhr, status, error )
                {
                    // Display error message using Swal.fire
                    Swal.fire( {
                        title: 'Error',
                        text: 'An error occurred. Please try again later.',
                        icon: 'error'
                    } );
                    console.error( 'Error:', error );
                }
            } );
        }

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

        //////////////////// FORMAT DATE AND TIME IN TABLE /////////////////////////
        // Function to format date
        function formatDate ( dateString )
        {
            const date = new Date( dateString );
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return date.toLocaleDateString( undefined, options );
        }

        // Function to format time
        function formatTime ( dateString )
        {
            const date = new Date( dateString );
            const options = { hour: 'numeric', minute: 'numeric' };
            return date.toLocaleTimeString( undefined, options );
        }

        //////////////////// USER CREATION DROPDOWN /////////////////////////
        $( document ).on( 'click', '#addUserDropdownBtn', function ()
        {
            $( "#addUserDropdown" ).toggleClass( " transition-opacity opacity-100 ease-in-out duration-100" );
            $( "#openCreateUserModal" ).toggleClass( "hidden" );
            $( "#openBulkUserModal" ).toggleClass( "hidden" );
        } );

        //////////////////// DRAG AND DROP FUNCTIONALITY IN USER BULK CREATION /////////////////////////

        $( '#dropzone-file' ).on( 'change', function ( e )
        {
            e.preventDefault();
            e.stopPropagation();

            var files = e.target.files || e.originalEvent.dataTransfer.files;
            handleFiles( files );
        } );

        $( '#dropzone-holder' ).on( 'drop', function ( e )
        {
            // // Prevent default handling
            e.preventDefault();
            e.stopPropagation();

            // Verify data transfer
            if ( e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files )
            {
                var files = e.originalEvent.dataTransfer.files;
                handleFiles( files );
            } else
            {
                console.error( "Data transfer not found in drop event" );
            }

            $( this ).removeClass( 'dragover' );
        } );

        $( '#dropzone-holder' ).on( 'dragover', function ( e )
        {
            e.preventDefault();
            e.stopPropagation();

            $( this ).addClass( 'dragover' );
        } );

        $( '#dropzone-holder' ).on( 'dragleave', function ( e )
        {
            e.preventDefault();
            e.stopPropagation();

            $( this ).removeClass( 'dragover' );
        } );

        function handleFiles ( files )
        {
            if ( files.length > 0 )
            {
                var fileInput = files[0];
                var fileSize = fileInput.size; // Size in bytes
                var fileName = fileInput.name;
                var fileExtension = fileName.split( '.' ).pop().toLowerCase();
                var maxSizeInMb = 5;
                var maxSizeInBytes = 1024 * 1024 * maxSizeInMb; // 5 MB
                var errors = [];

                // Check file size
                if ( fileSize > maxSizeInBytes )
                {
                    errors.push( 'File size exceeds ' + maxSizeInMb + 'MB limit.' );
                }

                if ( fileExtension !== 'csv' && fileExtension !== 'xlsx' )
                {
                    errors.push( 'Please select a valid Excel file (.xlsx) or CSV file.' );
                }

                if ( errors.length === 0 )
                {
                    $( '#file-name' ).text( 'File Name: ' + fileName ).addClass( 'underline underline-offset-4 font-bold' );
                    $( '#uploadModalIconHolder' ).empty();

                    if ( fileExtension == 'csv' )
                    {
                        $( '#uploadModalIconHolder' ).append( $( '<i>' ).addClass( 'text-3xl mb-3 fa-solid fa-file-csv text-green-500' ) );
                    } else if ( fileExtension == 'xlsx' )
                    {
                        $( '#uploadModalIconHolder' ).append( $( '<i>' ).addClass( 'text-3xl mb-3 fa-solid fa-file-excel text-green-500' ) );
                    }
                } else
                {
                    // Display error message using SweetAlert
                    Swal.fire( {
                        title: 'Error',
                        text: errors.join( '\n' ),
                        icon: 'error',
                    } );
                }
            }
        }

        function validateForm ()
        {
            var fileInput = $( '#dropzone-file' )[0].files[0];
            var errors = [];

            // Check if a file is selected
            if ( !fileInput )
            {
                errors.push( 'Please select a file.' );
            } else
            {
                // Check file type
                var fileType = fileInput.type;

                if ( fileType !== 'application/vnd.ms-excel' && fileType !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && fileType !== 'text/csv' )
                {
                    errors.push( 'Please select a valid Excel file (.xlsx) or CSV file.' );
                }

                // Check file size (optional, you can add or remove this validation)
                var maxSizeInBytes = 1024 * 1024 * 5; // 5 MB
                if ( fileInput.size > maxSizeInBytes )
                {
                    errors.push( 'File size exceeds 5MB limit.' );
                }
            }

            // Display validation errors if any
            if ( errors.length > 0 )
            {
                // Display error message using SweetAlert
                Swal.fire( {
                    title: 'Error',
                    text: errors.join( '\n' ),
                    icon: 'error',
                } );
            }

            // Return true if no errors, false otherwise
            return errors.length === 0;
        }

        // Upload form submission
        $( '#uploadUserForm' ).submit( function ( e )
        {
            e.preventDefault();

            if ( validateForm() )
            {
                // Submit the form using AJAX
                var formData = new FormData( $( '#uploadUserForm' )[0] );

                Swal.fire( {
                    title: 'Upload File',
                    text: 'Are you sure you want to upload this file?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, upload it!'
                } ).then( ( result ) =>
                {
                    if ( result.isConfirmed )
                    {
                        // Show processing dialog
                        var processingDialog = Swal.fire( {
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

                        // Perform file upload
                        var formData = new FormData( this );
                        $.ajax( {
                            url: '/backend/users/users-upload.php',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            success: function ( response )
                            {
                                processingDialog.close(); // Close the processing dialog
                                if ( response.success )
                                {
                                    // Display success message using SweetAlert
                                    Swal.fire( {
                                        title: 'Success',
                                        text: 'File processed successfully!',
                                        icon: 'success',
                                    } ).then( ( result ) =>
                                    {
                                        // Show counts of success and failure in a popup
                                        Swal.fire( {
                                            title: 'Upload Summary',
                                            html: 'Success: ' + response.successCount + '<br>' +
                                                'Failures: ' + response.errorCount + '<br>' +
                                                ( response.errorCount > 0 ? '<hr class="mt-1"><button id="viewErrorsBtn" class="btn btn-primary mt-2">View Errors</button>' : '' ),
                                            icon: 'info'
                                        } );

                                        // Event listener for the "View Errors" button
                                        $( document ).on( 'click', '#viewErrorsBtn', function ()
                                        {
                                            // Display detailed error messages
                                            Swal.fire( {
                                                title: 'Error Details',
                                                html: response.errors.join( '<br>' ),
                                                icon: 'error'
                                            } );
                                        } );

                                        // Refresh user data
                                        filterUserData( '', '', '', 1, 5 );
                                    } );

                                    $( '#uploadUserModal' ).closest( '.modal' ).toggleClass( 'hidden' );

                                    // Reset form fields and icon
                                    $( '#file-name' ).text( '' );
                                    $( '#dropzone-file' ).val( null );
                                    $( '#uploadModalIconHolder' ).empty();
                                    $( '#uploadModalIconHolder' ).append( $( '<i>' ).addClass( 'text-3xl mb-3 fa-solid fa-file-arrow-up text-zinc-300' ) );
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

                                            // Display error message using SweetAlert
                                            Swal.fire( {
                                                title: 'Error',
                                                text: response.message[fieldName],
                                                icon: 'error',
                                            } );
                                        } );
                                    }
                                }
                            },
                            error: function ( xhr, status, error )
                            {
                                processingDialog.close(); // Close the processing dialog
                                console.error( 'Error:', error );
                                // Display error message using SweetAlert
                                Swal.fire( {
                                    title: 'Error',
                                    text: 'An error occurred. Please try again later.',
                                    icon: 'error',
                                } );
                            },
                        } );
                    }
                } );
            }
        } );

        filterUserData( '', '', '', 1, 5 );
    } );

</script>

<?php
$script = ob_get_clean();
include ("../../../public/master.php");
?>