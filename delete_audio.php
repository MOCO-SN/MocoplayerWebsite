<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $conn->prepare("DELETE FROM audios WHERE id = ?");
    $stmt->bind_param("s", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Audio deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete audio"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>