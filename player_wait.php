<?php

//
// Waiting Screen for unregistered Users / Students
//
// Previous Page: player_login.php
// Next Page: player_waitquestion.php
//



include 'conf.php';
session_start();

if(isset($_POST["gpin"])){
    $gpin = $_POST["gpin"];
    $nickname = $_POST["nickname"];
    $_SESSION["nickname"] = $nickname;
    $_SESSION["gamepin"] = $gpin;
} else {
    $nickname = $_SESSION["nickname"];
    $gpin = $_SESSION["gamepin"];
}

$sid = session_id();

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
    echo $isStarted;
} else {
    exit ("Das Game, für welches du dich anmelden wolltest, wurde nicht gefunden!");
}

if ($isStarted >= 0) {

    $sql0 = "SELECT id,sessionid FROM players WHERE nickname='$nickname' AND gameid='$gpin'";
    $result0 = $conn->query($sql0);
    if ($result0->num_rows > 0) {
        // output data of each row
        while ($row = $result0->fetch_assoc()) {
            $exists = true;
            if($row["sessionid"] = $sid) {
                $sameuser = true;
            }
        }
    } else {
        $exists = false;
        $sql = "INSERT INTO players (nickname, gameid, sessionid)
                    VALUES('$nickname', '$gpin', '$sid')";

        if ($conn->query($sql) === TRUE) {
            $success = true;
        } else {
            $success = false;
        }

        $sql2 = "SELECT id FROM players WHERE nickname='$nickname' AND gameid='$gpin'";
        $result = $conn->query($sql2);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $playerid = $row["id"];
            }
        } else {
            $success = false;
        }

        $_SESSION["pid"] = $playerid;
        $_SESSION["gpin"] = $gpin;
    }
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
<p>Willkommen, <?php echo "$nickname" ?>!</p>
<?php
if ($exists == true) {
    header("refresh:5;url=player_login.php");
    if ($sameuser == true) {
        if ($isStarted == 0) {
            echo "Bitte warte, bis dein/e LehrerIn das Spiel startet";
            header("refresh:1; url=player_wait.php");
        } else {
            echo "Dein Spielername wurde bereis verwendet, benutze bitte einen anderen!";
            header("refresh:1; url=player_waitquestion.php");
        }
    }
}
elseif ($isStarted == 1) {
    echo "Das Spiel ist bereits gestartet!";
} elseif ($success == false) {
    echo "Es ist ein Fehler mit unserer Datenbank aufgetreten!";
} else {
    echo "Bitte warte, bis dein/e LehrerIn das Spiel startet";
    header("refresh:1; url=player_wait.php");
} ?>

</body>
</html>
