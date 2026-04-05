<?php
include "db.php";

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM settings");

if ($result) {
    $settings = [];
    while ($row = $result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    echo json_encode($settings);
} else {
    echo json_encode([]);
}
?>