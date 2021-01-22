<?php
include 'conf.php';

foreach (glob("inc\*.php") as $filename) {
    include $filename;
}

// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$u_name = $_SESSION["user"];
echo "logout.php: " . $u_name;

$sql = "UPDATE `users` SET `sessionid` = '0' WHERE `users`.`username` = '$u_name'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

header("refresh:1;url=start.html");


$conn->close();

?>
