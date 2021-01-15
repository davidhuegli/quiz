<?php
include 'conf.php';

// Login Check Missing

// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();
//$u_id = $_SESSION["userid"];
//                                     TODO: CHANGE

?>



<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
	<title>Quiz von Rea und Lucien &copy; 2020</title>
    </head>
    <body>
        <div class="header">
             <img src="pics/quiz_logo.png">
        </div>




          <div class="topnav">
            <a href="quiz.php">Quiz erstellen</a>
            <a href="quiz.php">Quiz bearbeiten</a>
            <a href="teacher_choosequiz.php">Game starten</a>
            <a href="quiz.php">Frage erstellen</a>
            <a href="quiz.php">Frage bearbeiten</a>

            <a href="logout.php" style="float:right">Logout</a>
          </div>



    <div class="column middle">
        <?php
        //$sql = "SELECT quiz.id,quizdesc.title from `quiz` INNER JOIN quizdesc ON quiz.quizdescid = quizdesc.id WHERE `userid` = '1'";
        $sql = "SELECT DISTINCT quiz.quizdescid,quizdesc.title FROM `quiz` INNER JOIN quizdesc ON quiz.quizdescid = quizdesc.id WHERE `userid` = '1'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            echo "QuizID:" . $row["quizdescid"] . "<br> Quiztitel:" . $row["title"] . "  " . "<a href=teacher_gameplay.php?id=" . $row["quizdescid"] . ">Dieses Quiz auswählen</a><br><br>";
            }
          }

        ?>


    </div>

          <div class="footer">
            <p> &copy; by Rea & Lucien 2020</p>
          </div>


    </body>
</html>
