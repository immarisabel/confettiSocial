<?php
// Start session
session_start();

// Clear all session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page or any other page after logout
header("Location: login_form.php");
exit;
?>
