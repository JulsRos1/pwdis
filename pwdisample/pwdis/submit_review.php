<?php
include('includes/config.php');
session_start();

if (isset($_POST['submit'])) {
    $place_id = $_POST['place_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $first_name = $_SESSION['name'];
    $last_name = $_SESSION['lname'];

    // Combine first and last name to get the full name
    $full_name = $first_name . ' ' . $last_name;

    // Prepare the SQL query to insert the review
    $query = $con->prepare("INSERT INTO reviews (place_id, rating, review, full_name) VALUES (?, ?, ?, ?)");
    $query->bind_param("siss", $place_id, $rating, $review, $full_name);
    $query->execute();

    if ($query) {
        echo "Review submitted successfully.";
    } else {
        echo "Error submitting review.";
    }
}
