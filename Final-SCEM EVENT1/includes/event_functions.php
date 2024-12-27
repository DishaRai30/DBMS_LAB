<?php
include_once 'config.php';

function getAllEvents() {
    global $conn;
    $sql = "SELECT * FROM events ORDER BY type DESC, date ASC";
    return $conn->query($sql);
}

function addEvent($name, $type, $date, $venue, $time, $max_capacity, $organizer_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO events (name, type, date, venue, time, max_capacity, organizer_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $name, $type, $date, $venue, $time, $max_capacity, $organizer_id);
    return $stmt->execute();
}

function updateEvent($id, $name, $type, $date, $venue, $time) {
    global $conn;
    $stmt = $conn->prepare("UPDATE events SET name = ?, type = ?, date = ?, venue = ?, time = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $type, $date, $venue, $time, $id);
    return $stmt->execute();
}

function deleteEvent($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
