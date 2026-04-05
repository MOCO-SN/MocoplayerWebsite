<?php
include "db.php";

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Video deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete video"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing ID parameter"]);
}
?>