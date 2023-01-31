<?php
session_start();
if(!isset($_SESSION['loggedinas']))
{
   header("Location: loginpage.php");
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css">
    <title>Nowa mapka | MrOil</title>
    <style>
		#map
        {
            width: 95vw;
			margin:auto;
        }
        #map #imgView
        {
            width: 100%;
        }
		.hidden
		{
			display: none;
		}
		.modal-body
		{
			max-height: calc(100% - 120px);
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
                        <input class="form-control col-6" type="search" placeholder="Search" aria-label="Search" name="q">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <div class="row">
		<p class="text-center fs-1">Dodaj mapkę</p>
		<div class="mb-3 col-lg-6 offset-lg-3">
			<input type="file" class="form-control" aria-label="file example" id="mapFile" accept=".jpg, .jpeg, .png" required>
		</div>
		<div id="map">
			<img id="imgView">
			<div class="modal fade" id="myModal" data-bs-keyboard="true" tabindex="-1" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Dodaj punkt</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				  </div>
				  <div class="modal-body">
					<div class="form-group row">
						<label for="pointName" class="col-4 col-form-label">Nazwa punktu</label>
						<div class="col-8">
							<input type="text" class="form-control" id="pointName">
						</div>
					</div>
					<p id="pointData"></p>
					<input class="form-check-input" type="checkbox" checked="true" id="mapCheckbox">
					  <label class="form-check-label" for="mapCheckbox">
						Użyj tego punktu do mapowania
					  </label>
					  <div id="mappingParams">
						<div class="form-group row" id="mappingLength">
							<label for="mappingLengthDegrees" class="col-1 col-form-label">°</label>
							<div class="col-2">
								<input type="number" class="form-control" id="mappingLengthDegrees">
							</div>
							<label for="mappingLengthMinutes" class="col-1 col-form-label">'</label>
							<div class="col-2">
								<input type="number" class="form-control" id="mappingLengthMinutes">
							</div>
							<label for="mappingLengthSeconds" class="col-1 col-form-label">''</label>
							<div class="col-2">
								<input type="number" class="form-control" id="mappingLengthSeconds">
							</div>
							<div class="col-3">
								<select class="form-select" id="mappingLengthDirection">
								  <option selected value="-1">E</option>
								  <option value="1">W</option>
								</select>
							</div>
						</div>
						<div class="form-group row" id="mappingWidth">
							<label for="mappingWidthDegrees" class="col-1 col-form-label">°</label>
							<div class="col-2">
								<input type="number" class="form-control" id="mappingWidthDegrees">
							</div>
							<label for="mappingWidthMinutes" class="col-1 col-form-label">'</label>
							<div class="col-2">
								<input type="number" class="form-control" id="mappingWidthMinutes">
							</div>
							<label for="mappingWidthSeconds" class="col-1 col-form-label">''</label>
							<div class="col-2">
								<input type="number" class="form-control" id="mappingWidthSeconds">
							</div>
							<div class="col-3">
								<select class="form-select" id="mappingWidthDirection">
								  <option selected value="1">N</option>
								  <option value="-1">S</option>
								</select>
							</div>
						</div>
					  </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
					<button type="submit" class="btn btn-primary" onclick="addPoint()">Dodaj</button>
				  </div>
				</div>
			  </div>
			</div>
		</div>
    </div>
    <script src="jquery-3.6.0.min.js"></script>
    <script>
		let imgView = document.getElementById("imgView");
        let mapFileInput = document.getElementById("mapFile");
		let pointData = document.getElementById("pointData");
		var objects = [];
		var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
		  keyboard: true,
		})
		var mapImg=$("#imgView");
		var imgW=0;
		var imgH=0;
        mapImg.on("load", function() 
        {
            let mapImgPure = mapImg.get(0)
            imgW=mapImgPure.naturalWidth;
            imgH=mapImgPure.naturalHeight;
            var w = mapImgPure.width;
            var h = mapImgPure.height;
			console.log(imgW, imgH, w, h);
        });
		mapFileInput.onchange = evt => {
		  const [file] = mapFileInput.files
		  if (file) {
			imgView.src = URL.createObjectURL(file)
		  }
		}
		function addPoint()
		{
			let lengthDeg=parseInt(document.getElementById("mappingLengthDegrees").value);
			let lengthMin=parseInt(document.getElementById("mappingLengthMinutes").value);
			let lengthSec=parseInt(document.getElementById("mappingLengthSeconds").value);
			let lengthDir=parseInt(document.getElementById("mappingLengthDirection").value);
			let widthDeg=parseInt(document.getElementById("mappingWidthDegrees").value);
			let widthMin=parseInt(document.getElementById("mappingWidthMinutes").value);
			let widthSec=parseInt(document.getElementById("mappingWidthSeconds").value);
			let widthDir=parseInt(document.getElementById("mappingWidthDirection").value);
			let lengthVal = lengthDir*lengthSec*60*lengthMin*60*60*lengthDeg;
			let widthVal = widthDir*widthSec*60*widthMin*60*60*widthDeg;
			console.log(lengthVal, widthVal)
			if(!isNaN(lengthVal) && !isNaN(widthVal))
			{
				myModal.hide();
			}
		}
		let checkbox = document.getElementById("mapCheckbox");
		let mappingParams = document.getElementById("mappingParams");
		checkbox.addEventListener("change", function()
		{
			if(checkbox.checked)
			{
				mappingParams.classList.remove("hidden");
			}
			else
			{
				mappingParams.classList.add("hidden");
			}
		});
		$(document).ready(function() {
            $("#map").on("click", function(event) {
				if (imgW && imgH && !($('#myModal').hasClass('show')))
				{
					let mapImgPure = mapImg.get(0)
					var x = event.pageX - this.offsetLeft;
					var y = event.pageY - this.offsetTop;
					var w = mapImgPure.width;
					var h = mapImgPure.height;
					imgW=mapImgPure.naturalWidth;
					imgH=mapImgPure.naturalHeight;
					pointData.innerHTML="X: "+Math.round(x/w*100).toString()+"% Y: "+Math.round(y/h*100).toString()+"%";
					myModal.show();
				}
            });
        });
    </script>
</body>
</html>