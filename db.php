<?php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "money_namel";

// Create the connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

?>
