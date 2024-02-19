<?php
// Include the database connection script
require_once 'db_connection.php';

// Start session
session_start();

// Number of items per page
$itemsPerPage = 5; // Change this value as needed

// Determine current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = intval($_GET['page']);
} else {
    $currentPage = 1; // Default to the first page
}

// Calculate the offset for the SQL query
$offset = ($currentPage - 1) * $itemsPerPage;

// Initialize date variable
$date = isset($_POST['date']) ? $_POST['date'] : date("Y-m-d"); // Default to today's date if not provided

// Fetch posts and images combined, ordered by date with pagination
$sql_combined = "SELECT 'post' AS type, id, user_id, content, created_at FROM posts
                 WHERE DATE(created_at) = '$date'
                 UNION ALL
                 SELECT 'image' AS type, idGallery AS id, user_id, imgFullNameGallery AS content,  dateGallery AS created_at FROM gallery
                 WHERE DATE(dateGallery) = '$date'
                 ORDER BY created_at DESC
                 LIMIT $itemsPerPage OFFSET $offset"; // Add pagination to the query
$result_combined = $conn->query($sql_combined);

// Check if the query was successful
if (!$result_combined) {
    echo "Error executing query: " . $conn->error;
    exit();
}

// Count total number of posts and images
$sql_total = "SELECT COUNT(*) AS total FROM (SELECT 'post' AS type FROM posts
              WHERE DATE(created_at) = '$date'
              UNION ALL
              SELECT 'image' AS type FROM gallery
              WHERE DATE(dateGallery) = '$date') AS combined";
$result_total = $conn->query($sql_total);

// Check if the query was successful
if (!$result_total) {
    echo "Error executing query: " . $conn->error;
    exit();
}

$totalItems = $result_total->fetch_assoc()["total"];

// Calculate total number of pages
$totalPages = ceil($totalItems / $itemsPerPage);

// Pagination controls at the top
echo '<div class="pagination">';
if ($currentPage > 1) {
    echo "<a href='?page=" . ($currentPage - 1) . "'><span class='material-icons'>arrow_back</span></a>";
}
if ($currentPage < $totalPages) {
    echo "<a href='?page=" . ($currentPage + 1) . "'><span class='material-icons'>arrow_forward</span></a>";
}
echo "</div>";

// Add container for the form
echo '<div class="date-selection-container">';
echo '<form method="post" action="">';
echo '<label for="date">Select Date:</label>';
echo '<input type="date" id="date" name="date" value="' . $date . '" min="2000-01-01" max="' . date("Y-m-d") . '">';
echo '<button type="submit" class="material-icons">refresh</button>';
echo '</form>';
echo '</div>';

// Check if there are posts or images to display
if ($result_combined->num_rows > 0) {
    while ($row = $result_combined->fetch_assoc()) {
        // Format the date and time
        $formattedDateTime = date("F j, Y, g:i a", strtotime($row["created_at"]));
        
        // Output post or image based on type
        echo "<div>";
        if ($row["type"] === 'post') {
            // Post
            $sql_username = "SELECT username FROM users WHERE id = " . $row["user_id"];
            $result_username = $conn->query($sql_username);
            $username = $result_username->fetch_assoc()["username"];
            echo "<p><strong>" . $username . "</strong>: " . $row["content"] . 
                 " <span style='font-size: 0.8em; color: #666;'><br>Posted on " . $formattedDateTime . "</br></span> ";
            echo "<a href='load_post.php?type=post&id=" . $row["id"] . "'>View Post</a>";
            echo "</p>";

            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                // User is logged in, display delete button for posts
                echo "<button onclick=\"deletePost(" . $row["id"] . ")\">Delete Post</button>";
            }
        } else {
            // Image
            // Fetch username for image
            $sql_username = "SELECT username FROM users WHERE id = " . $row["user_id"];
            $result_username = $conn->query($sql_username);
            $username = $result_username->fetch_assoc()["username"];

            echo "<p><strong>" . $username . "</strong>: ";
            echo "<a href='load_post.php?type=image&id=" . $row["id"] . "'><img src='/photos/" . $row["content"] . "' style='width:100%;'></a>";
            echo " <span style='font-size: 0.8em; color: #666;'><br>Posted on " . $formattedDateTime . "</br></span></p>";

            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                // User is logged in, display delete button for images
                echo "<button onclick=\"deleteImage(" . $row["id"] . ")\">Delete Image</button>";
            }
        }
        echo "</div>";
    }

    // Pagination controls at the bottom
    echo '<div class="pagination">';
    if ($currentPage > 1) {
        echo "<a href='?page=" . ($currentPage - 1) . "'><span class='material-icons'>arrow_back</span></a>";
    }
    if ($currentPage < $totalPages) {
        echo "<a href='?page=" . ($currentPage + 1) . "'><span class='material-icons'>arrow_forward</span></a>";
    }
    echo "</div>";

} else {
    echo "No posts or images to display.";
}

// Close the database connection
$conn->close();
?>