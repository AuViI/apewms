<?
include("./exec/pulllib.php");



//check for session code:
$login = validLogin();
if (!$login){
    header("Location: ../interface/");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WMS-Interface</title>
    <? echo file_get_contents("./html/head.html"); ?>
</head>
<body>
    <div id="holder">
        <div id="menu"><? buildMenu(); ?></div>
        <div id="page">
        <?
            if(isset($_GET["folder"])){
                echo "<h2>Ordner: ".$_GET["folder"]."</h2>";
                if(isset($_GET["fid"])){
                    echo "Standart Link: <a href=\"../?fid=".$_GET["fid"]."\">../?fid=".$_GET["fid"]."</a><br><br>";
                    include("./exec/upload_include.php");
                    println("<br>");
                    include("./exec/fr_include.php");
                }
            } else {
                echo "<h2>WMS-Interface</h2>";
                println("<p>Willkommen auf dem WMS-Interface.<br>Das Weather Monitoring System (WMS) besteht aus mehreren Ordnern. Um die Bilder in den Ordnern zu bearbeiten findet Ihr auf der linken Seite eine Menü.</p>");
            }
            if(isset($_GET["i"])){
                $include = htmlspecialchars($_GET["i"]);
                if(strlen($include)==2){
                    include("./exec/$include"."_include.php");
                }
            }
        ?>
    </div>
</body>
</html>