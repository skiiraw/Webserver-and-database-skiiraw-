<?php
// Connect to database
$servername = "database-1.csqsi5wnwzc1.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "admin123";
$dbname = "rds";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get ID from URL
$id = $_GET['id'];

// Delete query
$sql = "DELETE FROM students WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data deleted successfully');location.href='index.php'</script>";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
