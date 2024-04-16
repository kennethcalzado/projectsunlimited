<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("../../backend/conn.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $title = $_POST['title'];
    $date = $_POST['date']; // Retrieve the selected date from the form
    $description = $_POST['description'];
    $type = $_POST['type'];
    $page = "{$type}_{$blog_id}";

    // Define the target directory for thumbnails
    $target_dir = "../../assets/blogs_img/";

    // Define the target directory for images
    $image_target_dir = "../../assets/blogs_img/";

    // Check if thumbnail file is uploaded
    if (isset($_FILES['thumbnail'])) {
        $thumbnail_name = $_FILES['thumbnail']['name'];
        $thumbnail_tmp_name = $_FILES['thumbnail']['tmp_name'];

        // Move uploaded thumbnail file to desired location
        $thumbnail_target_path = $target_dir . basename($thumbnail_name);
        if (move_uploaded_file($thumbnail_tmp_name, $thumbnail_target_path)) {
            $thumbnail_name = basename($thumbnail_name);
        } else {
            // Handle error if thumbnail file couldn't be moved
            // You can add your error handling code here
            $thumbnail_name = "default_thumbnail.jpg"; // Use default thumbnail
        }
    } else {
        // If thumbnail is not uploaded, use a default thumbnail
        $thumbnail_name = "default_thumbnail.jpg"; // Change this to your default thumbnail name
    }

    // Check if images files are uploaded
    $images = array();
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $key => $image_name) {
            if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                $image_tmp_name = $_FILES['images']['tmp_name'][$key];
                $images[] = $image_name;

                // Move uploaded image files to desired location
                $target_file_image = $image_target_dir . basename($image_name);
                move_uploaded_file($image_tmp_name, $target_file_image);
            }
        }
    } else {
    }

    // Insert data into the database
    $sql = "INSERT INTO blogs (title, date, thumbnail, description, images, type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $date, $thumbnail_name, $description, implode(',', $images), $type);

    if ($stmt->execute()) {
        // Create new PHP file based on blog type and ID
        $blog_id = $conn->insert_id; // Get the ID of the inserted blog
        $filename = "../../public/blogs/{$type}_{$blog_id}.php"; // Create filename
        $file_content = "<?php 
\$pageTitle = 'Projects Unlimited';
ob_start();
?>

<!DOCTYPE html>
<html lang=\"en\">

<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title><?php echo \$pageTitle; ?></title>
    <link rel=\"stylesheet\" href=\"../../assets/input.css\">
</head>

<body>
    <!-- Your HTML content goes here -->
</body>

</html>

<?php
\$content = ob_get_clean();
include(\"../../public/master.php\");
?>";
        // Example content

        // Write content to the new PHP file
        $result = file_put_contents($filename, $file_content);

        if ($result !== false) {
            // Update the page column with the filename
            $sql_update_page = "UPDATE blogs SET page = ? WHERE id = ?";
            $stmt_update_page = $conn->prepare($sql_update_page);
            $stmt_update_page->bind_param("si", $filename, $blog_id);
            $stmt_update_page->execute();

            if ($stmt_update_page->affected_rows > 0) {
                // Redirect back to the page with success message
                $_SESSION['success'] = "Blog added successfully!";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                // Redirect back to the page with error message
                $_SESSION['error'] = "Failed to update page column. Please try again.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } else {
            // Redirect back to the page with error message
            $_SESSION['error'] = "Failed to create PHP file. Please check file permissions.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        // Redirect back to the page with error message
        $_SESSION['error'] = "Failed to add blog. Please try again.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
