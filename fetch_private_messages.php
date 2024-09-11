<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['userId'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in or no recipient specified']);
    exit;
}

$loggedInUserId = $_SESSION['user_id'];
$selectedUserId = intval($_GET['userId']);

$query = "SELECT private_messages.message, private_messages.timestamp, users.username, users.avatar_url
          FROM private_messages
          JOIN users ON private_messages.sender_id = users.id
          WHERE (private_messages.sender_id = $loggedInUserId AND private_messages.receiver_id = $selectedUserId)
             OR (private_messages.sender_id = $selectedUserId AND private_messages.receiver_id = $loggedInUserId)
          ORDER BY private_messages.timestamp ASC";
$result = mysqli_query($con, $query);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['status' => 'success', 'messages' => $messages]);
