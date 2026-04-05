<?php
include "db.php";

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM carousel_groups ORDER BY sort_order ASC, id DESC");

if ($result) {
    $groups = [];
    while ($row = $result->fetch_assoc()) {
        $groups[] = $row;
    }
    echo json_encode($groups);
} else {
    echo json_encode([]);
}
?>