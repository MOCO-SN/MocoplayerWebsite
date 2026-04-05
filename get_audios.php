<?php
include "db.php";

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM audios ORDER BY created_at DESC");

$audios = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $audios[] = $row;
    }
}

echo json_encode($audios);
?>