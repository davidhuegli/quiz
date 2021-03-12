<?php

//
// Podium after Game for registered Users / Teachers
//
// Previous Page: teacher_runquiz-answers.php
// Next Page: teacher_results.php
//


include 'conf.php';
session_start();

// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_SESSION["gamepin"])) {
    $gamepin = $_SESSION["gamepin"];
    $gameid = $_SESSION["gameid"];
} else {
    echo "Keine GameID gesetzt, normalerweise würde jetzt eine Weiterleitung kommen...";
}

$sql = "SELECT playerid as player,sum(points) as psum FROM results WHERE `gamepin` = '$gamepin' GROUP BY playerid ORDER BY points ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo $row["player"] . ": " . $row["psum"] . "<br>";
    }
} else {
    echo "Keine Werte gefunden";
}