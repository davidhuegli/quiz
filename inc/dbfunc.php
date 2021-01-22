<?php


function dbconnect()
{
    include 'conf.php';
// Create connection
    $conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

?>
