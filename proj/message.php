<?php
	session_start();
	error_reporting(0);
	$_SESSION['latest'];
	$now;
	if((isset($_SESSION['mode']))&&(isset($_SESSION['name'])))
	{
		write_normal();
		$srvr = "localhost";
		$user = "terra";
		$dbPassword = "lol";
		$db = "Chat";
		$table = "txt";

    	$connection = new mysqli($srvr,$user,$dbPassword,$db);

		write_clear();
		eat_comments();
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
		echo "      <meta http-equiv=\"refresh\" content=\"2;\" />";
		echo "		<meta charset=\"utf-8\" lang=\"pl/PL\" />";
		echo "      <meta name=\"viewport\" content=\"width=device-width\" initial-scale=1 />";
		echo "		<title>Angry Soviet Pig Chat</title>";
		echo "		<link rel=\"stylesheet\" href=\"logged.css\" />";
		echo "		<link rel=\"shortcut icon\" href=\"src/ASPC.png\" />";
		echo "		<script src=\"main.js\"></script>";
		echo "	</head>";

		echo "	<body>";
		echo "		<div id=\"skreen\">";
		echo "		</div>";
		echo "	</body>";
		echo "</html>";
	}

	function write_onscreen($whaa,$name)
	{
		if($name == "admin")
		{
			echo "<script>";
			echo "	var log = '$name';";
			echo "	var XD = log.fontcolor(\"orange\");";
			echo "	document.getElementById(\"skreen\").innerHTML += XD+\" : $whaa <br />\";";
			echo "</script>";
		}
		else{echo "<script>document.getElementById(\"skreen\").innerHTML += \"$name : $whaa <br />\";</script>";}
	}

	function eat_comments()
	{
		$srvr = "localhost";
		$user = "terra";
		$dbPassword = "lol";
		$db = "Chat";
		$table = "txt";

		$connection = new mysqli($srvr,$user,$dbPassword,$db);

		if($connection->connect_error){die($connection->connect_error);}
		else
		{
			$XD = 1;
			for($i=1;$XD!=0;$i++)
			{
				/*if($i == 29)
				{
					$zap = "TRUNCATE $table;";
					$answer = $connection->query($zap);
				}*/
				$zap = "SELECT * FROM $table WHERE id=$i;";
				$answer = $connection->query($zap);

				if(mysqli_num_rows($answer) > 0)
				{
					$row = $answer->fetch_assoc();
					write_onscreen($row['txt'],$row['name']);
					$now = $row['id'];
				}
				else
				{
					$XD = 0;
				}
			}
			if($_SESSION['latest'] != $now)
			{
				echo "<script>var audio = new Audio('src/notice.mp3');audio.play();</script>";
			}
		}
		$_SESSION['latest'] = $now;
	}

	function write_clear()
	{
		echo "<script>document.getElementById(\"skreen\").innerHTML = \"\";</script>";
	}
?>
