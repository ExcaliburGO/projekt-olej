<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['loggedinas']))
{
	require_once "dbconfig.php";
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database) or die("BŁĄD POŁACZENIA Z BAZĄ DANYCH");
	$result = $mysqli->query("UPDATE users SET lastactive=NOW() WHERE login='".$_SESSION['loggedinas']."'");
}
?>