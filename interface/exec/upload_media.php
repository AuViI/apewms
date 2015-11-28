<?
include("pulllib.php");
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}

$fid = $_POST["fid"];                   // folder id
$remote = ($_POST["remote"]=="remote"); // remot or not
$dir = $_POST["folder"];            // target dir
$fail = false;
$content = "NO CONTENT";                // to be filled with iframe
$redir = "../panel.php?folder=$dir%20$fid&fid=$fid";   // redir back to panel
$i = 0;                                 // remote tag
$answer = "Generischer Fehler.";
$imgs = array(".bmp", ".gif", ".png", ".jpg", ".jpeg", ".svn", ".exif", ".tiff");

if($remote){
    $i = 1; // is remote
    $url = $_POST["url"];
    $content = "<iframe src='".htmlspecialchars($url)."' class='full'></iframe>";
    $src=$url;
    foreach ($imgs as $key => $value) {
        if(endsWith(strtolower($url),$value)){
            $content = str_replace("<iframe", "<img", $content);
            $content = str_replace("</iframe>", "</img>", $content);
        }
    }
} else {
    $uploaddir = '../../data/'.$dir . "/";
    $filename = basename($_FILES['userfile']['name']);
    $uploadfile = $uploaddir . $filename;
    println($uploaddir);
    println($filename);
    println($uploadfile);
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $src="data/$dir/$filename";
        $content = "<iframe src='$src' class='full'></iframe>";
        foreach ($imgs as $key => $value) {
            if(endsWith(strtolower($filename),$value)){
                $content = str_replace("<iframe", "<img", $content);
                $content = str_replace("</iframe>", "</img>", $content);
            }
        }
    } else {
        $fail = true;
        $answer = "Uploadfehler";
    }
}

if(!$fail){
    $con = getCon();
    if ($con->connect_error) {
        echo "Database Error";
        $answer = "Datenbankfehler";
    }
    $prep = $con->prepare("INSERT INTO entries (id, fid, remote, content, src, created) VALUES (NULL, ?, ?, ?, ?, CURRENT_TIMESTAMP);");

    $prep->bind_param('siss', $fid, $i, $content, $src);
    $prep->execute();
    $answer = "Upload erfolgreich. Weiterleitung in 5 Sekunden.<br>Link: <a href=\"$redir\">Zurück</a>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Datei Upload</title>
    <meta http-equiv="refresh" content="5; URL=<? echo $redir; ?>">
</head>
<body>
    <? echo $answer; ?>
</body>
</html>
