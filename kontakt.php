<?php require_once 'lastactive.php'; ?>
<?php
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
   if(!isset($_POST['imie']) && !isset($_POST['nazwisko']) && !isset($_POST['contact']) && !isset($_POST['message']))
   {
   	
   }
   else if(!isset($_POST['imie']) || $_POST['imie']=="" || !isset($_POST['nazwisko']) || $_POST['nazwisko']=="" || !isset($_POST['contact']) || $_POST['contact']=="" || !isset($_POST['message']) || $_POST['message']=="")
   {
   	$error="<span style='color:red'>Musisz wypełnić wszystkie pola!</span>";
   }
   else
   {
   	require_once "dbconfig.php";
   	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database) or die("BŁĄD POŁACZENIA Z BAZĄ DANYCH");
   	$result = $mysqli->query("INSERT INTO contact (imie, nazwisko, contact, message) VALUES ('".$mysqli->real_escape_string($_POST['imie'])."', '".$mysqli->real_escape_string($_POST['nazwisko'])."', '".$mysqli->real_escape_string($_POST['contact'])."', '".$mysqli->real_escape_string($_POST['message'])."')");
   	if($result)
   	{
   		$error="<span style='color:green'>Wiadomość została wysłana!</span>";
   	}
   	$_POST=array();
   }
   ?>
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
               <form class="d-flex">
                  <input class="form-control col-6" type="search" placeholder="Search" aria-label="Search">
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
            <p class="text-center fs-1">Formularz kontaktowy</p>
         </div>
      </div>
      <form class="col-lg-6 offset-lg-3" action="kontakt.php" method="POST">
         <div class="mb-3">
            <label for="InputName" class="form-label">Imię</label>
            <input type="text" class="form-control" aria-describedby="emailHelp" name="imie"<?php if(isset($_POST['imie'])) echo ' value="'.$_POST['imie'].'"';?>>
         </div>
         <div class="mb-3">
            <label for="InputSurname" class="form-label">Nazwisko</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="nazwisko"<?php if(isset($_POST['nazwisko'])) echo ' value="'.$_POST['nazwisko'].'"';?>>
         </div>
         <div class="mb-3">
            <label for="InputEmail" class="form-label">Adres e-mail lub numer telefonu</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="contact"<?php if(isset($_POST['contact'])) echo ' value="'.$_POST['contact'].'"';?>>
         </div>
         <div class="mb-3">
            <label for="ControlTextarea">Treść wiadomości</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"  name="message"><?php if(isset($_POST['message'])) echo $_POST['message'];?></textarea>
         </div>
         <?php
            if(isset($error))
            {
            	echo '<p class="text-center fs-3">'.$error.'</p>';
            }
             ?>
         <button type="submit" class="btn btn-primary">Wyślij</button>
      </form>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
   </body>
</html>