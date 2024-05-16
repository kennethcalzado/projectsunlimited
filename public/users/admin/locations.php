<?php
session_start();
$pageTitle = "CMS - Locations";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <link rel="stylesheet" href="../../../assets/input.css">

    <style>
        td.map {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        td img {
            display: block;
            margin: 0 auto;
            max-width: 100px;
            max-height: 100px;
        }

        .action-btns button {
            width: auto;
            padding: 6px 12px;
            font-size: 14px;
            margin-right: 10px;
        }

        td {
            padding: 2%;
        }

        tr {
            border-bottom: 1px solid #e5e7eb;
            /* Light Gray */
            vertical-align: center;
        }

        tr:hover {
            background-color: #f5f4f4;
            /* Gray */
        }

        tr.dark:hover {
            background-color: #f5f4f4;
            /* Off White */
        }
    </style>

</head>

<body>
    <!-- ADD NEW MODAL -->
    <div id="modal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="max-w-3xl w-full h-[90vh] overflow-auto">
            <!-- Modal Content -->
            <div class="bg-white p-6 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Add Location</h2>
                    <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal()">X</span>
                </div>
                <form action="../../../backend/locations/add_location.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4 flex flex-col">
                        <label for="name" class="block font-semibold mb-2">Name</label>
                        <textarea name="name" id="name" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required></textarea>
                        <div id="nameError" class="error-message text-red-500"></div>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="address" class="block font-semibold mb-2">Address</label>
                        <input type="text" name="address" id="address" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        <div id="addressError" class="error-message text-red-500"></div>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="time" class="block font-semibold mb-2">Time</label>
                        <input type="text" name="time" id="time" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        <div id="timeError" class="error-message text-red-500"></div>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="phone" class="block font-semibold mb-2">Phone</label>
                        <input type="text" name="phone" id="phone" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="email" class="block font-semibold mb-2">Email</label>
                        <input type="text" name="email" id="email" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="map" class="block font-semibold mb-2">Map
                            <i class="fas fa-info-circle" style="color: #F6E17A; padding-left: 10px;" data-bs-toggle="tooltip" data-bs-placement="top" title="1. Go to Google Maps and search for the specific location you want to add
        2. Click the share button
        3. Click the 'Embed a map' tab
        4. Lastly, click the 'Copy link' and paste it in this input field"></i>
                        </label>
                        <input type="text" name="map" id="map" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        <div id="mapError" class="error-message text-red-500"></div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="confirmAdd()">Add</button>
                        <button type="submit" id="hiddenAddButton" class="btn btn-primary" hidden>Add</button>
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div id="deleteModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="max-w-3xl w-full h-[90vh] overflow-auto">
            <div class="bg-white p-6 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold mb-4">Delete Location</h2>
                    <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeDeleteModal()">X</span>
                </div>
                <p style="font-size:large" class="mb-4">Are you sure you want to delete this?</p>
                <div class="text-right">
                    <input type="hidden" id="blogIdToDelete">
                    <button onclick="deleteBlog()" class="btn btn-primary">Delete</button>
                    <button onclick="closeDeleteModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- UPDATE MODAL -->
    <div id="updateModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="max-w-3xl w-full h-[90vh] overflow-auto">
            <div class="bg-white p-6 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold mb-4">Update Location</h2>
                    <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeUpdateModal()">X</span>
                </div>
                <!-- Form for updating the blog post -->
                <form id="updateForm" action="../../../backend/locations/update_location.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="blogIdToUpdate" id="blogIdToUpdate">
                    <div class="mb-4 flex flex-col">
                        <label for="name" class="block font-semibold mb-2">Name</label>
                        <textarea name="name" id="updateName" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required></textarea>
                        <div id="nameUpdateError" class="error-message text-red-500"></div>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="address" class="block font-semibold mb-2">Address</label>
                        <input type="text" name="address" id="updateAddress" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        <div id="addressUpdateError" class="error-message text-red-500"></div>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="time" class="block font-semibold mb-2">Time</label>
                        <input type="text" name="time" id="updateTime" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        <div id="timeUpdateError" class="error-message text-red-500"></div>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="phone" class="block font-semibold mb-2">Phone</label>
                        <input type="text" name="phone" id="updatePhone" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="email" class="block font-semibold mb-2">Email</label>
                        <input type="text" name="email" id="updateEmail" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="map" class="block font-semibold mb-2">Map<i class="fas fa-info-circle" style="color: #F6E17A; padding-left: 10px;" data-bs-toggle="tooltip" data-bs-placement="top" title="1. Go to Google Maps and search for the specific location you want to add
        2. Click the share button
        3. Click the 'Embed a map' tab
        4. Lastly, click the 'Copy link' and paste it in this input field"></i></label>
                        <input type="text" name="map" id="updateMap" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                        <div id="mapUpdateError" class="error-message text-red-500"></div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Update</button>
                        <button type="submit" id="hiddenSubmitButton" class="btn btn-primary" hidden></button>
                        <button type="button" onclick="closeUpdateModal()" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FILTER SCRIPTS -->
    <script>
        // FILTER SCRIPTS
        $(document).ready(function() {
            // Event listener for category and sort filters
            $('#sortFilter').change(function() {
                // Get the selected category and sort option
                var sortOption = $('#sortFilter').val();

                // Reset search input
                $('#searchInput').val('');

                // Call the function to fetch data based on the selected category and sort option
                fetchData(sortOption);
            });

            // Event listener for search input
            $('#searchInput').on('input', function() {
                // Get the search query
                var query = $(this).val();

                // Get the selected category and sort option
                var sortOption = $('#sortFilter').val();

                // Call the function to fetch data based on the selected sort option, and search query
                fetchData(sortOption, query);
            });

            // Function to fetch data based on category, sort option, and search query
            function fetchData(sortOption, query = '', page = 1) {
                var limit = 10; // Number of records per page
                $.ajax({
                    url: '../../../backend/locations/fetch_data.php',
                    method: 'POST',
                    data: {
                        sortOption: sortOption,
                        query: query, // Include search query in the AJAX request
                        page: page, // Include page parameter for pagination
                        limit: limit // Include limit parameter for pagination
                    },
                    dataType: 'json',
                    success: function(response) {
                        updateTable(response.data); // Update table with fetched data
                        updatePagination(response.total, page, limit); // Update pagination controls
                    }
                });
            }

            // Function to update the table with fetched data
            function updateTable(data) {
                var html = '';
                if (data.length > 0) {
                    $.each(data, function(index, item) {
                        html += '<tr>';
                        html += '<td>' + item.name + '</td>'; // Update with item.name
                        html += '<td>' + item.address + '</td>'; // Update with item.address
                        html += '<td>' + item.time + '</td>'; // Update with item.time
                        html += '<td>' + item.phone + '</td>'; // Update with item.phone
                        html += '<td>' + item.email + '</td>'; // Update with item.email
                        html += '<td class="action-btns" valign="middle">';
                        html += '<button onclick="viewPost(\'../../contact.php\')" class="btn-view rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg mr-2 hover:underline"><i class="fas fa-eye"></i> View</button>';
                        html += '<button onclick="openUpdateModal(\'' + item.id + '\', \'' + item.name.replace(/'/g, "\\'") + '\', \'' + item.address.replace(/'/g, "\\'") + '\', \'' + item.time.replace(/'/g, "\\'") + '\', \'' + item.phone.replace(/'/g, "\\'") + '\', \'' + item.email.replace(/'/g, "\\'") + '\', \'' + escapeHtmlQuotes(item.map) + '\')" type="button" class="btn btn-primary rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg mr-2 hover:underline" data-name="' + item.name.replace(/'/g, "\\'") + '" data-address="' + item.address.replace(/'/g, "\\'") + '" data-time="' + item.time.replace(/'/g, "\\'") + '" data-phone="' + item.phone.replace(/'/g, "\\'") + '" data-email="' + item.email.replace(/'/g, "\\'") + '" data-map="' + escapeHtmlQuotes(item.map) + '"><i class="fas fa-edit"></i> Update</button>';
                        html += '<button onclick="openDeleteModal(\'' + item.id + '\')" type="button" class="btn btn-danger rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg hover:underline"><i class="fas fa-trash-alt"></i> Delete</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                } else {
                    html += '<tr><td colspan="6">No records found</td></tr>';
                }
                $('#blogTable tbody').html(html);
                $('#blogTable .map').text(function(i, text) {
                    return text.length > 50 ? text.substr(0, 50) + '...' : text;
                });
            }

            // Function to escape double quotes in map values
            function escapeHtmlQuotes(str) {
                return str.replace(/"/g, '&quot;');
            }


            // Function to update pagination controls
            function updatePagination(totalCount, currentPage, limit) {
                var totalPages = Math.ceil(totalCount / limit); // Calculate total pages
                var pagination = $('#pagination');
                pagination.empty(); // Clear previous pagination buttons

                var startItem = currentPage === 1 ? 1 : (currentPage - 1) * limit + 1;
                var endItem = Math.min(currentPage * limit, totalCount);

                // Adjust endItem if it exceeds totalCount
                if (endItem > totalCount) {
                    endItem = totalCount;
                }

                // Create Page buttons
                for (var i = 1; i <= totalPages; i++) {
                    var pageBtn = $('<button>').text(i).addClass('pagination-btn mx-1 py-1 px-3 rounded-lg');
                    if (i === currentPage) {
                        pageBtn.addClass('bg-yellow-200 text-black font-bold transition');
                    } else {
                        pageBtn.addClass('bg-gray-200 text-gray-700 hover:bg-gray-300 hover:underline transition');
                    }
                    pageBtn.click(function(page) {
                        return function() {
                            fetchData($('#sortFilter').val(), $('#searchInput').val(), page);
                        };
                    }(i));
                    pagination.append(pageBtn);
                }
                pagination.addClass('flex justify-end');
                pagination.show(); // Show pagination if there are multiple pages

                $('#itemCount').text(`Showing ${startItem}-${endItem} of ${totalCount} items`);
            }

            // Fetch initial data
            fetchData('new');
        });
    </script>


    <!-- MODAL SCRIPTS -->
    <script>
        // MODAL SCRIPTS //

        // Function to open the specified URL and navigate to a specific section
        function viewPost(url) {
            // Open the URL with the specified sectionId in a new tab
            window.open(url, '_blank');
        }

        function isValidInput(input) {
            // Simple check for HTML and SQL injections
            var pattern = /<[^>]*>|[";=:]+|(--[^\r\n]*)|(\/\*[\w\W]*?(?=\*)\*\/)/gi;
            return !pattern.test(input);
        }

        // DELETE MODAL //

        function openDeleteModal(blogId) {
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.classList.remove('hidden');
            deleteModal.classList.remove('fade-out'); // Remove fade-out class if applied
            deleteModal.classList.add('fade-in');
            document.getElementById('blogIdToDelete').value = blogId;
        }

        function closeDeleteModal() {
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.classList.remove('fade-in');
            deleteModal.classList.add('fade-out');
            setTimeout(function() {
                deleteModal.classList.add('hidden');
                deleteModal.classList.remove('fade-out'); // Remove fade-out class after animation
            }, 300); // Adjust the timeout to match the animation duration
        }

        function deleteBlog() {
            var blogId = document.getElementById('blogIdToDelete').value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        // Blog deletion successful, show success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Location deleted successfully!',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        // Blog deletion failed, show error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete. Please try again.'
                        });
                    }
                }
            };
            xhr.open('POST', '../../../backend/locations/delete_blog.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('blogId=' + blogId);
        }

        // Open the update modal with blog details
        function openUpdateModal(blogId, name, address, time, phone, email, map) {
            var modal = document.getElementById('updateModal');

            modal.classList.remove('hidden');
            modal.classList.remove('fade-out'); // Remove fade-out class if applied
            modal.classList.add('fade-in');

            // Set input values
            document.getElementById('blogIdToUpdate').value = blogId;
            document.getElementById('updateName').value = name;
            document.getElementById('updateAddress').value = address;
            document.getElementById('updateTime').value = time;
            document.getElementById('updatePhone').value = phone;
            document.getElementById('updateEmail').value = email;
            document.getElementById('updateMap').value = map;
        }

        // Close the update modal with fade-out animation
        function closeUpdateModal() {
            $('.error-message').text('').hide();
            $('.border-red-500').removeClass('border-red-500');
            var modal = document.getElementById('updateModal');
            modal.classList.remove('fade-in'); // Remove fade-in class if applied
            modal.classList.add('fade-out');

            setTimeout(function() {
                modal.classList.add('hidden');
                modal.classList.remove('fade-out'); // Remove fade-out class after animation
            }, 300); // Adjust the timeout to match the animation duration
        }

        function confirmUpdate() {
            // Reset previous error messages and styles
            $('.error-message').text('').hide();
            $('.border-red-500').removeClass('border-red-500');

            var name = $('#updateName').val();
            var address = $('#updateAddress').val();
            var time = $('#updateTime').val();
            var map = $('#updateMap').val();
            // Add similar variables for other fields (if needed)

            // Validation: Check if fields are empty or contain invalid input
            if (name === '' || !isValidInput(name)) {
                $('#nameUpdateError').text('Please enter a valid name.').show();
                $('#updateName').addClass('border-red-500');
            }
            if (address === '' || !isValidInput(address)) {
                $('#addressUpdateError').text('Please enter a valid address.').show();
                $('#updateAddress').addClass('border-red-500');
            }
            if (time === '' || !isValidInput(time)) {
                $('#timeUpdateError').text('Please enter a valid time.').show();
                $('#updateTime').addClass('border-red-500');
            }
            if (map === '') {
                $('#mapUpdateError').text('Please enter a valid map.').show();
                $('#updateMap').addClass('border-red-500');
            }

            // If any field has an error, prevent form submission
            if ($('.error-message:visible').length > 0) {
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to update.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F9E89B', // Set confirm button color
                cancelButtonColor: '#e6e6e6', // Set cancel button color
                confirmButtonText: '<span style="color: black">Yes, update it!</span>',
                cancelButtonText: '<span style="color: black">No, cancel!</span>',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show success alert
                    showSuccessAlert('Updated successfully!');
                    // Add a small delay before clicking the hidden submit button
                    setTimeout(function() {
                        document.getElementById('hiddenSubmitButton').click();
                    }, 700); // Adjust the delay time as needed
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Do nothing if cancelled
                }
            });
        }

        function confirmAdd() {
            // Reset previous error messages and styles
            $('.error-message').text('').hide();
            $('.border-red-500').removeClass('border-red-500');

            var name = $('#name').val();
            var address = $('#address').val();
            var time = $('#time').val();
            var map = $('#map').val();
            // Add similar variables for other fields (if needed)

            // Validation: Check if fields are empty or contain invalid input
            if (name === '' || !isValidInput(name)) {
                $('#nameError').text('Please enter a valid name.').show();
                $('#name').addClass('border-red-500');
            }
            if (address === '' || !isValidInput(address)) {
                $('#addressError').text('Please enter a valid address.').show();
                $('#address').addClass('border-red-500');
            }
            if (time === '' || !isValidInput(time)) {
                $('#timeError').text('Please enter a valid time.').show();
                $('#time').addClass('border-red-500');
            }
            if (map === '') {
                $('#mapError').text('Please enter a valid map.').show();
                $('#map').addClass('border-red-500');
            }

            // If any field has an error, prevent form submission
            if ($('.error-message:visible').length > 0) {
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to add a new location.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F9E89B', // Set confirm button color
                cancelButtonColor: '#e6e6e6', // Set cancel button color
                confirmButtonText: '<span style="color: black">Yes, add it!</span>',
                cancelButtonText: '<span style="color: black">No, cancel!</span>',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show success alert
                    showSuccessAlert('Added successfully!');
                    // Add a small delay before clicking the hidden submit button
                    setTimeout(function() {
                        document.getElementById('hiddenAddButton').click();
                    }, 700); // Adjust the delay time as needed
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Do nothing if cancelled
                }
            });
        }

        // Success and error SweetAlerts
        function showSuccessAlert(message) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: message,
                showConfirmButton: false,
                timer: 1000
            });
        }

        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message
            });
        }

        // ADD NEW MODAL //
        function openModal() {
            var modal = document.getElementById('modal');
            modal.classList.remove('hidden');
            modal.classList.remove('fade-out'); // Remove fade-out class if applied
            modal.classList.add('fade-in');
        }

        // Close the modal with fade-out animation
        function closeModal() {
            $('.error-message').text('').hide();
            $('.border-red-500').removeClass('border-red-500');
            var modal = document.getElementById('modal');
            modal.classList.remove('fade-in'); // Remove fade-in class if applied
            modal.classList.add('fade-out');
            setTimeout(function() {
                modal.classList.add('hidden');
                modal.classList.remove('fade-out'); // Remove fade-out class after animation
            }, 300); // Adjust the timeout to match the animation duration
        }
    </script>

    <div class="transition-all duration-300 page-content sm:ml-36 mr-4 sm:mr-20">
        <div style="padding-top: 15px;">
            <!-- Content -->
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <h1 class="text-4xl font-bold">Locations</h1>
                <button class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center" onclick="openModal()"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>Add New</button>
            </div>
            <div class="border-b border-black flex-grow border-4 mt-2 mb-2"></div>
            <div class="flex flex-col sm:flex-row items-center justify-center">
                <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                    <label for="sortFilter" class="mr-2">Sort</label>
                    <select id="sortFilter" class="border rounded-md px-2 py-1">
                        <optgroup label="Sort By:">
                            <option value="new">Newest to Oldest</option>
                            <option value="old">Oldest to Newest</option>
                    </select>
                </div>
                <div class="flex justify-between">
                    <div class="relative mb-1 mt-1 sm:mb-0 sm:mr-2">
                        <!-- Search input -->
                        <div class="relative text-gray-600">
                            <input class="border-2 border-gray-300 bg-white h-9 w-64 px-2 rounded-md text-sm focus:outline-none" type="text" name="search" placeholder="Search" id="searchInput">
                            <button type="button" id="searchButton" class="absolute right-0 top-0 mt-3 mr-4">
                                <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                                    <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <table id="blogTable" class="display">
                <thead>
                    <th scope="col" class="px-6 py-3 w-1/12">Name</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Address</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Time</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Phone</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Email</th>
                    <th scope="col" class="px-6 py-3 w-1/4">Actions</th>
                </thead>

                <tbody>
                    <?php
                    include("../../../backend/conn.php");

                    $sql = 'SELECT * FROM locations ORDER BY created_at DESC';
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['time']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td class="map"><?php echo htmlspecialchars($row['map']); ?></td>
                                <td class="action-btns" valign="middle">
                                    <a href="" class="btn btn-view rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg mr-2 hover:underline" target="_blank"><i class="fas fa-eye"></i> View</a>
                                    <button onclick="openUpdateModal('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['address']; ?>' , '<?php echo $row['time']; ?>', '<?php echo $row['phone']; ?>' , '<?php echo $row['email']; ?>' , '<?php echo htmlspecialchars($row['map']); ?>')" type="button" class="btn btn-primary rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg mr-2 hover:underline" data-name="<?php echo $row['name']; ?>" data-address="<?php echo $row['address']; ?>" data-time="<?php echo $row['time']; ?>" data-phone="<?php echo $row['phone']; ?>" data-email="<?php echo $row['email']; ?>" data-map="<?php echo htmlspecialchars($row['map']); ?>"><i class="fas fa-edit"></i> Update</button>
                                    <button onclick="openDeleteModal('<?php echo $row['id']; ?>')" type="button" class=" btn btn-danger rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg hover:underline"><i class="fas fa-trash-alt"></i> Delete</button>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }
                    ?>
                </tbody>


            </table>
            <div class="flex flex-col sm:flex-row px-2 sm:self-center sm:items-center justify-between bottom-0">
                <div id="itemCount" class="text-center text-gray-500"></div>
                <div id="pagination" class="justify-center mt-4"></div>
            </div>
        </div>
</body>

<?php
$content = ob_get_clean();

include("../../../public/master.php");
include("../../../backend/conn.php");
?>