<?php

session_start();
include 'conf.php';
$gamepin = $_SESSION["gamepin"];

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
}

// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql0 = "SELECT started FROM game WHERE gamepin='$gamepin'";
$result0 = $conn->query($sql0);
if ($result0->num_rows > 0) {
    // output data of each row
    while ($row = $result0->fetch_assoc()) {
        $isStarted = $row["started"];
    }
} else {
    exit ("Fehler. Game wurde nicht (mehr) gefunden!");
}

switch ($isStarted) {
    case 1:
        header("refresh:3; url=player_waitquestion.php");
        break;
    case 2:
        echo "Auswertung auf dem Beamer.";
        header("refresh:3; url=player_stats.php");
        break;
    default:
        break;
}