<?php
header('Content-Type: application/json');
include "db.php";

$result = $conn->query("SELECT * FROM videos ORDER BY id DESC");

$videos = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }
}

echo json_encode($videos);
?>
