<?php
session_start();
$pageTitle = "Brands";
ob_start();
?>
<!-- Your page content goes here -->

<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">Brands List</h1>
        <div class=" flex flex-row justify-between items-cent">
            <button id="addUserDropdownBtn"
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 mx-1 sm:mt-4 !px-4 py-0 text-lg items-center flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg> Add Brands
            </button>
            <div class="absolute 
                text-left text-sm text-center
                w-[150px] z-10
                transition-all bg-[#F6E17A] rounded-md shadow-md
                opacity-0 
                translate-y-[60px] -translate-x-[11px] space-y-1" id="addUserDropdown">

                <button class="hidden cursor-pointer hover:bg-[#F9E89B] p-4 rounded-md w-full" id="openCreateUserModal">
                    Add Single Brand
                </button>
                <button class="hidden cursor-pointer hover:bg-[#F9E89B] p-4 rounded-md w-full" id="openBulkUserModal">
                    Upload Bulk Brands
                </button>
            </div>
        </div>
    </div>

    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div> <!--Divider-->

    <div class="flex sm:flex-row items-center justify-center">
        <div class="flex sm:flex-row mb-4 sm:mb-0">
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
                    <option value="20">20 per page</option>
                </select>
            </div>
        </div>
        <div class="flex justify-between">
            <div class="relative mb-1 mt-2 sm:mb-0 sm:mr-2">
                <!-- Search input -->
                <div class="relative">
                    <input
                        class="border-2 border-gray-300 bg-white h-11 w-64 px-2 pr-10 mt-1 sm:!mt-0 rounded-lg text-[16px] focus:outline-none"
                        type="text" name="search" placeholder="Search" id="searchInput">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <!-- <svg class="text-gray-600 h-5 w-5 fill-current hover:text-gray-500 "
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                            id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966"
                            style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px"
                            height="512px">
                            <path
                                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                        </svg> -->
                        <i class="fa-solid fa-magnifying-glass"></i>
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
                    <!-- <th scope="col" class="text-center px-6 py-3">
                        <span class="ml-1">Logo</span>
                    </th> -->
                    <th scope="col" class="text-center px-6 py-3">
                        <span id="StatusOrder" class="">
                            <i id="downArrow" class="bi bi-caret-down-fill cursor-pointer"></i>
                            <i id="upArrow" class="bi bi-caret-up-fill cursor-pointer"></i>
                            <span class="ml-1">Brand Name</span>
                        </span>
                    </th>
                    <!-- <th scope="col" class="text-center py-3">
                        <span id="CreatedAtOrder" class="">
                            <i id="downArrow" class="bi bi-caret-down-fill cursor-pointer"></i>
                            <i id="upArrow" class="bi bi-caret-up-fill cursor-pointer"></i>
                            <span class="ml-1"> Created At
                            </span>
                        </span>
                    </th> -->
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
            <tbody id="brands-list">
                <!-- User data will be dynamically added here -->
            </tbody>
        </table>
    </div>
    <div class="flex flex-col sm:flex-row px-2 sm:self-center sm:items-center justify-between bottom-0">
        <div id="itemCount" class="text-center text-gray-500"></div>
        <div id="pagination" class="justify-center mt-4"></div>
    </div>
</div>

<?php $content = ob_get_clean();
ob_start();
?>

<!-- Your javascript here -->
<script>
    $( document ).ready( function ()
    {
        $.ajax( {
            url: '/../../backend/brands/brands-get.php',
            type: 'GET',
            dataType: 'json',
            success: function ( data )
            {
                renderBrandsData( data, null )
            },
            error: function ( xhr, status, error )
            {
                console.error( 'Error:', error );
            }
        } );

        function renderBrandsData ( data, pagination )
        {
            const brandsList = $( '#brands-list' );
            brandsList.empty(); // Clear existing user data

            if ( !Array.isArray( data ) || data.length === 0 ) 
            {
                const noUserRow = $( '<tr>' ).addClass( 'bg-white-200 border-b' );
                const messageCell = $( '<td>' ).addClass( 'px-6 py-4 text-center text-red-800 font-bold' ).attr( 'colspan', '7' ).text( 'No brands found' );
                noUserRow.append( messageCell );
                brandsList.append( noUserRow );
            } else
            {
                data.forEach( function ( brand )
                {
                    const brandRow = $( '<tr>' ).addClass( 'bg-white-200 border-b text-center' );

                    // const logoCell = $( '<td>' ).addClass( ' py-4 flex justify-center items-center' ).append(
                    // );

                    const brandNameCell = $( '<td>' ).addClass( 'text-center py-4' );

                    const brandContentWrapper = $( '<div>' ).addClass( 'flex flex-col items-center justify-center' );
                    const brandImageWrapper = $( '<div>' ).addClass( 'w-[50px] h-[50px] rounded-full overflow-hidden flex items-center justify-center' );
                    const brandImage = $( '<img>' ).attr( 'src', brand.logo_url ).attr( 'alt', brand.brand_name ).addClass( 'block rounded-full max-w-[100px] max-h-[100px]' );

                    const brandName = $( '<span>' ).addClass( 'block mt-2' ).text( brand.brand_name );
                    const brandDescription = $( '<span>' ).addClass( 'text-xs text-gray-500 block' ).text( brand.description );

                    brandImageWrapper.append( brandImage );
                    brandContentWrapper.append( brandImageWrapper, brandName, brandDescription );
                    brandNameCell.append( brandContentWrapper );

                    const updateAtCell = $( '<td>' ).addClass( 'text-center py-4 ' ).append(
                        $( '<div>' ).text( formatDate( brand.updated_at ) ).addClass( 'text-sm' ), // Date with smaller text
                        $( '<div>' ).text( formatTime( brand.updated_at ) ).addClass( 'text-xs text-gray-500' ) // Time with even smaller and gray text                );
                    );

                    const viewButton = $( '<button>' ).addClass( 'viewBtn bg-[#a8c4dc] blue-btn btn-primary hover:underline text-[14px]' );
                    viewButton.append(
                        $( '<i>' ).addClass( 'fas fa-eye pr-[3px]' ),
                        $( '<span>' ).text( 'View' )
                    );

                    const editButton = $( '<button>' ).addClass( 'editBtn yellow-btn btn-primary hover:underline text-[14px]' );
                    editButton.append(
                        $( '<i>' ).addClass( 'fas fa-edit pr-[3px]' ),
                        $( '<span>' ).text( 'Update' )
                    );

                    const deleteButton = $( '<button>' ).addClass( 'delBtn btn-danger hover:underline text-[14px]' );
                    deleteButton.append(
                        $( '<i>' ).addClass( 'fas fa-trash pr-[3px]' ),
                        $( '<span>' ).text( 'Hide' )
                    );

                    const actionCell = $( '<td>' ).addClass( 'py-6 w-auto px-auto flex justify-center space-x-2' )
                        .append( viewButton, editButton, deleteButton );

                    // Add more cells if needed for other brand properties
                    brandRow.append( brandNameCell, updateAtCell, actionCell );
                    brandsList.append( brandRow );
                } );
            }
        }

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

    } );

</script>

<?php
$script = ob_get_clean();
include ("../../public/master.php");
?>