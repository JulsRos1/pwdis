<?php
include('includes/config.php');

$place_id = $_GET['place_id'];
$sql = "SELECT review, rating, user_name, timestamp FROM reviews WHERE place_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $place_id);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

echo json_encode($reviews);
