<?

include("auth.php");
include("string.php");

$logname = "wms.log";

function apilog($type, $data){
    global $logname;
    $line = "[".strtoupper($type)."] ".$data." << ".date("d.m.Y H:i:s")."\n";
    file_put_contents(getBaseDir()."$logname",$line, FILE_APPEND);
    return $line;
}

if (isset($_GET["t"]) && isset($_GET["d"])) {
    echo apilog($_GET["t"],$_GET["d"]);
} else if (!isset($_POST["function"])) {
    if (strpos($_SERVER["SCRIPT_FILENAME"], "api") === false){
        //echo "something went wrong";
    } else {
        echo "<pre>".file_get_contents(getBaseDir().$logname)."</pre>";
    }
}

?>
