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
            <button id="addBrandsDropdownBtn"
                class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 mx-1 !px-4 py-0 text-lg items-center flex">
                <i class="fa-light fa-plus text-3xl pb-1 pr-2"></i>
                Add Brands
            </button>
            <div class="absolute 
                text-left text-sm text-center
                w-[150px] z-10
                transition-all bg-[#F6E17A] rounded-md shadow-md
                opacity-0 
                translate-y-[60px] -translate-x-[0.5px] space-y-1" id="addBrandsDropdown">
                <button class="createSBtn hidden cursor-pointer hover:bg-[#F9E89B] p-4 rounded-md w-full"
                    id="addSingleBrand">
                    Add Single Brand
                </button>
                <button class="createMBtn hidden cursor-pointer hover:bg-[#F9E89B] p-4 rounded-md w-full"
                    id="addMultipleBrands">
                    Upload Bulk Brands
                </button>
            </div>
        </div>
    </div>

    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div> <!--Divider-->

    <div class="relative overflow-x-auto mb-1 rounded-lg mt-4 ">
        <table id="brandsTable" class="hover order-column row-border!w-full  ">
            <div class="relative ml-1 mb-2 mt-2 sm:mb-0 sm:mr-8">
                <button id="combinedDropdownButton" data-dropdown-toggle="combinedDropdown" class="yellow-btn btn-primary font-medium rounded-lg 
                    text-sm px-5 py-2 text-center inline-flex items-center" type="button">
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
                                    class="w-4 h-4 text-blue-600 bg-black border-gray-900 rounded 
                                    focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 
                                    dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="typeCheckboxCatalog"
                                    class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-900">Catalog</label>
                            </div>
                            <div class="flex items-center p-2 rounded hover:bg-[#F9E89B] ">
                                <input id="typeCheckboxInquiry" type="checkbox" value="Inquiry"
                                    class="w-4 h-4 text-blue-600 bg-black border-gray-900 rounded 
                                    focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 
                                    dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
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
    class="modal fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden  ">
    <div class="bg-white rounded-lg shadow-2xl p-6 max-h-full !min-w-[672px] max-w-2xl overflow-y-auto">
        <div class="flex justify-between items-center">
            <h2 id="brandModalTitle" class="text-xl font-semibold"><!--Modal Title--></h2>
            <button id="closeBrandModal"
                class="close rounded-full text-gray-600 px-2 hover:text-red-700 hover:bg-gray-100 focus:outline-none "
                aria-label="Close modal">&times;</button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-2"></div> <!--Divider-->
        <h3 class="text-lg font-medium mb-2">Brand Information</h3>
        <form id="brandForm">
            <div class="flex flex-wrap justify-between">
                <!-- Image Section -->
                <div class="w-1/3 mt-2">
                    <div id="imageDropzone" class="relative rounded-xl ring-1 ring-black ring-offset-gray-700
                         overflow-hidden flex items-center justify-center group h-full max-h-80">

                        <!-- Dark overlay -->
                        <div id="brandLogoOverlay"
                            class="absolute inset-0 bg-black opacity-0 group-hover:opacity-50 transition-opacity duration-200">
                        </div>

                        <div class="absolute inset-x-0 bottom-0 flex items-center justify-center 
                            opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <label for="uploadBrandLogo" class="bg-gray-800 text-sm text-white m-1 px-2 py-1 
                                rounded-full cursor-pointer w-full text-center">
                                Upload new brand logo
                            </label>
                            <input type="file" id="uploadBrandLogo" class="hidden">
                        </div>
                        <div class="mx-auto"> <!-- Container for the image -->
                            <img id="brandImage" src="" alt="" class="w-full h-auto object-cover">
                        </div>
                    </div>

                    <div class="text-xs text-center text-gray-500 !-mt-[0.1px]">
                        <div id="brandLogoError" class="text-sm text-red-500 mt-1 error-message"></div>
                        <div id="createdAtContainer">Created At: <span id="createdAt"></span></div>
                        <div id="updatedAtContainer">Updated At: <span id="updatedAt"></span></div>
                    </div>
                </div>
                <!-- Data Section -->
                <div class="w-2/3">
                    <div class="mx-4"> <!-- Container for the brand information -->
                        <div class="mb-4">
                            <label for="brandName" class="block text-sm font-medium text-gray-700">Brand
                                Name:</label>
                            <input type="text" id="brandName" name="brandName" placeholder="Brand Name"
                                class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm">
                            <div id="brandNameError" class="text-sm text-red-500 mt-1 error-message"></div>
                        </div>
                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700">Description:</label>
                            <textarea id="description" name="description" placeholder="Description"
                                class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm"
                                rows="5"></textarea>
                            <div id="descriptionError" class="text-sm text-red-500 mt-1 error-message"></div>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type:</label>
                            <select id="type" name="type"
                                class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm">
                                <option value="" disabled selected>Select Type</option>
                                <option value="catalog">Catalog</option>
                                <option value="inquiry">Inquiry</option>
                            </select>
                            <div id="typeError" class="text-sm text-red-500 mt-1 error-message"></div>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                            <select id="status" name="status"
                                class="pl-2 mt-1 w-full rounded-md border border-gray-700 shadow-sm">
                                <option value="" disabled selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div id="statusError" class="text-sm text-red-500 mt-1 error-message"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 w-full">
                <h3 class="text-lg font-medium mb-2">Brand Catalogs</h3>
                <label for="brandCatalogs" class="block text-sm font-medium text-gray-700">Upload
                    Catalogs:</label>
                <input type="file" id="brandCatalogs" name="brandCatalogs[]" multiple
                    class="pl-2 mt-1 mb-2 w-full rounded-md border border-gray-700 shadow-sm">
                <div id="uploadedCatalogList" class="mt-2 grid grid-cols-2 gap-4 overflow-y-auto"></div>
                <div id="brandCatalogsError" class="text-sm text-red-500 mt-1 error-message"></div>
                <!-- Catalog List Section -->
                <div class="mt-4">
                    <label for="catalogList" class="block text-sm font-medium text-gray-700">Catalog
                        List:</label>
                    <div id="catalogList" class="grid grid-cols-2 gap-4 overflow-y-auto"></div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button id="editBrandBtn" type="button" class="btn-primary mr-2">Edit</button>
                <button id="submitBrandBtn" type="submit" class="btn-primary mr-2 hidden">Submit</button>
                <button id="hideBrandBtn" type="button" class="btn-danger mr-2">Hide</button>
                <button id="closeBrandBtn" type="button" class="btn-secondary">Close</button>
            </div>
        </form>
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
                                    <img src="${ data.logo_url }" alt="${ data.brand_name }" class="block object-fill max-w-[100px] max-h-[100px]">
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
            pageLength: 5, // Initial number of rows per page
            searching: true,
            processing: true,
            serverSide: false, // Disable server-side processing
            lengthMenu: [5, 10, 20], // Dropdown for changing the number of rows per page
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
            event.stopPropagation();
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
        $( document ).on( 'click', '.viewBtn, .editBtn, .createSBtn', function ()
        {
            const rowData = table.row( $( this ).closest( 'tr' ) ).data();
            const isView = $( this ).hasClass( 'viewBtn' );
            const isEdit = $( this ).hasClass( 'editBtn' );
            const isCreate = $( this ).hasClass( 'createSBtn' );

            console.log( rowData );

            // Set modal title
            if ( isView )
            {
                $( '#brandModalTitle' ).text( `View Brand: ${ rowData.brand_name }` );
            } else if ( isEdit )
            {
                $( '#brandModalTitle' ).text( `Edit Brand: ${ rowData.brand_name }` );
            } else if ( isCreate )
            {
                $( '#brandModalTitle' ).text( 'Add New Brand: ' );
            }

            // Display catalogs or brochures based on the operation
            if ( isView || isEdit )
            {
                // Display catalogs or brochures for viewing or editing
                if ( rowData.catalogs && rowData.catalogs.length > 0 )
                {
                    // Clear previous catalog list
                    $( '#catalogList' ).empty();

                    // Append each catalog to the list
                    rowData.catalogs.forEach( catalog =>
                    {
                        const fileName = catalog.path.split( '/' ).pop();
                        const fileSize = catalog.size;
                        const fileExtension = fileName.split( '.' ).pop();
                        const catalogId = catalog.catalogId;
                        
                        // Create file container
                        const fileContainer = createFileContainer( fileName, fileSize, fileExtension, catalogId );
                        $( '#catalogList' ).append( fileContainer );
                    } );
                } else
                {
                    $( '#catalogList' ).html( '<p class="text-sm text-red-700">No catalogs available.</p>' );
                }
            } else if ( isCreate )
            {
                // Additional logic for creating brand and handling catalog uploads
                // Show/hide elements, enable/disable fields, etc.
            }

            // Set modal elements visibility and behavior based on view or edit
            if ( isView )
            {
                // Disable input fields
                $( '#brandName, #description, #type, #status' ).prop( 'disabled', true );

                // Set image source
                $( '#brandImage' ).attr( 'src', rowData.logo_url );

                // Set input field values
                $( '#brandName' ).val( rowData.brand_name );
                $( '#description' ).val( rowData.description );
                $( '#type' ).val( rowData.type );
                $( '#status' ).val( rowData.status );

                // Set date and time texts
                const date = formatDate( rowData.created_at );
                const time = formatTime( rowData.created_at );
                $( '#createdAt' ).text( `${ date } ${ time }` );
                $( '#updatedAt' ).text( `${ formatDate( rowData.updated_at ) } ${ formatTime( rowData.updated_at ) }` );

                // Set buttons visibility
                $( '#editBrandBtn, #hideBrandBtn' ).show();
                $( '#submitBrandBtn' ).hide();
                $( '#closeBrandBtn' ).text( 'Close' );

                // Hide upload button when hovering over the brand logo
                $( '#imageDropzone' ).hover( function ()
                {
                    $( 'label[for="uploadBrandLogo"],#brandLogoOverlay' ).hide();
                } );
            } else if ( isEdit )
            {
                const brandId = rowData.brand_id;
                $( '#brandForm' ).data( 'brandId', brandId );

                // Enable input fields for editing
                $( '#brandName, #description, #type, #status' ).prop( 'disabled', false );

                // Set image source
                $( '#brandImage' ).attr( 'src', rowData.logo_url );

                // Set input field values
                $( '#brandName' ).val( rowData.brand_name );
                $( '#description' ).val( rowData.description );
                $( '#type' ).val( rowData.type );
                $( '#status' ).val( rowData.status );

                // Set date and time texts
                const date = formatDate( rowData.created_at );
                const time = formatTime( rowData.created_at );
                $( '#createdAt' ).text( `${ date } ${ time }` );
                $( '#updatedAt' ).text( `${ formatDate( rowData.updated_at ) } ${ formatTime( rowData.updated_at ) }` );

                // Set buttons visibility
                $( '#submitBrandBtn, #hideBrandBtn' ).show();
                $( '#editBrandBtn' ).hide();
                $( '#closeBrandBtn' ).text( 'Cancel' );

                // Show label when hovering over the upload button
                $( '#imageDropzone' ).hover( function ()
                {
                    $( 'label[for="uploadBrandLogo"],#brandLogoOverlay' ).show();
                } );

                // Enable drag and drop for the brand logo
                enableDragAndDrop();

                // Set the form data to indicate it is for creating a new brand
                $( '#brandForm' ).data( 'isEdit', true );
            } else if ( isCreate )
            {
                // Reset form and error messages
                $( '#brandForm' )[0].reset();
                $( '.error-message' ).text( '' );

                // Set modal title
                $( '#brandModalTitle' ).text( 'Add New Brand: ' );

                // Set upload section for create operation
                $( '#brandImage' ).addClass( 'fa-solid fa-image text-3xl' );

                // Enable input fields for editing
                $( '#brandName, #description, #type, #status' ).prop( 'disabled', false );

                // Set buttons visibility
                $( '#submitBrandBtn' ).show();
                $( '#editBrandBtn, #hideBrandBtn' ).hide();
                $( '#closeBrandBtn' ).text( 'Cancel' );

                // Hide dates as they are not needed in create mode
                $( '#createdAtContainer, #updatedAtContainer' ).hide();

                // Show the label when hovering over the upload button
                $( '#imageDropzone' ).hover( function ()
                {
                    $( 'label[for="uploadBrandLogo"],#brandLogoOverlay' ).show();
                } );

                // Enable drag and drop for the brand logo
                enableDragAndDrop();

                // Set the form data to indicate it is for creating a new brand
                $( '#brandForm' ).data( 'isEdit', false );
            }

            // Show the modal
            $( '#modal-container' ).toggleClass( 'hidden' );
        } );

        $( '#brandCatalogs' ).on( 'change', function ()
        {
            const files = $( this )[0].files; // Get uploaded files
            $( '#uploadedCatalogList' ).empty(); // Clear previous files

            // Loop through uploaded files
            for ( let i = 0; i < files.length; i++ )
            {
                const file = files[i];
                const fileName = file.name;
                const fileSize = file.size;
                const fileExtension = fileName.split( '.' ).pop().toLowerCase();

                // Create file container and append it to the catalog list
                const fileContainer = createFileContainer( fileName, fileSize, fileExtension );
                $( '#uploadedCatalogList' ).append( fileContainer );
            }
        } );

        // Function to create file container
        function createFileContainer ( fileName, fileSize, fileExtension, catalogId)
        {
            const container = $( '<div>' ).addClass( 'relative bg-gray-200 rounded-md p-2 flex flex-col items-center justify-center text-center' );
            const deleteButton = $( '<button>' ).addClass( 'absolute top-0 right-0 w-6 h-6 text-center text-gray-500 bg-transparent border-none outline-none cursor-pointer rounded-full  hover:text-red-700 hover:bg-gray-100' ).html( '&times;' ).attr('type', 'button');
            const icon = $( '<i>' ).addClass( getFileIconClass( fileExtension ) + ' text-3xl mb-1' );
            const name = $( '<p>' ).addClass( 'text-sm font-medium' ).text( fileName );
            const size = $( '<p>' ).addClass( 'text-xs text-gray-500' ).text( formatSize( fileSize ) );

            // Add click event to delete button
            deleteButton.on( 'click', function ()
            {
                deleteCatalog(catalogId, container);
            } );

            // Append elements to the container
            container.append( deleteButton, icon, name, size );

            return container;
        }

        function getFileIconClass ( extension )
        {
            switch ( extension.toLowerCase() )
            {
                case 'pdf':
                    return 'far fa-file-pdf';
                case 'doc':
                case 'docx':
                    return 'far fa-file-word';
                case 'xls':
                case 'xlsx':
                    return 'far fa-file-excel';
                case 'ppt':
                case 'pptx':
                    return 'far fa-file-powerpoint';
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    return 'far fa-file-image';
                default:
                    return 'far fa-file';
            }
        }

        function formatSize ( bytes )
        {
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if ( bytes == 0 ) return '0 Byte';
            const i = parseInt( Math.floor( Math.log( bytes ) / Math.log( 1024 ) ) );
            return Math.round( bytes / Math.pow( 1024, i ), 2 ) + ' ' + sizes[i];
        }

        // Function to delete the catalog via AJAX with confirmation
        function deleteCatalog ( catalogId , container)
        {
            // Show confirmation dialog using SweetAlert
            Swal.fire( {
                title: 'Are you sure?',
                text: 'You are about to delete this catalog. This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            } ).then( ( result ) =>
            {
                if ( result.isConfirmed )
                {
                    // If user confirms, proceed with catalog deletion
                    $.ajax( {
                        url: '/../../backend/brands/catalog-delete.php', 
                        type: 'POST',
                        data: { catalogId: catalogId },
                        dataType: 'json',
                        success: function ( response )
                        {
                            // Remove the file container from the DOM
                            container.remove();
                            // Handle success response
                            Swal.fire( {
                                icon: 'success',
                                title: 'Success!',
                                text: 'Catalog deleted successfully.'
                            } );
                        },
                        error: function ( xhr, status, error )
                        {
                            // Handle error response
                            Swal.fire( {
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete catalog. Please try again later.'
                            } );
                            console.error( 'Error deleting catalog:', error );
                        }
                    } );
                }
            } );
        }

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

                    // Set the selected file to the input type file
                    $( '#uploadBrandLogo' ).prop( 'files', files );

                    renderImage( file );
                }
            }

            // Function to handle drag over
            function handleDragOver ( event )
            {
                event.stopPropagation();
                event.preventDefault();
                event.originalEvent.dataTransfer.dropEffect = 'copy';
            }

            // Setup the dnd listeners.
            dropZone.on( 'dragover', handleDragOver );
            dropZone.on( 'drop', handleFileSelect );
        }

        // Function to render the selected image
        function renderImage ( file )
        {
            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = function ( e )
            {
                // Render thumbnail.
                var span = $( '<span>' );
                span.html( ['<img class="thumb" src="', e.target.result,
                    '" title="', escape( file.name ), '"/>'].join( '' ) );
                $( '#brandImage' ).attr( 'src', e.target.result ); // Update image preview
                $( '#imageFileName' ).text( file.name );
            };

            // Read in the image file as a data URL.
            reader.readAsDataURL( file );
        }

        // Event listener for file input change
        $( '#uploadBrandLogo' ).on( 'change', function ( e )
        {
            var file = e.target.files[0]; // Get the selected file
            if ( file )
            {
                renderImage( file );
            }
        } );

        // Function to disable drag and drop for image upload
        function disableDragAndDrop ()
        {
            $( '#imageDropzone' ).off( 'dragover drop' );
        }

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

        function validateForm ()
        {
            var brandName = $( '#brandName' ).val().trim();
            var description = $( '#description' ).val().trim();
            var type = $( '#type' ).val().trim();
            var status = $( '#status' ).val().trim();

            // Validation rules
            var isValid = true;
            if ( !brandName )
            {
                $( '#brandName' ).addClass( 'border-red-500' );
                $( '#brandNameError' ).text( 'Brand Name is required.' );
                isValid = false;
            } else
            {
                $( '#brandName' ).removeClass( 'border-red-500' );
                $( '#brandNameError' ).empty();
            }

            if ( !description )
            {
                $( '#description' ).addClass( 'border-red-500' );
                $( '#descriptionError' ).text( 'Description is required.' );
                isValid = false;
            } else
            {
                $( '#description' ).removeClass( 'border-red-500' );
                $( '#descriptionError' ).empty();
            }

            if ( !type )
            {
                $( '#type' ).addClass( 'border-red-500' );
                $( '#typeError' ).text( 'Type is required.' );
                isValid = false;
            } else
            {
                $( '#type' ).removeClass( 'border-red-500' );
                $( '#typeError' ).empty();
            }

            if ( !status )
            {
                $( '#status' ).addClass( 'border-red-500' );
                $( '#statusError' ).text( 'Status is required.' );
                isValid = false;
            } else
            {
                $( '#status' ).removeClass( 'border-red-500' );
                $( '#statusError' ).empty();
            }
            return isValid;
        }

        $( '#brandForm' ).on( 'submit', function ( event )
        {
            event.preventDefault(); // Prevent default form submission

            if ( validateForm() )
            {
                const brandId = $( '#brandForm' ).data( 'brandId' );
                let formData = new FormData( this ); // Create a FormData object with the form
                formData.append( 'brandId', brandId ); // Append brandId to formData

                // Append brand logo file to formData
                let brandLogoFile = $( '#uploadBrandLogo' ).prop( 'files' )[0];
                if ( brandLogoFile )
                {
                    formData.append( 'brandLogo', brandLogoFile );
                }

                // Get the URL for form submission based on the value of 'isEdit'
                let url = '';
                if ( $( '#brandForm' ).data( 'isEdit' ) )
                {
                    url = '/../../backend/brands/brands-update.php';
                } else
                {
                    url = '/../../backend/brands/brands-create.php';
                }

                // If form is valid, proceed with form submission or AJAX request
                console.log( 'Form is valid. Proceed with submission.' );

                // AJAX request to submit the form data
                $.ajax( {
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function ( response )
                    {
                        Swal.fire( {
                            icon: 'success',
                            title: 'Success',
                            text: 'Form submitted successfully!',
                            showConfirmButton: false,
                            timer: 1000
                        } );

                        table.ajax.reload();

                        closeModal();
                    },
                    error: function ( xhr, status, error )
                    {
                        // Handle error response from the server
                        console.error( 'Error:', error );
                        Swal.fire( {
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to submit the form. Please try again. Error: ' + error
                        } );
                        table.columns().search( '' ).draw();
                    }
                } );
            } else
            {
                console.log( 'Form is not valid. Please fill out all required fields.' );
            }
        } );

        $( document ).on( 'click', '#addBrandsDropdownBtn', function ()
        {
            $( "#addBrandsDropdown" ).toggleClass( " transition-opacity opacity-100 ease-in-out duration-100" );
            $( "#addSingleBrand" ).toggleClass( "hidden" );
            $( "#addMultipleBrands" ).toggleClass( "hidden" );
        } );

    } );
</script>

<?php
$script = ob_get_clean();
include ("../../public/master.php");
?>