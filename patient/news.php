<?php
$category = 'health'; // Example category
$language = 'en'; // Example language
$apiKey = '374adb940cd542f3a0f32b0b61e82ce7'; // Replace with your actual API key

// Encode URL parameters
$url = "https://newsapi.org/v2/top-headlines?category=" . urlencode($category) . "&language=" . urlencode($language) . "&apiKey=" . urlencode($apiKey);

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true, // Return response as a string instead of outputting it
    CURLOPT_SSL_VERIFYHOST => false, // Skip host verification (you can remove this in production)
    CURLOPT_SSL_VERIFYPEER => false, // Skip peer verification (you can remove this in production)
    CURLOPT_TIMEOUT => 30, // Timeout in seconds
    CURLOPT_USERAGENT => 'Your-App-Name', // Replace with your application's name
]);

// Execute cURL session
$response = curl_exec($curl);

// Check for cURL errors
if ($response === false) {
    die('Failed to fetch news. cURL error: ' . curl_error($curl));
}

// Check HTTP status code
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
if ($httpCode !== 200) {
    die('Failed to fetch news. HTTP Status Code: ' . $httpCode);
}

// Close cURL session
curl_close($curl);

// Decode JSON response
$data = json_decode($response, true);

// Check if decoding was successful
if ($data === null || !isset($data['articles'])) {
    die('Failed to fetch news. API response error.');
}

// Extract articles from response
$articles = $data['articles'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health News</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .article {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .article h2 {
            margin-top: 0;
            font-size: 1.8rem;
            color: #333;
        }

        .article p {
            color: #666;
        }

        .article a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .article a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Health News</h1>
        <?php foreach ($articles as $article) : ?>
            <div class="article">
                <h2><?php echo htmlspecialchars($article['title']); ?></h2>
                <p><?php echo htmlspecialchars($article['description']); ?></p>
                <a href="<?php echo htmlspecialchars($article['url']); ?>" target="_blank">Read more</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
