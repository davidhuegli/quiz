<?php

include 'conf.php';
session_start();

// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$gamepin = 238477;
$round = 1;

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

echo $answer1;
echo $answer2;
echo $answer3;
echo $answer4;


/*





$sql5 = "SELECT quiz.questionid,question.solution1,question.solution2,question.solution3,question.solution4
  FROM `quiz` INNER JOIN question ON quiz.questionid = question.id WHERE `quizdescid` = 1 ORDER BY position ASC";
$result = $conn->query($sql5);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row["questionid"];
        $solution1[] = $row["solution1"];
        $solution2[] = $row["solution2"];
        $solution3[] = $row["solution3"];
        $solution4[] = $row["solution4"];
    }
}

$answer = 1;
$currentquestion = 2;

switch ($answer) {
    case 1:
        echo $solution1[$currentquestion];
        break;
    case 2:
        echo $solution2[$currentquestion];
        break;
    case 3:
        echo $solution3[$currentquestion];
        break;
    case 4:
        echo $solution4[$currentquestion];
        break;
    default:
        echo "Error!";
}

$soltest = "solution$answer";

echo $$soltest[$currentquestion];

echo "<br>";
echo $solution1[2];
echo $solution2[2];
echo $solution3[2];
echo $solution4[2];*/