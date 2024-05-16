<?php
$is_public_page = true;
$pageTitle = "Brands";
ob_start();
?>
<!-- Your page content goes here -->
<div class="flex">
    <!-- Vertical Slider of Brand Logos -->
    <div class="w-1/4 p-0 fade-in-hidden">
        <div class="flex justify-center items-center h-screen bg-gray-100">
            <div id="verticalCarousel" class="h-full w-full overflow-y-scroll snap-y snap-mandatory overflow-x-hidden">
                <!-- Repeat this section for each card in the cards array -->
            </div>
        </div>
    </div>
    <div id="brandDetails"
        class="w-3/4 overflow-y-scroll max-h-screen relative flex justify-center items-center fade-in-hidden">
        <!-- Brand Logo will be set as background here -->
        <div id="brandLogo" class="relative h-full w-full">
            <div id="brandDetailsBackground" class="top-0 left-0 w-full w-fit bg-contain bg-center bg-no-repeat">
                <div class="absolute top-0 left-0 w-full h-full bg-white opacity-90"></div>
                <!-- Content inside the brand details section -->
                <div class="flex flex-col items-center relative z-10 mx-4 ">
                    <h2 id="brandName" class="text-center text-5xl font-extrabold mb-2 mt-24 text-black ">Brand Name
                    </h2>
                    <p id="brandDescription" class="text-center text-lg text-black mb-4">Brand Description</p>
                    <hr id="separatorLine" class=" border-1 border-zinc-900 w-full">
                    <!-- Catalog Listing -->
                    <div class="mt-5 mb-8">
                        <h3 id="catalogListHeader" class="text-xl font-bold mb-4 text-black">Catalogs</h3>
                        <div id="catalogList" class="flex flex-wrap gap-4 mb-8"></div>

                        <div id="inquirySection" class="relative mt-4">
                            <img src="../assets/image/customizebanner.png" class="w-full h-60 object-cover">
                            <div class="absolute inset-0 bg-black opacity-50"></div>

                            <div class="absolute inset-0 flex items-center justify-center">
                                <p class="text-[#F6E381] font-extrabold text-3xl text-center">CUSTOMIZE PRODUCTS <br>
                                    <span class="text-white text-lg font-normal">Many of our products can be
                                        customized to the
                                        requirements
                                        of our clients.<br> These may include the dimensions, colors, textures, and
                                        materials used in the
                                        item.</span><br>
                                    <span class="text-white text-xl font-semibold block mt-6"> For Inquiries:
                                        <a href="/public/contact.php"
                                            class="group bg-gray-50 text-black py-2 px-6 rounded-full hover:bg-gray-200 inline-flex items-center transition-all ease-in-out duration-300">
                                            Contact us here!
                                            <span
                                                class="inline-block ml-2 transition-transform ease-in-out duration-300 group-hover:translate-x-2">►</span>
                                        </a>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();
ob_start();
?>

<!-- Your javascript here -->
<script>
    $( document ).ready( function ()
    {
        // Function to update Brand Details Container
        function updateBrandDetails ( brand )
        {
            console.log( "Updating Brand Details for brand:", brand.brand_name );
            // Update brand details in Brand Details Container
            $( '#brandDetailsBackground' ).css( 'background-image', `url(${ brand.logo_url })` );
            $( '#brandName' ).text( brand.brand_name );
            $( '#brandDescription' ).text( brand.description ).addClass( 'text-justify' );
        }

        // Function to update catalog listing based on brand details
        function updateCatalogListing ( brand )
        {
            console.log( "Updating catalog listing for brand:", brand.brand_name );

            // Clear previous catalog listing
            $( '#catalogList' ).empty();

            // Create a container for the catalog buttons
            var catalogContainer = $( '<div>', {
                class: 'flex flex-wrap justify-center gap-4'
            } );

            // Display catalogs for the selected brand
            brand.catalogs.forEach( function ( catalog )
            {
                var catalogButton = $( '<a>', {
                    class: 'bg-yellow-500 text-white px-4 py-2 rounded-full cursor-pointer hover:bg-yellow-600 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105',
                    text: catalog.catalog_title,
                    href: `../../backend/brands/catalog-download.php?catalogId=${ catalog.catalog_id }`,
                    download: `${ catalog.catalog_title }.pdf`
                } );

                // Tooltip for additional information
                var tooltip = $( '<span>', {
                    class: 'tooltip-text bg-gray-800 text-white text-xs rounded-lg py-1 px-2 absolute z-10 hidden',
                    text: `Download ${ catalog.catalog_title }`
                } );

                // Wrapper for the button and tooltip
                var wrapper = $( '<div>', {
                    class: 'relative group'
                } );

                wrapper.append( catalogButton );
                wrapper.append( tooltip );

                // Show tooltip on hover
                wrapper.hover(
                    function ()
                    {
                        $( this ).find( '.tooltip-text' ).removeClass( 'hidden' ).addClass( 'block' );
                    },
                    function ()
                    {
                        $( this ).find( '.tooltip-text' ).removeClass( 'block' ).addClass( 'hidden' );
                    }
                );

                catalogContainer.append( wrapper );
            } );

            // Append the catalog container to the catalog list
            $( '#catalogList' ).append( catalogContainer );
        }

        // AJAX call to fetch brand data
        $.ajax( {
            url: '../../backend/brands/brands-get-guest.php',
            type: 'GET',
            success: function ( response )
            {
                console.log( "Response received:", response );
                if ( response )
                {
                    // Iterate over each brand object in the response
                    response.forEach( function ( brand )
                    {
                        var brandName = brand.brand_name;
                        var logoUrl = brand.logo_url;
                        var description = brand.description;
                        var type = brand.type;
                        var catalogs = brand.catalogs; // Extract catalogs array from brand object

                        console.log( "Processing brand:", brandName );

                        // Create a section for each brand
                        var section = $( '<section>' )
                            .addClass( 'carousel-item h-[500px] max-w-[950px] snap-center overflow-hidden' +
                                'flex flex-col items-center justify-center transition-transform transform hover:scale-105 hover:bg-gradient-to-t from-zinc-100 via-yellow-200 to-zinc-100' );

                        // Add data attributes to store brand data
                        section.data( 'brandName', brandName );
                        section.data( 'logoUrl', logoUrl );
                        section.data( 'description', description );
                        section.data( 'type', type );
                        section.data( 'catalogs', JSON.stringify( catalogs ) );  // Store catalogs as a JSON string

                        // Add the brand name above the logo
                        var brandNameDiv = $( '<div>' )
                            .addClass( 'text-center text-2xl font-semibold !-mb-6' );
                        brandNameDiv.text( brandName );

                        // Add the brand logo to the section
                        var img = $( '<img>' )
                            .addClass( 'bg-cover bg-no-repeat object-contain lg:max-h-[700px] sm:max-h-[500px] mx-auto' );
                        img.attr( 'src', logoUrl );

                        // Create a wrapper div for the content
                        var contentWrapper = $( '<div>' )
                            .addClass( 'flex flex-col items-center justify-center w-full h-full' );

                        // Append the brand name and image to the wrapper
                        contentWrapper.append( brandNameDiv );
                        contentWrapper.append( img );

                        // Append the wrapper to the section
                        section.append( contentWrapper );

                        // Append the section to the vertical carousel
                        $( '#verticalCarousel' ).append( section );

                        console.log( "Brand", brandName, "added to carousel" );
                    } );

                    // Function to update brand information when hovering over or clicking on a slide
                    function updateBrandInformation ( slideIndex )
                    {
                        // Extract brand data from the specified slide's data attributes
                        var brand = {
                            brand_name: $( `#verticalCarousel .carousel-item:eq(${ slideIndex })` ).data( 'brandName' ),
                            logo_url: $( `#verticalCarousel .carousel-item:eq(${ slideIndex })` ).data( 'logoUrl' ),
                            description: $( `#verticalCarousel .carousel-item:eq(${ slideIndex })` ).data( 'description' ),
                            type: $( `#verticalCarousel .carousel-item:eq(${ slideIndex })` ).data( 'type' ),
                            catalogs: JSON.parse( $( `#verticalCarousel .carousel-item:eq(${ slideIndex })` ).data( 'catalogs' ) )
                        };

                        // Show or hide catalog list and header based on brand type
                        if ( brand.type === 'inquiry' )
                        {
                            $( '#catalogList' ).addClass( 'hidden' );
                            $( '#catalogListHeader' ).addClass( 'hidden' );
                        } else
                        {
                            $( '#catalogList' ).removeClass( 'hidden' );
                            $( '#catalogListHeader' ).removeClass( 'hidden' );
                        }

                        // Update Brand Details Container and Catalog Listing
                        updateBrandDetails( brand );
                        updateCatalogListing( brand );
                    }

                    // Function to handle scroll events and detect carousel snaps
                    function handleCarouselSnap ()
                    {
                        // Calculate the height of each slide including padding and border
                        const slideHeight = $( '#verticalCarousel .carousel-item' ).outerHeight();
                        console.log( 'Slide Height:', slideHeight );

                        // Determine the current scroll position
                        const scrollTop = $( '#verticalCarousel' ).scrollTop();
                        console.log( 'Scroll Top:', scrollTop );

                        // Calculate the index of the currently visible slide
                        const visibleSlideIndex = Math.round( scrollTop / slideHeight );
                        console.log( 'Visible Slide Index:', visibleSlideIndex );

                        // Update brand information when the carousel snaps to a new slide
                        updateBrandInformation( visibleSlideIndex );
                    }


                    // Listen for scroll events on the vertical carousel
                    $( '#verticalCarousel' ).on( 'scroll', function ()
                    {
                        // Handle carousel snap when scrolling stops
                        clearTimeout( $.data( this, 'scrollTimer' ) );
                        $.data( this, 'scrollTimer', setTimeout( function ()
                        {
                            handleCarouselSnap();
                        }, 50 ) ); // Adjust this timeout value as needed for smooth snapping
                    } );
                }

                // On load functions
                handleCarouselSnap();
            },
            error: function ( xhr, status, error )
            {
                console.error( "Error fetching brands:", error );
            }
        } );
    } );
</script>

<?php
$script = ob_get_clean();
include ("../public/master.php");
?>