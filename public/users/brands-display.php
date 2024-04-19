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

    <div class="relative overflow-x-auto mb-1 rounded-lg mt-4 ">
        <table id="brandsTable" class="hover order-column row-border!w-full  ">
            <div class="relative ml-1 mb-2 mt-2 sm:mb-0 sm:mr-8">
                <button id="combinedDropdownButton" data-dropdown-toggle="combinedDropdown"
                    class="yellow-btn btn-primary font-medium rounded-lg text-sm px-5 py-2 text-center inline-flex items-center"
                    type="button">
                    Filters
                    <i class="fa-solid fa-angle-down pt-1 ml-2 text-md"></i>
                </button>
                <!-- Dropdown menu -->
                <div id="combinedDropdown"
                    class="z-10 hidden w-64 absolute bg-white rounded-lg shadow bg-[#F6E17A] mt-1" data-dropdown>
                    <ul class="p-3 space-y-1 text-sm text-gray-900 dark:text-gray-200"
                        aria-labelledby="combinedDropdownButton">
                        <li class="border-b border-gray-900 pb-2 mb-2">
                            <h3 class="text-gray-900 font-semibold">Type</h3>
                            <div class="flex items-center p-2 rounded hover:bg-[#F9E89B] ">
                                <input id="typeCheckboxCatalog" type="checkbox" value="Catalog"
                                    class="w-4 h-4 text-blue-600 bg-black border-gray-900 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="typeCheckboxCatalog"
                                    class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-900">Catalog</label>
                            </div>
                            <div class="flex items-center p-2 rounded hover:bg-[#F9E89B] ">
                                <input id="typeCheckboxInquiry" type="checkbox" value="Inquiry"
                                    class="w-4 h-4 text-blue-600 bg-black border-gray-900 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="typeCheckboxInquiry"
                                    class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-900">Inquiry</label>
                            </div>
                        </li>
                        <li>
                            <h3 class="text-gray-900 font-semibold">Status</h3>
                            <div class="flex items-center p-2 rounded hover:bg-[#F9E89B] ">
                                <input id="statusCheckboxActive" type="checkbox" value="Active"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-900 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="statusCheckboxActive"
                                    class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-900">Active</label>
                            </div>
                            <div class="flex items-center p-2 rounded hover:bg-[#F9E89B] ">
                                <input id="statusCheckboxInactive" type="checkbox" value="Inactive"
                                    class="w-4 h-4 text-blue-600 bg-gray-900 border-gray-900 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="statusCheckboxInactive"
                                    class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-900">Inactive</label>
                            </div>
                        </li>
                        <li class="text-center">
                            <button id="resetFilters"
                                class="text-sm text-gray-900 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-sync-alt mr-1"></i> Reset Filters
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
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

        </table>
    </div>
    <div class="flex flex-col sm:flex-row px-2 sm:self-center sm:items-center justify-between bottom-0">
        <div id="itemCount" class="text-center text-gray-500"></div>
        <div id="pagination" class="justify-center mt-4"></div>
    </div>
</div>

<div id="modal-container"
    class="modal fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-2xl">
        <div class="flex justify-between items-center">
            <h2 id="brandModalTitle" class="text-xl font-semibold">Brand Details</h2>
            <button id="closeBrandModal"
                class="close rounded-full text-gray-600 px-2 hover:text-gray-800 focus:outline-none hover:bg-gray-300"
                aria-label="Close modal">&times;</button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-2"></div> <!--Divider-->
        <div class="flex flex-wrap justify-between">
            <form id="brandForm">

                <!-- Image Section -->
                <div id="imageDropzone"
                    class="relative w-1/3 rounded-xl ring-1 ring-black ring-offset-gray-700 overflow-hidden flex items-center justify-center group">
                    <div
                        class="absolute inset-x-0 bottom-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <label for="uploadBrandLogo"
                            class="bg-gray-800 text-sm text-white m-1 px-2 py-1 rounded-full cursor-pointer">Upload new
                            brand
                            logo</label>
                        <input type="file" id="uploadBrandLogo" class="hidden">
                    </div>
                    <div class="mx-auto mb-4"> <!-- Container for the image -->
                        <img id="brandImage" src="" alt="" class="w-full h-auto object-contain rounded-full">
                    </div>
                </div>

                <!-- Data Section -->
                <div class="w-2/3">
                    <div class="mx-4"> <!-- Container for the brand information -->
                        <form id="brandForm">
                            <div class="mb-4">
                                <label for="brandName" class="block text-sm font-medium text-gray-700">Brand
                                    Name:</label>
                                <input type="text" id="brandName" name="brandName" placeholder="Brand Name"
                                    class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm" disabled>
                            </div>
                            <div class="mb-4">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Description:</label>
                                <textarea id="description" name="description" placeholder="Description"
                                    class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm"
                                    disabled></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="type" class="block text-sm font-medium text-gray-700">Type:</label>
                                <input type="text" id="type" name="type" placeholder="Type"
                                    class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm" disabled>
                            </div>
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                                <input type="text" id="status" name="status" placeholder="Status"
                                    class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm" disabled>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-8 text-xs text-center text-gray-500 ml-6 !-mt-[0.1px]">
                    <div>Created At: <span id="createdAt"></span></div>
                    <div>Updated At: <span id="updatedAt"></span></div>
                </div>
            </form>
        </div>

        <div class="flex justify-end mt-4">
            <button id="editBrandBtn" class="btn-primary mr-2">Edit</button>
            <button id="submitBrandBtn" class="btn-primary mr-2 hidden">Submit</button>
            <button id="hideBrandBtn" class="btn-danger mr-2">Hide</button>
            <button id="closeBrandBtn" class="btn-secondary">Close</button>
        </div>
    </div>
</div>

<div id="popup-container">
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
                    title: 'Brand',
                    className: '!text-center',
                    render: function ( data )
                    {
                        return `
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-[100px] h-[100px] rounded-full ring-1 ring-black overflow-hidden flex items-center justify-center">
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
                                <i class="fas fa-edit pr-[3px]"></i>Edit
                            </button>
                            <button class="delBtn btn-danger !m-0  hover:underline text-[14px]">
                                <i class="fas fa-trash pr-[3px]"></i>Hide
                            </button>
                    `;
                    }
                }
            ],
            order: [[3, 'desc']], // Default sorting by the fouth column (Updated At)
            paging: true,
            pageLength: 4, // Initial number of rows per page
            searching: true,
            processing: true,
            serverSide: false, // Disable server-side processing
            lengthMenu: [4, 10, 20], // Dropdown for changing the number of rows per page
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

        ////////////////// DROPDOWN /////////////////////
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

        $( '#resetFilters' ).on( 'click', function ()
        {
            // Uncheck checkboxes within the dropdown
            $( '#combinedDropdown input[type="checkbox"]' ).prop( 'checked', false );
            table.columns().search( '' ).draw();
        } );

        // Dropdown toggle
        $( '[data-dropdown-toggle]' ).on( 'click', function ()
        {
            var dropdownId = $( this ).data( 'dropdown-toggle' );
            $( '#' + dropdownId ).toggle();
        } );

        // Prevent dropdown from closing when clicking inside it
        $( '#combinedDropdown' ).on( 'click', function ( event )
        {
            event.stopPropagation(); // Stop event propagation
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

        ////////////////// MODALS /////////////////////
        $( document ).on( 'click', '.viewBtn', function ()
        {
            var data = table.row( $( this ).closest( 'tr' ) ).data();
            console.info( data );
            // Set modal title
            $( '#brandModalTitle' ).text( data.brand_name );

            // Set image source
            $( '#brandImage' ).attr( 'src', data.logo_url );

            // Set input field values
            $( '#brandName' ).val( data.brand_name );
            $( '#description' ).val( data.description );
            $( '#type' ).val( data.type );
            $( '#status' ).val( data.status );

            var date = formatDate( data.created_at );
            var time = formatTime( data.created_at );
            $( '#createdAt' ).text( date + ' ' + time );
            date = formatDate( data.updated_at );
            time = formatTime( data.updated_at );
            $( '#updatedAt' ).text( date + ' ' + time );

            $( 'label[for="uploadBrandLogo"]' ).addClass( 'hidden' );

            // Show the modal
            $( '#modal-container' ).toggleClass( 'hidden' );
        } );

        // Function to enable drag and drop for image upload
        function enableDragAndDrop ()
        {
            var dropZone = $( '#imageDropzone' );

            // Function to handle file selection
            function handleFileSelect ( event )
            {
                event.stopPropagation();
                event.preventDefault();

                var files = event.originalEvent.dataTransfer.files; // FileList object.

                // Process each dropped file
                for ( var i = 0, file; file = files[i]; i++ )
                {
                    // Only process image files.
                    if ( !file.type.match( 'image.*' ) )
                    {
                        continue;
                    }

                    var reader = new FileReader();

                    // Closure to capture the file information.
                    reader.onload = ( function ( theFile )
                    {
                        return function ( e )
                        {
                            // Render thumbnail.
                            var span = $( '<span>' );
                            span.html( ['<img class="thumb" src="', e.target.result,
                                '" title="', escape( theFile.name ), '"/>'].join( '' ) );
                            dropZone.empty().append( span );
                            $( '#brandImage' ).attr( 'src', e.target.result ); // Update image preview
                            $( '#imageFileName' ).text( theFile.name );
                        };
                    } )( file );

                    // Read in the image file as a data URL.
                    reader.readAsDataURL( file );
                }
            }

            // Function to handle drag over
            function handleDragOver ( event )
            {
                event.stopPropagation();
                event.preventDefault();
                event.originalEvent.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
            }

            // Setup the dnd listeners.
            dropZone.on( 'dragover', handleDragOver );
            dropZone.on( 'drop', handleFileSelect );
        }

        // Function to disable drag and drop for image upload
        function disableDragAndDrop ()
        {
            $( '#imageDropzone' ).off( 'dragover drop' );
        }

        $( document ).on( 'click', '.editBtn', function ()
        {
            var data = table.row( $( this ).closest( 'tr' ) ).data();

            // Set modal title
            $( '#brandModalTitle' ).text( 'Edit Brand: ' + data.brand_name );

            // Set image source
            $( '#brandImage' ).attr( 'src', data.logo_url );

            // Set input field values
            $( '#brandName' ).val( data.brand_name );
            $( '#description' ).val( data.description );
            $( '#type' ).val( data.type );
            $( '#status' ).val( data.status );

            var date = formatDate( data.created_at );
            var time = formatTime( data.created_at );
            $( '#createdAt' ).text( date + ' ' + time );
            date = formatDate( data.updated_at );
            time = formatTime( data.updated_at );
            $( '#updatedAt' ).text( date + ' ' + time );

            // Show the label when hovering over the upload button
            $( '#imageDropzone' ).hover( function ()
            {
                $( 'label[for="uploadBrandLogo"]' ).show();
            }, function ()
            {
                $( 'label[for="uploadBrandLogo"]' ).hide();
            } );

            $( '#editBrandBtn' ).hide();
            $( '#submitBrandBtn' ).show();

            // Show the modal
            $( '#modal-container' ).toggleClass( 'hidden' );

            // Enable input fields for editing
            $( '#brandName, #description, #type, #status' ).prop( 'disabled', false );

            // Enable drag and drop for the brand logo
            enableDragAndDrop();
        } );

        // Click event handler for editing the brand
        $( '#editBrandBtn' ).on( 'click', function ()
        {
            // Enable input fields for editing
            $( '#brandName, #description, #type, #status' ).prop( 'disabled', false );
        } );

        // Click event handler for closing the modal
        $( '#closeBrandModal, #closeBrandBtn' ).on( 'click', function ()
        {
            closeModal();
        } );

        // Function to close the modal
        function closeModal ()
        {
            // Reset image source
            $( '#brandImage' ).attr( 'src', '' );

            // Clear input field values
            $( '#brandName, #description, #type, #status' ).val( '' );
            $( '#createdAt, #updatedAt' ).text( '' );

            // Disable input fields
            $( '#brandName, #description, #type, #status' ).prop( 'disabled', true );

            // Hide the modal
            $( '#modal-container' ).toggleClass( 'hidden' );

            // Disable drag and drop for the brand logo
            disableDragAndDrop();
        }

        
    } );
</script>

<?php
$script = ob_get_clean();
include ("../../public/master.php");
?>