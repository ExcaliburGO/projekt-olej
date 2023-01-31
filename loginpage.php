<?php
   session_start();
   if(isset($_SESSION['loggedinas']))
   {
	   header("Location: user.php?user=".$_SESSION['loggedinas']);
	   die();
   }
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
            <p class="text-center fs-1">Zaloguj się</p>
         </div>
      </div>
      <form class="col-lg-6 offset-lg-3" action="login.php" method="POST">
         <div class="mb-3">
            <label for="InputName" class="form-label">Login</label>
            <input type="text" class="form-control" aria-describedby="emailHelp" name="login"<?php if(isset($_SESSION['login'])) {echo ' value="'.$_SESSION['login'].'"';} ?> required>
         </div>
         <div class="mb-3">
            <label for="InputSurname" class="form-label">Hasło</label>
            <input type="password" class="form-control" aria-describedby="emailHelp" name="password"<?php if(isset($_POST['password'])) {echo ' value="'.$_POST['password'].'"';}?> required>
         </div>
		 <?php
            if(isset($_SESSION['loginerror']))
            {
            	echo '<p class="text-center fs-5" style="color:red;">'.$_SESSION['loginerror'].'</p>';
            }
		 ?>
         <button type="submit" class="btn btn-success">Zaloguj się</button>
      </form>
	  
	  <div class="row">
         <div class="col">
			<p class="text-center fs-3">lub</p>
            <p class="text-center fs-1">Zarejestruj się</p>
         </div>
      </div>
      <form class="col-lg-6 offset-lg-3" action="register.php" method="POST">
         <div class="mb-3">
            <label for="InputName" class="form-label">Login</label>
            <input type="text" class="form-control" aria-describedby="emailHelp" name="login"<?php if(isset($_SESSION['login'])) echo ' value="'.$_SESSION['login'].'"';?> required>
         </div>
		 <div class="mb-3">
            <label for="InputEmail" class="form-label">Adres e-mail</label>
            <input type="email" class="form-control" aria-describedby="emailHelp" name="email"<?php if(isset($_SESSION['email'])) echo ' value="'.$_SESSION['email'].'"';?> required>
         </div>
         <div class="mb-3">
            <label for="InputSurname" class="form-label">Hasło</label>
            <input type="password" class="form-control" aria-describedby="emailHelp" name="password"<?php if(isset($_SESSION['password'])) echo ' value="'.$_SESSION['password'].'"';?> required>
         </div>
         <?php
            if(isset($_SESSION['registererror']))
            {
            	echo '<p class="text-center fs-5" style="color:red;">'.$_SESSION['registererror'].'</p>';
            }
		 ?>
         <button type="submit" class="btn btn-warning">Zarejestruj się</button>
      </form>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
   </body>
</html>
<?php
$_SESSION=array();
?>