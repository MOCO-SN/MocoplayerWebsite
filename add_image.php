<?php
header('Content-Type: application/json');
include "db.php";

if (!isset($_POST['url']) || empty($_POST['url'])) {
    echo json_encode(["status" => "error", "message" => "No URL provided"]);
    exit;
}

$url = trim($_POST['url']);

$stmt = $conn->prepare("INSERT INTO slider_images (image_url) VALUES (?)");
$stmt->bind_param("s", $url);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Added"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error adding image"]);
}
?>