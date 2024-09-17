<?php
include('includes/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['place_id'])) {
    $place_id = $_GET['place_id'];

    // Prepare the query
    $query = "SELECT wheelchairAccessibleParking, wheelchairAccessibleEntrance, wheelchairAccessibleRestroom, wheelchairAccessibleSeating FROM place_accessibility WHERE place_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $place_id);  // Bind the place_id parameter

    $stmt->execute();  // Execute the query
    $result = $stmt->get_result();  // Get the result set

    if ($result->num_rows > 0) {
        $accessibilityOptions = $result->fetch_assoc();  // Fetch as associative array

        header('Content-Type: application/json');
        echo json_encode($accessibilityOptions);  // Return the result as JSON
    } else {
        // Return null for all fields if no result is found
        echo json_encode([
            'wheelchairAccessibleParking' => null,
            'wheelchairAccessibleEntrance' => null,
            'wheelchairAccessibleRestroom' => null,
            'wheelchairAccessibleSeating' => null
        ]);
    }
}
