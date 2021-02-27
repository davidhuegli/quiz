<?php
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
        $answer1 = [];
        $answer2 = [];
        $answer3 = [];
        $answer4 = [];
        while ($row = $result->fetch_assoc()) {
            array_push($questions, $row["questionid"]);
            //array_push($questionsfull, $row["question"]);
            $questionfull[] = $row["question"];
            $answer1[] = $row["answer1"];
            $answer2[] = $row["answer2"];
            $answer3[] = $row["answer3"];
            $answer4[] = $row["answer4"];
        }
    }


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
value 0 aus dem Array (und Antworten):
<?php
if (isset($_SESSION["round"])) {
    $round = $_SESSION["round"];
    if ($round < $sum) {
        echo $round;
        echo $questionfull[$round];
        echo $answer1[$round];
        echo $answer2[$round];
        echo $answer3[$round];
        echo $answer4[$round];
        $round++;
        $_SESSION["round"] = $round;
        header("refresh:5; url=teacher_runquiz.php");
    } else {
        echo "Keine Fragen mehr, normalerweise käme jetzt die Auswertung!";
    }
} else {
    header("refresh:1; url=teacher_runquiz.php");
}


?>
<br>
</body>
</html>
