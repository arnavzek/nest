<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


$servername = "us-cdbr-iron-east-05.cleardb.net";
$username = "b0560a82032ca8";
$password = "85bf2cc9";
$dbname = "heroku_61ed0b70a5132fd";

// $servername = "localhost";
// $username = "root";
// $password = "00000";
// $dbname = "nest";


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	
    die("Connection failed: " . $conn->connect_error);
}


?>