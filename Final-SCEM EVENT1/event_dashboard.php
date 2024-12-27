<?php
// event_dashboard.php

// Start the session
session_start();

// Include database connection
include('config.php');

// Check if the user is logged in (i.e., if the session is set)
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Fetch events for the organizer
$sql = "SELECT * FROM events WHERE organizer_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);

// Check for errors in the query
if (!$result) {
    die("Error fetching events: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Dashboard</title>
</head>
<body>
    <h1>Event Dashboard</h1>
    <a href="add_event.php">Add New Event</a>
    <h2>Your Events</h2>
    <table>
        <tr>
            <th>Event Name</th>
            <th>Type</th>
            <th>Date</th>
            <th>Venue</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['event_name']; ?></td>
            <td><?php echo $row['event_type']; ?></td>
            <td><?php echo $row['event_date']; ?></td>
            <td><?php echo $row['venue']; ?></td>
            <td>
                <a href="update_event.php?id=<?php echo $row['event_id']; ?>">Update</a>
                <a href="delete_event.php?id=<?php echo $row['event_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>
