<?php
include("./interface/exec/pulllib.php");

function verifyEncryptPw($username, $pdbpassword){
    // LINK THIS TO Pull-Lib getCon()
    $con = getCon();
    if ($con->connect_error) {
        echo "Database Error";
    }
    $prep = $con->prepare('SELECT pw FROM logins WHERE username = ? ');
    $prep->bind_param('s',$username);
    $prep->bind_result($dbpassword);
    $prep->execute();
    $prep->fetch();
    // compare form-hash and stored hash-pw
    // only check first 16 chars
    if(substr($pdbpassword,0,16) == substr($dbpassword,0,16)) {
        return true;
    }
    return false;
}

if(isset($_GET["username"]) && isset($_GET["encrypt"])){
    $username = $_GET["username"];
    $pdbpassword = $_GET["encrypt"];
    // only check first 16 chars
    if(verifyEncryptPw($username, $pdbpassword)){
        $session = generateSessionData($username);
        $_SESSION["username"]=$username;
        $_SESSION["session"]=$session;
    } else {
        $_SESSION["username"]="FALSE";
        $_SESSION["session"]="NULL";
    }
}
if(isset($_GET["fid"])){
    $fid = $_GET["fid"];
    header("Location:index.php?fid=$fid");
} else {
    header("Location:index.php");
}

?>
