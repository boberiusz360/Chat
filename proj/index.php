<?php
	session_start();
	//error_reporting(0);

	$srvr = "localhost";
	$user = "terra";
	$dbPassword = "lol";
	$db = "Chat";
	$_SESSION['mode'] = "none";

	if(($_SERVER['REQUEST_METHOD'] == "POST")&&(isset($_POST['submit'])))
	{
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['password'] = $_POST['password'];
		$table = "users";

		$connection = new mysqli($srvr,$user,$dbPassword,$db);

		if($connection->connect_error){die($connection->connect_error);}
		else if($_POST['name'] != "")
		{
			$question = "SELECT * FROM $table WHERE name='$_SESSION[name]';";
			$answer = $connection->query($question);
			if(($answer != "")&&(mysqli_num_rows($answer)> 0))
			{
				$table = $answer->fetch_assoc();
				if(($_SESSION['name'] == $table['name'])&&($_SESSION['password'] == $table['password']))
				{
					$_SESSION['mode'] = $table['permissions'];
					header("Location: logged.php");
				}
				else
				{
					write_normal();
					echo "<script>document.getElementById(\"loginBox\").style.backgroundColor = \"red\";";
					echo "document.getElementById(\"echo\").innerHTML += \"Wrong Password\";</script>";
				}
			}
			else
			{
				write_normal();
				echo "<script>document.getElementById(\"loginBox\").style.backgroundColor = \"red\";";
				echo "document.getElementById(\"echo\").innerHTML += \"No such user\";</script>";
			}
		}
		mysqli_close($connection);
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	else if(($_SERVER['REQUEST_METHOD'] == "POST")&&(isset($_POST['reg'])))
	{
		write_head();
		echo "      <div id=\"regeBox\">";
		echo "		<form action=\"index.php\" method=\"POST\">";
		echo "			<div class=\"inputDiv\">Login:<input style=\"margin-left:35.5px;\" class=\"input\" type=\"text\" name=\"login\"></input></div>";
		echo "			<div class=\"inputDiv\">Password: <input class=\"input\" type=\"password\" name=\"secret\"></input></div>";
		echo "			<div class=\"inputDiv\"><input class=\"innerButton\" type=\"submit\" name=\"addU\" value=\"DODAJ UŻYTKOWNIKA\"></input></div>";
		echo "			<div class=\"inputDiv\" id=\"echo\"></div>";
		echo "		</form>";
		echo "	</div>";
		echo "</html>";
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	else if(($_SERVER['REQUEST_METHOD'] == "POST")&&(isset($_POST['addU'])))
	{
		$login = $_POST['login'];
		$secret = $_POST['secret'];
		$table = "users";
		$connection = new mysqli($srvr,$user,$dbPassword,$db);
		if($connection->connect_error){die($connection->connect_error);}
		else
		{
			$question = "SELECT * FROM $table WHERE name='$login'";
			$answer = $connection->query($question);
			if(($answer != "")&&(mysqli_num_rows($answer) > 0))
			{
				write_head();
				echo "      <div id=\"regeBox\">";
				echo "		<form action=\"index.php\" method=\"POST\">";
				echo "			<div class=\"inputDiv\">Login:<input style=\"margin-left:35.5px;\" class=\"input\" type=\"text\" name=\"login\"></input></div>";
				echo "			<div class=\"inputDiv\">Password: <input class=\"input\" type=\"password\" name=\"secret\"></input></div>";
				echo "			<div class=\"inputDiv\"><input class=\"innerButton\" type=\"submit\" name=\"addU\" value=\"DODAJ UŻYTKOWNIKA\"></input></div>";
				echo "			<div class=\"inputDiv\" id=\"echo\"></div>";
				echo "		</form>";
				echo "	</div>";
				echo "</html>";
				echo "<script>document.getElementById(\"regeBox\").style.backgroundColor = \"red\";";
				echo "document.getElementById(\"echo\").innerHTML += \"User already exists\";</script>";
			}
			else
			{
				$question = "INSERT INTO $table(name,password,permissions) values('$login','$secret','user');";
				$odp = $connection->query($question);
				write_normal();
				echo "<script>document.getElementById(\"echo\").innerHTML += \"User added\";</script>";
			}
		}
		mysqli_close($connection);
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	else
	{
		write_normal();
	}

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function write_head()
	{
		echo "<!DOCTYPE html>";
		echo "	<head>";
		echo "		<meta charset=\"utf-8\" lang=\"pl/PL\" />";
		echo "		<title>Angry Soviet Pig Chat</title>";
		echo "      <meta name=\"viewport\" content=\"width=device-width\" initial-scale=1 />";
		echo "		<link rel=\"stylesheet\" href=\"main.css\" />";
		echo "		<link rel=\"shortcut icon\" href=\"src/ASPC.png\" />";
		echo "		<script src=\"main.js\"></script>";
		echo "	</head>";
		echo "	<body>";
		echo "		<div id=\"pigo\">";
		echo "			<video id=\"pig\" src=\"src/Pig.mp4\" autoplay loop />";
		echo "		</div>";
		echo "<script>pigo();</script>";
	}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	function write_normal()
	{
		write_head();
		echo "      <div id=\"loginBox\">";
		echo "		<form action=\"index.php\" method=\"POST\">";
		echo "			<div class=\"inputDiv\">Login:<input style=\"margin-left:35.5px;\" class=\"input\" type=\"text\" name=\"name\"></input></div>";
		echo "			<div class=\"inputDiv\">Password: <input class=\"input\" type=\"password\" name=\"password\"></input></div>";
		echo "			<div class=\"inputDiv\"><input class=\"innerButton\" type=\"submit\" name=\"submit\" value=\"LOGUJ\"></input></div>";
		echo "		</form>";
		echo "		<form action=\"index.php\" method=\"POST\">";
		echo "			<div class=\"inputDiv\"><input class=\"innerButton\" type=\"submit\" name=\"reg\" value=\"REJESTRUJ\"></input></div>";
		echo "			<div class=\"inputDiv\" id=\"echo\"></div>";
		echo "		</form>";
		echo "	</div>";
		echo "</html>";
	}


?>
