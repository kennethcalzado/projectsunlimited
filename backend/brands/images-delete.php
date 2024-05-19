<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection script
include '../../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['imageSrc']) && isset($_POST['brandId'])) {
        // Sanitize the inputs to prevent SQL injection
        $imageSrc = filter_var($_POST['imageSrc'], FILTER_SANITIZE_STRING);
        $brandId = intval($_POST['brandId']);
        
        // Verify that both imageSrc and brandId are valid
        if ($imageSrc && $brandId) {
            try {
                // Fetch the brand data from the database
                $stmt = $conn->prepare("SELECT images FROM brands WHERE brand_id = ?");
                $stmt->bind_param('i', $brandId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $brand = $result->fetch_assoc();
                    $images = json_decode($brand['images'], true);

                    // Check if the image exists in the images array
                    if (($key = array_search($imageSrc, $images)) !== false) {
                        // Remove the image from the images array
                        unset($images[$key]);

                        // Update the images column in the database
                        $updatedImages = json_encode(array_values($images));
                        $updateStmt = $conn->prepare("UPDATE brands SET images = ? WHERE brand_id = ?");
                        $updateStmt->bind_param('si', $updatedImages, $brandId);
                        $updateStmt->execute();

                        // Delete the image file from the server
                        $imagePath = '../../assets/brands_images/' . basename($imageSrc);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }

                        // Respond with success
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Image not found.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Brand not found.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid parameters.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing required parameters.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
