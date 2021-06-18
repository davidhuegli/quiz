<?php

//
// Quiz Login Page for unregistered Users / Students
//
// Previous Page: /
// Next Page: player_wait.php
//

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
    <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
</head>
<body>
<div class="login">
<form action="player_wait.php" method="post">
    <label for="gpin">GamePin:</label><br>
    <input class="logininput" type="text" id="gpin" name="gpin" value="<?php echo $gpin; ?>"><br>
    <label for="nickname">Nickname:</label><br>
    <input class="logininput type="text" id="nickname" name="nickname"><br><br>
    <input class="btn" type="submit" value="Spiel beitreten">
</form>
</div>
</body>
</html>
