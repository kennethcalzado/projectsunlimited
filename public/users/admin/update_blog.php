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

    // Check if thumbnail file is uploaded
    if (isset($_FILES['updateThumbnail'])) {
        $thumbnail_name = $_FILES['updateThumbnail']['name'];
        $thumbnail_tmp_name = $_FILES['updateThumbnail']['tmp_name'];

        // Move uploaded thumbnail file to desired location
        $target_dir = "../../../assets/blogs_img/";
        $target_file = $target_dir . basename($thumbnail_name);
        move_uploaded_file($thumbnail_tmp_name, $target_file);
    } else {
        // If thumbnail is not uploaded, retain the existing thumbnail
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
            $image_tmp_name = $_FILES['updateImages']['tmp_name'][$key];
            $images[] = $image_name;

            // Move uploaded image files to desired location
            $target_file = $target_dir . basename($image_name);
            move_uploaded_file($image_tmp_name, $target_file);
        }
    } else {
        // If images are not uploaded, retain the existing images
        $sql_select_images = "SELECT images FROM blogs WHERE id = ?";
        $stmt_select_images = $conn->prepare($sql_select_images);
        $stmt_select_images->bind_param("i", $blogId);
        $stmt_select_images->execute();
        $result_select_images = $stmt_select_images->get_result();
        $row_select_images = $result_select_images->fetch_assoc();
        $images = explode(',', $row_select_images['images']);
    }

    // Update data in the database
    $sql = "UPDATE blogs SET title = ?, description = ?, thumbnail = ?, images = ?, type = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $title, $description, $thumbnail_name, implode(',', $images), $type, $blogId);

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
