<?php
error_reporting(E_ALL);

$host = "127.0.0.1";
$user = "u807707365_mocoplayer";
$pass = "Sachin34241@@";
$db   = "u807707365_mocoplayerside";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed");
}

$conn->query("CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    video_url TEXT NOT NULL,
    thumbnail_url TEXT,
    category_id INT,
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$title = "Test Video " . time();
$desc = "Test description";
$videoUrl = "https://example.com/test.mp4";
$thumbUrl = "https://example.com/thumb.jpg";

$stmt = $conn->prepare("INSERT INTO videos (title, description, video_url, thumbnail_url) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $desc, $videoUrl, $thumbUrl);

if ($stmt->execute()) {
    echo "INSERT_SUCCESS:" . $stmt->insert_id;
} else {
    echo "INSERT_ERROR:" . $stmt->error;
}

$stmt->close();
$conn->close();
?>
