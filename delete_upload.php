<?php
include "db.php";

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM uploads WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Upload deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete upload"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing ID parameter"]);
}
?>