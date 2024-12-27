<?php
session_start();

// If not logged in or not an organizer, redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'organizer') {
    header("Location: login.php");
    exit;
}

include_once '../includes/event_functions.php';

// Fetch the event ID from the query string
$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    echo "Event ID is missing!";
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "SCEM");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch event details from the database
$sql = "SELECT * FROM events WHERE event_id = $event_id";
$result = mysqli_query($conn, $sql);
$event = mysqli_fetch_assoc($result);

mysqli_close($conn);

if (!$event) {
    echo "Event not found!";
    exit;
}

// If the form is submitted, update the event
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $time = $_POST['time'];

    if (updateEvent($id, $name, $type, $date, $venue, $time)) {
        echo "Event updated successfully!";
    } else {
        echo "Error updating event.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>

    <h2>Edit Event</h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
        
        <label for="name">Event Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required><br><br>
        
        <label for="type">Event Type:</label>
        <select name="type" required>
            <option value="technical" <?php echo $event['event_type'] == 'technical' ? 'selected' : ''; ?>>Technical</option>
            <option value="non-technical" <?php echo $event['event_type'] == 'non-technical' ? 'selected' : ''; ?>>Non-Technical</option>
        </select><br><br>

        <label for="date">Event Date:</label>
        <input type="date" name="date" value="<?php echo date('Y-m-d', strtotime($event['event_date'])); ?>" required><br><br>

        <label for="venue">Venue:</label>
        <input type="text" name="venue" value="<?php echo htmlspecialchars($event['venue']); ?>" required><br><br>

        <label for="time">Event Time:</label>
        <input type="time" name="time" value="<?php echo date('H:i', strtotime($event['event_time'])); ?>" required><br><br>

        <button type="submit">Update Event</button>
    </form>

</body>
</html>
