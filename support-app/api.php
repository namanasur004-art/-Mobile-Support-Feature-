<?php
include 'db.php';
header('Content-Type: application/json');
$action = $_GET['action'] ?? '';

if($action == 'get') {
    $res = $conn->query("SELECT * FROM messages ORDER BY id ASC");
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
}

if($action == 'send') {
    $sender = $conn->real_escape_string($_GET['sender']);
    $msg = $conn->real_escape_string($_GET['msg']);
    $conn->query("INSERT INTO messages (sender, message) VALUES ('$sender', '$msg')");
    echo json_encode(["status" => "success"]);
}
?>