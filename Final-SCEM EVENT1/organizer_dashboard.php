<?php
session_start();
include('config.php'); // Database connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'organizer') {
    header("Location: index.php");
    exit();
}

// Handle form submission to add events
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'];
    $event_type = $_POST['event_type'];
    $event_date = $_POST['event_date'];
    $venue = $_POST['venue'];
    $organizer_id = $_SESSION['user_id'];

    // Insert the event into the database
    $sql = "INSERT INTO events (event_name, event_type, event_date, venue, organizer_id) 
            VALUES ('$event_name', '$event_type', '$event_date', '$venue', '$organizer_id')";
    if (mysqli_query($conn, $sql)) {
        echo "Event added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <h2>Add a New Event</h2>
    <form method="POST">
        <label>Event Name:</label>
        <input type="text" name="event_name" required><br>

        <label>Event Type:</label>
        <select name="event_type" required>
            <option value="technical">Technical</option>
            <option value="non_technical">Non-Technical</option>
        </select><br>

        <label>Event Date:</label>
        <input type="datetime-local" name="event_date" required><br>

        <label>Venue:</label>
        <input type="text" name="venue" required><br>

        <button type="submit">Add Event</button>
    </form>

    <a href="index.php">Back to Home</a>
</body>
</html>
