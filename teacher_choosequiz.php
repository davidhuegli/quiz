<?php
include 'conf.php';


// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();
$u_id = $_SESSION["userid"];
//                                     TODO: CHANGE
$sql = "SELECT quiz.id,quizdesc.title from `quiz` INNER JOIN quizdesc ON quiz.quizdescid = quizdesc.id WHERE `userid` = '1'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
  echo "QuizID:" . $row["id"] . "<br> Quiztitel:" . $row["title"] . "  " . "<a href=teacher_gameplay.php?id=" . $row["id"] . ">Dieses Quiz auswählen</a><br><br>";
  }
}



 ?>
