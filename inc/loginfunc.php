<?php
include 'conf.php';

function login($redirect, $error, $conn, $u_name, $hash, $result) {
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
  	//echo " <br> $hash";
  	echo "<br>PW HASH from DB: " . $row["pwhash"]. "<br>";
  	if ($hash == $row["pwhash"]) {
  		echo "Login erfolgreich :-)";
  		session_start();
  		$sid = session_id();
  			$_SESSION["user"] = $u_name;
  		echo " <br> SessionID: $sid <br>";
  		$sql = "UPDATE `users` SET `sessionid` = '$sid' WHERE `users`.`username` = '$u_name'";

  		if ($conn->query($sql) === TRUE) {
    			echo "New record created successfully";
          $sql2 = "SELECT id FROM users WHERE username='$u_name'";
          $result = $conn->query($sql2);
          if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              $_SESSION["userid"] = $row["id"];
              echo "<br> UserID: " . $_SESSION["userid"];
            }
          }
  		} else {
   			echo "Error: " . $sql . "<br>" . $conn->error;
  		}

  		header("refresh:3;url=$redirect");
          }

  	else {
  		echo "Benutzername und/oder Passwort nicht korrekt";

  		header("refresh:5;url=$error");
  		exit(1);
          }

    }
  } else {
    echo "<br> User nicht vorhanden oder Passwort falsch ;-)";
  }
}

function logout($u_name) {

  echo "<br> loginfunc.php: " . $u_name;
  $sql = "UPDATE `users` SET `sessionid` = '0' WHERE `users`.`username` = '$u_name'";
  echo "<br> Logout erfolgreich";

}


 ?>
