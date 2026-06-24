<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$conn = new mysqli('localhost','root','','db_milagres_puc');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all configuration values
$sql = "SELECT config_key, config_value FROM tbl_configuration";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $key = $row['config_key'];
        $value = $row['config_value'];

        // Define constant only if not already defined
        if(!defined($key)){
            define($key, $value);
        }
    }
}

$conn->close();