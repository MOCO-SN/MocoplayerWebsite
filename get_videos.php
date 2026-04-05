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

// Check if table has data
$count = $conn->query("SELECT COUNT(*) as cnt FROM videos");
$cnt = $count->fetch_assoc()['cnt'];

if ($cnt == 0) {
    $conn->query("INSERT INTO videos SET title='Demo Video', description='Test video', video_url='https://sample-videos.com/video321/mp4/720/big_buck_bunny_720p_1mb.mp4', thumbnail_url='https://via.placeholder.com/320x180'");
}

$result = $conn->query("SELECT * FROM videos ORDER BY id DESC");
$videos = [];
while ($row = $result->fetch_assoc()) {
    $videos[] = $row;
}

echo json_encode($videos);
$conn->close();
?>
