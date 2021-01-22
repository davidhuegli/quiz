<?php
include 'conf.php';
session_start();

if (isset($_GET["gpin"])) {
    $gpin = $_GET["gpin"];
} else {
    $gpin = "";
}

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/quiz.css"/>
</head>
<body>
<form action="player_wait.php" method="post">
    <label for="gpin">GamePin:</label><br>
    <input type="text" id="gpin" name="gpin" value="<?php echo $gpin; ?>"><br>
    <label for="nickname">Nickname:</label><br>
    <input type="text" id="nickname" name="nickname"><br><br>
    <input type="submit" value="Spiel beitreten">
</form>
</body>
</html>
