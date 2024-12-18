<?php
session_start();
$pageTitle = "Variations";
ob_start();
?>

<head>
    <link rel="stylesheet" href="../../../assets/input.css">
    <style>
        .btn {
            font-size: 14px;
            vertical-align: center;
            padding: 5px 20px !important;
        }

        .btn-pagination {
            padding: 4px 16px;
            margin: 0 2px;
            border-radius: 5px;
        }

        .btn-pagination:hover {
            text-decoration: underline;
        }

        .active {
            background-color: #F6E17A;
            color: black;
            border: none;
            padding: 4px 16px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: underline;
        }

        .item-count {
            margin-right: auto;
            font-size: 16px;
            color: gray;
        }

        .btn-reactivate {
            background-color: #10B981;
            color: black;
            border: none;
            padding: 5px 20px !important;
            cursor: pointer;
            border-radius: 5px;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20 mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-4xl font-bold mb-2 ml-2 mt-8 text-black">Variations</h1>
        <div class="flex justify-end">
        </div>
    </div>
    <div class="border-b border-black flex-grow border-4 mt-2 mb-3"></div>
    <div class="flex flex-col sm:flex-row items-center justify-center">
        <div class="flex flex-col sm:flex-row justify-between mb-4 sm:mb-0">
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="availFilter" class="mr-2">Availability:</label>
                <select id="availFilter" class="border rounded-md px-2 py-1">
                    <option value="availreset">Availability</option>
                    <!-- Add your availability options here -->
                </select>
            </div>
            <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                <label for="statusFilter" class="mr-2">Status</label>
                <select id="statusFilter" class="border rounded-md px-2 py-1">
                    <option value="statusreset">Status</option>
                    <!-- Add your status options here -->
                </select>
            </div>
            <div class="flex justify-between">
                <div class="relative mb-1 mt-2 sm:mb-0 sm:mr-2">
                    <!-- Search input -->
                    <div class="relative">
                        <input class="border-2 border-gray-300 bg-white h-10 w-64 px-2 pr-10 mt-4 sm:!mt-0 rounded-lg text-[16px] focus:outline-none" type="text" name="search" placeholder="Search" id="searchInput">
                        <button type="submit" class="absolute right-0 top-0 mt-7 mr-4 sm:mt-3">
                            <svg class="text-gray-600 h-5 w-5 fill-current hover:text-gray-500 " xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                                <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto mb-1 rounded-lg mt-4">
        <table id="variation" class="display w-full  ">
            <thead class="">
                <tr>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Variation
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Variation Image
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Availability
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 w-1/12">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody id="variationlisting">
                <!-- Content will be loaded dynamically using JavaScript -->
            </tbody>
        </table>
        <div class="pagination-container mt-4">
            <div id="itemCount" class="item-count"></div>
            <div id="pagination" class="flex justify-end"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var itemsPerPage = 10;
        var currentPage = 1;

        function fetchVariationData() {
            var selectedStatus = $('#statusFilter').val();
            var selectedAvailability = $('#availFilter').val();
            var searchQuery = $('#searchInput').val(); // Get the search query

            $.ajax({
                url: '../../../backend/variation/fetchvariation.php',
                method: 'GET',
                dataType: 'json',
                data: {
                    page: currentPage,
                    itemsPerPage: itemsPerPage,
                    status: selectedStatus,
                    availability: selectedAvailability,
                    searchQuery: searchQuery // Include search query in the data object
                },
                success: function(response) {
                    if (response.status === 'success') {
                        if (response.data.length === 0) {
                            // No variations found for the selected filters
                            $('#variationlisting').html('<tr><td colspan="5" class="text-center font-bold text-red-800">No Variation Found</td></tr>');
                            $('#pagination').empty();
                            $('#itemCount').empty();
                        } else {
                            populateVariationTable(response.data);
                            generatePagination(response.totalPages, response.totalItems);
                        }
                    } else {
                        console.error('Error fetching data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function populateVariationTable(variations) {
            var tableBody = $('#variationlisting');
            tableBody.empty();

            if (variations.length === 0) {
                tableBody.html('<tr><td colspan="5" class="text-center font-bold text-red-800">No Variations Found</td></tr>');
                return;
            }

            // Populate table with variations
            $.each(variations, function(index, variation) {
                var imageURL = '../../../assets/variations/' + variation.image_url;
                var row = '<tr class="border-b hover:bg-zinc-100 border-b bg-white-200">' +
                    '<td class="px-4 py-2 w-1/12">' + variation.VariationName + '</td>' +
                    '<td class="px-4 py-2 w-1/12"><img src="' + imageURL + '" alt="Variation Image" class="w-24 h-24 mx-auto block"></td>' +
                    '<td class="px-4 py-2 w-1/12">' + generateAvailabilityDropdown(variation.availability, variation.VariationID) + '</td>' +
                    '<td class="px-4 py-2 w-1/12">' + variation.status + '</td>' +
                    '<td class="px-4 py-2 w-1/12 justify-center">' + '<div class="flex justify-center">' +
                    '<button type="button" id="' + (variation.status === "active" ? 'btn-inactivate' : 'btn-reactivate') + '" class="btn ' + (variation.status === "active" ? 'btn-danger' : 'bg-emerald-500') + ' rounded-md text-center sm:mt-4 px-4 text-sm flex items-center mr-2 hover:bg-emerald-400 deleteVariation" data-variationid="' + variation.VariationID + '">' +
                    ((variation.status === "active") ? '<i class="fa-solid fa-eye-slash mr-2"></i><span class="hover:underline">Inactivate</span>' : '<i class="fa-solid fa-check-circle mr-2"></i><span class="hover:underline">Reactivate</span>') +
                    '</button>' +
                    '</td>' +
                    '</div>' +
                    '</tr>';
                tableBody.append(row);
            });

            $('.btn-reactivate').addClass('btn-reactivate');
        }

        function generatePagination(totalPages, totalRows) {
            const paginationBar = $('#pagination');
            paginationBar.empty();

            const itemCountElement = $('<div class="item-count">').text(`Showing ${(currentPage - 1) * itemsPerPage + 1} - ${Math.min(currentPage * itemsPerPage, totalRows)} of ${totalRows} items`);
            $('#itemCount').empty().append(itemCountElement);

            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationBar.append(`<button class="btn-primary btn-pagination">${i}</button>`);
                } else {
                    paginationBar.append(`<button class="btn btn-secondary btn-pagination">${i}</button>`);
                }
            }

            paginationBar.find('.btn-pagination').click(function() {
                const pageNumber = $(this).text();
                currentPage = parseInt(pageNumber);
                fetchVariationData();
                return false;
            });

            paginationBar.find(`.btn-pagination:contains(${currentPage})`).addClass('active');
            paginationBar.addClass('flex justify-end');
        }

        function generateAvailabilityDropdown(selectedAvailability, variationId) {
            var options = ['Available', 'Low Stocks', 'Unavailable'];
            var dropdown = '<select class="availability-dropdown border rounded-md px-2 py-1" data-variation-id="' + variationId + '">';
            options.forEach(function(option) {
                dropdown += '<option value="' + option + '" ' + (option === selectedAvailability ? 'selected' : '') + '>' + option + '</option>';
            });
            dropdown += '</select>';
            return dropdown;
        }

        $('#variationlisting').on('change', '.availability-dropdown', function() {
            var variationId = $(this).data('variation-id');
            var availability = $(this).val();

            Swal.fire({
                title: 'Confirm Update',
                text: 'Are you sure you want to update the availability of this variation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../../../backend/variation/fetchvariation.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            variationId: variationId,
                            availability: availability
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                console.log('Availability updated successfully');
                            } else {
                                console.error('Failed to update availability');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        });

        $.ajax({
            url: '../../../backend/variation/fetchavailability.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var availFilterDropdown = $('#availFilter');
                availFilterDropdown.empty();
                availFilterDropdown.append('<option value="availreset">All Availability</option>');
                response.forEach(function(option) {
                    availFilterDropdown.append('<option value="' + option + '">' + option + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching availability options:', error);
            }
        });

        $.ajax({
            url: '../../../backend/variation/fetchstatus.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var statusFilterDropdown = $('#statusFilter');
                statusFilterDropdown.empty();
                statusFilterDropdown.append('<option value="statusreset">All Status</option>');
                response.forEach(function(option) {
                    statusFilterDropdown.append('<option value="' + option + '">' + option.charAt(0).toUpperCase() + option.slice(1) + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching status options:', error);
            }
        });

        $('#statusFilter').change(function() {
            currentPage = 1; // Reset to the first page
            fetchVariationData();
        });

        $('#availFilter').change(function() {
            currentPage = 1; // Reset to the first page
            fetchVariationData();
        });

        $('#searchInput').on('input', function() {
            currentPage = 1; // Reset to the first page
            fetchVariationData(); // Trigger data fetch
        });


        $('#variationlisting').on('click', '.deleteVariation', function() {
            var variationId = $(this).data('variationid');
            var action = $(this).attr('id') === 'btn-inactivate' ? 'inactive' : 'active';

            Swal.fire({
                title: (action === 'inactive' ? 'Inactivate' : 'Reactivate') + ' Variation',
                text: 'Are you sure you want to ' + action + ' this variation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../../../backend/variation/updatestatus.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            variationId: variationId,
                            status: action
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Variation status set to ' + action + ' successfully!',
                                    confirmButtonText: 'OK'
                                }).then(function(result) {
                                    if (result.isConfirmed) {
                                        fetchVariationData();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to set the status of variation. Please try again.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to set the status of variation. Please try again.',
                                confirmButtonText: 'OK'
                            });
                            console.error('Error:', error);
                        }
                    });
                }
            });
        });

        fetchVariationData();
    });
</script>
<?php
$script = ob_get_clean();
include("../../../public/master.php");
?>