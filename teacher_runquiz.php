<?php

//
// Running Quiz, show Questions without answers
//
// Previous Page: teacher_gameplay.php
// Next Pages:
//      Ping-Pong while showing Questions:  teacher_runquiz-answers.php
//      End of Ping-Pong in:                teacher_runquiz-answers.php
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

$questions = array();

$sql = "UPDATE `game` SET `started` = 1 WHERE `id` = '$gameid'";

if ($conn->query($sql) === TRUE) {
    echo "Erfolg! Das Game wurde gestartet! <br>";

    $sql = "SELECT quiz.questionid,question.question,question.answer1,question.answer2,question.answer3,question.answer4,question.time
  FROM `quiz` INNER JOIN question ON quiz.questionid = question.id WHERE `quizdescid` = 1 ORDER BY position ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $_SESSION["questions"] = $result;
        $questionsfull = [];
        while ($row = $result->fetch_assoc()) {
            array_push($questions, $row["questionid"]);
            //array_push($questionsfull, $row["question"]);
            $questionfull[] = $row["question"];
            $questiontime = $row["time"];
        }
    }

    $sql2 = "SELECT started FROM `game` WHERE `id` = '$gameid'";
    $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            // output data of each row
            $startedvalue = $row["started"];
        }
        echo $startedvalue;


} else {
    echo "Error: Game konnte in der Datenbank nicht auf gestartet gesetzt werden! Fehler: <br>" . $conn->error;
}


?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/quiz.css"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</head>
<body>
GameID: <?php echo $gameid; ?>
<br>
GamePin3: <?php echo $gamepin; ?>
<br>
alle Inhalte: <?php print_r($questions); ?><br>
gesamte Anzahl im Array: <?php $sum = count($questions);
echo $sum; ?><br>
value 0 aus dem Array:
<?php

$currentquestion = $_SESSION["currentquestion"];

echo $startedvalue;


if (isset($_SESSION["round"])) {
    $round = $_SESSION["round"];
    if ($round < $sum) {
        if ($conn->query($sql) === TRUE) {
            echo "Erfolg! Das Game wurde gestartet! <br>";
        }
        echo $round;
        echo $questionfull[$round];

        $sql3 = "UPDATE `game` SET `currentquestion` = '$currentquestion' WHERE `id` = '$gameid'";
        if ($conn->query($sql3) === TRUE) {
            echo "CurrentQuestion erfolgreich zu $currentquestion gesetzt! <br>";
        }
        $currentquestion++;

        $_SESSION["currentquestion"] = $currentquestion;

        //$round++;
        //$_SESSION["round"] = $round;
        header("refresh:5; url=teacher_runquiz-answers.php");
    } else {
        header("refresh:0; url=teacher_podium.php");
    }
} else {
    $round = 0;
    $_SESSION["round"] = $round;
    header("refresh:1; url=#");
}


?>
</body>
</html>
