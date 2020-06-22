<?php
$servername = "localhost";
$username = "id13794868_hmsdb";
$password = "Rgukt@hospital1";
$database="id13794868_hms";
// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// else
    // echo "connection success";
?> 