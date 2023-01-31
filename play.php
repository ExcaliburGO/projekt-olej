<?php require_once 'lastactive.php'; ?>
<?php
require_once "dbconfig.php";
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_database) or die("BŁĄD POŁACZENIA Z BAZĄ DANYCH");
$mapid = $_GET['id'];
$mapid = filter_var($mapid, FILTER_SANITIZE_NUMBER_INT);
if(!$mapid)
{
	http_response_code(403);
	die('Forbidden');
}
$result = $mysqli->query("SELECT * FROM maps WHERE id=".$mapid);
if($result->num_rows==0)
{
	http_response_code(404);
	die('Nie znaleziono mapy.');
}
$map = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css">
    <title><?php echo $map['name'];?> | MrOil</title>
    <style>
        *
        {
            margin: 0;
            border: 0;
        }
        #map
        {
            position: absolute;
            top:55vh;
            left:50vw;
            transform: translate(-50%, -50%);
            height: 90vh;
        }
        #map #mapimg
        {
            height: 100%;
        }
        #debug
        {
            position: fixed;
            margin:0;
            top:1vh;
            left:1vw;
            font-size:2vh;
        }
        #answer
        {
            position: fixed;
            margin:0;
            top:9vh;
            left:1vw;
            font-size:2vh;
        }
        .marker
        {
            position: absolute;
            display: block;
            width: 1.3vh;
            height: 1.3vh;
            background-color: cyan;
            border: .5vh solid blue;
            border-radius: 50%;
            z-index: 3;
            transform: translate(-50%,-50%);
        }
        #map svg.canvas
        {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index:2;
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
    <div id="map">
        <img id="mapimg">
        <svg class="canvas">
            <line x1="20" y1="0" x2="0" y2="0" style="stroke:rgb(255,0,0);stroke-width:2" />
        </svg>
    </div>
    <p id="debug"></p>
    <p id="answer"></p>
    <script src="jquery-3.6.0.min.js"></script>
    <script>
        var objects = <?php echo $map['points']; ?>;
        objects.sort((a, b) => 0.5 - Math.random());
        var currObject=0;
        var picking=true;
        var mapImg=$("#mapimg")
        mapImg.on("load", function() 
        {
            let mapImgPure = mapImg.get(0)
            var imgW=mapImgPure.naturalWidth;
            var imgH=mapImgPure.naturalHeight;
            var w = mapImgPure.width;
            var h = mapImgPure.height;
            objects.forEach(function(e,i) {
                let dot = document.createElement("div");
                dot.classList.add("marker");
                dot.style.left=e.x_pos/imgW*100+"%";
                dot.style.top=e.y_pos/imgH*100+"%";
                dot=$(dot)
                e.marker=dot;
                $("#map").append(dot);
            });
            $("#answer").text(objects[currObject].dot_text)
        });
        mapImg.attr("src","map1.jpg");
        $(document).ready(function() {
            var line=document.querySelector("#map svg.canvas line");
            $("#map").on("click", function(event) {
                if(picking)
                {
                    let mapImgPure = mapImg.get(0)
                    var x = event.pageX - this.offsetLeft;
                    var y = event.pageY - this.offsetTop;
                    var w = mapImgPure.width;
                    var h = mapImgPure.height;
                    var imgW=mapImgPure.naturalWidth;
                    var imgH=mapImgPure.naturalHeight;
                    //$("#debug").text(objects[currObject].x_pos/imgW+" "+(x+w/2+1)/w);
                    let missX = objects[currObject].x_pos/imgW-(x+w/2)/w;
                    let missY = objects[currObject].y_pos/imgH-(y+h/2)/h;
                    let miss = Math.sqrt(missX*missX+missY*missY)*100*100/Math.sqrt(20000);
                    if(miss<0.8)
                    {
                        $("#answer").text("Dobrze!");
                        objects[currObject].marker.css("background-color", "lime");
                    }
                    else
                    {
                        $("#answer").text("Pomyliłeś się o "+miss+"%");
                        objects[currObject].marker.css("background-color", "red");
                        line.x1.baseVal.value=objects[currObject].marker.get(0).offsetLeft;
                        line.y1.baseVal.value=objects[currObject].marker.get(0).offsetTop;
                        line.x2.baseVal.value=(x+w/2);
                        line.y2.baseVal.value=(y+h/2);
                    }
                }
                else
                {
                    objects[currObject].marker.css("background-color", "cyan");
                    currObject++;
                    $("#answer").text(objects[currObject].dot_text)
                }
                picking=!picking;
            });
        });
    </script>
</body>
</html>