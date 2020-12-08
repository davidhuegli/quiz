<?php
include 'conf.php';
session_start();

if (isset($_SESSION["gamepin"])) {
  $gamepin = $_SESSION["gamepin"];
  $gameid = $_SESSION["gameid"];
} else {
  echo "Keine GameID gesetzt, normalerweise würde jetzt eine Weiterleitung kommen...";
}


?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/quiz.css" />
  </head>
  <body>
    GameID: <?php echo $gameid?>
    <br>
    GamePin: <?php echo $gamepin?>
  </body>
</html>
