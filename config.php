<?php
$servername = "localhost";
$username   = "root";     // change if needed
$password   = "";         // change if needed
$dbname     = "db_milagres_puc"; // your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
