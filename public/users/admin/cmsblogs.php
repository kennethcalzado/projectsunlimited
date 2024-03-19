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

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

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
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            vertical-align: top;
            text-align: center;
            margin: 0 auto;
            /* Align content at the top */
        }

        .btn {
            background-color: #F6E17A;
            color: black;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #FFD700;
        }

        .action-btns {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 10px;
            height: 100%;
            /* Set height to 100% */
        }

        .action-btns button {
            width: auto;
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
            /* Center horizontally */
        }
    </style>
</head>

<style>

</style>


<body>

    <div id="modal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center hidden">
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


    <div id="deleteModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex justify-center items-center hidden">
        <!-- Modal Content -->
        <div class="bg-white p-6 rounded-lg">
            <h2 class="text-xl font-bold mb-4">Delete Blog</h2>
            <p class="mb-4">Are you sure you want to delete this blog?</p>
            <div class="text-right">
                <input type="hidden" id="blogIdToDelete">
                <button onclick="deleteBlog()" class="btn btn-danger">Delete</button>
                <button onclick="closeDeleteModal()" class="btn btn-secondary">Cancel</button>
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
        <!-- Modal Content -->
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
                    <label for="updateImages" class="block font-semibold mb-2">Images</label>
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


    <script>
        // Store CKEditor instances
        var ckeditors = {};

        // Function to initialize CKEditor for a given ID if not already initialized
        function initCKEditor(id) {
            if (!ckeditors.hasOwnProperty(id)) {
                ClassicEditor
                    .create(document.querySelector('#' + id))
                    .then(editor => {
                        ckeditors[id] = editor; // Store editor instance
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }

        // JavaScript to show and hide the update modal
        function openUpdateModal(blogId, title, description, type) {
            document.getElementById('updateModal').classList.remove('hidden');
            // Populate form fields with existing blog data
            document.getElementById('blogIdToUpdate').value = blogId;
            document.getElementById('updateTitle').value = title;

            // Initialize CKEditor for the description textarea if not already initialized
            initCKEditor('updateDescription');

            // Set the CKEditor content to match the description text
            if (ckeditors.hasOwnProperty('updateDescription')) {
                ckeditors['updateDescription'].setData(description);
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

    <div style="padding-top: 80px;" class="container">
        <!-- Content -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">News & Projects</h1>
            <!-- Add New Button -->
            <button class="btn btn-primary" onclick="openModal()">Add New</button>
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
                        echo "<button onclick=\"editPost('" . $row['id'] . "')\" type='button' class='btn btn-primary'><i class='fas fa-eye'></i> View</button>";
                        echo "<button onclick=\"openUpdateModal('" . $row['id'] . "', '" . $row['title'] . "', '" . $row['description'] . "', '" . $row['type'] . "')\" type='button' class='btn btn-secondary'><i class='fas fa-edit'></i> Update</button>";
                        echo "<button onclick=\"openDeleteModal('" . $row['id'] . "')\" type='button' class='btn btn-danger'><i class='fas fa-trash-alt'></i> Delete</button>";
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