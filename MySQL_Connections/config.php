<?php
$servername = "23.97.29.252/";
$username = "dbConnectionUser";
$password = "dbConnectionPass";
$db = "ipfw-capstone";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>