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
	   if(isset($_POST['email'])) $_SESSION['email']=$_POST['email'];
	   header("Location: loginpage.php");
	   die();
   }
   if(!isset($_POST['password']) || $_POST['password']=="")
   {
	   if(isset($_POST['login'])) $_SESSION['login']=$_POST['login'];
	   if(isset($_POST['email'])) $_SESSION['email']=$_POST['email'];
	   header("Location: loginpage.php");
	   die();
   }
   if(!isset($_POST['email']) || $_POST['email']=="")
   {
	   if(isset($_POST['login'])) $_SESSION['login']=$_POST['login'];
	   if(isset($_POST['password'])) $_SESSION['password']=$_POST['password'];
	   header("Location: loginpage.php");
	   die();
   }
	require_once "dbconfig.php";
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database) or die("BŁĄD POŁACZENIA Z BAZĄ DANYCH");
	$result = $mysqli->query("INSERT INTO users (login, password, email) VALUES ('".$mysqli->real_escape_string($_POST['login'])."', '".password_hash($_POST['password'], PASSWORD_DEFAULT)."', '".$mysqli->real_escape_string($_POST['email'])."')");
	if($result)
	{
		$_SESSION=array();
		$_SESSION['loggedinas']=$mysqli->real_escape_string($_POST['login']);
		header("Location: user.php?user=".$_SESSION['loggedinas']);
		die();
	}
	else
	{
		$_SESSION['registererror']="Użytkownik o podanym loginie już istnieje.";
		header("Location: loginpage.php");
		die();
	}
?>