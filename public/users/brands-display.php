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
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 mx-1 !px-4 py-0 text-lg items-center flex">
                <i class="fa-light fa-plus text-3xl pb-1 pr-2"></i>
                Add Brands
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

    <div class="relative overflow-x-auto mb-1 rounded-lg mt-4">
        <table id="brandsTable" class="hover order-column row-border!w-full  ">
            <thead class="">
                <tr>
                    <th scope="col" class="text-center px-10 py-4">
                    </th>
                    <th scope="col" class="!text-center py-4">
                    </th>
                    <th scope="col" class="!text-center py-4">
                    </th>
                    <th scope="col" class="!text-center py-4">
                    </th>
                </tr>
            </thead>
            <tbody id="brands-list">
                <!-- User data will be dynamically added here -->
            </tbody>
            <tfoot>
                <td></td>
                <td class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                    <button id="typeDropdownButton" data-dropdown-toggle="typeDropdown"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Dropdown checkbox
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="typeDropdown" class="z-10 hidden w-48 bg-white rounded-lg shadow dark:bg-gray-700"
                        data-dropdown>
                        <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="typeDropdownButton">
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="typeCheckboxCatalog" type="checkbox" value="Catalog"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="typeCheckboxCatalog"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Catalog</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="typeCheckboxInquiry" type="checkbox" value="Inquiry"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="typeCheckboxInquiry"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Inquiry</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </td>

                <td class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                    <button id="statusDropdownButton" data-dropdown-toggle="statusDropdown"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Dropdown checkbox
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="statusDropdown" class="z-10 hidden w-48 bg-white rounded-lg shadow dark:bg-gray-700"
                        data-dropdown>
                        <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="statusDropdownButton">
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="statusCheckboxActive" type="checkbox" value="Active"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="statusCheckboxActive"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Active</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="statusCheckboxInactive" type="checkbox" value="Inactive"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="statusCheckboxInactive"
                                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Inactive</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </td>
                <td></td>
                <td></td>
            </tfoot>
        </table>
    </div>
    <div class="flex flex-col sm:flex-row px-2 sm:self-center sm:items-center justify-between bottom-0">
        <div id="itemCount" class="text-center text-gray-500"></div>
        <div id="pagination" class="justify-center mt-4"></div>
    </div>
</div>

<div id="form-holder">
</div>

<div id="popup-holder">
</div>

<?php $content = ob_get_clean();
ob_start();
?>

<!-- Your javascript here -->
<script>
    $( document ).ready( function ()
    {
        var table = $( '#brandsTable' ).DataTable( {
            ajax: {
                url: '/../../backend/brands/brands-get.php',
                type: 'GET',
                dataSrc: ''
            },
            columns: [
                {
                    data: null,
                    title: 'Brand Name',
                    className: '!text-center',
                    render: function ( data )
                    {
                        return `
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-[50px] h-[50px] rounded-full overflow-hidden flex items-center justify-center">
                                    <img src="${ data.logo_url }" alt="${ data.brand_name }" class="block rounded-full max-w-[100px] max-h-[100px]">
                                </div>
                                <span class="block mt-2">${ data.brand_name }</span>
                                <span class="text-xs text-gray-500 block">${ data.description }</span>
                            </div>
                    `;
                    }
                },
                { data: 'type', title: 'Type', className: 'text-center' },
                { data: 'status', title: 'Status', className: 'text-center' },
                {
                    data: 'updated_at',
                    title: 'Updated At',
                    className: '!text-center',
                    render: function ( data )
                    {
                        var date = formatDate( data ); // Assuming formatDate is a function that formats the date
                        var time = formatTime( data ); // Assuming formatTime is a function that formats the time
                        return '<div>' +
                            '<div>' + date + '</div>' +
                            '<div>' + time + '</div>' +
                            '</div>';
                    }
                },
                {
                    data: null,
                    title: 'Action',
                    className: '!text-center !p-0 !m-0 !w-[27.5%]',
                    orderable: false,
                    render: function ( data )
                    {
                        return `
                            <button class="viewBtn btn-view !m-0 hover:underline text-[14px]">
                                <i class="fas fa-eye pr-[3px]"></i>View
                            </button>
                            <button class="editBtn yellow-btn btn-primary !m-0  hover:underline text-[14px]">
                                <i class="fas fa-edit pr-[3px]"></i>Update
                            </button>
                            <button class="delBtn btn-danger !m-0  hover:underline text-[14px]">
                                <i class="fas fa-trash pr-[3px]"></i>Hide
                            </button>
                    `;
                    }
                }
            ],
            order: [[3, 'asc']], // Default sorting by the fouth column (Updated At)
            paging: true,
            pageLength: 2, // Initial number of rows per page
            searching: true,
            processing: true,
            serverSide: false, // Disable server-side processing
            lengthMenu: [2, 10, 20], // Dropdown for changing the number of rows per page
            stateSave: false,
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                lengthMenu: "Show _MENU_ entries",
                search: "Search:",
                zeroRecords: "No matching records found"
            }
        } );

        $( '#typeCheckboxCatalog, #typeCheckboxInquiry' ).on( 'change', function ()
        {
            var selectedValues = [];
            $( '#typeCheckboxCatalog:checked' ).each( function ()
            {
                selectedValues.push( $( this ).val() );
            } );
            $( '#typeCheckboxInquiry:checked' ).each( function ()
            {
                selectedValues.push( $( this ).val() );
            } );
            table.column( 1 ).search( selectedValues.join( '|' ), true, false ).draw();
        } );

        // Checkbox filtering for Status column
        $( '#statusCheckboxActive, #statusCheckboxInactive' ).on( 'change', function ()
        {
            var selectedValues = [];
            $( '#statusCheckboxActive:checked' ).each( function ()
            {
                selectedValues.push( $( this ).val() );
            } );
            $( '#statusCheckboxInactive:checked' ).each( function ()
            {
                selectedValues.push( $( this ).val() );
            } );
            table.column( 2 ).search( selectedValues.join( '|' ), true, false ).draw();
        } );

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

        // Dropdown toggle
        $( '[data-dropdown-toggle]' ).on( 'click', function ()
        {
            var dropdownId = $( this ).data( 'dropdown-toggle' );
            $( '#' + dropdownId ).toggle();
        } );

        // Close the dropdown menu if the user clicks outside of it
        $( window ).click( function ( event )
        {
            if ( !event.target.matches( '[data-dropdown-toggle]' ) )
            {
                var dropdowns = $( '[data-dropdown]' );
                dropdowns.each( function ()
                {
                    var dropdown = $( this );
                    if ( dropdown.is( ':visible' ) )
                    {
                        dropdown.hide();
                    }
                } );
            }
        } );

    } );
</script>

<?php
$script = ob_get_clean();
include ("../../public/master.php");
?>