<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $audioUrl = $_POST['audio_url'] ?? '';
    $imageUrl = $_POST['image_url'] ?? '';
    
    if (empty($id)) {
        echo json_encode(["status" => "error", "message" => "Audio ID is required"]);
        exit;
    }
    
    if (empty($title)) {
        echo json_encode(["status" => "error", "message" => "Title is required"]);
        exit;
    }
    
    $stmt = $conn->prepare("UPDATE audios SET title = ?, description = ?, audio_url = COALESCE(NULLIF(?, ''), audio_url), image_url = COALESCE(NULLIF(?, ''), image_url) WHERE id = ?");
    $stmt->bind_param("sssss", $title, $description, $audioUrl, $imageUrl, $id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Audio updated successfully"
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update audio"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>