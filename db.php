<?php
$host = "127.0.0.1";
$user = "u807707365_mocoplayer";
$pass = "Sachin34241@@";
$db   = "u807707365_mocoplayerside";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]));
}

// Set charset (IMPORTANT for emojis, UTF-8)
$conn->set_charset("utf8mb4");
?>