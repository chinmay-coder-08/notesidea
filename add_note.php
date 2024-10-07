<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    require 'config.php'; // DB connection

    // Function to generate a UUID for the note id
    function generate_uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, // Version 4 UUID
            mt_rand(0, 0x3fff) | 0x8000, // Variant UUID
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    // Generate a UUID for the note id
    $note_id = generate_uuid();

    // Sanitize inputs
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id']; // Logged-in user's id from the session

    // Insert sanitized data with the generated note ID and user's ID
    $sql = "INSERT INTO notes (id, user_id, title, description) VALUES ('$note_id', '$user_id', '$title', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "Note added!";
        header("Location: dashboard.php");
        exit(); // Ensure further code is not executed after redirect
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // echo "You must be logged in to add a note.";
}
?>


<form method="POST" action="add_note.php">
    <input type="text" name="title" placeholder="Note Title" required>
    <textarea name="description" placeholder="Note Description" required></textarea>
    <button type="submit">Add Note</button>
</form>
</body>
</html>