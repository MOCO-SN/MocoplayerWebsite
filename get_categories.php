<?php
header('Content-Type: application/json');
include "db.php";

$data = [];
$res = $conn->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY sort_order ASC, id DESC");

while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>