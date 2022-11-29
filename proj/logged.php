<?php
	session_start();
	error_reporting(0);
	$_SESSION['latest'];
	$now;
	if((isset($_SESSION['mode']))&&(isset($_SESSION['name'])))
	{
		write_normal();
		echo "<script>pigo();</script>";
		$srvr = "localhost";
		$user = "terra";
		$dbPassword = "lol";
		$db = "Chat";
		$table = "txt";

		$connection = new mysqli($srvr,$user,$dbPassword,$db);

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if($connection->connect_error){die($connection->connect_error);}
			else
			{
				if($_POST['off'])
				{
					session_destroy();
    				echo "<script type=\"text/javascript\">window.location.href='index.php';</script>";
				}

				if($_POST['send'])
				{
					if($connection->connect_error){die($connection->connect_error);}
					else
					{
						$name = $_SESSION['name'];
						$txt = $_POST['comment'];
						$question = "INSERT INTO txt(name,txt) VALUES('$name','$txt')";
						$answer = $connection->query($question);
					}
				}

				if($_POST['trunc'])
				{
				    $table = "txt";
					$zap = "TRUNCATE $table;";
					$answer = $connection->query($zap);
				}
			}
		}
		mysqli_close($connection);

	}
	else
	{
		echo "<script>alert(\"Sumnfig łent rong, if(using mobile){Try using firefox;}\")</script>";
	}

	function write_normal()
	{
	    $name = $_SESSION['name'];
		echo "<!DOCTYPE html>";
		echo "	<head>";
		echo "		<meta charset=\"utf-8\" lang=\"pl/PL\" />";
		echo "      <meta name=\"viewport\" content=\"width=device-width\" initial-scale=1 />";
		echo "		<title>Angry Soviet Pig Chat</title>";
		echo "		<link rel=\"stylesheet\" href=\"logged.css\" />";
		echo "		<link rel=\"shortcut icon\" href=\"src/ASPC.png\" />";
		echo "		<script src=\"main.js\"></script>";
		echo "	</head>";

		echo "	<body>";
		echo "  <div id=\"doc\">";
		echo "  Logged as:";
		echo $name;
		echo "   <div id=\"offBox\">";
		echo " 		<form action\"logged.php\" method=\"POST\">";
		echo " 			<input type=\"submit\" id=\"off\" name=\"off\" value=\"Φ\"/>";
		echo " 		</form>";
		echo " 	</div>";

		if($_SESSION['mode'] == "admin"){echo "   <div id=\"xxBox\">";}
		if($_SESSION['mode'] == "admin"){echo " 		<form action\"logged.php\" method=\"POST\">";}
		if($_SESSION['mode'] == "admin"){echo " 			<input type=\"submit\" id=\"off\" name=\"trunc\" value=\"XX\"/>";}
		if($_SESSION['mode'] == "admin"){echo " 		</form>";}
		if($_SESSION['mode'] == "admin"){echo " 	</div>";}

		echo "		<div id=\"pigo\">";
		echo "			<video id=\"pig\" src=\"src/Pig.mp4\" autoplay loop />";
		echo "		</div>";
		echo "	<div id=\"main\">";
		echo "   <div id=\"chatBox\">";
		echo "		<form action=\"logged.php\" method=\"POST\">";
		echo "			<div id=\"screen-container\">";
		echo "			<iframe id=\"screen\" src=\"message.php\"></iframe>";
		echo "			</div>";
		echo "			<div class=\"inputDiv\">";
		echo "				<div id=\"left\"><input class=\"input\" type=\"text\" autocomplete=\"off\" name=\"comment\"></input>";
		echo "				<input class=\"innerButton\" type=\"submit\" name=\"send\" value=\"Wyślij\"></input></div>";
		echo "			</div>";
		echo "		</form>";
		echo "	</div>";
		echo " </div>";
		echo " </div>";
		echo "</html>";
	}

?>
