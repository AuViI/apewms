<?
//include("pulllib.php"); if getCon not found...
if(isset($_POST["newDir"])){
    $dir = $_POST["newDir"];
    mkdir("../data/$dir",0777,true);

    $con = getCon();
    if ($con->connect_error) {
        echo "Database Error";
    }
    println("Prepared Statement folgt.");
    $prep = $con->prepare("INSERT INTO folders (id, folder) VALUES (NULL, ?);");
    println("Prepared Statement erstellt.");
    $prep->bind_param('s', $dir);
    println("Parameter gebunden.");
    $prep->execute();
    println("Verzeichnis erfolgreich erstellt.");
}
echo getcwd();
?>
<form method="POST" action="panel.php?i=no&amp;folder=neuer%20Ordner%20--%20Antwort">
    <table>
        <tr>
            <td>Name des neuen Ordners</td>
            <td><input type="text" placeholder="Name: ../data/?" name="newDir"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Erstellen"></td>
        </tr>
    </table>
</form>
<?

?>