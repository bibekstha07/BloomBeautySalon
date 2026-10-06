<?php
// Connect to the MySQL database.

$conn = mysqli_connect("localhost", "root", "", "BloomBeautySalon");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
