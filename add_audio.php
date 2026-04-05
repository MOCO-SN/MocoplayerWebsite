<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $audioUrl = $_POST['audio_url'] ?? '';
    $imageUrl = $_POST['image_url'] ?? '';
    
    if (empty($title) || empty($audioUrl) || empty($imageUrl)) {
        echo json_encode(["status" => "error", "message" => "Title, audio_url and image_url are required"]);
        exit;
    }
    
    $id = uniqid();
    
    $stmt = $conn->prepare("INSERT INTO audios (id, title, description, audio_url, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id, $title, $description, $audioUrl, $imageUrl);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Audio added successfully",
            "id" => $id
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add audio"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>