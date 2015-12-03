<?
// FIXME correct spelling, lowercase

// Contains credential function:
// getServer(), getUser(), getPass(), getData(), getBaseDir()
require("auth.php");
include("myio.php");

session_start();

function getCon(){
    $server = getServer();
    $user = getUser();
    $pass = getPass();
    $data = getData();
    // TODO create Tables if not exist
    return new mysqli($server, $user, $pass, $data);
}

function getFolderArray(){
    $folders = array();
    $con = getCon();
    if ($con->connect_error) {
        println("database error");
    }
    $prep = $con->prepare("SELECT id, folder FROM folders");
    $prep->bind_result($number,$folder);
    $prep->execute();
    while($prep->fetch()){
        $folders[$number]=$folder;
    }
    $con->close();
    return $folders;
}

function buildMenu(){
    $folders = getFolderArray();
    echo '<h2 class="center">Men&uuml;</h2><h3>Ordner:</h3><ul>';
    foreach ($folders as $num => $dir) {
        echo "<li><a href=\"?folder=$dir%20$num&fid=$num\">$dir</a></li>";
    }
    echo '</ul><h3>Funktionen:</h3><ul><li><a href="?i=no&folder=neuer%20Ordner">neuer Ordner</a></li>
        <li><a href="?i=nu&folder=neuer%20Benutzer">neuer Benutzer</a></li>
    </ul>';
}

// check if login data is valid
function checkLoginData($username, $password){
    // get user salt
    $con = getCon();
    if ($con->connect_error) {
        echo "Database Error";
    }
    $prep = $con->prepare('SELECT pw, salt FROM logins WHERE username = ? ');
    $prep->bind_param('s',$username);
    $prep->bind_result($dbpassword, $salt);
    $prep->execute();
    $prep->fetch();
    $con->close();

    // generate hash-pw from form data
    $formpw = hash("sha256", "tibyte".$password.$salt);
    // compare form-hash and stored hash-pw
    if($formpw == $dbpassword){
        apilog("log",$username." logged in");
        return true;
    }
    return false;
}

// compares GET session data and DB session
function checkSessionData($username, $session){
    $con = getCon();
    if ($con->connect_error) {
        echo "Database Error";
    }
    $prep = $con->prepare('SELECT session FROM logins WHERE username = ?');
    $prep->bind_param('s', $username);
    $prep->bind_result($dbsession);
    $prep->execute();
    $prep->fetch();
    $con->close();
    return ($dbsession==$session);
}

function directCheckSessionData(){
    if(isset($_SESSION["username"]) && isset($_SESSION["session"])){
        return checkSessionData($_SESSION["username"], $_SESSION["session"]);
    }
    println("data <b>not</b> available");
    return false;
}

// (over)writes session attribute
function generateSessionData($username){
    $con = getCon();
    if ($con->connect_error) {
        println("database error");
    }
    $prep = $con->prepare('UPDATE logins SET session=? WHERE username=?');
    $prep->bind_param('ss', $hash, $username);
    $hash=hash("sha256", time().$username);
    $prep->execute();
    return $hash;
    $con->close();
}

function println($test){
    echo $test."<br>";
}

function apiprint($test){
    echo $test."\n";
}

function apilogin(){
    if (isset($_POST["username"]) && isset($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        if(!checkLoginData($username, $password)){
            return false; // wrong data
        }
        return true;
    }
    return false;
}

// Main Auth function
function validLogin(){
    if (isset($_POST["username"])){
        //used Form generate session code
        $username = $_POST["username"];
        $password = $_POST["password"];
        //write session code in database, after confirm
        if(!checkLoginData($username, $password)){
            //if confirm fails return false
            return false;
        }
        // generate and write session code
        $session = generateSessionData($username);
        $_SESSION["username"]=$username;
        $_SESSION["session"]=$session;
        header("Location:../interface/panel.php");
        return true;
    }
    // already logged in
    if(isset($_SESSION["session"]) && isset($_SESSION["username"])){
        return checkSessionData($_SESSION["username"],$_SESSION["session"]);
    }
    return false;
}

function getFilesInFolderSQL($fid){
    //array(array(all information))
    $frames = array();
    $con = getCon();
    if ($con->connect_error) {
        println("database error");
    }
    $prep = $con->prepare("SELECT content FROM entries WHERE fid=?");
    $prep->bind_param('i',$fid);
    $prep->bind_result($frame);
    $prep->execute();
    $count = 0;
    while($prep->fetch()){
        $frames[$count]=$frame;
        $count = $count + 1;
    }
    $con->close();
    return $frames;
}

function getSourceInFolderSQL($fid){$frames = array();
    $con = getCon();
    if ($con->connect_error) {
        println("database error");
    }
    $prep = $con->prepare("SELECT src FROM entries WHERE fid=?");
    $prep->bind_param('i',$fid);
    $prep->bind_result($frame);
    $prep->execute();
    $count = 0;
    while($prep->fetch()){
        $frames[$count]=$frame;
        $count = $count + 1;
    }
    $con->close();
    return $frames;
}

function getInfoFilesInFolderSQL($fid){
    $files = array();
    $con = getCon();
    if ($con->connect_error) {
        println("database error");
    }
    $prep = $con->prepare("SELECT id, content, src, created  FROM entries WHERE fid=?");
    $prep->bind_param('i',$fid);
    $prep->bind_result($i, $c, $s, $d);
    $prep->execute();
    $count = 0;
    while($prep->fetch()){
        $files[$count]=array($i, $c, $s, $d);
        $count = $count + 1;
    }
    $con->close();
    return $files;
}

function delFileInFolderSQL($fid, $id){
    //delete file from disk and SQL
}
?>
