<?php
include "db.php";

header('Content-Type: application/json');

$tables = $conn->query("SHOW TABLES");
$tableList = [];
while ($row = $tables->fetch_array()) {
    $tableList[] = $row[0];
}

$videosExists = in_array('videos', $tableList);
$audiosExists = in_array('audios', $tableList);

echo json_encode([
    "tables" => $tableList,
    "videos_exists" => $videosExists,
    "audios_exists" => $audiosExists
]);
?>
