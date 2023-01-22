<?php


$servername = "nif.h.filess.io:3307";
$username = "telegramfilesbot_warntoyout";
$password = "224135bdd18e9d652eac284be6007fb95e167aa9";
$db = "telegramfilesbot_warntoyout";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

?>