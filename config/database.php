<?php

$host = "localhost";
$username = "root";
$password = "114101129";
$database = "user_management_system";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>