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
            margin-left: 12%;
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

<style>

</style>


<body>
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

    <script>
        // JavaScript to show and hide the delete modal
        function openDeleteModal(blogId) {
            document.getElementById('deleteModal').classList.remove('hidden');
            // Pass the blog ID to the modal for deletion
            document.getElementById('blogIdToDelete').value = blogId;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // AJAX function to delete blog
        function deleteBlog() {
            var blogId = document.getElementById('blogIdToDelete').value;
            // Send AJAX request to delete blog
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    if (xhr.status == 200) {
                        // If deletion is successful, reload the page
                        window.location.reload();
                    } else {
                        // Handle errors
                        alert('Failed to delete blog. Please try again.');
                    }
                }
            };
            xhr.open('POST', 'delete_blog.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('blogId=' + blogId);
        }
    </script>

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


    <script>
        // Function to preview selected images
        document.getElementById('updateImages').addEventListener('change', function(event) {
            var imagesPreview = document.getElementById('existingImages');
            imagesPreview.innerHTML = ''; // Clear existing preview

            var files = event.target.files; // Get selected files

            // Loop through selected files and display their preview
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 100;
                    img.height = 100;
                    img.className = 'mr-2 mb-2';
                    imagesPreview.appendChild(img); // Append preview to the existing images area
                };

                reader.readAsDataURL(file);
            }
        });

        // Store TinyMCE instances
        var tinymces = {};

        // Function to initialize TinyMCE for a given ID if not already initialized
        function initTinyMCE(id) {
            if (!tinymces.hasOwnProperty(id)) {
                tinymce.init({
                    selector: '#' + id,
                    plugins: 'advlist autolink lists link image charmap print preview anchor',
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                    height: 300,
                    setup: function(editor) {
                        tinymces[id] = editor; // Store editor instance
                    }
                });
            }
        }

        // JavaScript to show and hide the update modal
        function openUpdateModal(blogId, title, description, type, date) {
            document.getElementById('updateModal').classList.remove('hidden');
            // Populate form fields with existing blog data
            document.getElementById('blogIdToUpdate').value = blogId;
            document.getElementById('updateTitle').value = title;
            document.getElementById('updateDescription').value = description;
            document.getElementById('updateType').value = type;
            document.getElementById('updateDate').value = date;

            // Initialize TinyMCE for the description textarea if not already initialized
            initTinyMCE('updateDescription');

            // Set the TinyMCE content to match the description text
            if (tinymces.hasOwnProperty('updateDescription')) {
                tinymces['updateDescription'].setContent(description);
            }
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }
    </script>


    <script>
        // JavaScript to show and hide the modal
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>

    <div style="padding-top: 15px;" class="container">
        <!-- Content -->
        <div class="flex justify-between items-center">
            <h1 class="text-4xl font-bold">News & Projects</h1>
            <button class="yellow-btn btn-primary" onclick="openModal()">Add New</button>
        </div>
        <div class="border-b border-black flex-grow border-4 mt-2 mb-2"></div>

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
</body>

<?php
$content = ob_get_clean();
include("../../../public/master.php"); // Corrected path to master.php
include("../../../backend/conn.php"); // Corrected path to conn.php
?>