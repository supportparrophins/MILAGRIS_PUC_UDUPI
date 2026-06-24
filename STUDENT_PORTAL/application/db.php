<?php
date_default_timezone_set("Asia/Kolkata"); 

// $servername = "localhost";
// $username = "root";
// $password = "";
 $servername = "192.168.0.100";
 $username = "root";
 $password = "";
try {
    $con = new PDO("mysql:host=$servername;dbname=db_sjpuc_hassan_v1", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //  echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
     echo "Connection failed: " . $e->getMessage();
    }
?>