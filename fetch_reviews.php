<?php
include('includes/config.php');

if (isset($_GET['place_id'])) {
    $place_id = $_GET['place_id'];

    // Prepare the SQL query to prevent SQL injection, including review_date and photo_url
    $query = $con->prepare("SELECT rating, review, full_name, photo_url, review_date, avatar_url FROM reviews WHERE place_id = ?");
    $query->bind_param("s", $place_id);
    $query->execute();
    $result = $query->get_result();

    $reviews = array();
    $totalRating = 0;
    $reviewCount = 0;

    // Loop through the results and calculate the total rating and count
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
        $totalRating += $row['rating'];  // Sum up the ratings
        $reviewCount++;  // Count the number of reviews
    }

    // Calculate the average rating
    $averageRating = ($reviewCount > 0) ? ($totalRating / $reviewCount) : 0;

    // Return the reviews, average rating, and review count in JSON format
    echo json_encode([
        'reviews' => $reviews,  // Now includes photo_url and review_date
        'averageRating' => $averageRating,
        'reviewCount' => $reviewCount
    ]);
} else {
    echo json_encode(array("error" => "No place ID provided"));
}
