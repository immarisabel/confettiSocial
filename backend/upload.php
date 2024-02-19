<?php
if (isset($_POST['submit'])) {

    // Retrieve form data
    $imageTitle = $_POST['filetitle'];
    $imageDesc = $_POST['filedesc'];

    $file = $_FILES['fileToUpload'];

    $fileName = $file["name"];
    $fileTempName = $file["tmp_name"];

    // Generate unique file name
    $imageFullName = uniqid("", true) . "_" . $fileName;
    $fileDestination = "photos/" . $imageFullName;

    // Include database connection
    include_once "db_connection.php";

    // Check if connection is successful
    if ($conn) {
        // Check if the user is logged in
        session_start();
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            // Handle case when user is not logged in
            echo "Error: User is not logged in";
            exit; // Stop execution
        }

        // Prepare and execute SQL statement
        $sql = "INSERT INTO gallery (user_id, titleGallery, descGallery, imgFullNameGallery, dateGallery) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed!";
        } else {
            mysqli_stmt_bind_param($stmt, "isss", $user_id, $imageTitle, $imageDesc, $imageFullName);
            mysqli_stmt_execute($stmt);

            // Move uploaded file to destination
            move_uploaded_file($fileTempName, $fileDestination);

            // Redirect with success message
            header("Location: ../index.php?upload=success");
            exit();
        }
    } else {
        // Database connection failed
        echo "Database connection failed!";
    }
}
?>
