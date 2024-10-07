<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Register </title>
  <link rel="stylesheet" href="./css/register.css">
</head>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'config.php'; // DB connection

    // Function to generate a UUID
    function generate_uuid() {
        // Generate a unique ID based on time, with more entropy for randomness
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, // Version 4 UUID
            mt_rand(0, 0x3fff) | 0x8000, // Variant UUID
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    // Generate a UUID for user ID
    $user_id = generate_uuid();

    // Sanitize inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password

    // Insert sanitized data with UUID into the database
    $sql = "INSERT INTO users (id, username, email, password) VALUES ('$user_id', '$username', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<body>
  <div class="container">
    <!-- Title section -->
    <div class="title">Registration</div>
    <div class="content">
      <!-- Registration form -->
      <form method="POST" action="register.php">
        <div class="user-details">
          <!-- Input for Full Name -->
          <!-- Input for Username -->
          <div class="input-box">
            <span class="details">Username</span>
            <input name="username" type="text" placeholder="Enter your username" required>
          </div>
          <!-- Input for Email -->
          <div class="input-box">
            <span class="details">Email</span>
            <input name="email" type="text" placeholder="Enter your email" required>
          </div>

          <!-- Input for Password -->
          <div class="input-box">
            <span class="details">Password</span>
            <input name="password" type="text" placeholder="Enter your password" required>
          </div>
          <!-- Input for Confirm Password -->
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="text" placeholder="Confirm your password" required>
          </div>
        </div>
        <!-- Submit button -->
        <button class="buttonsubmit" type="submit">Register</button>
      </form>
    </div>
  </div>
</body>

</html>