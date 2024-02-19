<!DOCTYPE html>
<html lang="en">
<?php include 'header.php' ?>

    <?php
    // Start session
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // User is logged in, display logout button
        echo '<a href="backend/logout.php">            <span class="material-icons">logout</span>
</a>';
    }

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // User is logged in, display post form and delete buttons
        echo '
        <div class="container">
        <div class="form-group">
            <form action="backend/create_post.php" method="post">
                <label for="content">Content:</label><br>
                <textarea id="content" class="content" name="content" rows="6" required></textarea><br>
                <input type="submit" value="Submit">
            </form>
        </div>
        <div class="form-group">
            <form action="backend/upload.php" method="post" enctype="multipart/form-data">
                <label for="fileToUpload">Select image to upload:</label><br>
                <input type="file" name="fileToUpload" id="fileToUpload"><br>
                <label for="filetitle">Title:</label><br>
                <input type="text" name="filetitle" id="filetitle"><br>
                <label for="filedesc">Description:</label><br>
                <textarea name="filedesc" id="filedesc" rows="4"></textarea><br>
                <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>
    </div>
        ';
    }

    // Display posts
    include 'backend/display_posts.php';
    ?>
<?php include 'footer.php' ?>
    </body>

    
</html>