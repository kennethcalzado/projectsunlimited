<?php
session_start();
$pageTitle = "CMS - Blogs";
ob_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <link rel="stylesheet" href="../../../assets/input.css">

    <style>
        td.description {
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
                    <h2 class="text-xl font-bold">Add New Blog</h2>
                    <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal()">X</span>
                </div>
                <form action="../../../backend/blogs/add_blog.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4 flex flex-col">
                        <label for="title" class="block font-semibold mb-2">Title</label>
                        <input type="text" name="title" id="title" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="description" class="block font-semibold mb-2">Description</label>
                        <textarea name="description" id="description" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required></textarea>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="thumbnail" class="block font-semibold mb-2">Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" accept="image/*" required>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="images" class="block font-semibold mb-2">Images</label>
                        <input type="file" name="images[]" id="images" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" accept="image/*" multiple>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="date" class="block font-semibold mb-2">Date</label>
                        <!-- Date picker input field -->
                        <input type="date" name="date" id="date" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="type" class="block font-semibold mb-2">Type</label>
                        <select name="type" id="type" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                            <option value="News">News</option>
                            <option value="Projects">Projects</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="confirmAdd()">Add Blog</button>
                        <button type="submit" id="hiddenAddButton" class="btn btn-primary" hidden>Add Blog</button>
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
                    <h2 class="text-xl font-bold mb-4">Delete Blog</h2>
                    <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeDeleteModal()">X</span>
                </div>
                <p style="font-size:large" class="mb-4">Are you sure you want to delete this blog?</p>
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
                    <h2 class="text-xl font-bold mb-4">Update Blog</h2>
                    <span class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeUpdateModal()">X</span>
                </div>
                <!-- Form for updating the blog post -->
                <form id="updateForm" action="../../../backend/blogs/update_blog.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="blogIdToUpdate" id="blogIdToUpdate">
                    <input type="hidden" name="removedImages" id="removedImages" value="">
                    <div class="mb-4 flex flex-col">
                        <label for="updateTitle" class="block font-semibold mb-2">Title</label>
                        <input type="text" name="updateTitle" id="updateTitle" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="updateDescription" class="block font-semibold mb-2">Description</label>
                        <textarea name="updateDescription" id="updateDescription" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required></textarea>
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="updateDate" class="block font-semibold mb-2">Date</label>
                        <input type="date" name="updateDate" id="updateDate" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label for="updateThumbnail" class="block font-semibold mb-2">Thumbnail</label>
                        <!-- Thumbnail preview container -->
                        <div id="thumbnailPreview" class="mt-2 mb-2">
                            <img id="thumbnailImg" src="#" alt="Thumbnail Preview" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <input type="file" name="updateThumbnail" id="updateThumbnail" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" accept="image/*">
                    </div>
                    <div class="mb-4 flex flex-col">
                        <label class="block font-semibold mb-2">Existing Images</label>
                        <div id="existingImages" class="mb-2 flex flex-wrap">
                            <!-- Existing images will be displayed here -->
                        </div>
                        <input type="file" name="updateImages[]" id="updateImages" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" accept="image/*" multiple>
                    </div>

                    <div class="mb-4 flex flex-col">
                        <label for="updateType" class="block font-semibold mb-2">Type</label>
                        <select name="updateType" id="updateType" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent" required>
                            <option value="News">News</option>
                            <option value="Projects">Projects</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Update Blog</button>
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
            $('#categoryFilter, #sortFilter').change(function() {
                // Get the selected category and sort option
                var category = $('#categoryFilter').val();
                var sortOption = $('#sortFilter').val();

                // Reset search input
                $('#searchInput').val('');

                // Call the function to fetch data based on the selected category and sort option
                fetchData(category, sortOption);
            });

            // Event listener for search input
            $('#searchInput').on('input', function() {
                // Get the search query
                var query = $(this).val();

                // Get the selected category and sort option
                var category = $('#categoryFilter').val();
                var sortOption = $('#sortFilter').val();

                // Call the function to fetch data based on the selected category, sort option, and search query
                fetchData(category, sortOption, query);
            });

            // Function to fetch data based on category, sort option, and search query
            function fetchData(category, sortOption, query = '', page = 1) {
                var limit = 10; // Number of records per page
                $.ajax({
                    url: '../../../backend/blogs/fetch_data.php',
                    method: 'POST',
                    data: {
                        category: category,
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
                        html += '<td>' + item.title + '</td>';
                        html += '<td>' + item.date + '</td>';
                        html += '<td><img src="../../../assets/blogs_img/' + item.thumbnail + '" width="100" height="100"></td>';
                        html += '<td class="description">' + item.description + '</td>';
                        html += '<td>' + item.type + '</td>';
                        html += '<td class="action-btns">';
                        html += '<button onclick="viewPost(\'' + item.page + '\')" class="btn-view" target="_blank"><i class="fas fa-eye"></i> View</button>';
                        html += '<button onclick="openUpdateModal(' + item.id + ', \'' + item.title.replace(/'/g, "\\'") + '\', \'' + encodeURIComponent(item.description) + '\', \'' + item.type + '\', \'' + item.date + '\', \'' + item.images + '\', \'' + item.thumbnail + '\')" class="yellow-btn btn-primary" data-title="' + item.title.replace(/'/g, "\\'") + '" data-description="' + encodeURIComponent(item.description) + '" data-type="' + item.type + '" data-date="' + item.date + '" data-images="' + item.images + '"><i class="fas fa-edit"></i> Update</button>';
                        html += '<button onclick="openDeleteModal(' + item.id + ')" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>';
                        // Add more action buttons if needed
                        html += '</td>';
                        html += '</tr>';
                    });
                } else {
                    html += '<tr><td colspan="6">No records found</td></tr>';
                }
                $('#blogTable tbody').html(html);
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
                            fetchData($('#categoryFilter').val(), $('#sortFilter').val(), $('#searchInput').val(), page);
                        };
                    }(i));
                    pagination.append(pageBtn);
                }
                pagination.addClass('flex justify-end');
                pagination.show(); // Show pagination if there are multiple pages

                $('#itemCount').text(`Showing ${startItem}-${endItem} of ${totalCount} items`);
            }

            // Fetch initial data
            fetchData('', 'new');
        });
    </script>


    <!-- MODAL SCRIPTS -->
    <script>
        // MODAL SCRIPTS //

        function viewPost(page) {
            window.open(page, '_blank');
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
                            text: 'Blog deleted successfully!',
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
                            text: 'Failed to delete blog. Please try again.'
                        });
                    }
                }
            };
            xhr.open('POST', '../../../backend/blogs/delete_blog.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('blogId=' + blogId);
        }

        // Update modal functions //
        // Open the update modal with blog details //
        function openUpdateModal(blogId, title, description, type, date, images, thumbnail) {
            var modal = document.getElementById('updateModal');
            modal.classList.remove('hidden');
            modal.classList.remove('fade-out'); // Remove fade-out class if applied
            modal.classList.add('fade-in');

            // Set input values
            document.getElementById('blogIdToUpdate').value = blogId;
            document.getElementById('updateTitle').value = title;
            document.getElementById('updateDescription').value = decodeURIComponent(description);
            document.getElementById('updateType').value = type;
            document.getElementById('updateDate').value = date;

            // Display existing images preview
            var imagesPreview = document.getElementById('existingImages');
            imagesPreview.innerHTML = ''; // Clear existing images preview

            if (images.trim() === '') { // Check if images string is empty
                var noImageText = document.createTextNode("No image uploaded");
                imagesPreview.appendChild(noImageText);
            } else {
                var imagesArray = images.split(','); // Split the images string into an array
                for (var i = 0; i < imagesArray.length; i++) {
                    // Create container for each image and remove button
                    var imgContainer = document.createElement('div');
                    imgContainer.className = 'relative inline-block';
                    imgContainer.setAttribute('data-image-index', i); // Store image index as a data attribute

                    // Create image element
                    var img = document.createElement('img');
                    img.src = '../../../assets/blogs_img/' + imagesArray[i];
                    img.width = 100;
                    img.height = 100;
                    img.className = 'mr-2 mb-2';
                    imgContainer.appendChild(img);

                    // Create remove button
                    var removeBtn = document.createElement('button');
                    removeBtn.textContent = 'X';
                    removeBtn.className = 'absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center';
                    removeBtn.style.fontSize = '0.75rem'; // Adjust font size if needed

                    // Add click event listener to remove button
                    removeBtn.addEventListener('click', function() {
                        var indexToRemove = parseInt(this.parentElement.getAttribute('data-image-index'));
                        var removedImagesInput = document.getElementById('removedImages');
                        var removedIndexes = removedImagesInput.value ? JSON.parse(removedImagesInput.value) : [];
                        console.log('Removing image at index:', indexToRemove); // Log the index to be removed
                        removedIndexes.push(indexToRemove);
                        removedImagesInput.value = JSON.stringify(removedIndexes);
                        this.parentElement.remove();
                    });

                    imgContainer.appendChild(removeBtn);

                    imagesPreview.appendChild(imgContainer); // Append the container to the images preview
                }
            }

            // Display thumbnail preview
            if (thumbnail) {
                var thumbnailPreview = document.getElementById('thumbnailPreview');
                var thumbnailImg = document.getElementById('thumbnailImg');
                thumbnailImg.src = '../../../assets/blogs_img/' + thumbnail;
                thumbnailPreview.style.display = 'block'; // Show the thumbnail preview container
            } else {
                var thumbnailPreview = document.getElementById('thumbnailPreview');
                thumbnailPreview.style.display = 'none'; // Hide the thumbnail preview container if no thumbnail
            }
        }

        // Close the update modal with fade-out animation
        function closeUpdateModal() {
            var modal = document.getElementById('updateModal');
            modal.classList.remove('fade-in'); // Remove fade-in class if applied
            modal.classList.add('fade-out');

            // Log the value of removedImages before form submission
            var removedImagesInput = document.getElementById('removedImages');
            console.log('Removed images:', removedImagesInput.value);

            setTimeout(function() {
                modal.classList.add('hidden');
                modal.classList.remove('fade-out'); // Remove fade-out class after animation
            }, 300); // Adjust the timeout to match the animation duration
        }

        function confirmUpdate() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to update the blog.',
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
                    showSuccessAlert('Blog updated successfully!');
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
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to add a new blog.',
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
                    showSuccessAlert('Blog added successfully!');
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
                <h1 class="text-4xl font-bold">News & Projects</h1>
                <button class="yellow-btn btn-primary rounded-md text-center h-10 mt-3 sm:mt-4 !px-4 py-0 text-lg flex items-center" onclick="openModal()"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>Add New</button>
            </div>
            <div class="border-b border-black flex-grow border-4 mt-2 mb-2"></div>
            <div class="flex flex-col sm:flex-row items-center justify-center">
                <div class="relative mb-2 mt-4 sm:mb-0 sm:mr-8">
                    <label for="categoryFilter" class="mr-2">Filter by Category</label>
                    <select id="categoryFilter" class="border rounded-md px-2 py-1">
                        <option value="">All Categories</option>
                        <option value="News">News & Updates</option>
                        <option value="Projects">Projects</option>
                    </select>
                </div>
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
                    <th scope="col" class="px-6 py-3 w-1/12">Title</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Date</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Thumbnail</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Description</th>
                    <th scope="col" class="px-6 py-3 w-1/12">Type</th>
                    <th scope="col" class="px-6 py-3 w-1/6">Actions</th>
                </thead>

                <tbody>
                    <?php
                    include("../../../backend/conn.php");

                    $sql = 'SELECT * FROM blogs ORDER BY date DESC';
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><img src="../../../assets/blogs_img/<?php echo $row['thumbnail']; ?>"></td>
                                <td class="description"><?php echo $row['description']; ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <td class="action-btns" valign="middle">
                                    <a href="<?php echo $row['page']; ?>" class="btn btn-view rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg mr-2 hover:underline" target="_blank"><i class="fas fa-eye"></i> View</a>
                                    <button onclick="openUpdateModal('<?php echo $row['id']; ?>', '<?php echo $row['title']; ?>', '<?php echo $row['description']; ?>', '<?php echo $row['type']; ?>', '<?php echo $row['date']; ?>', '<?php echo $row['images']; ?>')" type="button" class="btn btn-primary rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg mr-2 hover:underline" data-title="<?php echo $row['title']; ?>" data-description="<?php echo $row['description']; ?>" data-type="<?php echo $row['type']; ?>" data-date="<?php echo $row['date']; ?>" data-images="<?php echo $row['images']; ?>"><i class="fas fa-edit"></i> Update</button>
                                    <button onclick="openDeleteModal('<?php echo $row['id']; ?>')" type="button" class=" btn btn-danger rounded-md text-center h-9 mt-3 sm:mt-4 !px-4 py-0 text-lg hover:underline"><i class="fas fa-trash-alt"></i> Delete</button>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
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