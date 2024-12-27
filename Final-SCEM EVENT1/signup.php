<?php
include('config.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // Either "student" or "organizer"

    // Check if the email already exists in the database
    $checkEmailSql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmailSql);
    if (mysqli_num_rows($result) > 0) {
        $error = "The email address is already registered. Please use a different email.";
    } else {
        // Insert user into the database if email doesn't exist
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            // Redirect based on the role
            if ($role === 'student') {
                header("Location: event_list.php"); // Redirect to student event list
            } else {
                header("Location: manage-event.php"); // Redirect to organizer's event creation or update page in the events folder
            }
            exit();
        } else {
            $error = "Error signing up: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Link to external CSS -->
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('https://content.jdmagicbox.com/comp/mangalore/d4/0824px824.x824.121018150858.v1d4/catalogue/sahyadri-college-of-engineering-and-management-adyar-mangalore-colleges-bv6g86tj6o.jpg'); /* Background image behind the card */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white; /* General text color */
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.6); /* Transparent background */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Slight shadow to make the card stand out */
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            color: #fff; /* Text color inside the card */
        }

        .card h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #fff;
        }

        .card form {
            display: flex;
            flex-direction: column;
        }

        .card form label {
            text-align: left;
            font-size: 14px;
            margin-bottom: 5px;
            color: #fff;
        }

        .card form input, .card form select {
            padding: 10px;
            margin-bottom: 0px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            background-color: #f9f9f9;
            color: #333;
        }

        .card form input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .card form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .card .back-link {
            margin-top: 0px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }

        .card .back-link:hover {
            text-decoration: underline;
        }

        /* Error message styling */
        .card p {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Signup Form Card -->
    <div class="card-container">
        <div class="card">
            <h1>Signup</h1>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="student">Student</option>
                    <option value="organizer">Organizer</option>
                </select><br>

                <input type="submit" value="Sign Up">
            </form>
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
            <a href="index.php" class="back-link">Back to Home</a>
        </div>
    </div>
</body>
</html>
