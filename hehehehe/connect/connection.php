<?php
function dbConnect() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "motor_db";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
