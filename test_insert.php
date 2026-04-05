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

// Try inserting into slider_images as test
$conn->query("INSERT INTO slider_images (image_url) VALUES ('https://example.com/test.jpg')");

$result = $conn->query("SELECT * FROM slider_images ORDER BY id DESC LIMIT 5");
$images = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
}

echo json_encode($images);
$conn->close();
?>
