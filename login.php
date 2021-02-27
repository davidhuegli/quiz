<?php

//
// Backend for Login Page for registered Users / Teachers
//
// Previous Page: start.html
// Next Page: quiz.php
//

include 'conf.php';

//foreach (glob("inc\*.php") as $filename) {
//    include $filename;
//}

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is comming from a form


    $u_name = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $u_password = filter_var($_POST["user_password"], FILTER_SANITIZE_STRING);

    $hash = hash(sha256, $u_password);
    echo "$hash <br>";
    echo "$u_name <br>";

    // Create connection
    $conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //TODO: select uID from DB and set Session-Variable
    $sql = "SELECT pwhash,id FROM users WHERE username='$u_name'";
    $result = $conn->query($sql);

    echo $sql . "<br>";


    //require_once "inc\loginfunc.php";
    //login("quiz.php", "start.html", $conn, $u_name, $hash, $result);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo $row["pwhash"] . "<br>";
            $_SESSION["userid"] = $row["id"];
            if ($hash == $row["pwhash"]) {
                echo "Login erfolgreich :-)";
                session_start();
                $sid = session_id();
                $_SESSION["user"] = $u_name;
                echo " <br> SessionID: $sid <br>";

                $sql = "UPDATE `users` SET `sessionid` = '$sid' WHERE `users`.`username` = '$u_name'";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                header("refresh:5;url=quiz.php");

            } else {
                echo "Benutzername und/oder Passwort nicht korrekt";

                header("refresh:5;url=start.html");
                exit(1);
            }
        }
    }


    $conn->close();


}
?>
