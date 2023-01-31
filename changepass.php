<?php
   session_start();
   if(!isset($_SESSION['loggedinas']))
   {
	   header("Location: index.php");
	   die();
   }
   if(!isset($_POST['oldpass']) || $_POST['oldpass']=="")
   {
	   header("Location: user.php?user=".$_SESSION['loggedinas']);
	   die();
   }
   if(!isset($_POST['newpass']) || $_POST['newpass']=="")
   {
	   header("Location: user.php?user=".$_SESSION['loggedinas']);
	   die();
   }
	require_once "dbconfig.php";
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database) or die("BŁĄD POŁACZENIA Z BAZĄ DANYCH");
	$result = $mysqli->query("SELECT * FROM users WHERE login='".$_SESSION['loggedinas']."'");
	if($result && $result->num_rows==1)
	{
		$row = $result->fetch_assoc();
		if(password_verify($_POST['oldpass'], $row['password']))
		{
			$result2 = $mysqli->query("UPDATE users SET password='".password_hash($_POST['newpass'], PASSWORD_DEFAULT)."' WHERE login='".$_SESSION['loggedinas']."'");
			$_SESSION['changepasssuccess']="Hasło zmienione pomyślnie.";
			header("Location: user.php?user=".$row['login']);
			die();
		}
		else
		{
			$_SESSION['changepasserror']="Błędne hasło";
			header("Location: user.php?user=".$_SESSION['loggedinas']);
			die();
		}
	}
	else
	{
		header("Location: user.php?user=".$_SESSION['loggedinas']);
		die();
	}
?>