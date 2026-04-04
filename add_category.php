<?php
header('Content-Type: application/json');
include "db.php";

if (!isset($_POST['name']) || empty(trim($_POST['name']))) {
    echo json_encode(["status" => "error", "message" => "Category name is required"]);
    exit;
}

$name = trim($_POST['name']);
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$icon = isset($_POST['icon']) ? trim($_POST['icon']) : 'folder';

$stmt = $conn->prepare("INSERT INTO categories (name, description, icon) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $description, $icon);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Category added successfully", "id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Error adding category"]);
}
?>