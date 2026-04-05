<?php
include "db.php";

header('Content-Type: application/json');

$stmt = $conn->prepare("INSERT INTO videos (title, description, video_url, thumbnail_url) VALUES (?, ?, ?, ?)");
$title = "Test Video";
$desc = "This is a test video";
$videoUrl = "https://mocoplayer.interiorsita.com/uploads/videos/test.mp4";
$thumbUrl = "https://mocoplayer.interiorsita.com/uploads/videos/test.jpg";

$stmt->bind_param("ssss", $title, $desc, $videoUrl, $thumbUrl);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Video added", "id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
?>
