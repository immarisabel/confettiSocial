<?php
// Include the database connection script
require_once 'db_connection.php';

// Get form data
$username_email = $_POST['username_email'];
$password = $_POST['password'];

// Prepare and execute SQL statement to retrieve user information
$sql = "SELECT id, username, email, password FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username_email, $username_email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists and verify password
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Login successful
        // Start session
        session_start();

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to index page
        header("Location: index.php");
        exit;
    } else {
        // Incorrect password
        echo "Incorrect username/email or password.";
    }
} else {
    // User does not exist
    echo "Incorrect username/email or password.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
