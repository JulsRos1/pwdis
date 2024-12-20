<?php
include('includes/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $place_id = isset($_POST['place_id']) ? $_POST['place_id'] : '';
    $display_name = isset($_POST['display_name']) ? $_POST['display_name'] : '';
    if (!isset($_SESSION['name']) || !isset($_SESSION['lname'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    $first_name = $_SESSION['name'];
    $last_name = $_SESSION['lname'];

    $full_name = $first_name . ' ' . $last_name;

    // Get the accessibility level
    $accessibility_level = isset($_POST['accessibility_level']) ? $_POST['accessibility_level'] : '';

    // Check if accessibilityOptions is set and is an array
    $accessibilityOptions = isset($_POST['accessibilityOptions']) && is_array($_POST['accessibilityOptions']) ? $_POST['accessibilityOptions'] : [];

    // Initialize options to false
    $wheelchairAccessibleParking = in_array('wheelchairAccessibleParking', $accessibilityOptions) ? 1 : 0;
    $wheelchairAccessibleEntrance = in_array('wheelchairAccessibleEntrance', $accessibilityOptions) ? 1 : 0;
    $wheelchairAccessibleRestroom = in_array('wheelchairAccessibleRestroom', $accessibilityOptions) ? 1 : 0;
    $wheelchairAccessibleSeating = in_array('wheelchairAccessibleSeating', $accessibilityOptions) ? 1 : 0;

    // Check if the place_id already exists
    $checkQuery = "SELECT * FROM place_accessibility WHERE place_id = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("s", $place_id); // Use bind_param for mysqli
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $query = "UPDATE place_accessibility SET
                    wheelchairAccessibleParking = ?,
                    wheelchairAccessibleEntrance = ?,
                    wheelchairAccessibleRestroom = ?,
                    wheelchairAccessibleSeating = ?,
                    accessibility_level = ?,
                    created_at = NOW()
                  WHERE place_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("iiisss", $wheelchairAccessibleParking, $wheelchairAccessibleEntrance, $wheelchairAccessibleRestroom, $wheelchairAccessibleSeating, $accessibility_level, $place_id);
    } else {
        // Insert new record
        $query = "INSERT INTO place_accessibility (place_id, full_name, display_name, wheelchairAccessibleParking, wheelchairAccessibleEntrance, wheelchairAccessibleRestroom, wheelchairAccessibleSeating, accessibility_level, created_at)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssiiiss", $place_id, $full_name, $display_name, $wheelchairAccessibleParking, $wheelchairAccessibleEntrance, $wheelchairAccessibleRestroom, $wheelchairAccessibleSeating, $accessibility_level);
    }

    if ($stmt->execute()) {
        // Send a success message
        echo json_encode(['status' => 'success', 'message' => 'Accessibility options updated successfully.']);
    } else {
        // Handle errors
        echo json_encode(['status' => 'error', 'message' => 'Failed to update accessibility options.']);
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$con->close();
