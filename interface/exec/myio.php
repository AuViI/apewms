<?

require("auth.php");

$logname = "wms.log";

function apilog($type, $data){
    $line = "[".strtoupper($type)."] ".$data." << ".date("d.m.Y H:i:s")."\n";
    echo getBaseDir()."$logname";
    file_put_contents(getBaseDir()."$logname",$line, FILE_APPEND);
    return $line;
}

if (isset($_GET["t"]) && isset($_GET["d"])) {
    echo apilog($_GET["t"],$_GET["d"]);
} else {
    echo file_get_contents(getBaseDir().$logname);
}

?>
