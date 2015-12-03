<?
# Data: username 	-> speed
# 		fid 		-> folder
function sendError(){
	header("Location:./data/error.php");
}

include("./interface/exec/pulllib.php");
include("./interface/exec/string.php");
include("./interface/exec/image.php");
$valid=directCheckSessionData();
// HARDCODE, bc i fucked up
$valid = true;
if($valid && isset($_GET["fid"])){
	$fid = $_GET["fid"];
    $folders =getFolderArray();
    if(is_null($folders[$fid]))
        sendError();

    $dir="./data/$folders[$fid]";
    $frames = getFilesInFolderSQL($fid);
}else{
	sendError();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>WMS-Anzeige</title>
    <!-- 1. Download vom Server, 2. Neuladen nach zwei Stunden -->
    <meta http-equiv="expires" content="0;">
    <meta http-equiv="refresh" content="7200;"> <!-- 7200 = 2h -->
	<link rel="stylesheet" type="text/css" href="anzeige.css">
</head>
<body>
<div id="wms">

</div>
</body>
<script type="text/javascript">
var num = 0;
var wms = document.getElementById("wms");
var frames = [<?
foreach ($frames as $key => $frame) {
    print("\"".$frame."\",");
}
// WARNING HARDCODING SPEED VARIABLE
// changing every 20 seconds
$speed = 14;
?>]
if(frames.length==0){
    frames[0]="Es liegen für diesen Ordner keine Inhalte auf dem Server vor.";
}else{
	wms.innerHTML = "";
	for (var imgid in frames) {
		if (frames.hasOwnProperty(imgid)) {
			wms.innerHTML += frames[imgid];
		}
	}
	for (var i = 0; i < frames.length; i++) {
		wms.children[i].setAttribute("class","loading")
	}
	wms.children[0].setAttribute("class","full")
}

window.setInterval(function(){
        if(num >= frames.length){
            num =0;
        }
		wms.children[num].setAttribute("class","full")
		if (num>0){
			wms.children[(num-1)%frames.length].setAttribute("class","loading");
		} else {
			wms.children[frames.length-1].setAttribute("class","loading")
		}
        num = num+1;
    }, <? echo $speed * 1000; ?>);
</script>
</html>
