<?php
// Include the database connection script
require_once 'db_connection.php';

// Check if the image ID is provided
if (isset($_POST['image_id'])) {
    $imageId = $_POST['image_id'];
    
    // Prepare and execute the SQL query to delete the image
    $sql = "DELETE FROM gallery WHERE idGallery = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $imageId);
    if ($stmt->execute()) {
        // Image deleted successfully
        echo "success";
    } else {
        // Error occurred while deleting the image
        echo "error";
    }
} else {
    // Image ID not provided
    echo "no_id";
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
