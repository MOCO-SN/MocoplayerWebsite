<?php
include "db.php";

header('Content-Type: application/json');

$uploads = [];
$audios = [];

$result = $conn->query("SELECT * FROM uploads ORDER BY id DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $uploads[] = $row;
    }
}

$result2 = $conn->query("SELECT * FROM audios ORDER BY created_at DESC");
if ($result2) {
    while ($row = $result2->fetch_assoc()) {
        $audios[] = $row;
    }
}

echo json_encode([
    "uploads" => $uploads,
    "audios" => $audios
]);
?>