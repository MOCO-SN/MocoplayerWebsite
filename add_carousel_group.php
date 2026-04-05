<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    
    if (empty($name)) {
        echo json_encode(["status" => "error", "message" => "Name is required"]);
        exit;
    }
    
    $stmt = $conn->prepare("INSERT INTO carousel_groups (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Carousel group added successfully",
            "id" => $stmt->insert_id
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add carousel group"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>