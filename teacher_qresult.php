<?php

//
// Running Quiz, show Questions with answers
//
// Previous Page: teacher_runquiz-answers.php
// Next Page: teacher_runquiz.php
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

$nextround = $_SESSION["round"];
$round = $nextround - 1;

/*echo $nextround;
echo $round;*/

$answer1 = 0;
$answer2 = 0;
$answer3 = 0;
$answer4 = 0;

$sql = "SELECT answerid
  FROM `results` WHERE `gamepin` = $gamepin AND `questionid` = $round ORDER BY answerid ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        //TODO: Schauen, ob es weniger als 4 Fragen hat
        switch ($row["answerid"]) {
            case 1:
                $answer1++;
                break;
            case 2:
                $answer2++;
                break;
            case 3:
                $answer3++;
                break;
            case 4:
                $answer4++;
                break;
            default:
                break;
        }
    }
}


$sql2 = "SELECT COUNT(answerid) AS answerCount FROM `results` WHERE `gamepin` = $gamepin AND `questionid` = $round";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    // output data of each row
    while ($row = $result2->fetch_assoc()) {
        $answerCount = $row["answerCount"];
    }
}

echo "Gesamtzahl an Antworten:" . $answerCount . "<br>";
echo "Antwort 1: " . $answer1 . "<br>";
echo "Antwort 2: " . $answer2 . "<br>";
echo "Antwort 3: " . $answer3 . "<br>";
echo "Antwort 4: " . $answer4 . "<br>";

echo "<a href='teacher_runquiz.php'>Weiterspielen</a>";