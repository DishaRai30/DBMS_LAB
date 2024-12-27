<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$event_id = $_GET['event_id'];
$user_id = $_SESSION['user_id'];

// Check if the event is full
$query = "SELECT registration_count, max_capacity FROM events WHERE id = '$event_id'";
$result = mysqli_query($conn, $query);
$event = mysqli_fetch_assoc($result);

if ($event['registration_count'] < $event['max_capacity']) {
    // Register user for the event
    $query = "INSERT INTO event_registrations (user_id, event_id) VALUES ('$user_id', '$event_id')";
    if (mysqli_query($conn, $query)) {
        // Update the registration count
        $new_count = $event['registration_count'] + 1;
        $update_query = "UPDATE events SET registration_count = '$new_count' WHERE id = '$event_id'";
        mysqli_query($conn, $update_query);
        echo "Successfully registered for the event.";
    } else {
        echo "You are already registered for this event.";
    }
} else {
    echo "Event is full.";
}
?>
