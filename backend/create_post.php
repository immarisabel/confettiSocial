<?php
// Include the database connection script
require_once 'db_connection.php';

// Check if the user is logged in (you can implement session management for this)
// For demonstration purposes, assuming session management sets the user ID
// Get the user ID of the logged-in user from your session management system
session_start(); // Start the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Handle case when user is not logged in
    echo "Error: User is not logged in";
    exit; // Stop execution
}

// Get form data
$content = $_POST['content'];

// Prepare and execute SQL statement to insert post into the database
$sql = "INSERT INTO posts (user_id, content) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $content);

if ($stmt->execute()) {
    echo "Post created successfully!";
 	header("Location: ../index.php");
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$stmt->close();
$conn->close();

?>