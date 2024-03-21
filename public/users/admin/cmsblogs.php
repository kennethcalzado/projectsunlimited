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

    <script src="https://cdn.tiny.cloud/1/9frvewhh5omzgdpfqvh7kwq6xuau933hnsftejl9bjatfrez/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body,
        p {
            font-family: 'Karla', sans-serif;
            letter-spacing: -0.4px;
        }

        body {
            background-color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            margin-left: 13%;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            vertical-align: top;
            text-align: center;
            margin: 0 auto;
        }

        .action-btns {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .action-btns button {
            width: auto;
            padding: 6px 12px;
            font-size: 14px;
        }

        td.description {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        td img {
            display: block;
            margin: 0 auto;
            max-width: 50px;
            max-height: 50px;
        }
    </style>
</head>

<body>
    <!-- ADD NEW MODAL -->
    <div id="modal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="max-w-3xl w-full h-[90vh] overflow-auto">
            <!-- Modal Content -->
            <div class="bg-white p-6 rounded-lg">
                <h2 class="text-xl font-bold mb-4">Add New Blog</h2>
                <form action="add_blog.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="title" class="block font-semibold mb-2">Title</label>
                        <input type="text" name="title" id="title" class="border rounded px-4 py-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block font-semibold mb-2">Description</label>
                        <textarea name="description" id="description" class="border rounded px-4 py-2 w-full" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="thumbnail" class="block font-semibold mb-2">Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="border rounded px-4 py-2 w-full" accept="image/*">
                    </div>
                    <div class="mb-4">
                        <label for="images" class="block font-semibold mb-2">Images</label>
                        <input type="file" name="images[]" id="images" class="border rounded px-4 py-2 w-full" accept="image/*" multiple>
                    </div>
                    <div class="mb-4">
                        <label for="date" class="block font-semibold mb-2">Date</label>
                        <!-- Date picker input field -->
                        <input type="date" name="date" id="date" class="border rounded px-4 py-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="type" class="block font-semibold mb-2">Type</label>
                        <select name="type" id="type" class="border rounded px-4 py-2 w-full" required>
                            <option value="News">News</option>
                            <option value="Projects">Projects</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Add Blog</button>
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
                <h2 class="text-xl font-bold mb-4">Delete Blog</h2>
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
                <h2 class="text-xl font-bold mb-4">Update Blog</h2>
                <!-- Form for updating the blog post -->
                <form id="updateForm" action="update_blog.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="blogIdToUpdate" id="blogIdToUpdate">
                    <div class="mb-4">
                        <label for="updateTitle" class="block font-semibold mb-2">Title</label>
                        <input type="text" name="updateTitle" id="updateTitle" class="border rounded px-4 py-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="updateDescription" class="block font-semibold mb-2">Description</label>
                        <textarea name="updateDescription" id="updateDescription" class="border rounded px-4 py-2 w-full" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="updateDate" class="block font-semibold mb-2">Date</label>
                        <input type="date" name="updateDate" id="updateDate" class="border rounded px-4 py-2 w-full">
                    </div>
                    <div class="mb-4">
                        <label for="updateThumbnail" class="block font-semibold mb-2">Thumbnail</label>
                        <input type="file" name="updateThumbnail" id="updateThumbnail" class="border rounded px-4 py-2 w-full" accept="image/*">
                    </div>
                    <div class="mb-4">
                        <label for="updateImages" class="block font-semibold mb-2">Existing Images</label>
                        <div id="existingImages" class="mb-2">
                            <!-- Existing images will be displayed here -->
                            <?php
                            include("../../../backend/conn.php");

                            $sql = 'SELECT * FROM blogs ORDER BY date DESC';
                            $result = mysqli_query($conn, $sql);

                            $displayedImages = []; // Array to store displayed image filenames

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Fetch and explode existing images
                                    $images = explode(',', $row['images']);
                                    foreach ($images as $image) {
                                        // Check if the image has already been displayed
                                        if (!in_array($image, $displayedImages)) {
                                            // If not, display it
                                            echo "<img src='../../../assets/blogs_img/{$image}' width='100' height='100' class='mr-2 mb-2' />";
                                            // Add the image filename to the displayed images array
                                            $displayedImages[] = $image;
                                        }
                                    }
                                }
                            } else {
                                echo "<p>No blogs found.</p>";
                            }
                            ?>
                        </div>
                        <input type="file" name="updateImages[]" id="updateImages" class="border rounded px-4 py-2 w-full" accept="image/*" multiple>
                    </div>

                    <div class="mb-4">
                        <label for="updateType" class="block font-semibold mb-2">Type</label>
                        <select name="updateType" id="updateType" class="border rounded px-4 py-2 w-full" required>
                            <option value="News">News</option>
                            <option value="Projects">Projects</option>
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update Blog</button>
                        <button type="button" onclick="closeUpdateModal()" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL SCRIPTS -->
    <script>
        // DELETE MODAL

        function openDeleteModal(blogId) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('blogIdToDelete').value = blogId;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function deleteBlog() {
            var blogId = document.getElementById('blogIdToDelete').value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        window.location.reload();
                    } else {
                        alert('Failed to delete blog. Please try again.');
                    }
                }
            };
            xhr.open('POST', 'delete_blog.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('blogId=' + blogId);
        }

        // UPDATE MODAL
        // IMAGES
        document.getElementById('updateImages').addEventListener('change', function(event) {
            var imagesPreview = document.getElementById('existingImages');
            imagesPreview.innerHTML = '';

            var files = event.target.files;

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 100;
                    img.height = 100;
                    img.className = 'mr-2 mb-2';
                    imagesPreview.appendChild(img);
                };

                reader.readAsDataURL(file);
            }
        });

        // TINYMCE EDITOR - UPDATE MODAL
        var tinymces = {};


        function initTinyMCE(id) {
            if (!tinymces.hasOwnProperty(id)) {
                tinymce.init({
                    selector: '#' + id,
                    plugins: 'advlist autolink lists link image charmap print preview anchor',
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                    height: 300,
                    setup: function(editor) {
                        tinymces[id] = editor;
                    }
                });
            }
        }

        function openUpdateModal(blogId, title, description, type, date) {
            document.getElementById('updateModal').classList.remove('hidden');
            document.getElementById('blogIdToUpdate').value = blogId;
            document.getElementById('updateTitle').value = title;
            document.getElementById('updateDescription').value = description;
            document.getElementById('updateType').value = type;
            document.getElementById('updateDate').value = date;

            initTinyMCE('updateDescription');

            if (tinymces.hasOwnProperty('updateDescription')) {
                tinymces['updateDescription'].setContent(description);
            }
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }

        // ADD NEW MODAL
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
            initTinyMCEForModal(); // Initialize TinyMCE for description textarea
        }

        function initTinyMCEForModal() {
            tinymce.init({
                selector: '#description', // ID of the textarea
                plugins: 'advlist autolink lists link image charmap print preview anchor',
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                height: 300,
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save(); // Update textarea when content changes
                    });
                }
            });
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            tinymce.remove(); // Remove TinyMCE instance when modal is closed
        }
    </script>


    <div style="padding-top: 15px;" class="container">
        <!-- Content -->
        <div class="flex justify-between items-center">
            <h1 class="text-4xl font-bold">News & Projects</h1>
            <button class="yellow-btn btn-primary" onclick="openModal()">Add New</button>
        </div>
        <div class="border-b border-black flex-grow border-4 mt-2 mb-2"></div>
        <div class="flex flex-col sm:flex-row items-center justify-center">
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="categoryFilter" class="mr-2">Filter by Category</label>
                <select id="categoryFilter" class="border rounded-md px-2 py-1">
                    <option value="">All Categories</option>
                    <option value="News">News</option>
                    <option value="Projects">Projects</option>
                </select>
            </div>
            <div class="relative mb-2 mt-2 sm:mb-0 sm:mr-8">
                <label for="sortFilter" class="mr-2">Sort</label>
                <select id="sortFilter" class="border rounded-md px-2 py-1">
                    <optgroup label="Sort By:">
                        <option>Sort By</option>
                        <option>Newest to Oldest</option>
                        <option>Oldest to Newest</option>
                </select>
            </div>
            <div class="flex justify-between">
                <div class="relative mb-1 mt-1 sm:mb-0 sm:mr-2">
                    <!-- Search input -->
                    <div class="relative text-gray-600">
                        <input class="border-2 border-gray-300 bg-white h-9 w-64 px-2 rounded-md text-sm focus:outline-none" type="text" name="search" placeholder="Search" id="searchInput">
                        <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
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
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Thumbnail</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>
                <?php
                include("../../../backend/conn.php");

                $sql = 'SELECT * FROM blogs ORDER BY date DESC';
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td><img src='../../../assets/blogs_img/{$row['thumbnail']}' width='100' height='100'></td>";
                        echo "<td class='description'>" . $row['description'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo '<td class="action-btns">';
                        echo "<button onclick=\"editPost('" . $row['id'] . "')\" type='button' class='btn-view'><i class='fas fa-eye'></i> View</button>";
                        echo "<button onclick=\"openUpdateModal('" . $row['id'] . "', '" . htmlspecialchars($row['title']) . "', '" . htmlspecialchars($row['description']) . "', '" . $row['type'] . "', '" . $row['date'] . "', '" . $row['images'] . "')\" type='button' class='yellow-btn btn-primary' data-title='" . htmlspecialchars($row['title']) . "' data-description='" . htmlspecialchars($row['description']) . "' data-type='" . $row['type'] . "' data-date='" . $row['date'] . "' data-images='" . $row['images'] . "'><i class='fas fa-edit'></i> Update</button>";
                        echo "<button onclick=\"openDeleteModal('" . $row['id'] . "')\" type='button' class=' btn-danger'><i class='fas fa-trash-alt'></i> Delete</button>";
                        echo '</td>';

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found</td></tr>";
                }

                ?>
            </tbody>
        </table>
    </div>
    </div>
</body>

<?php
$content = ob_get_clean();

include("../../../public/master.php");
include("../../../backend/conn.php");
?>