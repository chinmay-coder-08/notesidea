<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Login </title>
  <link rel="stylesheet" href="./css/register.css">
</head>
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'config.php'; // DB connection

    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Retrieve user information
    $sql = "SELECT id, password FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true); // Prevent session fixation attacks
            $_SESSION['user_id'] = $row['id'];
            echo "Login successful!";
            header("Location: dashboard.php");
            exit(); // Ensure further code is not executed after redirect
        } else {
            echo "Invalid email or password!";
        }
    } else {
        echo "Invalid email or password!";
    }
}
?>

<body>
  <div class="container">
    <!-- Title section -->
    <div class="title">Login</div>
    <div class="content">
      <!-- Registration form -->
      <form method="POST" action="login.php">
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
          <div style="align-self: center;" class="input-box">
            <span class="details">Password</span>
            <input name="password" type="text" placeholder="Enter your password" required>
          </div>
          <!-- Input for Confirm Password -->
        </div>
        <!-- Submit button -->
        <button class="buttonsubmit" type="submit">Login</button>
      </form>
    </div>
  </div>
</body>

</html>

