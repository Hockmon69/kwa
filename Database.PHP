<?php
$host = "localhost";
$user = "root";     // Default XAMPP user
$pass = "";         // Default XAMPP password is empty
$dbname = "photography_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>