<?php
session_start();
require 'db.php';
/*
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit("Not logged in.");
}
*/
// Retrieve the latest 50 chat messages (ordered oldest first)
$stmt = $pdo->query("
    SELECT cm.*, u.username 
    FROM chat_messages cm
    JOIN users u ON cm.user_id = u.id
    ORDER BY cm.sent_at ASC 
    LIMIT 50
");
$messages = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($messages);
?>
