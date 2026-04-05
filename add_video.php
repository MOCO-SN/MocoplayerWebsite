<?php
header('Content-Type: application/json');

$host = "127.0.0.1";
$user = "u807707365_mocoplayer";
$pass = "Sachin34241@@";
$db   = "u807707365_mocoplayerside";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit;
}

// Create videos table if not exists
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

// Insert test data
$title = "Test Video " . time();
$desc = "Test description";
$videoUrl = "https://example.com/test.mp4";
$thumbUrl = "https://example.com/thumb.jpg";

$stmt = $conn->prepare("INSERT INTO videos (title, description, video_url, thumbnail_url) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $desc, $videoUrl, $thumbUrl);

if ($stmt->execute()) {
    $insertId = $stmt->insert_id;
    echo json_encode(["status" => "success", "message" => "Video added", "id" => $insertId]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
