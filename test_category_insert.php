<?php
include "db.php";

$conn->query("INSERT INTO categories (name, description) VALUES ('Test Category', 'Test Description')");

$result = $conn->query("SELECT * FROM categories WHERE is_active = 1");
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
