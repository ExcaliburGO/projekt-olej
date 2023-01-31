<?php
   session_start();
   if(isset($_SESSION['loggedinas']))
   {
	   header("Location: user.php?user=".$_SESSION['loggedinas']);
	   die();
   }
   if(!isset($_POST['login']) || $_POST['login']=="")
   {
	   if(isset($_POST['password'])) $_SESSION['password']=$_POST['password'];
	   header("Location: loginpage.php");
	   die();
   }
   if(!isset($_POST['password']) || $_POST['password']=="")
   {
	   if(isset($_POST['login'])) $_SESSION['login']=$_POST['login'];
	   header("Location: loginpage.php");
	   die();
   }
	require_once "dbconfig.php";
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database) or die("BŁĄD POŁACZENIA Z BAZĄ DANYCH");
	$result = $mysqli->query("SELECT * FROM users WHERE login='".$mysqli->real_escape_string($_POST['login'])."'");
	if($result && $result->num_rows==1)
	{
		$row = $result->fetch_assoc();
		if(password_verify($_POST['password'], $row['password']))
		{
			$_SESSION=array();
			$_SESSION['loggedinas']=$row['login'];
			header("Location: user.php?user=".$row['login']);
			die();
		}
		else
		{
			$_SESSION['login']=$_POST['login'];
			$_SESSION['loginerror']="Błędne hasło";
			header("Location: loginpage.php");
			die();
		}
	}
	else
	{
		$_SESSION['loginerror']="Użytkownik o podanym loginie nie istnieje.";
		header("Location: loginpage.php");
		die();
	}
?>