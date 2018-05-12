<?php

include("pulllib.php");
println( "Trying to validate");
if(!validLogin()){
    println("Not logged in");
    exit();
    return;
}

println("Retrieving Information");
$fid = $_GET["fid"];
$con = getCon();
if ($con->connect_error) {
    println("Database Error");
}
$prep = $con->prepare("SELECT remote, src FROM entries WHERE id=?");
$prep->bind_param('i',$fid);
$prep->bind_result($r, $s);
$prep->execute();
$prep->fetch();
$prep->close();
$prep = $con->prepare("DELETE FROM entries WHERE id=?");
$prep->bind_param('i',$fid);
$prep->execute();
$con->close();
if($r==0){
    if(unlink("../../".$s)){
        println("Deleting complete");
    } else{
        println("Physical deleting process failed.");
    }
} else {
    println("Deleting complete");
}
$back = "../panel.php?folder=".$_GET['f']."&fid=".$_GET['back'];
println("Zurück: <a href=\"$back\">Link</a>. Redirect in 5 Sekunden.");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Datei gelöscht</title>
    <meta http-equiv="refresh" content="5; URL=<?php echo htmlspecialchars($back); ?>">
</head>
<body>

</body>
</html>
