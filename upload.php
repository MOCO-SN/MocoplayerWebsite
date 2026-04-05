<?php
include "db.php";

header('Content-Type: application/json');

$uploadType = $_POST['type'] ?? 'image';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "Upload failed"]);
        exit;
    }
    
    if ($uploadType === 'audio') {
        $allowedTypes = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg', 'audio/m4a'];
        $fileType = $file['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(["status" => "error", "message" => "Only MP3, WAV, OGG, M4A files allowed"]);
            exit;
        }
        
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = 'audio_' . time() . '_' . uniqid() . '.' . $ext;
        
        $uploadDir = 'uploads/audios/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $targetPath = $uploadDir . $newName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $fileUrl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $targetPath;
            
            echo json_encode([
                "status" => "success",
                "message" => "Audio uploaded successfully",
                "url" => $fileUrl,
                "file_name" => $newName
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to move uploaded file"]);
        }
    } elseif ($uploadType === 'video' || $uploadType === 'thumbnail') {
        $allowedTypes = ['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'];
        $fileType = $file['type'];
        
        if ($uploadType === 'video' && !in_array($fileType, $allowedTypes)) {
            echo json_encode(["status" => "error", "message" => "Only MP4, WEBM, OGG, MOV files allowed"]);
            exit;
        }
        
        if ($uploadType === 'thumbnail') {
            $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($fileType, $allowedImageTypes)) {
                echo json_encode(["status" => "error", "message" => "Only JPEG, PNG, GIF, WEBP files allowed"]);
                exit;
            }
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = 'thumb_' . time() . '_' . uniqid() . '.' . $ext;
            $uploadDir = 'uploads/videos/';
        } else {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = 'video_' . time() . '_' . uniqid() . '.' . $ext;
            $uploadDir = 'uploads/videos/';
        }
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $targetPath = $uploadDir . $newName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $fileUrl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $targetPath;
            
            echo json_encode([
                "status" => "success",
                "message" => ($uploadType === 'video' ? "Video" : "Thumbnail") . " uploaded successfully",
                "url" => $fileUrl,
                "file_name" => $newName
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to move uploaded file"]);
        }
    } else {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = $file['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(["status" => "error", "message" => "Only JPEG, PNG, GIF, WEBP files allowed"]);
            exit;
        }
        
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = 'upload_' . time() . '_' . uniqid() . '.' . $ext;
        
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $targetPath = $uploadDir . $newName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $fileUrl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $targetPath;
            
            $stmt = $conn->prepare("INSERT INTO uploads (file_name, file_url, file_type) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $newName, $fileUrl, $fileType);
            $stmt->execute();
            $uploadId = $stmt->insert_id;
            $stmt->close();
            
            echo json_encode([
                "status" => "success",
                "message" => "File uploaded successfully",
                "url" => $fileUrl,
                "id" => $uploadId,
                "file_name" => $newName
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to move uploaded file"]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "No file uploaded"]);
}
?>