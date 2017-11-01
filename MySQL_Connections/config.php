<?php
$servername = "localhost";
$username = "whitbm06";
$password = "";
$db = "viridian_capstone_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>