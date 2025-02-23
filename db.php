<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "rds"; // Pastikan sesuai

$conn = new mysqli($host, $user, $pass, $db);
$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
