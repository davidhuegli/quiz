<?php
echo "<h1> Quizseite ohne jeglichen Inhalt oder so....... </h1>";



session_start();
$sid = session_id();
echo "<br> SessionID: " . $sid;
$user = $_SESSION["user"];
echo "<br> Session User: " . $user ;

include 'conf.php';
// Create connection
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
/*    Call and implement Database functions (error)
include 'inc\dbfunc.php';
dbconnect();
*/

$sql = "SELECT sessionid FROM users WHERE username='$user'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);
echo "<br> DBSessionid: " . $row['sessionid'] .  "<br>";

$conn->close();


if ($row['sessionid'] == $sid) {
    echo "<br>Session OK";
} else {
   echo "<br> Session NOK";
   // set  SessionID in Db => 0 or delete it ;-)
   // redirect to loginpage
}

echo "<br><br><a href='teacher_choosequiz.php'><button>Quiz auswählen</button></a>";

?>
