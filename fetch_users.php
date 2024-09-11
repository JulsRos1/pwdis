<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

$query = "SELECT id, username, avatar_url FROM users WHERE username LIKE '%$search%'";
$result = mysqli_query($con, $query);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode(['status' => 'success', 'users' => $users]);
