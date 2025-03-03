<?php
$servername = "database-1.csqsi5wnwzc1.us-east-1.rds.amazonaws.com"; // AWS RDS Endpoint
$username = "admin";  // Your MySQL username
$password = "admin123";  // Your MySQL password
$dbname = "rds";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment this line for debugging
// echo "Connected successfully"; 

?>
