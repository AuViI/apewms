<?

include("../interface/exec/pulllib.php");
include("../interface/exec/string.php");
$valid = apilogin();

function apiprintall(){
    foreach ($_POST as $key => $value) {
        apiprint($key . " ==POST=> " . $value);
    }
    foreach ($_FILES as $key => $value) {
        apiprint($key . " ==FILES=> ".$value);
        foreach ($value as $key => $value) {
            apiprint("...".$key." --file-> ".$value);
        }
    }
}

if (isset($_POST["function"])){
    $imgs = array(".bmp", ".gif", ".png", ".jpg", ".jpeg", ".svn", ".exif", ".tiff");

    if ($_POST["function"]=="ping") {
        if ($valid) {
            echo "valid";
        } else {
            echo "invalid";
        }
        return;
    }

    if (isset($_POST["debug"]) && $_POST["debug"]=="true") {
        apiprintall();
    }

    if ($_POST["function"]=="dirsize") {
        $query = "SELECT COUNT(*) FROM entries WHERE fid=?";
        $con = getCon();
        $prep = $con->prepare($query);
        $prep->bind_param('s',$_POST["target"]);
        $prep->bind_result($count);
        $prep->execute();
        $prep->fetch();
        $con->close();
        echo $count;
        return;
    }

    if ($_POST["function"]=="newcycle") {
        apiprintall();
        if ($valid){
            $dir = getFolderArray()[ (int) $_POST["target"] ];
            $uploaddir = '/home/pi/wms.viwetter.de/data/'.$dir . "/";
            $filename = basename($_FILES['file']['name']);
            $uploadfile = $uploaddir . $filename;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $src="data/$dir/$filename";
                $content = "<iframe src='$src' class='full'></iframe>";
                foreach ($imgs as $key => $value) {
                    if(endsWith(strtolower($filename),$value)){
                        $content = str_replace("<iframe", "<img", $content);
                        $content = str_replace("</iframe>", "</img>", $content);
                    }
                }
                $con = getCon();
                if ($con->connect_error) {
                    apiprint("failed to connect to database");
                    return;
                } else {
                    apiprint("successfully connected to database");
                }
                $prep = $con->prepare("INSERT INTO entries (id, fid, remote, content, src, created) VALUES (NULL, ?, 0, ?, ?, CURRENT_TIMESTAMP);");
                $prep->bind_param('sss', $_POST["target"], $content, $src);
                $prep->execute();
                apiprint("executed");
                $con->close();
            }
        }
        return;
    }

    if($_POST["function"]=="deloldest"){
        $query1 = "SELECT remote, src FROM entries WHERE fid = ? ORDER BY id ASC LIMIT 1";
        $query2 = "DELETE FROM entries WHERE fid = ? ORDER BY id ASC LIMIT 1";
        if ($valid){
            $con = getCon();
            $prep = $con->prepare($query1);
            $prep->bind_param('s',$_POST["target"]);
            $prep->bind_result($r, $s);
            $prep->execute();
            $prep->fetch();
            $prep->close();

            if ($r == 0){
                unlink("../".$s);
            }

            $prep = $con->prepare($query2);
            $prep->bind_param('s', $_POST["target"]);
            $prep->execute();
            $con->close();
        }
    }

    if ($_POST["function"]=="tablejson") {
        $tbl = $_POST["table"];
        if($valid && $tbl == "folders" || $tbl == "entries" || $tbl == "logins"){
            $row = array();
            $con = getCon();
            $result = $con->query("SELECT * FROM " . $tbl);
            $json = "[";
            while($row = $result->fetch_assoc()){
                $json .= "{";
                foreach ($row as $key => $value) {
                    $json .= "\"".$con->real_escape_string($key)."\":\"".$con->real_escape_string($value)."\",";
                }
                $json .= "},";
            }
            $result->free();
            $con->close();
            $json .= "]";
            echo $json;
        }
    }
}



?>
