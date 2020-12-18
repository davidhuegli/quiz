<?php 
// etwas php Code und ein cooles SQL Statement von Lucien ;-)
$player1 = "Rea";
$player2 = "Lucien";
$player3 = "David";
?>

<html>
  <head>

        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
	<title>Podium</title>

  </head>
  <body>
    <div class="podium">
    <p>
    <img src="./pics/podium.png" alt="Podium" class="center"> <br>
      <h1>
        <?php echo $player2; ?> 
        <?php echo $player1; ?>
        <?php echo $player3; ?> <br>
    </div>
  </body>
</html>
