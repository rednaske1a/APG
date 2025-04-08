<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit("Not logged in.");
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // We expect a form POST (not JSON here) so we use $_POST
    $message = trim($_POST['message'] ?? '');
    if (empty($message)) {
        echo "Message cannot be empty.";
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
    if ($stmt->execute([$user['id'], $message])) {
        echo "Message sent.";
    } else {
        http_response_code(500);
        echo "Error sending message.";
    }
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
?>
