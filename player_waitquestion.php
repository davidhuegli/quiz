<?php //TODO: NEXT, add waittime for player, when only question is displayed on screen
include 'conf.php';
session_start();


echo "<p>Die Frage erscheint auf dem Beamer!<p>";
header("refresh:1; url=player_waitquestion.php");

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/quiz.css"/>
</head>
<body>
<a href="player_runquiz.php?answerid=1">Antwort 1</a>
<a href="player_runquiz.php?answerid=2">Antwort 2</a>
<a href="player_runquiz.php?answerid=3">Antwort 3</a>
<a href="player_runquiz.php?answerid=4">Antwort 4</a>

</body>
</html>
