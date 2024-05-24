<?php
// signup.php

// Database connection (replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopme";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // Validate input
    if (empty($user) || empty($pass) || empty($confirm_pass)) {
        echo "All fields are required.";
    } elseif ($pass !== $confirm_pass) {
        echo "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Signup successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopme | Signup</title>
    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand bg-white" href="#">
            <img src="content/Logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            Shopme
          </a>
        </div>
    </nav>
    <section class="container">
        <div class="logincard">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">Signup</h5>
                  <br>
                  <form action="register.php" method="post">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                        Username: <input type="text" name="username" required><br>
                        </div>
                        <div class="col-auto">
                        Email: <input type="email" name="email" required><br>
                        </div>
                        <div class="col-auto">
                        Password: <input type="password" name="password" required><br>
                        </div>
                        <input type="submit" value="Register">
                    </div>
                  </form>
                </div>
            </div>
        </div>

    </section>
</body>
</html>