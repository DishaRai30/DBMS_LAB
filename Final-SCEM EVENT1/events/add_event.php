<?php
session_start();

// If not logged in or not an organizer, redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'organizer') {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "SCEM");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch events added by the organizer
$sql = "SELECT * FROM events WHERE organizer_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
</head>
<body>

    <h2>Welcome Organizer</h2>
    <h3>Your Events</h3>
    <table border="1">
        <tr>
            <th>Event Name</th>
            <th>Type</th>
            <th>Date</th>
            <th>Venue</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                <td><?php echo htmlspecialchars($row['event_type']); ?></td>
                <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                <td><?php echo htmlspecialchars($row['venue']); ?></td>
                <td><a href="events/edit_event.php?event_id=<?php echo $row['event_id']; ?>">Edit</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Add New Event</h3>
    <form action="events/add_event_process.php" method="POST">
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" required><br><br>

        <label for="event_type">Event Type:</label>
        <input type="text" name="event_type" required><br><br>

        <label for="event_date">Event Date:</label>
        <input type="datetime-local" name="event_date" required><br><br>

        <label for="venue">Venue:</label>
        <input type="text" name="venue" required><br><br>

        <input type="submit" value="Add Event">
    </form>

    <p><a href="logout.php">Logout</a></p>

</body>
</html>
