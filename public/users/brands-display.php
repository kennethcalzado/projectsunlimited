<?php
session_start();
$pageTitle = "Brands Listings";
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
                            <input type="file" id="uploadBrandLogo" accept=".jpg, .jpeg, .png" class="hidden"
                                multiple="false">
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
                            <input type="text" id="brandName" name="brandName" placeholder="Brand Name" class="pl-2 mt-1 w-full rounded-md border 
                        focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent shadow-sm">
                            <div id="brandNameError" class="text-sm text-red-500 mt-1 error-message"></div>
                        </div>
                        <div class="mb-4">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700">Description:</label>
                            <textarea id="description" name="description" placeholder="Description" class="pl-2 mt-1 w-full rounded-md border 
                        focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent shadow-sm"
                                rows="5"></textarea>
                            <div id="descriptionError" class="text-sm text-red-500 mt-1 error-message"></div>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type:</label>
                            <select id="type" name="type" class="pl-2 mt-1 w-full rounded-md border shadow-sm  
                        focus:outline-none focus:ring-2 focus:ring-yellow-500 ">
                                <option value=" " disabled selected>Select Type</option>
                                <option value="catalog">Catalog</option>
                                <option value="inquiry">Inquiry</option>
                            </select>
                            <div id="typeError" class="text-sm text-red-500 mt-1 error-message"></div>
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                            <select id="status" name="status" class="pl-2 mt-1 w-full rounded-md border shadow-sm  
                        focus:outline-none focus:ring-2 focus:ring-yellow-500 ">
                                <option value=" " disabled selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="hidden">Hidden</option>
                            </select>
                            <div id="statusError" class="text-sm text-red-500 mt-1 error-message"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 w-full">
                <h3 class="text-lg font-medium mb-2">Brand Catalogs</h3>
                <!-- Uploaded Catalog List Section -->
                <div id="uploadCatalogWrapper">
                    <label for="brandCatalogs" class="block text-sm font-medium text-gray-700">Upload
                        Catalogs:</label>
                    <input type="file" id="brandCatalogs" name="brandCatalogs[]" accept=".pdf" multiple class="pl-2 px-3 py-2 mt-1 mb-2 w-full rounded-md border 
                        focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent shadow-sm">
                    <div id="uploadedCatalogList" class="mt-2 grid grid-cols-2 gap-4 overflow-y-auto"></div>
                    <div id="brandCatalogsError" class="text-sm text-red-500 mt-1 error-message"></div>
                </div>

                <!-- Catalog List Section -->
                <div id="catalogWrapper" class="mt-4">
                    <label for="catalogList" class="block text-sm font-medium text-gray-700">Catalog
                        List:</label>
                    <div id="catalogList" class="grid grid-cols-2 gap-4 overflow-y-auto"></div>
                </div>
            </div>

            <div class="mt-8 w-full">
                <h3 class="text-lg font-medium mb-2">Image Section</h3>
                <!-- Upload Image List Section -->
                <div id="uploadBrandImagesWrapper">
                    <label for="brandImages" class="block text-sm font-medium text-gray-700">Upload Sample
                        Images:</label>
                    <input type="file" id="brandImages" name="brandImages[]" accept=".jpg, .jpeg, .png" multiple
                        class="border rounded-md 
        pl-2 px-3 py-2 mt-1 mb-2 w-full focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent shadow-sm">
                    <div id="loadBrandImages" class="mt-2 grid grid-cols-2 gap-4 overflow-y-auto"></div>
                    <div id="brandBrandImagesError" class="text-sm text-red-500 mt-1 error-message"></div>
                </div>

                <!-- Image List Section -->
                <div id="brandImageWrapper" class="mt-4">
                    <label for="brandImageList" class="block text-sm font-medium text-gray-700">Brand Images:</label>
                    <div id="brandImageList" class="grid grid-cols-2 gap-4 overflow-y-auto"></div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button id="editBrandBtn" type="button" class="btn-primary mr-2">Edit</button>
                <button id="submitBrandBtn" type="submit" class="btn-primary mr-2 hidden">Submit</button>
                <button id="hideBrandBtn" type="button" class="delBtn btn-danger mr-2">Hide</button>
                <button id="closeBrandBtn" type="button" class="btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>

<div id="uploadBrandModal"
    class="modal fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-20 w-full hidden">
    <div class="bg-black opacity-25 w-full h-full absolute -z-10"></div>
    <div class="bg-white p-4 rounded-md w-full max-w-md">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">Upload .xlsx or .csv file for Brands</h2>
            <button id="closeUploadBrandModal"
                class="close rounded-full text-gray-600 px-2 text-center text-lg hover:text-gray-800 focus:outline-none hover:bg-gray-300"
                aria-label="Close modal">&times;</button>
        </div>
        <div class="border-b border-black flex-grow border-2 mt-2 mb-3"></div>
        <!-- Instructions -->
        <p class="text-black justify-center mb-4 text-lg"><b class="mr-2">Instruction:</b> To upload multiple or bulk
            brands into the table, select an Excel or a CSV file.</p>
        <!-- Brand Upload Form -->
        <form id="uploadBrandForm" enctype="multipart/form-data" class="mt-2">
            <div class="mb-4 flex flex-col">
                <label for="dropzone-brand-file" class="text-sm font-medium text-gray-700 mb-1">Select File</label>
                <!-- File Selection Area -->
                <div id="brand-dropzone-holder" class="flex items-center justify-center w-full">
                    <label for="dropzone-brand-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-900 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <div id="brand-uploadModalIconHolder">
                                <i class="fa-solid fa-file-arrow-up text-3xl mb-3 text-zinc-300"></i>
                            </div>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                    to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">CSV, or XLSX (MAX. 800x400px)</p>
                            <!-- Placeholder for the file name -->
                            <p id="brand-file-name" class="text-xs text-gray-500 dark:text-gray-400 mt-2"></p>
                        </div>
                        <!-- Hidden input for file selection -->
                        <input id="dropzone-brand-file" type="file" class="hidden" name="upload_brand"
                            accept=".xlsx, .csv" />
                    </label>
                </div>
            </div>
            <!-- Form Buttons -->
            <div class="flex justify-end">
                <button type="submit" id="uploadBrandSubmitBtn"
                    class="btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center mr-2">Upload
                    File</button>
                <button type="button" id="cancelUploadBrandModal"
                    class="btn btn-secondary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center">Cancel</button>
            </div>
        </form>
    </div>
</div>


<?php $content = ob_get_clean();
ob_start();
?>

<!-- Your javascript here -->
<script>
    $( document ).ready( function ()
    {
        ////////////////// DATA TABLE RENDERING /////////////
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
                    className: '!text-center max-w-[200px]',
                    render: function ( data )
                    {
                        return `
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-[100px] h-[100px] rounded-full ring-1 ring-black overflow-hidden flex items-center justify-center">
                                    <img src="${ data.logo_url }" alt="${ data.brand_name }" class="block object-fill max-w-[100px] max-h-[100px]">
                                </div>
                                <span class="block mt-2">${ data.brand_name }</span>
                        <span class="text-xs text-gray-500 truncate max-w-[200px]">${ data.description }</span>
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
                        const isHidden = data.status === 'hidden';
                        const hideButtonText = isHidden ? 'Unhide' : 'Hide';

                        return `
                            <button class="viewBtn btn-view !m-0 hover:underline text-[14px]">
                                <i class="fas fa-eye pr-[3px]"></i>View
                            </button>
                            <button class="editBtn yellow-btn btn-primary !m-0 hover:underline text-[14px]">
                                <i class="fas fa-edit pr-[3px]"></i>Edit
                            </button>
                            <button class="delBtn btn-danger !m-0 hover:underline text-[14px] ${ data.status === 'hidden' ? '!bg-emerald-500 hover:!bg-emerald-400' : '' }">
                                <i class="fas fa-trash pr-[3px]"></i>${ hideButtonText }
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

        ////////////////// DROPDOWN FILTERS /////////////////////
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

        ////////////////// BRANDS CRUD DATA RENDERING ON MODAL  /////////////////////
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

                // Render brand images
                if ( rowData.images && rowData.images.length > 0 )
                {
                    // Clear previous brand images
                    $( '#brandImageList' ).empty();

                    // Extract image names from paths and render images
                    rowData.images.forEach( imagePath =>
                    {
                        const imageName = imagePath.split( '/' ).pop(); // Extract image name from path
                        const file = {
                            name: imageName
                        };
                        renderBrandImages( rowData.images, rowData.brand_id, true ); // Pass true to indicate images are from database
                    } );
                } else
                {
                    $( '#brandImageList' ).html( '<p class="text-sm text-red-700">No images available.</p>' );
                }

                // Set hide button text based on status
                const hideButtonText = rowData.status === 'hidden' ? 'Unhide' : 'Hide';
                $( '#hideBrandBtn' ).text( hideButtonText );
            }

            // Set modal elements visibility and behavior based on view or edit
            if ( isView )
            {
                // Disable input fields
                $( '#brandName, #description, #type, #status' ).prop( 'disabled', true );

                // Check if the brand type is 'inquiry'
                if ( rowData.type === 'inquiry' )
                {
                    // Hide upload catalog fields and catalog wrapper
                    $( '#uploadCatalogWrapper' ).hide();
                    $( '#catalogWrapper' ).hide();
                } else
                {
                    // Show upload catalog fields and catalog wrapper for other types
                    $( '#uploadCatalogWrapper' ).hide();
                    $( '#catalogWrapper' ).show();
                }

                // Hide upload catalog fields
                $( '#uploadBrandImagesWrapper' ).hide();
                $( '#brandImageWrapper' ).show();

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

                // Check if the brand type is 'inquiry'
                if ( rowData.type === 'inquiry' )
                {
                    // Hide upload catalog fields and catalog wrapper
                    $( '#uploadCatalogWrapper' ).hide();
                    $( '#catalogWrapper' ).hide();
                } else
                {
                    // Show upload catalog fields and catalog wrapper for other types
                    $( '#uploadCatalogWrapper' ).show();
                    $( '#catalogWrapper' ).show();
                }

                // Hide upload catalog fields
                $( '#uploadBrandImagesWrapper' ).show();
                $( '#brandImageWrapper' ).show();

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

                // Check if the brand type is 'inquiry'
                if ( rowData.type === 'inquiry' )
                {
                    // Hide upload catalog fields and catalog wrapper
                    $( '#uploadCatalogWrapper' ).hide();
                    $( '#catalogWrapper' ).hide();
                } else
                {
                    // Show upload catalog fields and catalog wrapper for other types
                    $( '#uploadCatalogWrapper' ).show();
                    $( '#catalogWrapper' ).hide();
                }

                // Show upload catalog fields
                $( '#uploadBrandImagesWrapper' ).show();
                $( '#brandImageWrapper' ).hide();

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

        $( document ).on( 'click', '#editBrandBtn', function ()
        {
            // Enable input fields for editing
            $( '#brandName, #description, #type, #status' ).prop( 'disabled', false );

            // Show upload catalog fields
            $( '#uploadCatalogWrapper' ).show();
            $( '#catalogWrapper' ).show();

            // Show upload brand images fields
            $( '#uploadBrandImagesWrapper' ).show();
            $( '#brandImageWrapper' ).show();

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
        } );

        ////////////////// CATALOG HANDLING ////////////////
        $( '#brandCatalogs' ).on( 'change', function ()
        {
            const files = $( this )[0].files; // Get uploaded files
            $( '#uploadedCatalogList' ).empty(); // Clear previous files
            const invalidFiles = {}; // Object to store invalid files with their respective errors

            // Loop through uploaded files
            for ( let i = 0; i < files.length; i++ )
            {
                let file = files[i];
                let fileName = file.name;
                let fileSize = file.size;
                let fileExtension = fileName.split( '.' ).pop().toLowerCase();
                let isValid = true;

                // Validate file extension
                if ( fileExtension !== 'pdf' )
                {
                    if ( !invalidFiles[fileName] )
                    {
                        invalidFiles[fileName] = [];
                    }
                    invalidFiles[fileName].push( fileName + ' is not a PDF file.' );
                    isValid = false;
                }

                // Validate file size (in bytes)
                const maxSize = 30 * 1024 * 1024; // 30 MB
                if ( fileSize > maxSize )
                {
                    if ( !invalidFiles[fileName] )
                    {
                        invalidFiles[fileName] = [];
                    }
                    invalidFiles[fileName].push( fileName + ' exceeds the maximum size limit (30 MB).' );
                    isValid = false;

                }

                // Create file container and append it to the catalog list
                if ( isValid )
                {
                    const fileContainer = createFileContainer( fileName, fileSize, fileExtension );
                    $( '#uploadedCatalogList' ).append( fileContainer );
                }
            }

            // Remove invalid files from the input field
            for ( const fileName in invalidFiles )
            {
                deleteInvalidFile( fileName );
            }

            // Display error message for invalid files using Swal.fire
            const errorMessages = Object.values( invalidFiles ).flat();
            if ( errorMessages.length > 0 )
            {
                const errorMessage = 'The following files could not be uploaded:<br>' + errorMessages.join( '<br>' );
                Swal.fire( {
                    icon: 'error',
                    title: 'Invalid Files',
                    html: errorMessage
                } );
            }
        } );

        // Function to remove invalid files from the input field
        function deleteInvalidFile ( fileName )
        {
            const files = $( '#brandCatalogs' )[0].files;
            const newFiles = Array.from( files ).filter( file => file.name !== fileName );

            // Create a new FileList object from the filtered files
            const newFileList = new DataTransfer();
            newFiles.forEach( file => newFileList.items.add( file ) );

            // Assign the new FileList to the input field
            $( '#brandCatalogs' )[0].files = newFileList.files;
        }

        // Function to create file container
        function createFileContainer ( fileName, fileSize, fileExtension, catalogId = null )
        {
            const container = $( '<div>' ).addClass( 'relative bg-gray-200 rounded-md p-2 flex flex-col items-center justify-center text-center' );
            const deleteButton = $( '<button>' ).addClass( 'absolute top-0 right-0 bg-red-500 w-6 h-6 text-center text-white border-none outline-none cursor-pointer rounded-full flex items-center justify-center hover:bg-red-600' ).html( '&times' ).attr( 'type', 'button' );
            const icon = $( '<i>' ).addClass( getFileIconClass( fileExtension ) + ' text-3xl mb-1' );
            const name = $( '<p>' ).addClass( 'text-sm font-medium whitespace-normal break-all' ).text( fileName );
            const size = $( '<p>' ).addClass( 'text-xs text-gray-500' ).text( formatSize( fileSize ) );

            // Create a download link for the PDF
            const downloadLink = $( '<a>' ).addClass( 'text-blue-500 hover:underline mt-1' ).attr( 'href', `/../../backend/brands/catalog-download.php?catalogId=${ catalogId }` ).attr( 'target', '_blank' ).text( 'Download' );

            // Add click event to delete button
            deleteButton.on( 'click', function ()
            {
                if ( catalogId !== null )
                {
                    deleteCatalog( catalogId, container ); // Delete catalog with catalog ID
                } else
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
                        container.remove(); // Remove the file container
                        deleteInvalidFile( fileName );

                        // Handle success response
                        Swal.fire( {
                            icon: 'success',
                            title: 'Success!',
                            text: 'Catalog deleted successfully.'
                        } );
                    } );
                }
            } );

            // Append elements to the container
            container.append( deleteButton, icon, name, size, downloadLink );

            return container;
        }

        function getFileIconClass ( extension )
        {
            switch ( extension.toLowerCase() )
            {
                case 'pdf':
                    return 'far fa-file-pdf';
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
        function deleteCatalog ( catalogId, container )
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
                            table.ajax.reload();

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

        //////////////////////// BRAND LOGO DRAG AND DROP ON MODAL //////////////////////////////
        function enableDragAndDrop ()
        {
            var dropZone = $( '#imageDropzone' );

            // Function to handle file selection
            function handleFileSelect ( event )
            {
                event.stopPropagation();
                event.preventDefault();

                var files = event.originalEvent.dataTransfer.files; // FileList object.
                var file = files[0]; // Only process the first file

                // Only process image files.
                if ( file && !file.type.match( 'image.*' ) )
                {
                    // Show Swal error message
                    Swal.fire( {
                        icon: 'error',
                        title: 'Invalid file type',
                        text: 'Please upload an image file (jpg, jpeg, png).',
                    } );
                    return;
                }

                // Set the selected file to the input type file
                $( '#uploadBrandLogo' ).prop( 'files', files );

                renderBrandLogo( file );
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
        function renderBrandLogo ( file )
        {
            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = function ( e )
            {
                // Render thumbnail.
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
                // Only process image files.
                if ( !file.type.match( 'image.*' ) )
                {
                    // Show Swal error message
                    Swal.fire( {
                        icon: 'error',
                        title: 'Invalid file type',
                        text: 'Please upload an image file (jpg, jpeg, png).',
                    } );
                    return;
                }
                renderBrandLogo( file );
            }
        } );

        // Function to disable drag and drop for image upload
        function disableDragAndDrop ()
        {
            $( '#imageDropzone' ).off( 'dragover drop' );
        }

        //////////////////////// IMAGE SECTION ON MODAL //////////////////////////////
        // Event listener for file input change
        $( '#brandImages' ).on( 'change', function ( e )
        {
            const files = $( this )[0].files; // Get uploaded Images
            $( '#loadBrandImages' ).empty(); // Clear previous files
            const invalidFiles = []; // Object to store invalid files with their respective errors

            if ( files.length > 4 )
            {
                Swal.fire( {
                    icon: 'error',
                    title: 'Too many files',
                    text: 'You can only upload up to 4 images.',
                } );
                return;
            }

            for ( let i = 0; i < files.length; i++ )
            {
                let file = files[i];
                let fileName = file.name;
                let isValid = true;

                if ( file && !file.type.match( 'image.*' ) )
                {
                    if ( !invalidFiles[fileName] )
                    {
                        invalidFiles[fileName] = [];
                    }
                    invalidFiles[fileName].push( fileName + ' is not a valid image.' );
                    isValid = false;
                }

                // Create file container and append it to the catalog list
                if ( isValid )
                {
                    renderBrandImages( file );
                }
            }

            // Remove invalid files from the input field
            for ( const fileName in invalidFiles )
            {
                removeInvalidImageFromInput( fileName );
            }

            // Display error message for invalid files using Swal.fire
            if ( invalidFiles.length > 0 )
            {
                const errorMessage = 'The following files could not be uploaded:<br>' + invalidFiles.join( '<br>' );
                Swal.fire( {
                    icon: 'error',
                    title: 'Invalid Files',
                    html: errorMessage
                } );
            }
        } );

        function renderBrandImages ( imagesData, brandId = null, fromDatabase = false )
        {
            // Function to render an image
            function renderImage ( imageSrc, container, fileName = null )
            {
                const imageContainer = $( '<div>' ).addClass( 'relative bg-gray-200 rounded-md p-2 flex flex-col items-center justify-center text-center' );
                const image = $( '<img>' ).addClass( 'w-32 h-32 object-cover rounded-md' ).attr( 'src', imageSrc );
                const deleteButton = $( '<button>' ).addClass( 'absolute top-0 right-0 bg-red-500 w-6 h-6 text-center text-white border-none outline-none cursor-pointer rounded-full flex items-center justify-center hover:bg-red-600' ).html( '&times;' ).attr( 'type', 'button' );
                const zoomButton = $( '<button>' ).addClass( 'absolute bottom-0 left-0 bg-blue-500 w-6 h-6 text-center text-white border-none outline-none cursor-pointer rounded-full flex items-center justify-center hover:bg-blue-600' ).html( '🔍' ).attr( 'type', 'button' );

                // Add click event to delete button
                deleteButton.on( 'click', function ()
                {
                    // Show confirmation dialog using SweetAlert
                    Swal.fire( {
                        title: 'Are you sure?',
                        text: 'You are about to delete this brand image. This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    } ).then( ( result ) =>
                    {
                        if ( result.isConfirmed )
                        {
                            deleteInvalidBrandImage( imageSrc, imageContainer, brandId, fromDatabase, fileName ); // Passing necessary parameters for deletion
                        }
                    } );
                } );

                // Add click event to zoom button
                zoomButton.on( 'click', function ()
                {
                    Swal.fire( {
                        title: 'Zoomed Image',
                        imageUrl: imageSrc,
                        imageAlt: 'Zoomed Image',
                        showCloseButton: true,
                        showConfirmButton: false,
                        customClass: {
                            image: 'object-contain'
                        }
                    } );
                } );

                // Append elements to the container
                imageContainer.append( deleteButton, zoomButton, image );
                container.append( imageContainer );
            }

            // Render images into the appropriate container based on the context
            if ( fromDatabase )
            {
                // Rendering images fetched from the database
                const container = $( '#brandImageList' );
                container.empty(); // Clear previous images
                if ( Array.isArray( imagesData ) )
                {
                    imagesData.forEach( imagePath => renderImage( imagePath, container ) );
                } else if ( typeof imagesData === 'string' )
                {
                    try
                    {
                        const imagePaths = JSON.parse( imagesData );
                        imagePaths.forEach( imagePath => renderImage( imagePath, container ) );
                    } catch ( error )
                    {
                        console.error( 'Error parsing image data:', error );
                    }
                } else
                {
                    console.error( 'Invalid image data:', imagesData );
                }
            } else
            {
                // Rendering images from input file type
                const container = $( '#loadBrandImages' );
                container.empty(); // Clear previous images

                // Ensure imagesData is an array
                const filesArray = Array.isArray( imagesData ) ? imagesData : [imagesData];

                // Loop through each file
                for ( let i = 0; i < filesArray.length; i++ )
                {
                    const file = filesArray[i];
                    const reader = new FileReader();
                    reader.onload = function ( e )
                    {
                        renderImage( e.target.result, container, file.name );
                    };
                    reader.readAsDataURL( file );
                }
            }
        }

        function deleteInvalidBrandImage ( imageSrc, container, brandId = null, fromDatabase = false, fileName = null )
        {

            // Check if the image is from the database
            if ( fromDatabase )
            {
                // Redirect to the appropriate endpoint for database images
                $.ajax( {
                    url: '/../../backend/brands/images-delete.php', // Update the URL as needed
                    method: 'POST',
                    data: { imageSrc: imageSrc, brandId: brandId }, // Pass brandId for deletion
                    dataType: 'json',
                    success: function ( response )
                    {
                        console.log( response );
                        // Handle success response
                        if ( response.success )
                        {
                            container.remove(); // Remove the file container from the DOM
                            Swal.fire( {
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Your image has been deleted.',
                                timer: 2000,
                                showConfirmButton: false
                            } );
                        } else
                        {
                            Swal.fire( {
                                icon: 'error',
                                title: 'Error!',
                                text: 'There was a problem deleting your image.',
                                timer: 2000,
                                showConfirmButton: false
                            } );
                        }
                    },
                    error: function ()
                    {
                        // Handle error response
                        Swal.fire( {
                            icon: 'error',
                            title: 'Error!',
                            text: 'There was a problem deleting your image.',
                            timer: 2000,
                            showConfirmButton: false
                        } );
                    }
                } );
            } else
            {
                // For images from input file type, simply remove the container
                container.remove();
                removeInvalidImageFromInput( fileName );
            }
        }

        function removeInvalidImageFromInput ( fileName )
        {
            const inputField = $( '#brandImages' )[0].files;
            const newFiles = Array.from( inputField ).filter( file => file.name !== fileName );;

            // Create a new FileList object from the filtered files
            const newFileList = new DataTransfer();
            newFiles.forEach( file => newFileList.items.add( file ) );

            // Assign the new FileList to the input field
            $( '#brandImages' )[0].files = newFileList.files;
        }

        //////////////////// FORM VALIDATION /////////////////////////
        // Function to validate Brand Name
        function validateBrandName ()
        {
            var brandName = $( '#brandName' ).val().trim();
            var brandNameError = $( '#brandNameError' );
            var htmlRegex = /<\/?[\w\s="/.':;#-\/\?]+>/gi;
            var sqlRegex = /\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/ig;
            var phpRegex = /<\?(php)?[\s\S]*?\?>/ig;

            if ( !brandName )
            {
                $( '#brandName' ).addClass( 'border-red-500' );
                brandNameError.text( 'Brand Name is required.' );
                return false;
            } else if ( htmlRegex.test( brandName ) )
            {
                $( '#brandName' ).addClass( 'border-red-500' );
                brandNameError.text( 'Brand Name cannot contain HTML elements.' );
                return false;
            } else if ( sqlRegex.test( brandName ) )
            {
                $( '#brandName' ).addClass( 'border-red-500' );
                brandNameError.text( 'Brand Name cannot contain SQL injection.' );
                return false;
            } else if ( phpRegex.test( brandName ) )
            {
                $( '#brandName' ).addClass( 'border-red-500' );
                brandNameError.text( 'Brand Name cannot contain PHP tags.' );
                return false;
            } else
            {
                $( '#brandName' ).removeClass( 'border-red-500' );
                brandNameError.empty();
                return true;
            }
        }

        // Function to validate Description
        function validateDescription ()
        {
            var description = $( '#description' ).val().trim();
            var descriptionError = $( '#descriptionError' );
            var htmlRegex = /<\/?[\w\s="/.':;#-\/\?]+>/gi;
            var sqlRegex = /\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/ig;
            var phpRegex = /<\?(php)?[\s\S]*?\?>/ig;

            if ( !description )
            {
                $( '#description' ).addClass( 'border-red-500' );
                descriptionError.text( 'Description is required.' );
                return false;
            } else if ( htmlRegex.test( description ) )
            {
                $( '#description' ).addClass( 'border-red-500' );
                descriptionError.text( 'Description cannot contain HTML elements.' );
                return false;
            } else if ( sqlRegex.test( description ) )
            {
                $( '#description' ).addClass( 'border-red-500' );
                descriptionError.text( 'Description cannot contain SQL injection.' );
                return false;
            } else if ( phpRegex.test( description ) )
            {
                $( '#description' ).addClass( 'border-red-500' );
                descriptionError.text( 'Description cannot contain PHP tags.' );
                return false;
            } else
            {
                $( '#description' ).removeClass( 'border-red-500' );
                descriptionError.empty();
                return true;
            }
        }

        // Function to validate Type
        function validateType ()
        {
            var type = $( '#type' ).val();
            var typeError = $( '#typeError' );
            var htmlRegex = /<\/?[\w\s="/.':;#-\/\?]+>/gi;
            var sqlRegex = /\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/ig;
            var phpRegex = /<\?(php)?[\s\S]*?\?>/ig;
            console.log( type );

            if ( !type || type === '' )
            {
                $( '#type' ).addClass( 'border-red-500' );
                typeError.text( 'Type is required.' );
                return false;
            } else if ( htmlRegex.test( type ) )
            {
                $( '#type' ).addClass( 'border-red-500' );
                typeError.text( 'Type cannot contain HTML elements.' );
                return false;
            } else if ( sqlRegex.test( type ) )
            {
                $( '#type' ).addClass( 'border-red-500' );
                typeError.text( 'Type cannot contain SQL injection.' );
                return false;
            } else if ( phpRegex.test( type ) )
            {
                $( '#type' ).addClass( 'border-red-500' );
                typeError.text( 'Type cannot contain PHP tags.' );
                return false;
            } else
            {
                $( '#type' ).removeClass( 'border-red-500' );
                typeError.empty();
                return true;
            }
        }

        // Function to validate Status
        function validateStatus ()
        {
            var status = $( '#status' ).val();
            var statusError = $( '#statusError' );
            var htmlRegex = /<\/?[\w\s="/.':;#-\/\?]+>/gi;
            var sqlRegex = /\b(SELECT|INSERT INTO|UPDATE|DELETE FROM|DROP TABLE|CREATE TABLE|ALTER TABLE)\b/ig;
            var phpRegex = /<\?(php)?[\s\S]*?\?>/ig;
            console.log( status );

            if ( !status || status === '' )
            {
                $( '#status' ).addClass( 'border-red-500' );
                statusError.text( 'Status is required.' );
                return false;
            } else if ( htmlRegex.test( status ) )
            {
                $( '#status' ).addClass( 'border-red-500' );
                statusError.text( 'Status cannot contain HTML elements.' );
                return false;
            } else if ( sqlRegex.test( status ) )
            {
                $( '#status' ).addClass( 'border-red-500' );
                statusError.text( 'Status cannot contain SQL injection.' );
                return false;
            } else if ( phpRegex.test( status ) )
            {
                $( '#status' ).addClass( 'border-red-500' );
                statusError.text( 'Status cannot contain PHP tags.' );
                return false;
            } else
            {
                $( '#status' ).removeClass( 'border-red-500' );
                statusError.empty();
                return true;
            }
        }

        // Function to perform overall form validation
        function validateForm ()
        {
            // Call each individual validation function
            const isValidateBrandName = validateBrandName();
            const isValidateDescription = validateDescription();
            const isValidateType = validateType();
            const isValidateStatus = validateStatus();

            // Combine the results of individual validations
            return isValidateBrandName && isValidateDescription && isValidateType && isValidateStatus;
        }

        // Bind input event listeners to trigger validation functions
        $( '#brandName' ).on( 'input', validateBrandName );
        $( '#description' ).on( 'input', validateDescription );
        $( '#type' ).on( 'input', validateType );
        $( '#status' ).on( 'input', validateStatus );

        //////////////////// FORM SUBMIT  /////////////////////////
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

                        $( '#brandForm' ).trigger( 'reset' );
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
                        table.ajax.reload();
                    }
                } );
            } else
            {
                console.log( 'Form is not valid. Please fill out all required fields.' );
            }
        } );

        //////////////////// BRAND HIDE / UNHIDE OPERATIONS ///////////////////////
        // Function to delete the brands via AJAX with confirmation
        function handleBrandDelete ( brandId, buttonText )
        {
            // Determine the appropriate confirmation message and success message based on button text
            let confirmationMessage = '';
            let successMessage = '';
            if ( buttonText === 'Hide' )
            {
                confirmationMessage = 'You are about to hide this brand. Are you sure?';
                successMessage = 'Brand hidden successfully.';
            } else if ( buttonText === 'Unhide' )
            {
                confirmationMessage = 'You are about to unhide this brand. Are you sure?';
                successMessage = 'Brand unhidden successfully.';
            }

            // Show confirmation dialog using SweetAlert
            Swal.fire( {
                title: 'Are you sure?',
                text: confirmationMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, ' + buttonText + ' it!'
            } ).then( ( result ) =>
            {
                if ( result.isConfirmed )
                {
                    // If user confirms, proceed with brand deletion
                    $.ajax( {
                        url: '/../../backend/brands/brands-hide.php',
                        type: 'POST',
                        data: {
                            brandId: brandId,
                            status: buttonText
                        },
                        dataType: 'json',
                        success: function ( response )
                        {
                            // Reload the DataTable to reflect the changes
                            table.ajax.reload();

                            Swal.fire( {
                                icon: 'success',
                                title: 'Success!',
                                text: successMessage
                            } );

                            // Check if modal is currently shown
                            if ( !( $( '#modal-container' ).hasClass( 'hidden' ) ) )
                            {
                                // If modal is shown, close it
                                closeModal();
                            }
                        },
                        error: function ( xhr, status, error )
                        {
                            // Handle error response
                            Swal.fire( {
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to ' + buttonText.toLowerCase() + ' brand. Please try again later.'
                            } );
                            console.error( 'Error ' + buttonText.toLowerCase() + ' brand:', error );
                        }
                    } );
                }
            } );
        }

        // Event handler for brand deletion from the table's action column
        $( document ).on( 'click', '.delBtn', function ()
        {
            const buttonText = $( this ).text().trim(); // Get the text of the button
            const rowData = table.row( $( this ).closest( 'tr' ) ).data();
            const brandId = rowData.brand_id;
            handleBrandDelete( brandId, buttonText ); // Pass the button text to the function
        } );

        // Event handler for brand deletion from the modal form
        $( '#hideBrandBtn' ).on( 'click', function ()
        {
            const buttonText = $( this ).text().trim(); // Get the text of the button
            const brandId = $( '#brandForm' ).data( 'brandId' );
            handleBrandDelete( brandId, buttonText ); // Pass the button text to the function
        } );

        ///////////// DRAG AND DROP FOR UPLOAD BRANDS /////////////
        $( document ).on( 'click', '#addMultipleBrands', function ()
        {
            $( '#uploadBrandModal' ).toggleClass( 'hidden' );

            $( "#addBrandsDropdown" ).toggleClass( "transition-opacity opacity-100 ease-in-out duration-100" );
            $( "#addSingleBrand" ).toggleClass( "hidden" );
            $( "#addMultipleBrands" ).toggleClass( "hidden" );
        } );

        // Event handler for file input change
        $( '#dropzone-brand-file' ).on( 'change', function ( e )
        {
            e.preventDefault();
            e.stopPropagation();
            var files = e.target.files || e.originalEvent.dataTransfer.files;
            handleFiles( files );
        } );

        // Event handler for drop
        $( '#brand-dropzone-holder' ).on( 'drop', function ( e )
        {
            e.preventDefault();
            e.stopPropagation();
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

        // Event handler for drag over
        $( '#brand-dropzone-holder' ).on( 'dragover', function ( e )
        {
            e.preventDefault();
            e.stopPropagation();
            $( this ).addClass( 'dragover' );
        } );

        // Event handler for drag leave
        $( '#brand-dropzone-holder' ).on( 'dragleave', function ( e )
        {
            e.preventDefault();
            e.stopPropagation();
            $( this ).removeClass( 'dragover' );
        } );

        function handleFiles ( files )
        {
            var errors = [];

            if ( files.length > 0 )
            {
                var fileInput = files[0];
                var fileSize = fileInput.size; // Size in bytes
                var fileName = fileInput.name;
                var fileExtension = fileName.split( '.' ).pop().toLowerCase();
                var maxSizeInMb = 5;
                var maxSizeInBytes = 1024 * 1024 * maxSizeInMb; // 5 MB

                // Check file size
                if ( fileSize > maxSizeInBytes )
                {
                    errors.push( 'File size exceeds ' + maxSizeInMb + 'MB limit.' );
                }

                // Check file extension
                if ( fileExtension !== 'csv' && fileExtension !== 'xlsx' )
                {
                    errors.push( 'Please select a valid Excel file (.xlsx) or CSV file.' );
                }

                if ( errors.length === 0 )
                {
                    $( '#brand-file-name' ).text( 'File Name: ' + fileName ).addClass( 'underline underline-offset-4 font-bold' );
                    $( '#brand-uploadModalIconHolder' ).empty();

                    if ( fileExtension == 'csv' )
                    {
                        $( '#brand-uploadModalIconHolder' ).append( $( '<i>' ).addClass( 'text-3xl mb-3 fa-solid fa-file-csv text-green-500' ) );
                    } else if ( fileExtension == 'xlsx' )
                    {
                        $( '#brand-uploadModalIconHolder' ).append( $( '<i>' ).addClass( 'text-3xl mb-3 fa-solid fa-file-excel text-green-500' ) );
                    }
                } else
                {
                    if ( errors.length > 0 )
                    {
                        // Join the errors array elements into a single string with line breaks
                        var message = errors.join( '\n' );
                        Swal.fire( {
                            icon: 'error',
                            title: 'Error',
                            text: message
                        } );
                    } else
                    {
                        Swal.fire( {
                            icon: 'error',
                            title: 'Error',
                            text: errors
                        } );
                    }
                }
            } else
            {
                errors.push( 'No file selected.' );
            }

            return errors;
        }

        ////////////////// UPLOAD SUBMIT ///////////////////
        // Event handler for form submission
        $( '#uploadBrandForm' ).submit( function ( e )
        {
            e.preventDefault();
            var files = $( '#dropzone-brand-file' )[0].files; // Corrected line
            if ( files && files.length > 0 )
            {
                var errors = handleFiles( files ); // Removed stray 'e'

                if ( errors.length === 0 )
                {
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
                                url: '/../../backend/brands/brands-upload.php',
                                type: 'POST',
                                data: formData,
                                dataType: 'json',
                                processData: false,
                                contentType: false,
                                success: function ( response )
                                {
                                    processingDialog.close();
                                    if ( response.success )
                                    {
                                        console.log( response.success );
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

                                            table.ajax.reload();

                                            closeUploadBrandModal();
                                        } );
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
                                    // Handle error response
                                    Swal.close(); // Close the processing dialog
                                    Swal.fire( {
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Failed to upload file. Please try again later.'
                                    } );
                                    console.error( 'Error uploading file:', error );
                                }
                            } );
                        }
                    } );
                }
            } else
            {
                Swal.fire( {
                    icon: 'error',
                    title: 'Error!',
                    text: 'No file selected.'
                } );
            }
        } );

        ////////////////////// CLOSE MODAL /////////////////////////////

        // Click event handler for closing the modal
        $( '#closeUploadBrandModal, #cancelUploadBrandModal' ).on( 'click', function ()
        {
            closeUploadBrandModal();
        } );

        function closeUploadBrandModal ()
        {
            // Reset the form by triggering a reset event
            $( '#uploadBrandForm' )[0].reset();

            // Clear the file name display
            $( '#brand-file-name' ).text( '' );
            $( '#brand-uploadModalIconHolder' ).empty();
            $( '#brand-uploadModalIconHolder' ).append( $( '<i>' ).addClass( 'fa-solid fa-file-arrow-up text-3xl mb-3 text-zinc-300' ) );

            $( '#uploadBrandModal' ).toggleClass( 'hidden' );
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

            // Clear catalog lists and upload field
            $( '#uploadedCatalogList' ).empty(); // Clear previous files
            $( '#catalogList' ).empty(); // Clear previous files
            $( '#brandCatalogs' ).val( '' );

            // Clear brands image lists and upload field
            $( '#loadBrandImages' ).empty(); // Clear previous files
            $( '#brandImageList' ).empty(); // Clear previous files
            $( '#brandImages' ).val( '' );

            // Hide the modal
            $( '#modal-container' ).toggleClass( 'hidden' );

            // Disable drag and drop for the brand logo
            disableDragAndDrop();
        }

        ////////////////// USER CREATION DROPDOWN ///////////////
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