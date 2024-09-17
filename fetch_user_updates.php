<?php
include('includes/config.php');

if (isset($_GET['place_id'])) {
    $place_id = $_GET['place_id'];

    // Query the database for user-submitted accessibility updates
    $query = "SELECT wheelchairAccessibleParking, wheelchairAccessibleEntrance, wheelchairAccessibleRestroom, wheelchairAccessibleSeating FROM user_accessibility_updates WHERE place_id = ?";
    $stmt = $dbh->prepare($query);
    $stmt->execute([$place_id]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the user updates or null if not found
    echo json_encode($result ? $result : [
        'wheelchairAccessibleParking' => null,
        'wheelchairAccessibleEntrance' => null,
        'wheelchairAccessibleRestroom' => null,
        'wheelchairAccessibleSeating' => null,
    ]);
}
