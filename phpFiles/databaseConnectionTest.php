<?php
//uses MySQLi Object Oriented
$servername = "localhost";
$username = "testUser";
$password = "testPass";

// Create connection
$conn = new mysqli($servername, $username, $password, "phpmyadmin");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br>" ;


$sql = "SELECT strUsername FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["strUsername"]. "<br>";
    }
} else {
    echo "0 results";
}



mysqli_close($conn);
?>