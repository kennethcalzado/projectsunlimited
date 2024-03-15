<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("../../../backend/conn.php");

// Check if form is submitted
if (
    $_SERVER["REQUEST_METHOD"] == "POST"
) {
    // Validate form inputs
    $title = $_POST['title'];
    $date = date("Y-m-d"); // Current date
    $description = $_POST['description'];
    $type = $_POST['type'];

    // Check if thumbnail file is uploaded
    if (isset($_FILES['thumbnail'])) {
        $thumbnail_name = $_FILES['thumbnail']['name'];
        $thumbnail_tmp_name = $_FILES['thumbnail']['tmp_name'];

        // Move uploaded thumbnail file to desired location
        $target_dir = "../assets/blogs_img/";
        $target_file = $target_dir . basename($thumbnail_name);
        move_uploaded_file($thumbnail_tmp_name, $target_file);
    } else {
        // If thumbnail is not uploaded, use a default thumbnail
        $thumbnail_name = "default_thumbnail.jpg"; // Change this to your default thumbnail name
    }

    // Check if images files are uploaded
    $images = array();
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $key => $image_name) {
            $image_tmp_name = $_FILES['images']['tmp_name'][$key];
            $images[] = $image_name;

            // Move uploaded image files to desired location
            $target_file = $target_dir . basename($image_name);
            move_uploaded_file($image_tmp_name, $target_file);
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO blogs (title, date, thumbnail, description, images, type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $date, $thumbnail_name, $description, implode(',', $images), $type);

    if ($stmt->execute()) {
        // Create new PHP file based on blog type and ID
        $blog_id = $conn->insert_id; // Get the ID of the inserted blog
        $filename = "../../../public/blogs/{$type}_{$blog_id}.php"; // Create filename
        $file_content = "<?php // Content for your new blog file goes here ?>"; // Example content

        // Write content to the new PHP file
        $result = file_put_contents($filename, $file_content);

        if ($result !== false) {
            // Redirect back to the page with success message
            $_SESSION['success'] = "Blog added successfully!";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
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
