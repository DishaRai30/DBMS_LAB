<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If the user is already logged in, redirect them
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'organizer') {
        header("Location: add_event.php");  // Redirect to event adding page for organizers
        exit;
    } else {
        header("Location: home.php");  // Redirect to home page for students
        exit;
    }
}

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Login logic
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "SCEM");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to check if the user exists with the provided email using prepared statements
    $stmt = $conn->prepare("SELECT user_id, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Login successful, set session variables
            $_SESSION['user_id'] = $user['user_id']; // Store user ID
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Store the role

            // Redirect to the appropriate page based on user role
            if ($user['role'] == 'organizer') {
                header("Location: manage_event.php");  // Redirect to event adding page for organizers
                exit;
            } else {
                header("Location: home.php");  // Redirect to home page for students
                exit;
            }
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with this email.";
    }

    $stmt->close();
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Custom styles for card layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .card form {
            display: flex;
            flex-direction: column;
        }

        .card form label {
            margin-bottom: 5px;
        }

        .card form input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .card form button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .card form button:hover {
            background-color: #0056b3;
        }

        .card .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .card p {
            text-align: center;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login</h2>

        <!-- Display error messages -->
        <?php
        if (isset($error)) {
            echo "<div class='error'>$error</div>";
        }
        ?>

        <!-- Login Form -->
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit" name="login">Login</button>
        </form>

        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>

    <footer>
        <p>&copy; 2024 College Events. All rights reserved.</p>
    </footer>
</body>
</html>
