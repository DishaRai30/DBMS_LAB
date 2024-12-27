<?php
// Start session
session_start();

// Include the database connection
include('config.php');

// Check if the user is logged in and is an organizer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'organizer') {
    header("Location: login.php"); // Redirect to login if not logged in or not an organizer
    exit();
}

// Fetch completed events for the logged-in organizer
$sql = "SELECT * FROM events WHERE organizer_id = {$_SESSION['user_id']} AND status = 'completed'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Events</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="header-content">
            <h1>Completed Events</h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Display organizer's completed events -->
        <h2>Your Completed Events</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table border="1">
                <tr>
                    <th>Event Name</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Time</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['event_name']; ?></td>
                        <td><?php echo $row['event_type']; ?></td>
                        <td><?php echo $row['event_date']; ?></td>
                        <td><?php echo $row['event_venue']; ?></td>
                        <td><?php echo $row['event_time']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>You don't have any completed events yet.</p>
        <?php endif; ?>

    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 College Events</p>
    </footer>

</body>
</html>
