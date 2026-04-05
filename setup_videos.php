<?php
include "db.php";

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

$result = $conn->query("SELECT COUNT(*) as cnt FROM videos");
$row = $result->fetch_assoc();

if ($row['cnt'] == 0) {
    $conn->query("INSERT INTO videos (title, description, video_url, thumbnail_url) VALUES 
        ('Sample Video 1', 'This is a test video', 'https://sample-videos.com/video321/mp4/720/big_buck_bunny_720p_1mb.mp4', 'https://via.placeholder.com/320x180'),
        ('Sample Video 2', 'Another test video', 'https://sample-videos.com/video321/mp4/720/big_buck_bunny_720p_2mb.mp4', 'https://via.placeholder.com/320x180')");
}

echo json_encode(["status" => "success", "message" => "Setup complete"]);
?>
