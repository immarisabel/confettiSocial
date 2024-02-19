<?php
// Include the database connection script
require_once '../backend/db_connection.php';

// Fetch posts and images combined, ordered by date
$sql_combined = "SELECT 'post' AS type, posts.id AS id, posts.user_id, posts.content, posts.created_at, NULL AS imgFullNameGallery 
                 FROM posts 
                 UNION ALL 
                 SELECT 'image' AS type, gallery.idGallery AS id, gallery.user_id, NULL AS content, gallery.dateGallery AS created_at, gallery.imgFullNameGallery 
                 FROM gallery 
                 ORDER BY created_at DESC"; // Combine and order by date
$result_combined = $conn->query($sql_combined);

// Start generating the XML feed
header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>Marisabel Status Feed</title>
    <subtitle>An experiment on solo media. Like social media but for myself.</subtitle>
    <link href="https://social.marisabel.nl"/>
    <updated><?php echo date("Y-m-d\TH:i:s\Z"); ?></updated>
    <author>
        <name>Marisabel Munoz</name>
    </author>

    <?php
    // Output data of each row as XML entries
    while ($row = $result_combined->fetch_assoc()) {
        ?>
<entry>
    <title><?php echo $row["type"] === 'post' ? "Post" : "Image"; ?></title>
<link href="https://social.marisabel.nl/load_post.php?type=<?php echo $row["type"]; ?>&amp;id=<?php echo $row["id"]; ?>"/>
    <id><?php echo htmlspecialchars($row["id"]); ?></id>
    <updated><?php echo date("Y-m-d\TH:i:s\Z", strtotime($row["created_at"])); ?></updated>
    <?php if ($row["type"] === 'post') { ?>
        <content type="html"><![CDATA[<?php echo htmlspecialchars_decode($row["content"]); ?>]]></content>
    <?php } elseif ($row["type"] === 'image') { ?>
        <content type="html"><![CDATA[<img src="https://social.marisabel.nl/photos/<?php echo $row["imgFullNameGallery"]; ?>" alt="Image"/>]]></content>
    <?php } ?>
</entry>


        <?php
    }
    ?>
</feed>
<?php
// Close the database connection
$conn->close();
?>
