<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['message']) || !isset($_POST['receiver_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$message = mysqli_real_escape_string($con, $_POST['message']);
$receiver_id = intval($_POST['receiver_id']);
$sender_id = $_SESSION['user_id'];

$query = "INSERT INTO private_messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
$result = mysqli_query($con, $query);

if ($result) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Message could not be sent']);
}
