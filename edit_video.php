<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $videoUrl = $_POST['video_url'] ?? '';
    $thumbnailUrl = $_POST['thumbnail_url'] ?? '';
    $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;
    
    if (empty($id)) {
        echo json_encode(["status" => "error", "message" => "Video ID is required"]);
        exit;
    }
    
    if (empty($title)) {
        echo json_encode(["status" => "error", "message" => "Title is required"]);
        exit;
    }
    
    $stmt = $conn->prepare("UPDATE videos SET title = ?, description = ?, video_url = COALESCE(NULLIF(?, ''), video_url), thumbnail_url = COALESCE(NULLIF(?, ''), thumbnail_url), category_id = COALESCE(NULLIF(?, ''), category_id) WHERE id = ?");
    $stmt->bind_param("ssssii", $title, $description, $videoUrl, $thumbnailUrl, $categoryId, $id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Video updated successfully"
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update video"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
