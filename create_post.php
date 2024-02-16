<?php
// Include the database connection script
require_once 'db_connection.php';

// Check if the user is logged in (you can implement session management for this)
// For demonstration purposes, assuming user ID 1 represents the logged-in user
$user_id = 1;

// Get form data
$content = $_POST['content'];

// Prepare and execute SQL statement to insert post into the database
$sql = "INSERT INTO posts (user_id, content) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $content);

if ($stmt->execute()) {
    echo "Post created successfully!";
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
