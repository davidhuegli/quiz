<?php
include 'conf.php';
session_start();

// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nickname = $_SESSION["nickname"];
$time = date("Y-m-d H:i:s");
$questionid = ""; //TODO: Set $questionid to actual questionid



//TODO: Check, if answer was right, then set $right
$right = "";

if (isset($_GET["answerid"])) {
    $answerid = $_GET["answerid"];




    if($right) {
        $sql2 = "INSERT INTO results (playerid, timestamp, questionid, points)
              VALUES('$nickname', '$time', '$questionid', '1')";

        if ($conn->query($sql2) === TRUE) {
            echo "Antwort registriert!";
        } else {
            echo "Error: Antwort konnte nicht in der Datenbank registriert werden! Fehler: " . $conn->error;
        }
    } else {
        $sql2 = "INSERT INTO results (playerid, timestamp, questionid, points)
              VALUES('$nickname', '$time', '$questionid', '0')";

        if ($conn->query($sql2) === TRUE) {
            echo "Antwort registriert!";
        } else {
            echo "Error: Antwort konnte nicht in der Datenbank registriert werden! Fehler: " . $conn->error;
        }
    }

} else{
    echo "Ungültige Antwort...";
}

?>