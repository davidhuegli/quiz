<?php

// Check Login
session_start();
$sid = session_id();
//echo "<br> SessionID: " . $sid;
$user = $_SESSION["user"];
//echo "<br> Session User: " . $user ;

include 'conf.php';
$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT sessionid FROM users WHERE username='$user'";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);
//echo "<br> DBSessionid: " . $row['sessionid'] .  "<br>";

$conn->close();


if ($row['sessionid'] == $sid) {
    //echo "<br>Session OK";
} else {
   //echo "<br> Session NOK";
   header("refresh:1;url=start.html");
}
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
            <h2> <?php echo "Hallo $user"; ?>, Willkommen beim QUIZ</h2>
            <p>  blablabla</p>
            <p>  blablabla</p>
          </div>

          <div class="footer">
            <p> &copy; by Rea & Lucien 2020</p>
          </div>
        
        
    </body>
</html>
