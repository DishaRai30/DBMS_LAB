<?php
session_start();
include('config.php'); // Database connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: index.php");
    exit();
}

// Fetch all events
$sql = "SELECT * FROM events";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <h2>Upcoming and Completed Events</h2>
    <table border="1">
        <tr>
            <th>Event Name</th>
            <th>Event Type</th>
            <th>Event Date</th>
            <th>Venue</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                <td><?php echo htmlspecialchars($row['event_type']); ?></td>
                <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                <td><?php echo htmlspecialchars($row['venue']); ?></td>
                <td><?php echo htmlspecialchars($row['event_status']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php">Back to Home</a>
</body>
</html>
