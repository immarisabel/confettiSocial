<?php
// Include the database connection script
require_once 'db_connection.php';

// Fetch posts from the database
$sql = "SELECT posts.*, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.created_at DESC"; // Fetch posts in descending order of creation time
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" . $row["username"] . "</strong>: " . $row["content"] . "</p>";
    }
} else {
    echo "No posts to display.";
}

// Close the database connection
$conn->close();
?>
