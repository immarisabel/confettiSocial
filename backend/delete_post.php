<?php
// Include the database connection script
require_once 'db_connection.php';

// Check if the post ID is provided in the request
if (isset($_POST['post_id'])) {
    // Sanitize the post ID to prevent SQL injection
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);

    // Prepare and execute SQL statement to delete the post from the database
    $sql = "DELETE FROM posts WHERE id = $post_id";
    if ($conn->query($sql) === TRUE) {
        // Post deleted successfully
        echo "Post deleted successfully!";
    } else {
        // Error deleting post
        echo "Error deleting post: " . $conn->error;
    }
} else {
    // Post ID not provided in the request
    echo "Post ID not provided.";
}

// Close the database connection
$conn->close();
?>
