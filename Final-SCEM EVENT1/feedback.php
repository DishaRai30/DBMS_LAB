<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$event_id = $_GET['event_id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    $query = "INSERT INTO feedback (user_id, event_id, feedback) VALUES ('$user_id', '$event_id', '$feedback')";
    if (mysqli_query($conn, $query)) {
        echo "Thank you for your feedback!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Feedback</title>
</head>
<body>
    <h1>Feedback for Event</h1>
    <form method="POST">
        <textarea name="feedback" rows="4" cols="50" required></textarea><br>
        <button type="submit">Submit Feedback</button>
    </form>
</body>
</html>
