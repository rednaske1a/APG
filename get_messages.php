<?php
session_start();
require 'db.php';

/*
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit("Not logged in.");
}

*/
// Retrieve the latest 50 chat messages (oldest first)
$stmt = $pdo->query("
    SELECT m.*, u.username 
    FROM chat_messages m 
    JOIN users u ON m.user_id = u.id 
    ORDER BY m.sent_at ASC 
    LIMIT 50
");
$messages = $stmt->fetchAll();
header('Content-Type: application/json');
echo json_encode($messages);
?>
