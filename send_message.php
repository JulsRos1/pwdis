<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

if (isset($_POST['message']) && isset($_POST['receiver_id'])) {
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $sender_id = $_SESSION['user_id'];  // Sender is the logged-in user
    $receiver_id = $_POST['receiver_id'];

    $query = "INSERT INTO chats (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Message could not be sent']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
