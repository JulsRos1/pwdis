<?php
include('includes/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $place_id = $_POST['place_id'];
    $display_name = $_POST['display_name'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $first_name = $_SESSION['name'];
    $last_name = $_SESSION['lname'];

    // Combine first and last name to get the full name
    $full_name = $first_name . ' ' . $last_name;

    // Prepare the SQL query to insert the review
    $query = $con->prepare("INSERT INTO reviews (place_id, display_name, rating, review, full_name) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssss", $place_id, $display_name, $rating, $review, $full_name);

    // Check if the query executed successfully
    if ($query->execute()) {
        // Send a success response as JSON
        echo json_encode(['status' => 'success', 'message' => 'Review submitted successfully.']);
    } else {
        // Send an error response as JSON
        echo json_encode(['status' => 'error', 'message' => 'Error submitting review.']);
    }
}
