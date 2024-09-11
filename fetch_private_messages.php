<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['userId'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in or no recipient specified']);
    exit;
}

$loggedInUserId = $_SESSION['user_id'];
$selectedUserId = intval($_GET['userId']);

// Prepare SQL query to fetch messages along with the full name and avatar URL
$query = "SELECT private_messages.message, private_messages.timestamp, 
                 CONCAT(users.FirstName, ' ', users.LastName) AS fullname, users.avatar_url
          FROM private_messages
          JOIN users ON private_messages.sender_id = users.id
          WHERE (private_messages.sender_id = ? AND private_messages.receiver_id = ?)
             OR (private_messages.sender_id = ? AND private_messages.receiver_id = ?)
          ORDER BY private_messages.timestamp ASC";

// Prepare the statement
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "iiii", $loggedInUserId, $selectedUserId, $selectedUserId, $loggedInUserId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode(['status' => 'success', 'messages' => $messages]);
