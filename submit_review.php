<?php
include('includes/config.php');
session_start();

header('Content-Type: application/json');

// Set the correct time zone
date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input
    $required_fields = ['place_id', 'display_name', 'formatted_address', 'rating', 'review', 'review_date', 'place_type', 'avatar_url'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    $place_id = $_POST['place_id'];
    $display_name = $_POST['display_name'];
    $formatted_address = $_POST['formatted_address'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $photo_url = $_POST['photo_url'];
    $review_date = date('Y-m-d H:i:s');  // Set current date/time using the correct timezone
    $place_type = $_POST['place_type'];
    $avatar_url = $_POST['avatar_url'];

    // Check if user is logged in
    if (!isset($_SESSION['name']) || !isset($_SESSION['lname'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    $first_name = $_SESSION['name'];
    $last_name = $_SESSION['lname'];

    $full_name = $first_name . ' ' . $last_name;

    // Prepare the SQL query to insert the review
    $query = $con->prepare("INSERT INTO reviews (place_id, display_name, formatted_address, rating, review, full_name, photo_url, review_date, place_type, avatar_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$query) {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing query: ' . $con->error]);
        exit;
    }

    $query->bind_param("ssssssssss", $place_id, $display_name, $formatted_address, $rating, $review, $full_name, $photo_url, $review_date, $place_type, $avatar_url);

    if ($query->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Thanks for submitting a review..']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting review: ' . $query->error]);
    }

    $query->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$con->close();
