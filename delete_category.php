<?php
header('Content-Type: application/json');
include "db.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "No ID provided"]);
    exit;
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Category deleted"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error deleting category"]);
}
?>