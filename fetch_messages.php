<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$query = "SELECT messages.id, messages.message, messages.timestamp, users.username, users.avatar_url
          FROM messages
          JOIN users ON messages.user_id = users.id
          ORDER BY messages.timestamp ASC";
$result = mysqli_query($con, $query);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['status' => 'success', 'messages' => $messages]);
