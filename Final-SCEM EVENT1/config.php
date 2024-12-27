<?php
$servername = "localhost";
$username = "root";  // Default XAMPP username is 'root'
$password = "";      // Default XAMPP password is empty
$dbname = "SCEM";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
