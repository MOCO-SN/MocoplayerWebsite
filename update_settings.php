<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = isset($_POST['key']) ? trim($_POST['key']) : '';
    $value = isset($_POST['value']) ? trim($_POST['value']) : '';
    
    if (empty($key)) {
        echo json_encode(["status" => "error", "message" => "Setting key is required"]);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    $stmt->bind_param("ss", $key, $value);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Setting updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update setting"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>