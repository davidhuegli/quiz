<?php
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

$nickname = $_SESSION["nickname"];
$time = date("Y-m-d H:i:s");

$sql0 = "SELECT started FROM game WHERE gamepin=$gpin";
$result0 = $conn->query($sql0);
if ($result0->num_rows > 0) {
// output data of each row
    while ($row = $result0->fetch_assoc()) {
        $isStarted = $row["started"];
    }

    echo $isStarted;
    $questionid = "";
}

//TODO: Check, if answer was right, then set $right
    $right = "";

    if (isset($_GET["answerid"])) {
        $answerid = $_GET["answerid"];


        if ($right) {
            $sql2 = "INSERT INTO results (playerid, timestamp, questionid, points)
              VALUES('$nickname', '$time', '$questionid', '1')";

            if ($conn->query($sql2) === TRUE) {
                echo "Antwort registriert!";
                header("refresh:1; url=player_waitquestion.php");
            } else {
                echo "Error: Antwort konnte nicht in der Datenbank registriert werden! Fehler: " . $conn->error;
                header("refresh:1; url=player_waitquestion.php");
            }
        } else {
            $sql2 = "INSERT INTO results (playerid, timestamp, questionid, points)
              VALUES('$nickname', '$time', '$questionid', '0')";

            if ($conn->query($sql2) === TRUE) {
                echo "Antwort registriert!";
                header("refresh:1; url=player_waitquestion.php");
            } else {
                echo "Error: Antwort konnte nicht in der Datenbank registriert werden! Fehler: " . $conn->error;
                header("refresh:1; url=player_waitquestion.php");
            }
        }

    } else {
        echo "Ungültige Antwort...";
    }

?>