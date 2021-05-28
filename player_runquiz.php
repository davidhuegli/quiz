<?php

//
// Question register Page unregistered Users / Students
//
// Previous Page: player_waitquestion.php
// Next Page: player_waitquestion.php (loopback)
//

include 'conf.php';
session_start();


if(isset($_GET["answerid"])){
    $answer = $_GET["answerid"];
    $redirect = true;
} else if(isset($_GET["redirect"])){
        $redirect = true;
} else {
    $redirect = false;
}
if(isset($_POST["gpin"])){
    $gpin = $_POST["gpin"];
    $nickname = $_POST["nickname"];
    $_SESSION["nickname"] = $nickname;
    $_SESSION["gamepin"] = $gpin;
    $answer = $_GET["answerid"];
} else {
    $nickname = $_SESSION["nickname"];
    $gpin = $_SESSION["gamepin"];
    $answer = $_GET["answerid"];
}
$sid = session_id();

function redirect() {
    include 'conf.php';
    $gamepin = $_SESSION["gamepin"];
    // Create connection
    $conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql0 = "SELECT started FROM game WHERE gamepin='$gamepin'";
    $result0 = $conn->query($sql0);
    if ($result0->num_rows > 0) {
        // output data of each row
        while ($row = $result0->fetch_assoc()) {
            $isStarted = $row["started"];
        }
    } else {
        exit ("Fehler. Game wurde nicht (mehr) gefunden!");
    }

    switch ($isStarted) {
        case 1:
            echo "Wait";
            header("refresh:3; url=player_runquiz.php?redirect=1");
            break;
        case 2:
            header("refresh:3; url=player_stats.php?redirect=1"); //TODO: player_stats.php und dann von dort aus die Weiterleitung nach Bild auf Handy machen
            break;
        default:
            break;
    }



}











if($redirect) {

    // Create connection
    $conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }



    $nickname = $_SESSION["nickname"];
    $time = date("Y-m-d H:i:s");

    $sql0 = "SELECT currentquestion FROM game WHERE gamepin='$gpin'";
    $result0 = $conn->query($sql0);
    // if game started
    if ($result0->num_rows > 0) {
    // output data of each row
        while ($row = $result0->fetch_assoc()) {
            $currentquestion = $row["currentquestion"];
        }

        echo "Currentquestion: " . $currentquestion;
        $questionid = $currentquestion;
    }




    $sql5 = "SELECT quiz.questionid,question.solution1,question.solution2,question.solution3,question.solution4
      FROM `quiz` INNER JOIN question ON quiz.questionid = question.id WHERE `quizdescid` = 1 ORDER BY position ASC";
    $result = $conn->query($sql5);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $question[] = $row["questionid"];
            $solution1[] = $row["solution1"];
            $solution2[] = $row["solution2"];
            $solution3[] = $row["solution3"];
            $solution4[] = $row["solution4"];
        }
    }


    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo $solution1[$currentquestion];
    echo $solution2[$currentquestion];
    echo $solution3[$currentquestion];
    echo $solution4[$currentquestion];
    echo "<br>";
    echo "<br>";
    echo "<br>";



    switch ($answer) {
        case "1":
            echo $solution1[$currentquestion];
            if ($solution1[$currentquestion] == 1) {
                $right = true;
            } else {
                $right = false;
            }
            break;
        case "2":
            echo $solution2[$currentquestion];
            if ($solution2[$currentquestion] == 1) {
                $right = true;
            } else {
                $right = false;
            }
            break;
        case "3":
            echo $solution3[$currentquestion];
            if ($solution3[$currentquestion] == 1) {
                $right = true;
            } else {
                $right = false;
            }
            break;
        case "4":
            echo $solution4[$currentquestion];
            if ($solution4[$currentquestion] == 1) {
                $right = true;
            } else {
                $right = false;
            }
            break;
        default:
            redirect();
    }

    $answerid = $answer;
        //TODO: die $questionid wird irgendwie falsch gelesen...

        if ($right) {
            $sql2 = "INSERT INTO results (gamepin, playerid, timestamp, questionid, points, answerid)
              VALUES('$gpin', '$nickname', '$time', '$questionid', '1', '$answerid')";

            if ($conn->query($sql2) === TRUE) {
                echo "Antwort registriert!";
                redirect();
            } else {
                echo "Error: Antwort konnte nicht in der Datenbank registriert werden! Fehler: " . $conn->error;
                redirect();
            }
        } else {
            $sql2 = "INSERT INTO results (gamepin, playerid, timestamp, questionid, points, answerid)
              VALUES('$gpin', '$nickname', '$time', '$questionid', '0', '$answerid')";

            if ($conn->query($sql2) === TRUE) {
                echo "Antwort registriert!";
                redirect();
            } else {
                echo "Error: Antwort konnte nicht in der Datenbank registriert werden! Fehler: " . $conn->error;
                redirect();
            }
        }

    } else {
    redirect();
}

/*
$soltest = "solution$answer";

if ($$soltest[$currentquestion] == 1) {
    echo "HALLLOOOOOOOOO";
} else {
    echo "Doch nicht ganz";
}*/




?>