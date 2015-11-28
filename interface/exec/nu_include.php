<?
if(isset($_POST["newUser"])){
    //used thingy
    $newusername = $_POST["newUser"];
    $newuserplainpw = $_POST["newPw"];
    $newuserdesc = $_POST["desc"];
    $newuserspeed = $_POST["speed"];
    println("Daten wurden erfolgreich an den Server gesendet.");
    if(!is_numeric($newuserspeed)){
        $newuserspeed=10;
        println("Geschwindigkeit wurde auf 10 Sekunden gesetzt.");
    } else {
        $newuserspeed=intval($newuserspeed);
    }
    println("Hashes werden erstellt.");
    $newusersalt = hash("sha256",time().$newusername);
    $newuserpw = hash("sha256","tibyte".$newuserplainpw.$newusersalt);
    println("Hashes wurden erstellt.");

    $con = getCon();
    if ($con->connect_error) {
        echo "Database Error";
    }
    println("Prepared Statement folgt.");
    $prep = $con->prepare("INSERT INTO `wms`.`logins` (
`id` ,
`username` ,
`desc` ,
`pw` ,
`salt` ,
`speed` ,
`session` ,
`created`
)
VALUES (
NULL , ?, ?, ?, ?, ?, NULL ,
CURRENT_TIMESTAMP
);");
    println("Prepared Statement erstellt. Username: ".$newusername. " und Desc: ".$newuserdesc);
    $prep->bind_param('ssssi', $newusername, $newuserdesc, $newuserpw, $newusersalt, $newuserspeed);
    println("Parameter gebunden.");
    $prep->execute();
    println("Benutzer erfolgreich erstellt.");
    println("<br><br><br><br>");
}
echo "Nutzer über folgende Form hinzufügen:";
?>
<form action="panel.php?i=nu&amp;folder=neuer%20Benutzer%20--%20Antwort" method="POST">
    <table>
        <tr>
            <td>Benutzer</td>
            <td><input type="text" id="nu1" placeholder="Benutzername" name="newUser"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" id="pw1" placeholder="Password" name="newPw"></td>
        </tr>
        <tr>
            <td>Password wdh.</td>
            <td><input type="password" id="pw2" placeholder="Password"></td>
        </tr>
        <tr>
            <td>Beschreibung</td>
            <td><input type="text" id="desc" placeholder="Beschreibung" name="desc"></td>
        </tr>
        <tr>
            <td>Anzeige Geschwindigkeit</td>
            <td><input type="text" id="speed" placeholder="in Sekunden" name="speed"></td>
        </tr>
        <tr>
            <td></td>
            <td><input id="subbutton" type="submit" value="Erstellen"></td>
        </tr>
    </table>
    <script type="text/javascript">
    var nu1, pw1, pw2;
    nu1 = document.getElementById("nu1");
    pw1 = document.getElementById("pw1");
    pw2 = document.getElementById("pw2");
    subbutton = document.getElementById("subbutton");
    nu1.onkeyup=check;
    pw1.onkeyup=check;
    pw2.onkeyup=check;
    subbutton.disabled=true;
    function check(){
        subbutton.disabled=true;
        if(nu1.value.length >= 3){
            if(pw1.value == pw2.value){
                if(pw1.value.length>=3){
                    subbutton.disabled=false;
                }
            }
        }
    }
    </script>
</form>
<br>Benutzername und Password müssen mehr als drei Zeichen lang sein.
<?

?>