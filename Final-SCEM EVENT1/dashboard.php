<?php
session_start();
include('config.php');  // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch events for the logged-in user based on their role
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role == 'organizer') {
    // Query to fetch events created by the organizer
    $sql = "SELECT * FROM events WHERE organizer_id = $user_id";
} else {
    // Query to fetch upcoming events for regular users
    $sql = "SELECT * FROM events WHERE event_status = 'upcoming'";
}

$result = mysqli_query($conn, $sql);

// Check for query execution errors
if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>

<?php if ($role == 'organizer'): ?>
    <h3>Your Events</h3>
<?php else: ?>
    <h3>Upcoming Events</h3>
<?php endif; ?>

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

<a href="logout.php">Logout</a>

</body>
</html>

<?php
mysqli_close($conn);
?>
