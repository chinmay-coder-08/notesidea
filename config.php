<?php
$servername = "localhost";  // Your database server, typically "localhost"
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password (leave blank if no password)
$dbname = "notesidea";      // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn){
    echo  "Connection successful";
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
