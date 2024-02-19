<?php include 'header.php'?>

<?php
// Include the database connection script
require_once 'backend/db_connection.php';

// Check if the type and ID parameters are set
if(isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];

    // Load post or picture based on type and ID
    if($type === 'post') {
        // Load post
        $sql = "SELECT posts.*, users.username 
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                WHERE posts.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Display post content
        echo "<div class='container'>";
        echo "<p><strong>" . $row["username"] . "</strong>: " . $row["content"] . 
             " <span style='font-size: 0.8em; color: #666;'><br>Posted on " . $row["created_at"] . "</br></span>";
    	echo "<a href='../'>back</a>";
        
        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // User is logged in, display delete button for posts
            echo "<button onclick=\"deletePost(" . $row["id"] . ")\">Delete Post</button>";
        }

        echo "</div>"; // Close the container div
    } elseif ($type === 'image') {
        // Load image
        $sql = "SELECT * FROM gallery WHERE idGallery = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Display image
        echo "<h2>Image</h2>";
        echo "<img style='max-width: 100%; margin-left:auto; margin-right:auto;' src='/photos/" . $row['imgFullNameGallery'] . "' alt='Image'>";
        	echo "<a href='../'>back</a>";

    } else {
        echo "Invalid type.";
    }
} else {
    echo "Type and ID parameters are required.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
