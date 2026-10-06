<?php
// Connect to the MySQL database.

$conn = mysqli_connect("localhost", "root", "", "BloomBeautySalon");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Make the next ID code for a table, e.g. U001, U002 ... or B001, B002 ...
// $table  - the table name, e.g. "users"
// $column - its ID column, e.g. "user_id"
// $prefix - the letter in front, e.g. "U"
// It finds the highest code so far, adds 1 to the number part
// and pads it to 3 digits (U007 -> U008). The very first row gets U001.
function next_id($conn, $table, $column, $prefix) {
    // Sort by length first, so U1000 counts as higher than U999
    $result = mysqli_query($conn, "SELECT $column FROM $table ORDER BY LENGTH($column) DESC, $column DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $number = (int)substr($row[$column], strlen($prefix)) + 1;
    } else {
        $number = 1;
    }
    return $prefix . str_pad($number, 3, "0", STR_PAD_LEFT);
}