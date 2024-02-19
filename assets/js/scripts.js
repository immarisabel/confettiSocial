$(document).ready(function() {
        $('.content').richText();
    });
   


    function deleteImage(imageId) {
        if (confirm("Are you sure you want to delete this image?")) {
            // Send an AJAX request to delete the image
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_image.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Image deleted successfully, reload the page
                        location.reload();
                    } else {
                        // Error occurred while deleting the image
                        alert("Error deleting the image. Please try again.");
                    }
                }
            };
            xhr.send("image_id=" + imageId);
        }
    }

    function deletePost(postId) {
        // Send an AJAX request to delete_post.php with the post ID
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "backend/delete_post.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Display the response message
                alert(xhr.responseText);
                // Refresh the page to reflect the changes
                location.reload();
            }
        };
        xhr.send("post_id=" + postId);
    }

