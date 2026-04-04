<?php
header('Content-Type: application/json');
include "db.php";

$data = [];
$res = $conn->query("SELECT * FROM slider_images");

while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>