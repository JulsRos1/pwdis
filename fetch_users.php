<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Get the logged-in user's ID
$loggedInUserId = $_SESSION['user_id'];

// Get search query and sanitize it
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

// Prepare SQL statement to fetch users excluding the logged-in user
$query = "SELECT id, CONCAT(FirstName, ' ', LastName) AS fullname, avatar_url FROM users WHERE id != ? AND CONCAT(FirstName, ' ', LastName) LIKE ?";
$stmt = mysqli_prepare($con, $query);
$search = "%$search%";
mysqli_stmt_bind_param($stmt, "is", $loggedInUserId, $search);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode(['status' => 'success', 'users' => $users]);
