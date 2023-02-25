<?php 
$username = 'your_username'; 
$password = 'your_password'; 
$host = 'localhost'; 
$dbname = 'your_dbname'; 
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);} 
?>