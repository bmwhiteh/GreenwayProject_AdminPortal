<?php
$servername = "localhost";
$username = "supadmin";
$password = "C@p\$tone#";
$db = "viridian_admin_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully";
?>