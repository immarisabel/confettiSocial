<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS Feeds</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        body {
              font-family: "Lora", serif;
line-height:2;
letter-spacing:2px;
            margin: 0;
            padding: 0;
            background-color: #222;
            color: #ddd;
        }

		a {
        	text-decoration:none;
        	color:#35a59c;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 20px;
        }
        h2 {
            margin-top: 30px;
            font-size: 28px;
            color: #fff;
        }
        .feed {
            margin-bottom: 40px;
            border-bottom: 1px solid #444;
            padding-bottom: 20px;
        }
        .feed h3 {
            margin-bottom: 10px;
            font-size: 24px;
        }
        .feed p {
            font-size: 18px;
            color: #ccc;
            line-height: 1.4;
        }
        .feed a {
            color: #007bff;
            text-decoration: none;
        }
        .feed a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
    
    <?php

// Function to parse RSS feeds
function parseFeed($url) {
    $xml = simplexml_load_file($url);
    if ($xml === false) {
        return null;
    }
    
    $feeds = array();
    foreach ($xml->channel->item as $item) {
        // Get the title and link
        $title = (string) $item->title;
        $link = (string) $item->link;
        
        // Parse the pubDate to get the publication date
        $pubDate = strtotime((string) $item->pubDate);
        
        // Check if the feed was posted within the last month
        if ($pubDate >= strtotime('-1 month')) {
            // Parse the description, handling HTML content
            $description = (string) $item->description;
            if (strpos($description, '<') !== false && strpos($description, '>') !== false) {
                // Description contains HTML tags
                $description = htmlspecialchars_decode($description); // Decode HTML entities
            } else {
                // Description is plain text
                $description = htmlspecialchars_decode(strip_tags($description)); // Strip HTML tags and decode HTML entities
            }

            // Construct the feed array
            $feed = array(
                'title' => htmlspecialchars_decode($title), // Decode HTML entities in the title
                'link' => $link,
                'description' => $description
            );

            // Add the feed to the feeds array
            $feeds[] = $feed;
        }
    }
    
    return $feeds;
}

// Read URLs from the text file
$file = "feeds.txt";
$urls = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Parse each feed URL and display results
foreach ($urls as $url) {
    $feeds = parseFeed($url);
    if ($feeds !== null) {
        echo "<h2>Feeds from $url:</h2>";
        foreach ($feeds as $feed) {
            echo "<div>";
            echo "<h3><a href='{$feed['link']}'>{$feed['title']}</a></h3>";
            echo "<p>{$feed['description']}</p>";
            echo "</div>";
        }
    } else {
        echo "<p>Unable to load or parse feed from $url</p>";
    }
}

?>
    </div>
</body>
</html>