<?php
// Include the database connection script
require_once 'db_connection.php';

// Check if the user is logged in (you can implement session management for this)
// For demonstration purposes, assuming user ID 1 represents the logged-in user
$follower_id = 1;
$following_id = $_POST['following_id']; // Assuming you pass the ID of the user to follow via POST

// Check if the user is already following the other user (optional)
$sql_check = "SELECT * FROM followers WHERE follower_id = ? AND following_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $follower_id, $following_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows == 0) {
    // Prepare and execute SQL statement to insert follow relationship into the database
    $sql_insert = "INSERT INTO followers (follower_id, following_id) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $follower_id, $following_id);

    if ($stmt_insert->execute()) {
        echo "You are now following this user.";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "You are already following this user.";
}

// Close the database connections
$stmt_check->close();
$stmt_insert->close();
$conn->close();
?>
