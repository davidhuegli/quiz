<?php

//
// Question-Screen (showing Answers) for unregistered Users / Students
//
// Previous Page: player_wait.php
// Next Pages:
//      Running Quiz:       player_runquiz.php
//      No Questions left:  player_result.php
//

//TODO: NEXT, add waittime for player, when only question is displayed on screen
include 'conf.php';
session_start();

if(isset($_GET["answerid"])){
    $answer = $_GET["answerid"];
    $redirect = false;
} else if(isset($_GET["redirect"])){
    $redirect = true;
} else {
    $redirect = false;
}
if(isset($_POST["gpin"])){
    $gpin = $_POST["gpin"];
    $nickname = $_POST["nickname"];
    $_SESSION["nickname"] = $nickname;
    $_SESSION["gamepin"] = $gpin;
} else {
    $nickname = $_SESSION["nickname"];
    $gpin = $_SESSION["gamepin"];
    if(!isset($_GET["redirect"])) {
        $answer = $_GET["answerid"];
    }
}

// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql0 = "SELECT started FROM game WHERE gamepin='$gpin'";
$result0 = $conn->query($sql0);
if ($result0->num_rows > 0) {
// output data of each row
    while ($row = $result0->fetch_assoc()) {
        $isStarted = $row["started"];
    }
    //echo $isStarted;
} else {
    exit ("Das Game, wurde nicht (mehr) gefunden!");
}

if($isStarted == 2) {
    header("refresh:0; url=player_stats.php");
} elseif($isStarted == 3) {
    header("refresh:0; url=player_podium.php");
}


echo "<p>Die Frage erscheint auf dem Beamer!<p>";
header("refresh:2; url=player_waitquestion.php");

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/quiz.css"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</head>
<body>
<a href="player_runquiz.php?answerid=1">Antwort 1</a>
<a href="player_runquiz.php?answerid=2">Antwort 2</a>
<a href="player_runquiz.php?answerid=3">Antwort 3</a>
<a href="player_runquiz.php?answerid=4">Antwort 4</a>

</body>
</html>
