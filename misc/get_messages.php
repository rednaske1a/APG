<?php
session_start();
require 'db.php';

/*
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit("Not logged in.");
}
    */

$after = isset($_GET['after']) ? (int)$_GET['after'] : 0;

$stmt = $pdo->prepare("
    SELECT cm.id, cm.message, cm.sent_at, u.username 
    FROM chat_messages cm
    JOIN users u ON cm.user_id = u.id
    WHERE cm.id > ?
    ORDER BY cm.sent_at ASC
");
$stmt->execute([$after]);
$messages = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($messages);
?>
