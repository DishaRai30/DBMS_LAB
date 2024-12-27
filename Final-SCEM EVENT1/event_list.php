<?php
// event_list.php

// Include database connection
include('config.php');

// Fetch upcoming events
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
</head>
<body>
    <h1>Upcoming Events</h1>
    <table>
        <tr>
            <th>Event Name</th>
            <th>Type</th>
            <th>Date</th>
            <th>Venue</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['event_name']; ?></td>
            <td><?php echo $row['event_type']; ?></td>
            <td><?php echo $row['event_date']; ?></td>
            <td><?php echo $row['venue']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>
