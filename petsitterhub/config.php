<?php
$host = "localhost";
$db = "petsitterhub";         // your database name
$user = "root";               // your DB username
$pass = "";                   // your DB password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}
?>
