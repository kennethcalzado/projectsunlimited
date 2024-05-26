<?php
$is_public_page = true;
$pageTitle = "Brands";
ob_start();
?>
<head>
<link rel="icon" href="../assets/image/PUlogo.png" type="image/png">
</head>
<style>
    #brandsImagesSection img {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    /* Media query for mobile devices */
    @media screen and (max-width: 768px) {
        #brandsContainer{
            flex-direction: column;
			align-items: center;
            margin: 0 !important;
            padding: 0 !important;
        }

        #brandVerticalCarousel {
			margin: 0 !important;
            padding: 0 !important;
        }

        #verticalCarouselContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto !important;
        }

        #verticalCarousel {
            display: flex;
            flex-direction: row;
            overflow-x: scroll;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            white-space: nowrap;
            width: 100% !important;
            min-width: 350px !important;
            padding: 20px !important;
            padding-top: 20px !important;
            margin-left: 5% !important;
			margin-right: 5% !important;
        }

        .carousel-item {
            flex: 0 0 auto;
            width: 100%;
            max-width: 100%;
            scroll-snap-align: center;
            margin: 0 auto;
            margin-left: 10px !important;
            margin-right: 10px !important;
        }

        .carousel-item>div {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section .text-2xl {
            margin-top: 15px !important;
            margin-bottom: 10px;
            font-size: 35px;
            padding: 0 !important;
        }

        .carousel-item-title .text-2xl {
            margin-top: 15px !important;
            margin-bottom: 10px;
            font-size: 35px;
        }

        .carousel-item-image {
            width: 250px !important;
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 10px !important;
        }

        #brandDetails {
            flex-wrap: nowrap;
            width: 100%;
            height: auto;
            padding-top: 10px !important;
            margin-top: 0.25rem !important;
            box-sizing: border-box;
            overflow-y: visible;
            max-height: none;
			max-width: none;
        }

        #brandDetails .relative {
            height: auto;
        }

        #brandDetails .relative .h-full {
            height: auto;
        }

        #brandDetailsBackground {
            background-size: contain;
            width: 100%;
            height: auto;
            margin-top: 0px !important;
            min-height: 100vh;
        }

        #brandInfoOverlay {
            height: auto;
            min-height: 100%;
            position: absolute;
            left: 0;
            width: 100%;
            background-color: rgba(244, 244, 252, 0.9);
            z-index: -10;
        }

        #brandsInfo {
			margin: 0 !important;
            position: abosolute;
            z-index: 10;
        }

        #brandsImagesHeader {
            margin-top: 5px;
        }

		#brandsImagesSection {
			margin-bottom:0.75rem !important;
		}

        #brandsImagesSection img {
            max-width: 120px;
            max-height: 120px;
            min-width: 100px;
            min-height: 100px;
            width: auto;
            height: auto;
            background-size: contain;
        }

        .grid-cols-4 {
            grid-template-columns: repeat(2, 1fr);
        }

        #brandName {
            font-size: 2.5rem;
            margin-top: 20px;
        }

        #brandDescription {
            font-size: 1rem;
            text-align: justify;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        #catalogListHeader,
        #brandsImagesHeader {
            font-size: 1.25rem;
			margin-left: 1rem;
        }
		
		#catalogList {
			gap: 0.75rem
		}

        #catalogList a {
            padding: 0.25rem !important;
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            /* Limit the width to 100% of its container */
            display: inline-block;
            /* Ensure the button behaves like a block element */
            box-sizing: border-box;
            /* Include padding and border in the total width */
            width: 250px;
        }

        #inquirySection {
            flex-direction: column !important;
            padding-bottom: 2rem !important;
			margin-bottom: 0 !important;
        }

        #inquirySection img,
        #overlayinquirySection {
            height: 100% !important;
            object-fit: cover !important;
        }

        #inquirySection p {
            font-size: 1rem;
            margin-top: 1rem;
            padding: 1rem !important;
            text-align: center;
            /* Center align the text */
            display: block;
            /* Ensure block-level display */
        }

        #inquirySection .text-3xl {
            font-size: 1.5rem !important;
            /* Adjust font size */
        }

        #inquirySection .text-lg {
            font-size: 0.875rem !important;
            /* Adjust font size */
        }

        #inquirySection .text-xl {
            font-size: 1rem !important;
            /* Adjust font size */
        }

        #inquirySection .mt-8 {
            margin-top: 1rem;
            /* Adjust margin */
        }

        #inquirySection .bg-[#F6E381]/80 {
            background-color: rgba(246, 227, 129, 0.8);
        }

        #inquirySection a {
            display: inline-flex;
            align-items: center;
            background-color: #f6f6f6;
            color: #000;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        #inquirySection a:hover {
            background-color: #e0e0e0;
        }

        #inquirySection a span {
            transition: transform 0.3s ease-in-out;
        }

        #inquirySection a:hover span {
            transform: translateX(0.5rem);
        }

        /* Adjust spacing and layout for smaller screens */
        #inquirySection .text-center {
            text-align: center;
        }

        /* Adjustments for the specific span element */
        #inquirySection span.bg-[#F6E381]/80 {
            padding: 0.25rem;
            /* Reduce padding for smaller height */
            line-height: 1;
            /* Adjust line height for more compact appearance */
        }

        #inquirySection.flex {
            flex-direction: column !important;
        }

		#callToActionWrapper{
			margin-bottom: 0!imporant;
		}

        .tooltip-text {
            display: none;
        }

        .w-1/4,
        .w-3/4 {
            width: 100%;
        }

        .bg-contain {
            background-size: contain;
        }

        .bg-center {
            background-position: center;
        }

        .bg-no-repeat {
            background-repeat: no-repeat;
        }

        .fade-in {
            animation: fade-in 0.2s ease forwards;
        }
    }
</style>

<!-- Your page content goes here -->
<div id="brandsContainer" class="flex">
    <!-- Vertical Slider of Brand Logos -->
    <div id="brandVerticalCarousel" class="w-1/4 p-0 fade-in-hidden">
        <div id="verticalCarouselContainer" class=" flex justify-center items-center h-screen bg-gray-100">
            <div id="verticalCarousel" class="h-full w-full overflow-y-scroll snap-y snap-mandatory overflow-x-hidden">
                <!-- Repeat this section for each card in the cards array -->
            </div>
        </div>
    </div>

    <div id="brandDetails"
        class="w-3/4 overflow-y-scroll max-h-screen relative flex justify-center items-center fade-in-hidden">
        <!-- Brand Logo will be set as background here -->
        <div class="relative h-full w-full">
            <div id="brandDetailsBackground"
                class="top-0 left-0 w-full w-full bg-contain bg-center bg-no-repeat">
                <!--Overlay-->
                <div id="brandInfoOverlay"
                    class="absolute top-0 left-0 w-full h-full bg-[#f4f4fc] opacity-90"></div>

                <!-- Content inside the brand details section -->
                <div id="brandsInfo" class="flex flex-col items-center relative z-10 mx-4 ">
                    <h3 id="brandsImagesHeader" class="text-xl font-bold mb-2 text-black mt-12"></h3>
                    <div id="brandsImagesSection" class="hidden mb-10"></div>

                    <h2 id="brandName" class="text-center text-5xl font-extrabold mb-2 text-black ">Brand Name
                    </h2>
                    <p id="brandDescription" class="text-center text-lg text-black mb-4">Brand Description</p>
                    <hr id="separatorLine" class=" border-1 border-zinc-900 w-full">
                    <!-- Catalog Listing -->
                    <div class="mt-5 mb-4">
                        <h3 id="catalogListHeader" class="text-xl font-bold mb-4 text-black">Catalogs</h3>
                        <div id="catalogList" class="flex flex-wrap justify-center gap-4 mb-8"></div>
                    </div>
                    <div id="inquirySection" class="relative mt-2 mb-2 w-full">
                        <img src="../assets/image/customizebanner.png"
                            class="absolute w-screen h-full object-cover -z-10">
                        <div id="overlayinquirySection"
                            class="absolute top-0 left-0 w-full h-full bg-black bg-contain bg-center bg-no-repeat opacity-50">
                        </div>

                        <div id="callToActionWrapper" class="flex relative items-center justify-center mb-4">
                            <p class="text-[#F6E381] font-extrabold text-3xl text-center mt-8">
                                The possibilities are
                                <span class="text-amber-900 bg-[#F6E381]/80 p-1 rounded-md">unlimited</span>. <br>
                                <span class="text-white text-lg font-normal">Whatever concept or aesthetics you are
                                    planning we can build and help design with you. <br> These may include the
                                    dimensions, colors, textures, and materials used in the item. <br> Get in touch
                                    now to schedule measurement and layouting for <strong>free</strong>!</span><br>
                                <span class="text-white text-xl font-semibold block mt-6">For Inquiries:
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
            $( '#brandDetailsBackground' )
                .css( 'background-image', `url(${ brand.logo_url })` )
                .addClass( 'fade-in' )
                .removeClass( 'fade-out' );
            $( '#brandName' )
                .text( brand.brand_name )
                .addClass( 'fade-in' )
                .removeClass( 'fade-out' );
            $( '#brandDescription' )
                .text( brand.description )
                .addClass( 'fade-in' )
                .removeClass( 'fade-out' )
                .addClass( 'text-justify' );
        }

        // Function to update catalog listing based on brand details
        function updateCatalogListing ( brand )
        {
            console.log( "Updating catalog listing for brand:", brand.brand_name );

            // Clear previous catalog listing
            $( '#catalogList' ).empty().addClass( 'fade-in' ).removeClass( 'fade-out' );

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
                } );

                // Add click event listener to open catalog in new tab
                catalogButton.on('click', function() {
                    var url = `../../backend/brands/catalog-open.php?catalogId=${catalog.catalog_id}`;
                    window.open(url, '_blank');
                });

                // Tooltip for additional information
                var tooltip = $( '<span>', {
                    class: 'tooltip-text bg-gray-800 text-white text-xs rounded-lg py-1 px-2 absolute z-10 hidden',
                    text: `Open ${ catalog.catalog_title }`
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

                //catalogContainer.append( wrapper );
				$( '#catalogList' ).append( wrapper );
            } );

            // Append the catalog container to the catalog list
            //$( '#catalogList' ).append( catalogContainer );
        }

        function updateBrandImages ( brand )
        {
            console.log( "Updating brand images for brand:", brand.brand_name );
            console.log( brand );

            var images = brand.images;
            console.log( images );
            // Check if there are images for the brand
            if ( images && images.length > 0 )
            {
                // Show the brandsImagesSection
                $( '#brandsImagesSection' ).show().addClass( 'fade-in' ).removeClass( 'fade-out' );

                // Clear previous images
                $( '#brandsImagesSection' ).empty();

                // Determine the number of images to display (maximum 4)
                var numImages = Math.min( images.length, 4 );

                // Calculate even spacing between images
                var spacing = 4; // Change this value as needed for spacing between images

                // Create a container for the images
                var imagesContainer = $( '<div>' ).addClass( 'grid grid-cols-' + numImages + ' justify-items-center gap-4' );

                // Loop through the images and create image elements
                for ( var i = 0; i < numImages; i++ )
                {
                    var imageUrl = images[i];

                    // Create a wrapper for the image and the zoom button
                    var imageWrapper = $( '<div>' ).addClass( 'relative group' );

                    // Create image element
                    var imageElement = $( '<img>' ).attr( 'src', imageUrl )
                        .addClass( 'h-48 w-56 shadow-md rounded-md transition-transform transform group-hover:scale-105 group-hover:shadow-lg' );

                    // Create zoom-in button
                    var zoomButton = $( '<button>' ).addClass( 'absolute top-0 right-0 bg-gray-800 text-white px-2 py-1 rounded-full text-xs opacity-0 group-hover:opacity-100 transition-opacity' );
                    zoomButton.append( $( '<i>' ).addClass( 'fas fa-search-plus' ) );

                    // Add click event to the zoom button
                    zoomButton.click( ( function ( imageUrl, i )
                    {
                        return function ()
                        {
                            // Trigger SweetAlert popup with full-size image
                            Swal.fire( {
                                imageUrl: imageUrl,
                                imageAlt: brand.brand_name + ' ' + i,
                                text: brand.brand_name + ' SAMPLE ' + ( i + 1 ),
                                showCloseButton: true,
                                showConfirmButton: false,
                                customClass: {
                                    image: 'object-contain max-h-[70vh]'
                                },
                                padding: '1em',
                            } );

                        };
                    } )( imageUrl, i ) );
                    // Append zoom button to the image wrapper
                    imageWrapper.append( imageElement );
                    imageWrapper.append( zoomButton );

                    // Append image wrapper to the container
                    imagesContainer.append( imageWrapper );
                }

                // Append images container to brandsImagesSection
                $( '#brandsImagesSection' ).append( imagesContainer );
            } else
            {
                // Hide the brandsImagesSection if there are no images
                $( '#brandsImagesSection' ).hide().addClass( 'fade-out' ).removeClass( 'fade-in' );
            }
        }

        // Calculate the height of the content and set the height of the overlay
        function adjustOverlayHeight ()
        {
            var brandDetailsHeight = $( '#brandDetailsBackground' ).height();
            $( '#brandInfoOverlay' ).height( brandDetailsHeight );
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
                        var images = brand.images;

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
                        section.data( 'images', JSON.stringify( images ) );  // Store catalogs as a JSON string

                        // Add the brand name above the logo
                        var brandNameDiv = $( '<div>' )
                            .addClass( 'carousel-item-title text-center text-2xl font-semibold mb-1' );
                        brandNameDiv.text( brandName );

                        // Add the brand logo to the section
                        var img = $( '<img>' )
                            .addClass( 'carousel-item-image bg-cover bg-no-repeat object-contain  mx-auto' );
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
                            catalogs: JSON.parse( $( `#verticalCarousel .carousel-item:eq(${ slideIndex })` ).data( 'catalogs' ) ),
                            images: JSON.parse( $( `#verticalCarousel .carousel-item:eq(${ slideIndex })` ).data( 'images' ) )
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
                        updateBrandImages( brand );
                        adjustOverlayHeight();
                    }

                    // Function to handle scroll events and detect carousel snaps
                    function handleCarouselSnap ()
                    {
                        // Calculate the height of each slide including padding and border
                        const slideHeight = $( '#verticalCarousel .carousel-item' ).outerHeight();
                        // console.log( 'Slide Height:', slideHeight );

                        // Determine the current scroll position
                        const scrollTop = $( '#verticalCarousel' ).scrollTop();
                        // console.log( 'Scroll Top:', scrollTop );

                        // Calculate the index of the currently visible slide
                        const visibleSlideIndex = Math.round( scrollTop / slideHeight );
                        // console.log( 'Visible Slide Index:', visibleSlideIndex );

                        // Update brand information when the carousel snaps to a new slide
                        updateBrandInformation( visibleSlideIndex );
                    }

                    // Function to handle swipe events and detect carousel snaps
                    function handleCarouselSwipe ()
                    {
                        // Calculate the width of each slide including padding and border
                        const slideWidth = $( '#verticalCarousel .carousel-item' ).outerWidth();
                        console.log( 'Slide Width:', slideWidth );

                        // Determine the current scroll position
                        const scrollLeft = $( '#verticalCarousel' ).scrollLeft();
                        console.log( 'Scroll Left:', scrollLeft );

                        // Calculate the index of the currently visible slide
                        const visibleSlideIndex = Math.round( scrollLeft / slideWidth );
                        console.log( 'Visible Slide Index:', visibleSlideIndex );

                        // Update brand information when the carousel snaps to a new slide
                        updateBrandInformation( visibleSlideIndex );
                    }

                    // Function to check if the screen width is within the mobile range
                    function isMobileView ()
                    {
                        return window.matchMedia( "(max-width: 768px)" ).matches;
                    }

                    // Listen for scroll events on the vertical carousel
                    $( '#verticalCarousel' ).on( 'scroll click', function ()
                    {
                        // Handle carousel snap when scrolling stops
                        clearTimeout( $.data( this, 'scrollTimer' ) );
                        $.data( this, 'scrollTimer', setTimeout( function ()
                        {
                            handleCarouselSnap();
                            if ( isMobileView() )
                            {
                                handleCarouselSwipe();
                            }
                        }, 50 ) ); // Adjust this timeout value as needed for smooth snapping
                    } );
                }

                // On load functions
                handleCarouselSnap();
                if ( isMobileView() )
                {
                    handleCarouselSwipe();
                }
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