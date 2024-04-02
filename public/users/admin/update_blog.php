<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include("../../../backend/conn.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $blogId = $_POST['blogIdToUpdate'];
    $title = $_POST['updateTitle'];
    $description = $_POST['updateDescription'];
    $type = $_POST['updateType'];
    $date = $_POST['updateDate'];

    // Define target directory for thumbnails
    $thumbnail_target_dir = "../../../assets/blogs_img/";
    // Define target directory for images
    $image_target_dir = "../../../assets/blogs_img/";

    // Check if thumbnail file is uploaded
    if (isset($_FILES['updateThumbnail']) && $_FILES['updateThumbnail']['error'] === UPLOAD_ERR_OK) {
        $thumbnail_name = $_FILES['updateThumbnail']['name'];
        $thumbnail_tmp_name = $_FILES['updateThumbnail']['tmp_name'];

        // Move uploaded thumbnail file to desired location
        $target_file_thumbnail = $thumbnail_target_dir . basename($thumbnail_name);
        move_uploaded_file($thumbnail_tmp_name, $target_file_thumbnail);
    } else {
        // If thumbnail is not uploaded or there's an error, retain the existing thumbnail
        $sql_select_thumbnail = "SELECT thumbnail FROM blogs WHERE id = ?";
        $stmt_select_thumbnail = $conn->prepare($sql_select_thumbnail);
        $stmt_select_thumbnail->bind_param("i", $blogId);
        $stmt_select_thumbnail->execute();
        $result_select_thumbnail = $stmt_select_thumbnail->get_result();
        $row_select_thumbnail = $result_select_thumbnail->fetch_assoc();
        $thumbnail_name = $row_select_thumbnail['thumbnail'];
    }

    // Check if images files are uploaded
    $images = array();
    if (!empty($_FILES['updateImages']['name'][0])) {
        foreach ($_FILES['updateImages']['name'] as $key => $image_name) {
            if ($_FILES['updateImages']['error'][$key] === UPLOAD_ERR_OK) {
                $image_tmp_name = $_FILES['updateImages']['tmp_name'][$key];
                $images[] = $image_name;

                // Move uploaded image files to desired location
                $target_file_image = $image_target_dir . basename($image_name);
                move_uploaded_file($image_tmp_name, $target_file_image);
            }
        }
    } else {
        // If images are not uploaded or there's an error, retain the existing images
        $sql_select_images = "SELECT images FROM blogs WHERE id = ?";
        $stmt_select_images = $conn->prepare($sql_select_images);
        $stmt_select_images->bind_param("i", $blogId);
        $stmt_select_images->execute();
        $result_select_images = $stmt_select_images->get_result();
        $row_select_images = $result_select_images->fetch_assoc();
        $images = explode(',', $row_select_images['images']);
    }
    // Handle removal of images
    if (!empty($_POST['removedImages'])) {
        $removedImageIndexes = json_decode($_POST['removedImages']);

        // Debug statement to check the value of removedImages
        echo "<script>console.log('Removed Images: " . json_encode($_POST['removedImages']) . "');</script>";

        // Debug statement to check the removed image indexes
        echo "<script>console.log('Removed Image Indexes: " . json_encode($removedImageIndexes) . "');</script>";

        // Explode the images column result to get separate image filenames
        $existingImages = explode(
            ',',
            $row_select_images['images']
        );

        // Debug statement to check the existing images before removal
        echo "<script>console.log('Existing Images Before Removal: " . json_encode($existingImages) . "');</script>";

        // Loop through each removed image index
        foreach ($removedImageIndexes as $index) {
            // Check if the index is valid
            if (isset($existingImages[$index])) {
                // Remove the image
                unset($existingImages[$index]);
            }
        }

        // Remove empty elements and re-index the array
        $existingImages = array_values($existingImages);

        // Debug statement to check the existing images after removal
        echo "<script>console.log('Existing Images After Removal: " . json_encode($existingImages) . "');</script>";

        // Implode the remaining images to update the 'images' column in the database
        $images_str = implode(',', $existingImages);

        // Update the 'images' column in the database
        $sql_update_images = "UPDATE blogs SET images = ? WHERE id = ?";
        $stmt_update_images = $conn->prepare($sql_update_images);
        $stmt_update_images->bind_param("si", $images_str, $blogId);
        $stmt_update_images->execute();
    }

    // Update data in the database
    $sql = "UPDATE blogs SET title = ?, description = ?, type = ?";
    $param_types = "sss";
    $param_values = array($title, $description, $type);

    // Add date to the update query if it is provided
    if (!empty($date)) {
        $sql .= ", date = ?";
        $param_types .= "s";
        $param_values[] = $date;
    }

    // Add thumbnail to the update query if it is not empty
    if (!empty($thumbnail_name)) {
        $sql .= ", thumbnail = ?";
        $param_types .= "s";
        $param_values[] = $thumbnail_name;
    }

    if (!empty($images)) {
        $sql .= ", images = ?";
        $param_types .= "s";
        $param_values[] = implode(',', $images);
    }

    $sql .= " WHERE id = ?";
    $param_types .= "i";
    $param_values[] = $blogId;

    // Prepare and bind parameters for the update query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($param_types, ...$param_values);

    if ($stmt->execute()) {
        // Redirect back to the page with success message
        $_SESSION['success'] = "Blog updated successfully!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Redirect back to the page with error message
        $_SESSION['error'] = "Failed to update blog. Please try again.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
