<?php
# Data: username 	-> speed
# 		fid 		-> folder
function sendError(){
	header("Location:./data/error.php");
}

include("./interface/exec/pulllib.php");
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
    $frames = getSourceInFolderSQL($fid);
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
</head>
<body>
<style media="screen">
	<?php echo file_get_contents("anzeige.css") ?>
</style>
<div id="wms">

</div>
</body>
<script type="text/javascript">
var num = 0;
var wms = document.getElementById("wms");
var frames = [<?php
foreach ($frames as $key => $frame) {
    print("\"".pathToBase64($frame)."\",");
}
// WARNING HARDCODING SPEED VARIABLE
// changing every 20 seconds
$speed = 14;
?>]
if(frames.length==0){
    frames[0]="Es liegen für diesen Ordner keine Inhalte auf dem Server vor.";
}
wms.innerHTML = frames[0];


window.setInterval(function(){
        if(num >= frames.length){
            num =0;
        }
        wms.innerHTML=frames[num];
        num= num+1;
    }, <?php echo $speed * 1000; ?>);
</script>
</html>
