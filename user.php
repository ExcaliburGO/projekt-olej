<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_GET['user']) || $_GET['user']=="")
{
	header("Location: index.php");
	die();
}
require_once "dbconfig.php";
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database) or die("BŁĄD POŁACZENIA Z BAZĄ DANYCH");
$result = $mysqli->query("SELECT * FROM users WHERE login='".$mysqli->real_escape_string($_GET['user'])."'");
if($result->num_rows==0)
{
	header("Location: index.php");
	die();
}
$row = $result->fetch_assoc();
?>
<?php require_once 'lastactive.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrOil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css">
    <style>
        a
        {
            text-decoration: none;
            color: black;
        }
        a:hover
        {
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="img/MrOilLogo.png" width="50" height="50">
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="d-flex" action="search.php">
						<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="q">
						<button class="btn btn-outline-success" type="submit"><img src="img/SearchIcon.jpg" width="50" height="50"></button>
                    </form>
                </div>
                <div class="ms-auto" id="ico1">
                    <button class="btn btn-outline-success" type="submit"><a href="loginpage.php"><img src="img/AccountIcon.jpg" width="30" height="30"></a></button>
                </div>
                <div class="mr-auto" id="ico2">
                    <button class="btn btn-outline-success" type="submit"><img src="img/SettingsIcon.jpg" width="30" height="30"></button>
                </div>
                <div class="mr-auto" id="ico3">
                    <button class="btn btn-outline-success" type="submit"><a href="kontakt.php"><img src="img/InfoIcon.jpg" width="30" height="30"></img></a></button>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="row">
          <div class="col">
            <p class="text-center fs-1">Użytkownik: <?php echo $row['login'];?></p>
				<?php
					if(isset($_SESSION['loggedinas']) && $_SESSION['loggedinas']==$row['login'])
					{
						echo '<p class="fs-3">Zarządzanie kontem:</p>';
						echo '<form action="logout.php"><button type="submit" class="btn btn-danger">Wyloguj się</button></form><br>';
						echo'<form action="changepass.php" method="POST"><p class="fs-5">Zmiana hasła</p><label for="oldpass">Stare hasło: </label><input required type="password" name="oldpass" id="oldpass" class="form-control"/><br><label for="newpass">Nowe hasło: </label><input required type="password" name="newpass" id="newpass" class="form-control"/><br><button type="submit" class="btn btn-danger">Zmień hasło</button></form>';
						if(isset($_SESSION['changepasssuccess']))
						{
							echo '<p class="fs-5" style="color:green;">'.$_SESSION['changepasssuccess'].'</p>';
							unset($_SESSION['changepasssuccess']);
						}
						if(isset($_SESSION['changepasserror']))
						{
							echo '<p class="fs-5" style="color:red">'.$_SESSION['changepasserror'].'</p>';
							unset($_SESSION['changepasserror']);
						}
					}
				?>
				<p class="fs-3">Informacje o koncie:</p>
				<p class="fs-5">Stworzono: <?php echo $row['registered']; ?></p>
				<p class="fs-5">Ostatnio aktywny: <?php echo $row['lastactive']; ?></p>
                <p class="fs-3">Utworzone mapki:</p>
          </div>
        </div>
        <div class="row">
			<?php
				$result2 = $mysqli->query("SELECT * FROM maps WHERE createdby=".$row['id']);
				for($i=0;$i<$result2->num_rows;$i++)
				{
					$row2=$result2->fetch_assoc();
					echo'
			<a href="play.php?id='.$row2['id'].'" class="col-md-2">
                <div class="card">
                    <img src="img/PlayIcon.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">'.$row2['name'].'</h5>
					  <p class="card-text"><small class="text-muted">Stworzone '.$row2['created'].'</small></p>
                    </div>
                </div>
            </a>';
				}
			?>
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>