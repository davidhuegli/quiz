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

  $sql = "SELECT `questionid` FROM `quiz` WHERE `quizdescid` = 1 ORDER BY position ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    $_SESSION["questions"] = $result;
    while($row = $result->fetch_assoc()) {
      echo $row["questionid"];
      array_push($questions, $row["questionid"]);
      }
    }



} else {
  echo "Error: Game konnte in der Datenbank nicht auf gestartet gesetzt werden! Fehler: <br>" . $conn->error;
}




?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/quiz.css" />
  </head>
  <body>
    GameID: <?php echo $gameid;?>
    <br>
    GamePin3: <?php echo $gamepin;?>
    <br>
    alle Inhalte: <?php print_r($questions);?><br>
    gesamte Anzahl im Array: <?php $sum  = count($questions); echo $sum;?><br>
    value 0 aus dem Array:
    <?php
        if (isset($_SESSION["round"])) {
          $round = $_SESSION["round"];
          if ($round < $sum) {
            echo $questions[$round];
            $round++;
            $_SESSION["round"] = $round;
            header("refresh:5; url=#");
          } else {
            echo "Keine Fragen mehr, normalerweise käme jetzt die Auswertung!";
          }
        } else {
          $round = 0;
          $_SESSION["round"] = $round;
          header("refresh:1; url=#");
      }


    ?>
    <br>
  </body>
</html>
