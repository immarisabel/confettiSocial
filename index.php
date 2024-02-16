<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login_form.php");
    exit;
}

// Include the database connection script
require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Posts</title>
</head>
<body>
    <h2>Posts</h2>
    <a href="logout.php">Logout</a> <!-- Add logout button -->

    <!-- Display posts -->
    <?php include 'display_posts.php'; ?>

    <!-- Post form -->
    <h2>Create Post</h2>
    <form action="create_post.php" method="post">
        <label for="content">Post Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
