<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "picpoint1"; // Change if your DB name is different

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
