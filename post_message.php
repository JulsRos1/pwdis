<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

if (isset($_POST['message'])) {
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['user'];

    $query = "INSERT INTO messages (user_id, message) VALUES ('$user_id', '$message')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Message could not be sent']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
