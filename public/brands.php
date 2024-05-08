<?php

$pageTitle = "Brands";
ob_start();
?>
<!-- Your page content goes here -->
<div class="flex">
    <!-- Vertical Slider of Brand Logos -->
    <div class="w-1/3 p-0">
        <div class="flex justify-center items-center h-screen bg-gray-300">
            <div id="verticalCarousel" class="h-full w-full overflow-y-scroll snap-y snap-mandatory no-scrollbar">
                <!-- Repeat this section for each card in the cards array -->
            </div>
        </div>
    </div>
    <div class="w-2/3 p-4">
        <!-- Brand Details Container -->
        <div class="mb-8">
            <img id="brandLogo" src="" alt="Brand Logo" class="mx-auto d-block h-full w-[90%] mb-4">
            <h2 id="brandName" class="text-center text-2xl font-bold mb-2">Brand Name</h2>
            <p id="brandDescription" class="text-center text-lg mb-4">Brand Description</p>
        </div>
        <!-- Catalog Listing -->
        <div>
            <h3 class="text-xl font-bold mb-4">Catalogs</h3>
            <div id="catalogList" class="flex flex-wrap gap-4"></div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();
ob_start();
?>
<!-- Your javascript here -->
<script>
    $(document).ready(function() {
        // Function to update Brand Details Container
        function updateBrandDetails(brand) {
            console.log("Updating Brand Details for brand:", brand.brand_name);
            // Update brand details in Brand Details Container
            $('#brandLogo').attr('src', brand.logo_url);
            $('#brandName').text(brand.brand_name);
            $('#brandDescription').text(brand.description);
        }

        // Function to update catalog listing based on brand details
        function updateCatalogListing(brand) {
            console.log(brand);
            console.log("Updating catalog listing for brand:", brand.brand_name);
            // Clear previous catalog listing
            $('#catalogList').empty();

            // Display catalogs for the selected brand
            brand.catalogs.forEach(function(catalog) {
                var catalogButton = $('<button>').addClass('bg-blue-500 text-white px-4 py-2 rounded');
                catalogButton.text(catalog.catalog_title);
                catalogButton.on('click', function() {
                    console.log("Catalog button clicked for catalog:", catalog.catalog_title);
                    // Handle catalog button click (e.g., download PDF)
                });
                $('#catalogList').append(catalogButton);
            });
        }

        // AJAX call to fetch brand data
        $.ajax({
            url: '../../backend/brands/brands-get-guest.php',
            type: 'GET',
            success: function(response) {
                console.log("Response received:", response);
                if (response) {
                    // Iterate over each brand object in the response
                    response.forEach(function(brand) {
                        var brandName = brand.brand_name;
                        var logoUrl = brand.logo_url;
                        var description = brand.description;
                        var type = brand.type;
                        var catalogs = brand.catalogs; // Extract catalogs array from brand object

                        console.log("Processing brand:", brandName);

                        // Create a section for each brand
                        var section = $('<section>').addClass('carousel-item h-[500px] max-w-[900px] snap-center');

                        // Add data attributes to store brand data
                        section.attr('data-brand-name', brandName);
                        section.attr('data-logo-url', logoUrl);
                        section.attr('data-description', description);
                        section.attr('data-type', type);
                        section.attr('data-catalogs', JSON.stringify(catalogs));

                        // Add the brand logo to the section
                        var img = $('<img>').addClass('bg-cover bg-no-repeat object-contain w-full h-full lg:max-h-[700px] sm:max-h-[500px] max-h-[400px]');
                        img.attr('src', logoUrl);

                        // Add the brand name below the logo
                        var brandNameDiv = $('<div>').addClass('text-center mt-4 text-xl font-semibold');
                        brandNameDiv.text(brandName);

                        // Append the logo and brand name to the section
                        section.append(brandNameDiv);
                        section.append(img);

                        // Append the section to the vertical carousel
                        $('#verticalCarousel').append(section);

                        console.log("Brand", brandName, "added to carousel");

                        // Click event handler for brand carousel item
                        section.on('click', function() {
                            // Extract brand data from the clicked item's data attributes
                            var brand = {
                                brand_name: $(this).attr('data-brand-name'),
                                logo_url: $(this).attr('data-logo-url'),
                                description: $(this).attr('data-description'),
                                type: $(this).attr('data-type'),
                                catalogs: JSON.parse($(this).attr('data-catalogs'))
                            };

                            // Update Brand Details Container and Catalog Listing
                            updateBrandDetails(brand);
                            updateCatalogListing(brand);
                        });
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching brands:", error);
            }
        });
    });
</script>

<?php
$script = ob_get_clean();
include ("../public/master.php");
?>