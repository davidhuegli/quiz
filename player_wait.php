<?php
include 'conf.php';
session_start();

$gpin = $_POST["gpin"];
$nickname = $_POST["nickname"];
$sid = session_id();

// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO players (nickname, gameid, sessionid)
          VALUES('$nickname', '$gpin', '$sid')";

          if ($conn->query($sql) === TRUE) {
            $success = true;
          } else {
            $success = false;
          }

$sql2 = "SELECT id FROM players WHERE nickname='$nickname'";
$result = $conn->query($sql2);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $playerid = $row["id"];
  }
} else {
  $success = false;
}

$_SESSION["pid"] = $playerid;
$_SESSION["gpin"] = $gpin;

?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/quiz.css" />
  </head>
  <body>
    <p>Willkommen, <?php echo "$nickname"?>!</p>
    <?php if($success == false) {
      echo "Es ist ein Fehler mit unserer Datenbank aufgetreten!";
    } else {
      echo "Bitte warte, bis dein/e LehrerIn das Spiel startet";
    }?>

  </body>
</html>
