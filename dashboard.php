<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    require 'config.php'; // DB connection

    $user_id = $_SESSION['user_id'];

    // Fetch notes belonging to the logged-in user
    $sql = "SELECT id, title, description, created_at FROM notes WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<h2  class='mx-2'>{$row['title']}</h2>";
            echo "<p  class='mx-2'>{$row['description']}</p>";
            echo "<small  class='mx-2'> Added on: {$row['created_at']}</small><br>";
            echo "<a  class='mx-2' href='edit_note.php?id={$row['id']}'>Edit</a> | ";
            echo "<a  class='mx-2' href='delete_note.php?id={$row['id']}'>Delete</a><hr>";
        }
    } else {
        echo "No notes found.";
        echo $user_id;
    }
} else {
    header("Location: login.php");
    exit(); // Ensure further code is not executed after redirect
}
?>

<body>
    <h1 class="mx-2">Welcome <?php echo "<h5 class='mx-2' style='color: red;'>$user_id </h5>";?></h1>
</body>
</html>