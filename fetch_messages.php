<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Get logged-in user ID
$loggedInUserId = $_SESSION['user_id'];

// Get search parameters
$chatMode = isset($_GET['chatMode']) ? $_GET['chatMode'] : 'group';
$userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;

// Determine query based on chat mode
if ($chatMode === 'group') {
    $query = "SELECT messages.*, CONCAT(users.FirstName, ' ', users.LastName) AS fullname, users.avatar_url
              FROM messages
              JOIN users ON messages.user_id = users.id
              ORDER BY messages.timestamp";
} else {
    $query = "SELECT messages.*, CONCAT(users.FirstName, ' ', users.LastName) AS fullname, users.avatar_url
              FROM messages
              JOIN users ON messages.user_id = users.id
              WHERE messages.receiver_id = ?
              ORDER BY messages.timestamp";
}

// Prepare and execute query
$stmt = mysqli_prepare($con, $query);

if ($chatMode === 'private') {
    mysqli_stmt_bind_param($stmt, "i", $userId);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['status' => 'success', 'messages' => $messages]);
