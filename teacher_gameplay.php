<?php

//
// Lobby Screen when Game started for registered Users / Teachers
//
// Previous Page: teacher_choosequiz.php
// Next Page: teacher_runquiz.php
//

include 'conf.php';

// Login Check Missing

session_start();
// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET["id"])) {
    if (isset($_SESSION["gameid"])) {
        $gameid = $_SESSION["gameid"];
        $gamepin = $_SESSION["gamepin"];
    } else {

        $gamepin = (rand(100000, 999999));
        $userid = $_SESSION["userid"];
        $quizid = $_GET["id"];
        $time = date("Y-m-d H:i:s");
        echo $time;
        echo $gamepin;


        $sql = "INSERT INTO game (userid, quizid, gamepin, date, started)
              VALUES('$userid', '$quizid', '$gamepin', '$time', '0')";

        if ($conn->query($sql) === TRUE) {
            echo "Erfolg! Das Game wurde registriert!";
        } else {
            echo "Error: Game konnte nicht in der Datenbank registriert werden! Fehler: " . $conn->error;
        }


        $sql2 = "SELECT id FROM game WHERE gamepin=$gamepin";
        $result = $conn->query($sql2);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $gameid = $row["id"];
            }
        }

        $_SESSION["gamepin"] = $gamepin;
        $_SESSION["gameid"] = $gameid;

    }

} else {
    echo "Keine GameID gesetzt, normalerweise würde jetzt eine Weiterleitung kommen...";
}


?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/quiz.css"/>
    <link rel="stylesheet" type="text/css" href="style/style.css"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta http-equiv="refresh" content="3">
</head>
<body>
<body>

<div class="header_game">
    <p>Join at ...</p>
    <p>Game Pin <?php echo $gamepin ?></p>
    <?php

    echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2Flovefield.goip.de%2Fquiz%2Fplayer_gameplay.php%2F?gpin=$gamepin%2F&choe=UTF-8' title='Beim Quiz anmelden' />";

    ?>
    <p></p>

    <p></p>
</div>

<div class="topnav_game">
    <a href="teacher_choosequiz.php">zur&uuml;ck</a>
    <a href="teacher_runquiz.php" style="float:right">start</a>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</div>

<?php
$sql3 = "SELECT COUNT(nickname) AS total FROM players WHERE gameid=$gamepin";
$result = $conn->query($sql3);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $players = $row["total"];
    }
}
?>


<div class="box1">
    <?php echo $players; ?> Teilnehmer beim Quiz
    <p><?php $sql4 = "SELECT nickname FROM players WHERE gameid=$gamepin";
        $result = $conn->query($sql4);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $nickname = $row["nickname"];
                echo "$nickname, ";
            }
        }
        ?></p>
</div>
<div class="box2">
    <p>
        Waiting for players...
    </p>
</div>

<div class="footer_game">
    &copy; by Rea und Lucien 2020
</div>


</body>
</html>
